<?php
require_once './_common.php';
require_once G5_LIB_PATH . '/mailer.lib.php';

// 사용자 입력값
$name = $_POST['name'];
$title = $_POST['title'];
$tel1 = $_POST['tel1'];
$email = $_POST['email'];
$budget = $_POST['budget'];
$form_index = $_POST['form_index'];
$type = $_POST['type'];

// 이메일 제목과 내용|
$mail_title = '호치킨 고객의 소리';
$mail_content = '<span style="font-size:15pt;">
    <p>작성자: ' . $name . '</p><br>
    <p>제목: ' . $title . '</p><br>
    <p>연락처: ' . $tel1 . '</p><br>
    <p>이메일: ' . $email . '</p><br>
    <p>매장명: ' . $budget . '</p><br>
    <p>내용: ' . $form_index . '</p><br>
</span>';

// 이메일 수신자&발신자
//$to = 'vworks02@naver.com';
//$from = 'wltjdrms93@naver.com';

// 파일이 정상 업로드 확인
//if (isset($_FILES['attachment']) && $_FILES['attachment']['error'][0] === UPLOAD_ERR_OK) {
//    $attachments = [];
//    foreach ($_FILES['attachment']['tmp_name'] as $index => $tmp_name) {
//        $attachments[] = [
//            'path' => $tmp_name,
//            'name' => $_FILES['attachment']['name'][$index]
//        ];
//    }
//    // 여러 개의 첨부파일 처리
//    mailer($name, $from, $to, $mail_title, $mail_content, 1, $attachments);
//} else {
//    // 첨부파일 없을 경우
//    mailer($name, $from, $to, $mail_title, $mail_content, 1);
//}

mailer($name, 'vworks02@naver.com', 'hochicken@dainfc.kr', $mail_title , $mail_content , 1);

// 데이터베이스 저장
$sql = "INSERT INTO g5_email_data
        SET name = '$name',
            title = '$title',
            phone = '$tel1',
            email = '$email',
            budget = '$budget',
            content = '$form_index',
            type='$type'";
sql_query($sql);

echo "데이터베이스에 저장되었습니다.";
?>
