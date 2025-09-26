<?php
// 👇 이 3줄을 파일 가장 위에 추가해 주세요.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// index.php (수정된 최종 버전)

// 1. 설정 파일 로드
require_once 'config.php';
$eventFile = 'event.php'; // 일반 리다이렉트 시 사용할 파일 이름

// 2. 설정 파일에서 URL 가져오기 (서버 변수 의존성 제거)
$fullEventUrl = $config['event_url'];

// 3. 접속 환경 확인 로직
$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
$inappKeywords = array('kakaotalk', 'fban', 'fbav', 'instagram', 'naver', 'wv');
$isInApp = false;

foreach ($inappKeywords as $keyword) {
    if (stripos($userAgent, $keyword) !== false) {
        $isInApp = true;
        break;
    }
}

// 4. 환경에 따라 리다이렉트
if ($isInApp && stripos($userAgent, 'android') !== false) {
    // 안드로이드 인앱 브라우저일 경우 Chrome으로 여는 인텐트 URL 생성
    $intentUrl = 'intent://' . str_replace(array('https://', 'http://'), '', $fullEventUrl) . '#Intent;scheme=https;package=com.android.chrome;end';
    header('Location: ' . $intentUrl);
} else {
    // 그 외 모든 경우, 이벤트 페이지로 바로 이동
    header('Location: ' . $eventFile);
}

exit;
?>