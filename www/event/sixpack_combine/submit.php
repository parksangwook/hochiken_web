<?php
// PHP 오류 보고 설정
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root"; // DB 사용자 이름
$password = ""; // DB 비밀번호
$dbname = "hochicken"; // DB 이름

// POST 요청이 아니면 페이지를 표시하지 않음
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    echo "Method Not Allowed.";
    exit;
}

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 오류 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 폼 데이터 수집 및 정제
$name = $conn->real_escape_string($_POST['user_name']);
$contact = $conn->real_escape_string($_POST['user_contact']);
$set_name = $conn->real_escape_string($_POST['set_name']);
$set_description = $conn->real_escape_string($_POST['set_description']);
$consent = isset($_POST['consent']) ? 1 : 0;

// 메뉴 정보 수집
$menu_1 = $conn->real_escape_string(isset($_POST['menu_1']) ? $_POST['menu_1'] : '');
$menu_2 = $conn->real_escape_string(isset($_POST['menu_2']) ? $_POST['menu_2'] : '');
$menu_3 = $conn->real_escape_string(isset($_POST['menu_3']) ? $_POST['menu_3'] : '');
$menu_4 = $conn->real_escape_string(isset($_POST['menu_4']) ? $_POST['menu_4'] : '');
$menu_5 = $conn->real_escape_string(isset($_POST['menu_5']) ? $_POST['menu_5'] : '');
$menu_6 = $conn->real_escape_string(isset($_POST['menu_6']) ? $_POST['menu_6'] : '');

// IP 주소 가져오기
$ip_address = $_SERVER['REMOTE_ADDR'];

// SQL INSERT 쿼리
$sql = "INSERT INTO event_sixpack_entries (
    name, 
    phone, 
    set_name, 
    set_description, 
    menu_1, 
    menu_2, 
    menu_3, 
    menu_4, 
    menu_5, 
    menu_6, 
    ip_address, 
    consent_agreed
) VALUES (
    '$name', 
    '$contact', 
    '$set_name', 
    '$set_description', 
    '$menu_1', 
    '$menu_2', 
    '$menu_3', 
    '$menu_4', 
    '$menu_5', 
    '$menu_6', 
    '$ip_address', 
    '$consent'
)";

// 쿼리 실행
$is_success = $conn->query($sql) === TRUE;

// 데이터베이스 연결 종료
$conn->close();

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>제출 완료</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans KR', sans-serif;
            background-color: #2e6b2c;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #2e6b2c;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="p-8">

    <div class="container text-center">
        <?php if ($is_success): ?>
            <h1 class="text-3xl font-bold mb-4">이벤트 참여가 완료되었습니다!</h1>
            <p class="text-lg">소중한 세트 아이디어가 성공적으로 저장되었습니다.</p>            
        <?php else: ?>
            <h1 class="text-3xl font-bold mb-4 text-red-400">오류 발생</h1>
            <p class="text-lg">데이터 저장 중 문제가 발생했습니다.</p>
            <p class="text-sm mt-2">Error: <?= $conn->error ?></p>
            <a href="hochicken_set_maker.html" class="inline-block mt-8 py-2 px-6 rounded-full bg-white text-[#2e6b2c] font-bold shadow-lg hover:bg-gray-200 transition-colors">
                다시 시도하기
            </a>
        <?php endif; ?>
    </div>

</body>
</html>
