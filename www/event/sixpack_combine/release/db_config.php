<?php
//header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Seoul');

// ===================================
// 데이터베이스 연결 정보 (공유 파일)
// ===================================

$servername = "localhost";
$username = "hochicken";       // 본인 DB 사용자 이름
$password = "sexy!020";           // 본인 DB 비밀번호
$dbname = "hochicken";    // 본인 DB 이름

// --- 데이터베이스 연결 및 오류 확인 ---
$conn = new mysqli($servername, $username, $password, $dbname);

$conn->set_charset("utf8mb4");

// 연결 오류가 발생하면 스크립트를 중단하고 오류 메시지를 표시
if ($conn->connect_error) {
    die("데이터베이스 연결 실패: " . $conn->connect_error);
}
?>