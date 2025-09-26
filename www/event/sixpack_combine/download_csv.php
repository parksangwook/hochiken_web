<?php
// *** 세션 기반 로그인 확인 로직 (가장 위에 추가) ***
session_start();

// 'loggedin' 세션 변수가 없거나 false이면 로그인 페이지로 리다이렉트
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: admin.php");
    exit;
}

// 1. 데이터베이스 연결
require_once 'db_config.php';

// 2. 모든 데이터 조회 (LIMIT 없는 전체 데이터)
$sql = "SELECT * FROM event_sixpack_entries ORDER BY id ASC";
$result = $conn->query($sql);

// 3. 다운로드될 파일 이름 설정
$filename = '호치킨_이벤트참여자_목록_' . date('Y-m-d') . '.csv';

// 4. CSV 다운로드를 위한 HTTP 헤더 설정
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

// 5. CSV 파일 생성 및 출력
$output = fopen('php://output', 'w');

// *** 중요: 엑셀에서 한글이 깨지지 않도록 UTF-8 BOM을 파일 맨 앞에 추가 ***
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// ✨ [수정] CSV 파일의 헤더를 DB 스키마에 맞게 변경
$headers = [
    'ID', '이름', '연락처', '세트이름', '세트설명', 
    '개인정보 동의일', '메뉴1', '메뉴2', '메뉴3', '메뉴4', '메뉴5', '메뉴6',
    '상태', '등록일'
];
fputcsv($output, $headers);

// DB에서 가져온 데이터를 한 줄씩 CSV 파일에 추가
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // ✨ [수정] 헤더 순서와 정확히 일치하도록 데이터 배열을 직접 구성
        $csv_row = [
            $row['id'],
            $row['name'],
            $row['phone'],
            $row['set_name'],
            $row['set_description'],
            $row['privacy_agreed_at'],
            $row['menu_1'],
            $row['menu_2'],
            $row['menu_3'],
            $row['menu_4'],
            $row['menu_5'],
            $row['menu_6'],
            $row['status'],
            $row['created_at']
        ];
        fputcsv($output, $csv_row);
    }
}

$conn->close();
exit;