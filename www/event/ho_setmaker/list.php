<?php
// *** 세션 기반 로그인 확인 로직 (가장 위에 추가) ***
session_start();

// 'loggedin' 세션 변수가 없거나 false이면 로그인 페이지로 리다이렉트
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: admin.php");
    exit;
}

// 1. 데이터베이스 연결 정보 포함
require_once 'db_config.php';

// 2. 페이지네이션 및 보기 옵션 변수 설정
// ✨ [수정] PHP 5.3 호환을 위해 array() 문법으로 변경
$limit_options = array(30, 50, 100, 200);
$limit = isset($_GET['limit']) && in_array($_GET['limit'], $limit_options) ? (int)$_GET['limit'] : 50;

$total_records_query = $conn->query("SELECT COUNT(id) FROM event_sixpack_entries");
// ✨ [수정] PHP 5.3 호환을 위해 함수 결과를 변수에 먼저 담도록 변경
$total_row = $total_records_query->fetch_row();
$total_records = $total_row[0];

$total_pages = ($total_records > 0) ? ceil($total_records / $limit) : 1;

$page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
if ($page > $total_pages) {
    $page = $total_pages;
}

$offset = ($page - 1) * $limit;

// 3. DB에서 데이터 조회
$sql = "SELECT * FROM event_sixpack_entries ORDER BY id DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();

