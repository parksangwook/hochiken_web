<?php
// PHP 오류 보고 설정
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 관리자 비밀번호 설정
$admin_password = "1234";
// URL 쿼리 파라미터에서 비밀번호 확인
if (!isset($_GET['password']) || $_GET['password'] !== $admin_password) {
    die("접근 권한이 없습니다.");
}

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root"; // DB 사용자 이름
$password = ""; // DB 비밀번호
$dbname = "hochicken"; // DB 이름

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 오류 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 무작위로 하나의 항목을 선택하는 SQL 쿼리
$sql = "SELECT name, phone, set_name, set_description, menu_1, menu_2, menu_3, menu_4, menu_5, menu_6 FROM event_sixpack_entries ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql);

$winner = null;
$winner_menus = [];

if ($result && $result->num_rows > 0) {
    $winner = $result->fetch_assoc();
    for ($i = 1; $i <= 6; $i++) {
        if (!empty($winner["menu_" . $i])) {
            $winner_menus[] = $winner["menu_" . $i];
        }
    }
}

// 데이터베이스 연결 종료
$conn->close();

// 메뉴 데이터를 JSON 형식으로 변환하여 JavaScript에서 사용할 수 있도록 준비합니다.
// 이 데이터는 메뉴 이름과 이미지 경로를 매핑하는 데 사용됩니다.
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
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>당첨자 발표</title>
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

        .main-content {
            max-width: 600px;
            margin: 0 auto;
            padding: 1.5rem;
            background-color: #2e6b2c;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .main-content {
                max-width: 100%;
                border-radius: 0;
            }
        }
        
        .image-container {
            position: relative;
            /* 육각형 이미지 컨테이너 크기 수정 */
            max-width: 250px;
            margin: 0 auto;
        }
        .center-image {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }
        
        .box-piece {
            position: absolute;
            width: 50%;
            height: auto;
            clip-path: polygon(50% 0%, 100% 100%, 0% 100%);
        }

        .box-piece.top-left {
            top: 25.5%;
            left: 25.3%;
            transform: translate(-50%, -49.5%) scale(0.96);
        }

        .box-piece.top-center {
            top: 25.5%;
            left: 50%;
            transform: translate(-50%, -49.5%) rotate(180deg) scale(0.96);
        }
        
        .box-piece.top-right {
            top: 25.5%;
            left: 74.7%;
            transform: translate(-50%, -49.5%) scale(0.96);
        }

        .box-piece.bottom-left {
            top: 74.5%;
            left: 25.3%;
            transform: translate(-50%, -50.5%) rotate(180deg) scale(0.96);
        }

        .box-piece.bottom-center {
            top: 74.5%;
            left: 50%;
            transform: translate(-50%, -50.5%) scale(0.96);
        }
        
        .box-piece.bottom-right {
            top: 74.5%;
            left: 74.7%;
            transform: translate(-50%, -50.5%) rotate(180deg) scale(0.96);
        }

    </style>
</head>
<body class="p-8">

    <div class="main-content text-center">
        <?php if ($winner): ?>
            <h1 class="text-4xl font-bold mb-4">🎉 당첨자 발표 🎉</h1>
            <p class="text-xl">축하합니다, <strong class="font-bold text-yellow-300"><?= htmlspecialchars($winner['name']) ?></strong>님!</p>

            <div class="mt-4 text-left p-4 rounded-md bg-white bg-opacity-10">
                <table class="w-full">
                    <tr>
                        <td class="text-white font-normal pr-2 whitespace-nowrap">연락처:</td>
                        <td class="font-bold text-yellow-300 w-full"><?= htmlspecialchars($winner['phone']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-white font-normal pr-2 whitespace-nowrap">세트 이름:</td>
                        <td class="font-bold text-yellow-300 w-full"><?= htmlspecialchars($winner['set_name']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-white font-normal pr-2 whitespace-nowrap">설명:</td>
                        <td class="font-bold text-yellow-300 w-full"><?= htmlspecialchars($winner['set_description']) ?></td>
                    </tr>
                </table>
            </div>
            
            <div class="image-container my-8">
                <img src="./images/box_white.png" alt="box_white" class="center-image">
                <div id="winner-menus-container"></div>
            </div>

            <!-- 메뉴 아이템 간격(gap) 수정 -->
            <div id="winner-menu-list" class="flex flex-wrap justify-center gap-2 mt-6">
                <!-- 메뉴 아이템이 여기에 동적으로 추가됩니다 -->
            </div>
            

        <?php else: ?>
            <h1 class="text-3xl font-bold mb-4">아직 참여자가 없습니다.</h1>
            <p class="text-lg">이벤트에 참여하고 1등의 기회를 잡아보세요!</p>
            <div class="mt-8">
                <a href="hochicken_set_maker.html" class="inline-block py-2 px-6 rounded-full bg-white text-[#2e6b2c] font-bold shadow-lg hover:bg-gray-200 transition-colors">
                    세트 만들러 가기
                </a>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        const winnerMenus = <?= json_encode($winner_menus); ?>;
        const menuData = <?= $menu_data_json; ?>;

        const allMenus = [
            ...menuData.crispy,
            ...menuData.roast,
            ...menuData.side
        ];

        const menuSrcMap = {};
        allMenus.forEach(menu => {
            menuSrcMap[menu.name] = menu.src;
        });

        const winnerMenusContainer = document.getElementById('winner-menus-container');
        const winnerMenuList = document.getElementById('winner-menu-list');

        const pieceClasses = [
            'top-left', 'top-center', 'top-right',
            'bottom-left', 'bottom-center', 'bottom-right'
        ];

        winnerMenus.forEach((menuName, index) => {
            const imgSrc = menuSrcMap[menuName] ? menuSrcMap[menuName].replace('.png', '_p.png') : null;
            const pieceClass = pieceClasses[index];
            
            if (imgSrc) {
                const img = document.createElement('img');
                img.src = imgSrc;
                img.alt = menuName;
                img.className = `box-piece ${pieceClass}`;

                winnerMenusContainer.appendChild(img);
            }
        });

        winnerMenus.forEach((menuName) => {
            const imgSrc = menuSrcMap[menuName] ? menuSrcMap[menuName] : null;

            if (imgSrc) {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'flex flex-col items-center';
                
                const img = document.createElement('img');
                img.src = imgSrc;
                img.alt = menuName;
                // 메뉴 이미지 크기 수정 (w-24 h-24 -> w-20 h-20)
                img.className = 'rounded-full w-20 h-20 object-cover';

                const nameSpan = document.createElement('span');
                nameSpan.textContent = menuName;
                // 메뉴 텍스트 크기 및 간격 수정
                nameSpan.className = 'mt-1 text-xs text-white';
                
                itemDiv.appendChild(img);
                itemDiv.appendChild(nameSpan);
                winnerMenuList.appendChild(itemDiv);
            }
        });
    </script>
</body>
</html>

