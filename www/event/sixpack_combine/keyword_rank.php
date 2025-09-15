<?php
// PHP 오류 보고 설정
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * 1. 접근 권한 확인
 * 보안 강화를 위해 실제 서비스에서는 세션 기반의 인증 방식을 사용하는 것이 좋습니다.
 */
$admin_password = "1234";
if (!isset($_GET['password']) || $_GET['password'] !== $admin_password) {
    http_response_code(403);
    die("접근 권한이 없습니다.");
}

/**
 * 2. 데이터베이스 연결 설정
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hochicken";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}

// 분석에서 제외할 불용어(stop words) 목록
$stop_words = ['세트', '치킨', '콤보', '팩', '스페셜', '세트메뉴', '패키지', '세트치킨', '맛있는', '입니다', '이', '가', '은', '는', '도', '을', '를', '과', '와', '고', '에', '에서', '에게', '와', '로', '와', '와도', '보다', '과도', '입니다', '에', '이', '그', '저', '저기', '저기서', '여기', '거기', '저것', '이것', '그것', '저에게', '그에게', '이에게'];

/**
 * 텍스트에서 단어 조합과 빈도를 추출하는 함수
 * @param string $text 입력 텍스트
 * @param array $stop_words 제외할 불용어 배열
 * @return array 단어 조합을 키로, 빈도를 값으로 갖는 배열
 */
function get_word_combinations($text, $stop_words) {
    $combinations = [];
    $words = array_filter(array_map('trim', explode(' ', $text)), 'strlen');
    $num_words = count($words);

    if ($num_words < 2) {
        return [];
    }

    for ($i = 0; $i < $num_words; $i++) {
        for ($j = $i + 1; $j < $num_words; $j++) {
            $word1 = $words[$i];
            $word2 = $words[$j];
            if (!in_array($word1, $stop_words) && !in_array($word2, $stop_words)) {
                $pair = [$word1, $word2];
                sort($pair);
                $key = implode(' ', $pair);
                $combinations[$key] = ($combinations[$key] ?? 0) + 1;
            }
        }
    }
    return $combinations;
}

/**
 * 3. 데이터 가져오기 및 분석
 */
$sql = "SELECT set_name, set_description FROM event_sixpack_entries WHERE set_name IS NOT NULL OR set_description IS NOT NULL";
$result = $conn->query($sql);

$name_combinations = [];
$desc_combinations = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // 세트 이름 단어 조합 집계
        if (!empty($row['set_name'])) {
            $name_pairs = get_word_combinations($row['set_name'], $stop_words);
            foreach ($name_pairs as $key => $count) {
                $name_combinations[$key] = ($name_combinations[$key] ?? 0) + $count;
            }
        }

        // 설명 단어 조합 집계
        if (!empty($row['set_description'])) {
            $desc_pairs = get_word_combinations($row['set_description'], $stop_words);
            foreach ($desc_pairs as $key => $count) {
                $desc_combinations[$key] = ($desc_combinations[$key] ?? 0) + $count;
            }
        }
    }
}

// 키워드 조합을 빈도수 기준으로 내림차순 정렬
arsort($name_combinations);
arsort($desc_combinations);

// 상위 5개 결과만 추출
$top_name_combinations = array_slice($name_combinations, 0, 5, true);
$top_desc_combinations = array_slice($desc_combinations, 0, 5, true);

// 데이터베이스 연결 종료
$conn->close();
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>인기 키워드 통합 랭킹</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans KR', sans-serif;
            background-color: #2e6b2c;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #app {
            width: 100%;
            max-width: 600px; /* 최대 너비를 늘려 더 넓게 보이도록 수정 */
            margin: 0 auto;
            padding: 2rem;
            background-color: #2e6b2c;
        }
        @media (max-width: 767px) {
            #app {
                padding: 1rem;
            }
        }
        .container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .ranking-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem; /* 패딩을 늘려 박스를 더 크게 수정 */
            border-radius: 0.75rem; /* 모서리를 좀 더 둥글게 */
            background-color: rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem; /* 아이템 간 간격을 늘려 여유있게 수정 */
            transition: all 0.2s ease-in-out;
        }
        .ranking-item:hover {
            transform: translateY(-3px);
            background-color: rgba(255, 255, 255, 0.15);
        }
        .ranking-rank {
            font-size: 1.1rem; /* 글씨 크기 키우기 */
            font-weight: bold;
            color: #facc15;
            margin-right: 1.25rem; /* 간격 늘리기 */
        }
        .ranking-count {
            font-size: 0.9rem; /* 글씨 크기 키우기 */
            color: #a1a1aa;
            font-weight: bold;
            flex-shrink: 0; /* 카운트 숫자가 줄어들지 않도록 설정 */
            padding-left: 1rem;
        }
        .ranking-text {
            flex-grow: 1;
            text-align: left;
            word-break: keep-all;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 1rem; /* 글씨 크기 키우기 */
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="container text-center">
            <h1 class="text-4xl font-bold mb-4">✍️ 인기 키워드 통합 랭킹</h1>
            <p class="text-lg mb-8">세트 이름과 설명에 가장 많이 사용된 단어 조합을 확인하세요!</p>

            <div class="w-full flex flex-col md:flex-row md:space-x-8">
                <!-- Set Name Keywords -->
                <div class="flex-1 mb-8 md:mb-0">
                    <!-- `whitespace-nowrap` 클래스를 추가하여 줄바꿈 방지 -->
                    <h2 class="text-2xl font-bold mb-4 whitespace-nowrap">세트 이름 조합 집계</h2>
                    <?php if (!empty($top_name_combinations)): ?>
                        <?php $rank = 1; ?>
                        <?php foreach ($top_name_combinations as $word => $count): ?>
                            <div class="ranking-item">
                                <span class="ranking-rank"><?= $rank ?></span>
                                <span class="ranking-text text-white" title="<?= htmlspecialchars($word) ?>"><?= htmlspecialchars($word) ?></span>
                                <span class="ranking-count"><?= $count ?>회</span>
                            </div>
                            <?php $rank++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-lg">데이터가 없습니다.</p>
                    <?php endif; ?>
                </div>

                <!-- Set Description Keywords -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-4 whitespace-nowrap">설명 조합 집계</h2>
                    <?php if (!empty($top_desc_combinations)): ?>
                        <?php $rank = 1; ?>
                        <?php foreach ($top_desc_combinations as $word => $count): ?>
                            <div class="ranking-item">
                                <span class="ranking-rank"><?= $rank ?></span>
                                <span class="ranking-text text-white" title="<?= htmlspecialchars($word) ?>"><?= htmlspecialchars($word) ?></span>
                                <span class="ranking-count"><?= $count ?>회</span>
                            </div>
                            <?php $rank++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-lg">데이터가 없습니다.</p>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>