// ✨ [수정] get_result()를 대체하는 로직
$stmt->store_result();
$meta = $stmt->result_metadata();
$params = array();
$row = array();
while ($field = $meta->fetch_field()) {
    $params[] = &$row[$field->name];
}
call_user_func_array(array($stmt, 'bind_result'), $params);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>관리자 페이지</title>
    <style>
        body { 
            font-family: 'Malgun Gothic', sans-serif; 
            padding: 20px;
            font-size: 14px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: center;
            word-break: break-all;
        }
        th { background-color: #f2f2f2; }

        th:nth-child(4), th:nth-child(5) {
            width: 30%;
        }

        .controls { 
            display: flex; 
            justify-content: flex-end;
            align-items: center; 
            margin: 15px 0;
            gap: 20px;
        }
        .pagination { display: flex; align-items: center; gap: 10px; }
        .pagination a {
            padding: 5px 10px;
            border: 1px solid #ccc;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
            user-select: none;
        }
        .pagination a:hover { background-color: #f2f2f2; }
        .pagination a.disabled {
            background-color: #f0f0f0;
            color: #aaa;
            pointer-events: none;
            cursor: default;
        }
        .pagination span {
            padding: 5px 10px;
            border: 1px solid #ccc;
            background-color: #eee;
            font-weight: bold;
            border-radius: 4px;
        }
        .limit-selector select { padding: 5px; border-radius: 4px; font-size: 13px; }

        .download-btn {
            padding: 5px 15px;
            background-color: #2e6b2c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .download-btn:hover {
            background-color: #245423;
        }

        tbody tr {
            cursor: pointer; 
        }
        tbody tr:hover {
            background-color: #f5f5f5; 
        }
        .description-cell {
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .description-cell.expanded {
            white-space: normal;
            overflow: visible;
        }

    </style>
</head>
<body>

    <h1>관리자 페이지</h1>

    <div class="controls">
        <div>
            <a href="download_csv.php" class="download-btn">CSV로 전체 다운로드</a>
        </div>
        
        <div class="limit-selector">
            <form action="" method="GET" id="limitFormTop">
                <select name="limit" onchange="document.getElementById('limitFormTop').submit()">
                    <?php foreach ($limit_options as $option): ?>
                        <option value="<?php echo $option; ?>" <?php if ($limit == $option) echo 'selected'; ?>>
                            <?php echo $option; ?>개씩 보기
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>
        
        <div class="pagination">
            <a href="?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>" class="<?php if ($page <= 1) echo 'disabled'; ?>">이전</a>
            
            <?php if ($total_records > 0): ?>
            <span><?php echo $page; ?> / <?php echo $total_pages; ?></span>
            <?php else: ?>
            <span>0 / 0</span>
            <?php endif; ?>

            <a href="?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>" class="<?php if ($page >= $total_pages) echo 'disabled'; ?>">다음</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>성함</th><th>연락처</th><th>세트이름</th><th>설명</th>
                <th>치킨메뉴</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // ✨ [수정] $result 대신 $stmt 객체를 사용하도록 변경
            if ($stmt->num_rows > 0) {
                while($stmt->fetch()) {
                    // ✨ --- 메뉴 수량 계산 로직 (수정됨) --- ✨
                    
                    // 1. 2칸을 차지하는 메뉴(size: 2) 목록 정의
                    $size_2_menus = array('스푼떡볶이', '누들로제떡볶이', '매콤비빔쫄면', '라구스파게티');

                    // 2. DB에서 모든 메뉴를 가져옴
                    $all_menus = array();
                    for ($i = 1; $i <= 6; $i++) {
                        if (!empty($row['menu_' . $i])) {
                            $all_menus[] = $row['menu_' . $i];
                        }
                    }

                    $final_menu_list = array();
                    if (!empty($all_menus)) {
                        // 3. 각 메뉴의 개수를 셈
                        $menu_counts = array_count_values($all_menus);
                        
                        foreach ($menu_counts as $menu_name => $count) {
                            $times_to_add = 0;
                            
                            // 4. 메뉴가 size:2 목록에 있는지 확인하여 분기 처리
                            if (in_array($menu_name, $size_2_menus)) {
                                // size:2 메뉴는 2개가 1개로 처리됨 (중복 제거 로직)
                                $times_to_add = floor($count / 2) + ($count % 2);
                            } else {
                                // size:1 메뉴는 개수 그대로 표시
                                $times_to_add = $count;
                            }
                            
                            // 5. 최종 목록에 메뉴 이름 추가
                            for ($j = 0; $j < $times_to_add; $j++) {
                                $final_menu_list[] = $menu_name;
                            }
                        }
                    }

                    // 6. 쉼표로 구분된 문자열로 변환
                    $menu_str = implode(', ', $final_menu_list);
                    
                    // ✨ --- 로직 끝 --- ✨

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['set_name']) . "</td>";
                    echo "<td class='description-cell' title='클릭하여 전체 내용 보기'>" . htmlspecialchars($row['set_description']) . "</td>";
                    echo "<td>" . htmlspecialchars($menu_str) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>표시할 데이터가 없습니다.</td></tr>";
            }
            $stmt->close();
            $conn->close();
            ?>
        </tbody>
    </table>

    <div class="controls">
        <div class="pagination">
            <a href="?page=<?php echo $page - 1; ?>&limit=<?php echo $limit; ?>" class="<?php if ($page <= 1) echo 'disabled'; ?>">이전</a>
            
            <?php if ($total_records > 0): ?>
            <span><?php echo $page; ?> / <?php echo $total_pages; ?></span>
            <?php else: ?>
            <span>0 / 0</span>
            <?php endif; ?>

            <a href="?page=<?php echo $page + 1; ?>&limit=<?php echo $limit; ?>" class="<?php if ($page >= $total_pages) echo 'disabled'; ?>">다음</a>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableRows = document.querySelectorAll('tbody tr');

    tableRows.forEach(row => {
        row.addEventListener('click', function () {
            const currentDescriptionCell = this.querySelector('.description-cell');
            if (!currentDescriptionCell) return;
            const isAlreadyExpanded = currentDescriptionCell.classList.contains('expanded');
            document.querySelectorAll('.description-cell.expanded').forEach(cell => {
                cell.classList.remove('expanded');
            });
            if (!isAlreadyExpanded) {
                currentDescriptionCell.classList.add('expanded');
            }
        });
    });
});
</script>

</body>
</html>