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
$limit_options = [30, 50, 100, 200];
$limit = isset($_GET['limit']) && in_array($_GET['limit'], $limit_options) ? (int)$_GET['limit'] : 50;

$total_records_query = $conn->query("SELECT COUNT(id) FROM event_sixpack_entries");
$total_records = $total_records_query->fetch_row()[0];

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
$result = $stmt->get_result();
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
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
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

        /* *** 버튼 스타일 추가 *** */
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
                <th>치킨메뉴</th><th>사이드1</th><th>사이드2</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $chicken_menus = [];
                    if (!empty($row['menu_1'])) $chicken_menus[] = $row['menu_1'];
                    if (!empty($row['menu_2'])) $chicken_menus[] = $row['menu_2'];
                    if (!empty($row['menu_3'])) $chicken_menus[] = $row['menu_3'];
                    $chicken_menu_str = implode(',', $chicken_menus);

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['set_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['set_description']) . "</td>";
                    echo "<td>" . htmlspecialchars($chicken_menu_str) . "</td>";
                    echo "<td>" . htmlspecialchars($row['menu_4']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['menu_5']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>표시할 데이터가 없습니다.</td></tr>";
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

</body>
</html>