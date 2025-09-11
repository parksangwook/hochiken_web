<?php
include_once('./_common.php');

$type = isset($_GET['type']) ? $_GET['type'] : 'A';
$filename = "email_data_{$type}_" . date("Ymd_His") . ".xls";

// 엑셀 다운로드 헤더
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Description: PHP Generated Data");
header("Cache-Control: max-age=0");

// 엑셀에서 한글깨짐 방지
echo "\xEF\xBB\xBF";

// 테이블 시작
echo "<table border='1' cellspacing='0' cellpadding='5' style='border-collapse:collapse; font-family:맑은 고딕;'>";

if ($type == 'A') {
    // ========================
    // 창업문의 내역 (Type A)
    // ========================
    echo "
    <thead>
        <tr>
            <th>이름</th>
            <th>연락처</th>
            <th>희망지역</th>
            <th>유입경로</th>
            <th>점포유무</th>
            <th>창업희망시기</th>
            <th>보유자금</th>
            <th>문의내용</th>
            <th>날짜</th>
        </tr>
    </thead>
    <tbody>";

    $sql = "SELECT name, phone, location, budget, have, gold, period, content, regDate 
              FROM g5_email_data 
             WHERE type='A' 
          ORDER BY regDate DESC";
    $result = sql_query($sql);

    while ($row = sql_fetch_array($result)) {
        // 줄바꿈 처리
        $content = str_replace(array("\r\n", "\r", "\n"), "<br>", $row['content']);

        echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['phone']}</td>
            <td>{$row['location']}</td>
            <td>{$row['budget']}</td>
            <td>{$row['have']}</td>
            <td>{$row['gold']}</td>
            <td>{$row['period']}</td>
            <td style='mso-data-placement:same-cell;'>{$content}</td>
            <td>{$row['regDate']}</td>
        </tr>";
    }
    echo "</tbody>";

} else if ($type == 'B') {
    // ========================
    // 고객소리 내역 (Type B)
    // ========================
    echo "
    <thead>
        <tr>
            <th>이름</th>
            <th>지점명</th>
            <th>이메일</th>
            <th>연락처</th>
            <th>상세문의내용</th>
            <th>날짜</th>
        </tr>
    </thead>
    <tbody>";

    $sql = "SELECT name, title, budget, phone, content, regDate 
              FROM g5_email_data 
             WHERE type='B' 
          ORDER BY regDate DESC";
    $result = sql_query($sql);

    while ($row = sql_fetch_array($result)) {
        $content = str_replace(array("\r\n", "\r", "\n"), "<br>", $row['content']);

        echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['title']}</td>
            <td>{$row['budget']}</td>
            <td>{$row['phone']}</td>
            <td style='mso-data-placement:same-cell;'>{$content}</td>
            <td>{$row['regDate']}</td>
        </tr>";
    }
    echo "</tbody>";

} else if ($type == 'C') {
    // ========================
    // 제안 내역 (Type C)
    // ========================
    echo "
    <thead>
        <tr>
            <th>이름</th>
            <th>지점명</th>
            <th>이메일</th>
            <th>연락처</th>
            <th>상세문의내용</th>
            <th>날짜</th>
        </tr>
    </thead>
    <tbody>";

    $sql = "SELECT name, title, budget, phone, content, regDate 
              FROM g5_email_data 
             WHERE type='C' 
          ORDER BY regDate DESC";
    $result = sql_query($sql);

    while ($row = sql_fetch_array($result)) {
        $content = str_replace(array("\r\n", "\r", "\n"), "<br>", $row['content']);

        echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['title']}</td>
            <td>{$row['budget']}</td>
            <td>{$row['phone']}</td>
            <td style='mso-data-placement:same-cell;'>{$content}</td>
            <td>{$row['regDate']}</td>
        </tr>";
    }
    echo "</tbody>";
}

echo "</table>";
exit;
?>
