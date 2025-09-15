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
 * 2. 데이터베이스 연결 및 데이터 가져오기
 */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hochicken";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}

// 모든 참가자 데이터 가져오기
$sql = "SELECT menu_1, menu_2, menu_3, menu_4, menu_5, menu_6 FROM event_sixpack_entries";
$result = $conn->query($sql);

$combinations = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $selected_menus = [];
        for ($i = 1; $i <= 6; $i++) {
            if (!empty($row["menu_" . $i])) {
                $selected_menus[] = $row["menu_" . $i];
            }
        }
        
        // 메뉴 조합 (2개씩) 계산
        $count = count($selected_menus);
        if ($count >= 2) {
            for ($i = 0; $i < $count - 1; $i++) {
                for ($j = $i + 1; $j < $count; $j++) {
                    $pair = [$selected_menus[$i], $selected_menus[$j]];
                    sort($pair); // 조합의 순서를 통일
                    $pair_key = implode('_', $pair);
                    $combinations[$pair_key] = ($combinations[$pair_key] ?? 0) + 1;
                }
            }
        }
    }
}

// 조합을 빈도수 기준으로 내림차순 정렬
arsort($combinations);

// 메뉴 데이터 매핑
// 메뉴 데이터를 JSON 형식으로 변환하여 JavaScript에서 사용할 수 있도록 준비합니다.
$menu_data_json = json_encode([
    'crispy' => [
        ['name' => '간장치킨', 'src' => './images/menu1/menu1_o_간장치킨.png'],
        ['name' => '맛나게맵닭', 'src' => './images/menu1/menu1_o_맛나게맵닭.png'],
        ['name' => '반반치킨', 'src' => './images/menu1/menu1_o_반반치킨.png'],
        ['name' => '양념치킨', 'src' => './images/menu1/menu1_o_양념치킨.png'],
        ['name' => '치타치킨', 'src' => './images/menu1/menu1_o_치타치킨.png'],
        ['name' => '크리스피', 'src' => './images/menu1/menu1_o_크리스피.png'],
    ],
    'roast' => [
        ['name' => '로스트', 'src' => './images/menu1/menu1_r_로스트.png'],
        ['name' => '매직핫로스트', 'src' => './images/menu1/menu1_r_매직핫로스트.png'],
        ['name' => '직화소금구이', 'src' => './images/menu1/menu1_r_직화소금구이.png'],
        ['name' => '직화양념구이', 'src' => './images/menu1/menu1_r_직화양념구이.png'],
        ['name' => '청양바베큐로스트', 'src' => './images/menu1/menu1_r_청양바베큐로스트.png'],
        ['name' => '치슐랭', 'src' => './images/menu1/menu1_s_치슐랭.png'],
    ],
    'side' => [
        ['name' => '라구스파게티', 'src' => './images/menu2/menu2_라구스파게티.png'],
        ['name' => '매콤비빔우동', 'src' => './images/menu2/menu2_매콤비빔우동.png'],
        ['name' => '매콤비빔쫄면', 'src' => './images/menu2/menu2_매콤비빔쫄면.png'],
        ['name' => '버갈퐁', 'src' => './images/menu2/menu2_버갈퐁.png'],
        ['name' => '소떡소떡', 'src' => './images/menu2/menu2_소떡소떡.png'],
        ['name' => '스노윙후라이', 'src' => './images/menu2/menu2_스노윙후라이.png'],
    ],
]);

$menu_src_map = [];
foreach (json_decode($menu_data_json, true) as $category) {
    foreach ($category as $menu) {
        $menu_src_map[$menu['name']] = $menu['src'];
    }
}

// 데이터베이스 연결 종료
$conn->close();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>인기 메뉴 조합 랭킹</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* 기본 스타일 */
        body {
            font-family: 'Noto Sans KR', sans-serif;
            background-color: #2e6b2c;
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* 중앙 정렬을 위한 새로운 박스 */
        .page-container {
            width: 100%;
            max-width: 600px;
            padding: 2rem 1rem;
            background-color: #2e6b2c;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* 모바일 화면에서는 너비 제한 해제 */
        @media (max-width: 767px) {
            .page-container {
                max-width: none;
                padding: 1rem;
            }
        }

        .ranking-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-radius: 0.5rem;
            background-color: rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }
        .ranking-rank {
            font-size: 1.5rem;
            font-weight: bold;
            color: #facc15;
            margin-right: 1rem;
        }
        .ranking-images {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            justify-content: center; /* 아이템을 가로로 가운데 정렬 */
            flex-grow: 1;
            flex-wrap: wrap;
        }
        .ranking-images .menu-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .ranking-images img {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
        }
        .ranking-images span {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            word-break: keep-all;
        }
        .ranking-count {
            font-size: 1.25rem;
            color: #fff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="container text-center">
            <h1 class="text-4xl font-bold mb-4">📈 인기 메뉴 조합 랭킹</h1>
            <p class="text-lg mb-8">가장 많이 선택된 메뉴 조합을 확인하세요!</p>

            <?php if (!empty($combinations)): ?>
                <?php $rank = 1; ?>
                <?php foreach ($combinations as $pair_key => $count): ?>
                    <?php
                    if ($rank > 5) break; // 상위 5개만 표시
                    $menu_names = explode('_', $pair_key);
                    ?>
                    <div class="ranking-item">
                        <span class="ranking-rank"><?= $rank ?></span>
                        <div class="ranking-images">
                            <?php foreach ($menu_names as $menu_name): ?>
                                <?php if (isset($menu_src_map[$menu_name])): ?>
                                    <div class="menu-item">
                                        <img src="<?= htmlspecialchars($menu_src_map[$menu_name]) ?>" alt="<?= htmlspecialchars($menu_name) ?>" title="<?= htmlspecialchars($menu_name) ?>">
                                        <span><?= htmlspecialchars($menu_name) ?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <span class="ranking-count"><?= $count ?>회</span>
                    </div>
                    <?php $rank++; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-lg">아직 조합 데이터가 없습니다.</p>
            <?php endif; ?>
            
        </div>
    </div>
</body>
</html>
