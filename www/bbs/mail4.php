<?php
require_once './_common.php';
require_once G5_LIB_PATH . '/mailer.lib.php';

if (!empty($_POST['tel1'])) {
    
    $name = $_POST['name'];
    $tel1 = $_POST['tel1'];
    $area = $_POST['area'];
    $budget = $_POST['budget'];
    $form_index = $_POST['form_index'];
    $gold = $_POST['gold'];
    $have = $_POST['have'];
    $period = $_POST['period'];
    $type = $_POST['type'];
    $title   = '호치킨 창업문의';
    $content = '
        <span style="font-size:15pt;">
            <p>성함: ' . $name . '</p><br>
            <p>연락처: ' . $tel1 . '</p><br>
            <p>희망지역: ' . $area . '</p><br>
            <p>점포유무: ' . $have . '</p><br>
            <p>창업희망시기: ' . $period . '</p><br>
            <p>보유자금: ' . $gold . '</p><br>
            <p>문의내용: ' . $form_index . '</p><br>
        </span>
    ';

    // 메일 전송
    mailer($name, 'vworks02@naver.com', 'hochicken@dainfc.kr', $title , $content , 1);

    // DB 저장
    $sql = "INSERT INTO g5_email_data
            set name   = '$name',
                phone = '$tel1',
                location = '$area',
                have = '$have',
                period = '$period',
                gold = '$gold',
                type='$type',
                content = '$form_index'";
    sql_query($sql);
    echo $sql;
}
