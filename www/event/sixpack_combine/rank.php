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

// 랭킹 데이터를 저장할 빈 배열을 초기화합니다.
$ranking = [];

// SQL 쿼리: 각 메뉴의 선택 횟수를 집계하고 내림차순으로 정렬합니다.
$sql = "
SELECT 
    menu_name,
    COUNT(menu_name) AS total_count
FROM (
    SELECT menu_1 AS menu_name FROM event_sixpack_entries WHERE menu_1 IS NOT NULL AND menu_1 != ''
    UNION ALL
    SELECT menu_2 AS menu_name FROM event_sixpack_entries WHERE menu_2 IS NOT NULL AND menu_2 != ''
    UNION ALL
    SELECT menu_3 AS menu_name FROM event_sixpack_entries WHERE menu_3 IS NOT NULL AND menu_3 != ''
    UNION ALL
    SELECT menu_4 AS menu_name FROM event_sixpack_entries WHERE menu_4 IS NOT NULL AND menu_4 != ''
    UNION ALL
    SELECT menu_5 AS menu_name FROM event_sixpack_entries WHERE menu_5 IS NOT NULL AND menu_5 != ''
    UNION ALL
    SELECT menu_6 AS menu_name FROM event_sixpack_entries WHERE menu_6 IS NOT NULL AND menu_6 != ''
) AS all_menus
GROUP BY menu_name
ORDER BY total_count DESC;
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $ranking[$row['menu_name']] = $row['total_count'];
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
    <title>치킨 랭킹</title>
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

        .rank-item:not(:last-child) {
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="container text-center">
            <h1 class="text-3xl font-bold mb-8">치킨 선택 랭킹</h1>

            <?php if (!empty($ranking)): ?>
                <ul class="text-left space-y-4">
                    <?php $rank = 1; ?>
                    <?php foreach ($ranking as $menu_name => $count): ?>
                        <li class="rank-item flex justify-between items-center py-4">
                            <div class="flex items-center">
                                <span class="text-2xl font-bold mr-4"><?= $rank ?>위</span>
                                <span class="text-lg"><?= htmlspecialchars($menu_name) ?></span>
                            </div>
                            <span class="text-xl font-bold"><?= $count ?>회</span>
                        </li>
                        <?php $rank++; ?>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-lg">아직 등록된 랭킹 데이터가 없습니다.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
