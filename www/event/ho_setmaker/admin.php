<?php
// 세션 시작: 로그인 상태를 기록하기 위해 최상단에 위치해야 합니다.
session_start();

// 설정 파일 포함
require_once 'config.php';

$admin_password = $config['admin_password']; // config 파일에서 비밀번호 가져오기
$error_message = "";

// 폼이 제출되었는지 확인 (POST 방식)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_password = $_POST['password'];

    // 비밀번호가 일치하는지 확인
    if ($input_password === $admin_password) {
        // 비밀번호가 맞으면, 세션에 로그인 상태 기록
        $_SESSION['loggedin'] = true;
        
        // list.php로 리다이렉트
        header("Location: list.php");
        exit; // 리다이렉트 후에는 항상 exit()를 호출하여 추가 실행을 막습니다.
    } else {
        // 비밀번호가 틀리면 에러 메시지 설정
        $error_message = "비밀번호가 올바르지 않습니다.";
    }
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>관리자 로그인</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans KR', sans-serif;
            background-color: #f0f4f8; /* 배경색을 좀 더 부드럽게 변경 */
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <div class="login-container text-center">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">관리자 로그인</h1>
        <form method="POST" action="">
            <input type="password" name="password" placeholder="비밀번호를 입력하세요" 
                   class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="w-full py-3 mt-6 rounded-md bg-blue-600 text-white font-bold
                                         hover:bg-blue-700 transition-colors">
                로그인
            </button>
        </form>
        <?php if (!empty($error_message)): ?>
            <p class="mt-4 text-red-500"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>

</body>
</html>