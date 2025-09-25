<?php
// 1. PHP 설정 및 변수 초기화
ini_set('display_errors', 1);
error_reporting(E_ALL);

// JSON 응답을 위한 헤더 설정
header('Content-Type: application/json');

// 최종 응답을 담을 배열
$response = [
    'success' => false,
    'message' => ''
];

// 2. POST 요청 처리 및 데이터베이스 작업
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once 'db_config.php';

    try {
        // --- 폼 데이터 수집 ---
        // ✨ 1. 서버 측에서 개인정보 동의 여부 재확인
        if (!isset($_POST['agree_privacy']) || $_POST['agree_privacy'] !== 'yes') {
            throw new Exception("개인정보 제공 동의가 필요합니다.");
        }

        $name = $_POST['user_name'] ?? '';
        $contact = $_POST['user_contact'] ?? '';
        $set_name = $_POST['set_name'] ?? '';
        $set_description = $_POST['set_description'] ?? '';

        // ✨ 2. 동의한 현재 시간 생성 (데이터베이스 저장을 위해)
        $privacy_agreed_at = date('Y-m-d H:i:s');

        // --- 메뉴 데이터 수집 ---
        $menus = [];
        for ($i = 1; $i <= 6; $i++) {
            $menus[] = $_POST['menu_' . $i] ?? '';
        }

        // ✨ 3. INSERT 쿼리에 `privacy_agreed_at` 컬럼 추가
        $sql = "INSERT INTO event_sixpack_entries (
            name, phone, set_name, set_description, privacy_agreed_at,
            menu_1, menu_2, menu_3, menu_4, menu_5, menu_6
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            throw new Exception("SQL 구문 준비에 실패했습니다: " . $conn->error);
        }

        // ✨ 4. bind_param에 타입 's'와 변수 `$privacy_agreed_at` 추가 (총 11개)
        $stmt->bind_param("sssssssssss",
            $name, $contact, $set_name, $set_description, $privacy_agreed_at,
            $menus[0], $menus[1], $menus[2], $menus[3], $menus[4], $menus[5]
        );

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = '이벤트 참여가 성공적으로 완료되었습니다.';
        } else {
            throw new Exception("데이터 저장에 실패했습니다: " . $stmt->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        // 오류 발생 시 메시지를 응답 배열에 저장
        $response['message'] = $e->getMessage();
    }
    
    // 데이터베이스 연결 종료
    if (isset($conn) && $conn->ping()) {
        $conn->close();
    }

} else {
    http_response_code(405); // Method Not Allowed
    $response['message'] = '올바른 방법으로 접근해주세요.';
}

// 최종 결과를 JSON 형태로 출력
echo json_encode($response);
?>