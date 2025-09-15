<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>관리자 페이지</title>
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
            padding: 2rem;
        }

        .responsive-container {
            width: 100%;
            max-width: 600px;
            padding: 2rem;
            background-color: #3b82f6;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
            margin: 0 auto;
        }

        .input-style {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .input-style::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body class="p-8">

    <div id="login-container" class="responsive-container text-center bg-gray-700">
        <h1 class="text-3xl font-bold mb-6">관리자 로그인</h1>
        <form id="login-form" method="POST" action="#">
            <input type="password" id="password-input" name="password" placeholder="비밀번호를 입력하세요" 
                   class="input-style w-full p-3 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <button type="submit" class="w-full py-3 mt-6 rounded-full bg-white text-gray-700 font-bold shadow-lg 
                                           hover:bg-gray-200 transition-colors">
                로그인
            </button>
        </form>
        <p id="error-message" class="mt-4 text-red-400 hidden">비밀번호가 올바르지 않습니다.</p>
    </div>

    <div id="dashboard-container" class="responsive-container text-center bg-green-700 hidden">
        <h1 class="text-3xl font-bold mb-4">관리자 대시보드</h1>
        <p class="mb-6">관리자 페이지에 오신 것을 환영합니다.</p>
        <nav>
            <ul class="space-y-4">
                <li>
                    <a href="rank.php?password=1234" target="_blank" rel="noopener noreferrer" class="block w-full py-3 rounded-full bg-white text-[#2e6b2c] font-bold shadow-lg hover:bg-gray-200 transition-colors">
                        전체 랭킹
                    </a>
                </li>
                <li>
                    <a href="combination_rank.php?password=1234" target="_blank" rel="noopener noreferrer" class="block w-full py-3 rounded-full bg-white text-[#2e6b2c] font-bold shadow-lg hover:bg-gray-200 transition-colors">
                        조합 랭킹
                    </a>
                </li>
                <li>
                    <a href="keyword_rank.php?password=1234" target="_blank" rel="noopener noreferrer" class="block w-full py-3 rounded-full bg-white text-[#2e6b2c] font-bold shadow-lg hover:bg-gray-200 transition-colors">
                        키워드 랭킹
                    </a>
                </li>
                <li>
                    <a href="recommend.php?password=1234" target="_blank" rel="noopener noreferrer" class="block w-full py-3 rounded-full bg-white text-[#2e6b2c] font-bold shadow-lg hover:bg-gray-200 transition-colors">
                        당첨자 추첨
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginForm = document.getElementById('login-form');
            const passwordInput = document.getElementById('password-input');
            const errorMessage = document.getElementById('error-message');
            const loginContainer = document.getElementById('login-container');
            const dashboardContainer = document.getElementById('dashboard-container');

            // 폼 제출 이벤트 리스너 (로그인 처리)
            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();

                const inputPassword = passwordInput.value;
                const adminPassword = "1234";

                if (inputPassword === adminPassword) {
                    loginContainer.classList.add('hidden');
                    dashboardContainer.classList.remove('hidden');
                    errorMessage.classList.add('hidden');
                } else {
                    errorMessage.classList.remove('hidden');
                }
            });
        });
    </script>
</body>
</html>

