<?php
// 1. 설정: 실제 이벤트 파일 이름
$eventFile = 'event.php';

// 2. 동적 URL 생성: 현재 서버 환경에 맞는 전체 URL을 자동으로 만듭니다.
//    (안드로이드 인텐트는 전체 주소가 반드시 필요하기 때문입니다.)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$dynamicEventUrl = $protocol . "://" . $host . $path . "/" . $eventFile;


// 3. 접속 환경 확인 로직 (기존과 동일)
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

// 인앱 브라우저 키워드
$inappKeywords = ['kakaotalk', 'fban', 'fbav', 'instagram', 'naver', 'wv'];

$isInApp = false;
foreach ($inappKeywords as $keyword) {
    if (stripos($userAgent, $keyword) !== false) {
        $isInApp = true;
        break;
    }
}


// 4. 환경에 따라 리다이렉트
// 모바일 인앱 브라우저로 접속한 경우 (안드로이드)
if ($isInApp && stripos($userAgent, 'android') !== false) {
    // 동적으로 생성된 전체 URL을 사용하여 인텐트 주소 생성
    $intentUrl = 'intent://' . str_replace(['https://', 'http://'], '', $dynamicEventUrl) . '#Intent;scheme=https;package=com.android.chrome;end';
    header('Location: ' . $intentUrl);
} 
// 그 외의 모든 경우 (PC, 모바일 일반 브라우저, iOS 등)
else {
    // 그냥 실제 이벤트 파일로 리다이렉트 (상대 경로)
    header('Location: ' . $eventFile);
}

exit;
?>