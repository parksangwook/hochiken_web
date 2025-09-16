<?php
// =================================================================
// 1. PHP 설정 및 변수 초기화
// =================================================================

ini_set('display_errors', 1);
error_reporting(E_ALL);

$is_success = false;
$error_message = '';
$event_url = "https://hochicken.co.kr/event/sixpack_combine/";

// =================================================================
// 2. POST 요청 처리 및 데이터베이스 작업
// =================================================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once 'db_config.php';

    try {
        // --- 폼 데이터 수집 (PHP 5.3 호환 문법) ---
        $name = isset($_POST['user_name']) ? $_POST['user_name'] : '';
        $contact = isset($_POST['user_contact']) ? $_POST['user_contact'] : '';
        $set_name = isset($_POST['set_name']) ? $_POST['set_name'] : '';
        $set_description = isset($_POST['set_description']) ? $_POST['set_description'] : '';
        $consent = isset($_POST['consent']) ? 1 : 0;
        $ip_address = $_SERVER['REMOTE_ADDR'];
        
        // --- 메뉴 데이터 수집 (PHP 5.3 호환 문법으로 수정) ---
        $menus = array(); // [] 대신 array() 사용
        for ($i = 1; $i <= 6; $i++) {
            $menus[] = isset($_POST['menu_' . $i]) ? $_POST['menu_' . $i] : '';
        }

        $sql = "INSERT INTO event_sixpack_entries (
            name, phone, set_name, set_description,
            menu_1, menu_2, menu_3, menu_4, menu_5, menu_6,
            ip_address, consent_agreed
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            throw new Exception("SQL 구문 준비에 실패했습니다: " . $conn->error);
        }

        $stmt->bind_param("sssssssssssi",
            $name, $contact, $set_name, $set_description,
            $menus[0], $menus[1], $menus[2], $menus[3], $menus[4], $menus[5],
            $ip_address, $consent
        );

        if ($stmt->execute()) {
            $is_success = true;
        } else {
            throw new Exception("데이터 저장에 실패했습니다: " . $stmt->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
    
    $conn->close();

} else {
    http_response_code(405);
    echo "올바른 방법으로 접근해주세요.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>제출 완료</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Noto Sans KR', sans-serif; background-color: #2e6b2c; color: #fff; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; }
        .container { max-width: 600px; margin: 0 auto; padding: 2rem; background-color: #2e6b2c; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
    </style>
</head>
<body class="p-8">

    <div class="container text-center">
        <?php if ($is_success): ?>
            <h1 class="text-3xl font-bold mb-4">이벤트 참여가 완료되었습니다!</h1>
            <p class="text-lg">소중한 세트 아이디어가 성공적으로 저장되었습니다.</p>
            
            <div class="mt-10">
                <p class="font-bold mb-4">친구에게 이벤트를 공유해보세요!</p>
                <button id="share-btn" class="py-3 px-8 rounded-full bg-yellow-400 text-black font-bold shadow-lg transition-transform hover:scale-105">
                    🎉 공유하기
                </button>
            </div>

        <?php else: ?>
            <h1 class="text-3xl font-bold mb-4 text-red-400">오류 발생</h1>
            <p class="text-lg">데이터 저장 중 문제가 발생했습니다.</p>
            <p class="text-sm mt-2">Error: <?= htmlspecialchars($error_message) ?></p>
            <a href="hochicken_set_maker.html" class="inline-block mt-8 py-2 px-6 rounded-full bg-white text-[#2e6b2c] font-bold shadow-lg hover:bg-gray-200 transition-colors">
                다시 시도하기
            </a>
        <?php endif; ?>
    </div>

    <?php if ($is_success): ?>
    <script>
        const shareBtn = document.getElementById('share-btn');
        const eventUrl = '<?= $event_url ?>';

        function legacyCopy(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            textArea.style.top = 0;
            textArea.style.left = 0;
            textArea.style.opacity = 0;
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                if (document.execCommand('copy')) {
                    alert('이벤트 링크를 복사했습니다!');
                } else {
                    alert('링크 복사에 실패했습니다.');
                }
            } catch (err) {
                alert('링크 복사에 실패했습니다.');
            }
            document.body.removeChild(textArea);
        }

        shareBtn.addEventListener('click', function() { // async () => 를 구형 function() 으로 수정
            if (navigator.share) {
                navigator.share({
                    title: '호치킨 나만의 Six-Pack 만들기!',
                    text: '내가 직접 만드는 치킨 세트! 지금 참여하고 상품도 받자!',
                    url: eventUrl,
                }).then(function() {
                    console.log('공유 성공!');
                }).catch(function(error) {
                    if (error.name !== 'AbortError') console.error('Share failed:', error);
                });
            } 
            else if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(eventUrl).then(function() {
                    alert('이벤트 링크를 복사했습니다!');
                }).catch(function(err) {
                    legacyCopy(eventUrl);
                });
            } 
            else {
                legacyCopy(eventUrl);
            }
        });
    </script>
    <?php endif; ?>

</body>
</html>