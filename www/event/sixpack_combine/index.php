<?php
// 접속한 기기의 User Agent 정보 확인
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

// 실제 이벤트 페이지 주소
$eventUrl = 'https://hochicken.co.kr/event/sixpack_combine/event.html';

// 인앱 브라우저 키워드
$inappKeywords = array('kakaotalk', 'fban', 'fbav', 'instagram', 'naver', 'wv');

$isMobile = preg_match('/(iphone|ipad|ipod|android)/i', $userAgent);
$isNormalBrowser = $isMobile && preg_match('/(chrome|safari)/i', $userAgent) && !preg_match('/(wv|crios|fxios)/i', $userAgent);

$isInApp = false;
foreach ($inappKeywords as $keyword) {
    if (strpos($userAgent, $keyword) !== false) {
        $isInApp = true;
        break;
    }
}

// 모바일 인앱 브라우저로 접속한 경우 (안드로이드)
if ($isInApp && preg_match('/android/i', $userAgent)) {
    // 외부 브라우저(크롬)로 여는 안드로이드 인텐트 주소로 리다이렉트
    header('Location: intent://' . str_replace('https://', '', $eventUrl) . '#Intent;scheme=https;package=com.android.chrome;end');
} 
// 그 외의 모든 경우 (PC, 모바일 일반 브라우저, iOS 등)
else {
    // 그냥 실제 이벤트 페이지로 리다이렉트
    header('Location: ' . $eventUrl);
}

exit;
?>