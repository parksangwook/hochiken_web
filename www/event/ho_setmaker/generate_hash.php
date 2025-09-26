<?php
// 원하는 비밀번호를 여기에 입력하세요.
$my_password = '';

// 비밀번호를 해시 값으로 변환하여 화면에 출력합니다.
echo password_hash($my_password, PASSWORD_DEFAULT);
?>