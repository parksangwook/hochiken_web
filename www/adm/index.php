<?php
$sub_menu = '100000';
include_once('./_common.php');
include_once('./admin.head.php');

$g5['title'] = '관리자메인';

// 페이지 설정
$pageA = isset($_GET['pageA']) ? (int)$_GET['pageA'] : 1;
$pageB = isset($_GET['pageB']) ? (int)$_GET['pageB'] : 1;
$pageC = isset($_GET['pageC']) ? (int)$_GET['pageC'] : 1;

$rowsPerPage = 10;
$offsetA = ($pageA - 1) * $rowsPerPage;
$offsetB = ($pageB - 1) * $rowsPerPage;
$offsetC = ($pageC - 1) * $rowsPerPage;

// Type A 전체 개수
$sqlCountA = "SELECT COUNT(*) AS cnt FROM g5_email_data WHERE type = 'A'";
$rowCountA = sql_fetch($sqlCountA);
$totalRowsA = $rowCountA['cnt'];
$totalPagesA = ceil($totalRowsA / $rowsPerPage);

// Type B 전체 개수
$sqlCountB = "SELECT COUNT(*) AS cnt FROM g5_email_data WHERE type = 'B'";
$rowCountB = sql_fetch($sqlCountB);
$totalRowsB = $rowCountB['cnt'];
$totalPagesB = ceil($totalRowsB / $rowsPerPage);

// Type C 전체 개수
$sqlCountC = "SELECT COUNT(*) AS cnt FROM g5_email_data WHERE type = 'C'";
$rowCountC = sql_fetch($sqlCountC);
$totalRowsC = $rowCountC['cnt'];
$totalPagesC = ceil($totalRowsC / $rowsPerPage);

// 각 타입 데이터 조회
$sqlA = "SELECT * FROM g5_email_data WHERE type = 'A' ORDER BY regdate DESC LIMIT {$offsetA}, {$rowsPerPage}";
$resultA = sql_query($sqlA);

$sqlB = "SELECT * FROM g5_email_data WHERE type = 'B' ORDER BY regdate DESC LIMIT {$offsetB}, {$rowsPerPage}";
$resultB = sql_query($sqlB);

$sqlC = "SELECT * FROM g5_email_data WHERE type = 'C' ORDER BY regdate DESC LIMIT {$offsetC}, {$rowsPerPage}";
$resultC = sql_query($sqlC);
// 방문자 통계
$sql_common = " from {$g5['visit_sum_table']} ";
$sql_search = " where (1) ";
$sql_order  = " order by vs_date desc ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 20;
$total_page  = ceil($total_count / $rows);
if ($page < 1) $page = 1;
$from_record = ($page - 1) * $rows;

$sql = " select vs_date, vs_count {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$page_sum_count = 0;
$data = array();
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $page_sum_count += $row['vs_count'];
    $data[] = $row;
}
?>

<section>
    <h2>날짜별 접속자 통계</h2>
    <div class="local_desc02 local_desc">전체 <?php echo number_format($total_count) ?> 건</div>
    <div class="tbl_head01 tbl_wrap">
        <table>
            <thead>
                <tr>
                    <th scope="col">날짜</th>
                    <th scope="col">그래프</th>
                    <th scope="col">접속자수</th>
                    <th scope="col">비율(%)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($data)) {
                    foreach ($data as $row) {
                        $count = $row['vs_count'];
                        $rate  = $page_sum_count > 0 ? ($count / $page_sum_count * 100) : 0;
                        $s_rate = number_format($rate, 1);
                        echo "<tr>
                            <td>{$row['vs_date']}</td>
                            <td><div class='visit_bar'><span style='width:{$s_rate}%'></span></div></td>
                            <td class='td_num_c3'>" . number_format($count) . "</td>
                            <td class='td_num'>{$s_rate}%</td>
                        </tr>";
                    }
                } else {
                    echo '<tr><td colspan="4" class="empty_table">자료가 없습니다.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    $pagelist = get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page=');
    if ($pagelist) echo $pagelist;
    ?>
</section>

<div class="local_desc01 local_desc"><p>최근 문의양식폼 전송 내역</p></div>

<!-- ========================== -->
<!-- 창업문의 내역 (Type A) -->
<!-- ========================== -->
<?php if ($is_admin) { ?>
<div style="margin-bottom:10px;">
    <a href='/adm/excel.php?bo_table=email_data&type=A' class="btn_admin btn2" target='_blank'>
        Excel (전체받기)
    </a>
</div>
<?php } ?>
<h2 class="h2_frm">창업문의 내역</h2>
<div class="tbl_head01 tbl_wrap">
    <table>
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
        <tbody>
            <?php
            for ($i=0; $row=sql_fetch_array($resultA); $i++) {
                echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['location']}</td>
                    <td>{$row['budget']}</td>
                    <td>{$row['have']}</td>
                    <td>{$row['gold']}</td>
                    <td>{$row['period']}</td>
                    <td>{$row['content']}</td>
                    <td>{$row['regDate']}</td>
                </tr>";
            }
            if ($i == 0) echo '<tr><td colspan="5">자료가 없습니다.</td></tr>';
            ?>
        </tbody>
    </table>
</div>

<?php if($totalPagesA > 1) { ?>
<nav class="pagination">
    <?php
    for($p=1; $p<=$totalPagesA; $p++){
        echo ($p == $pageA)
            ? "<strong>$p</strong> "
            : "<a href='?pageA={$p}&pageB={$pageB}&pageC={$pageC}'>$p</a> ";
    }
    ?>
</nav>
<?php } ?>

<!-- ========================== -->
<!-- 고객소리 내역 (Type B) -->
<!-- ========================== -->
<?php if ($is_admin) { ?>
<div style="margin-bottom:10px;">
    <a href='/adm/excel.php?bo_table=email_data&type=B' class="btn_admin btn2" target='_blank'>
        Excel (전체받기)
    </a>
</div>
<?php } ?>
<h2 class="h2_frm">고객소리 내역</h2>
<div class="tbl_head01 tbl_wrap">
    <table>
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
        <tbody>
            <?php
            for ($i=0; $row=sql_fetch_array($resultB); $i++) {
                echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['budget']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['content']}</td>
                    <td>{$row['regDate']}</td>
                </tr>";
            }
            if ($i == 0) echo '<tr><td colspan="6">자료가 없습니다.</td></tr>';
            ?>
        </tbody>
    </table>
</div>

<?php if($totalPagesB > 1) { ?>
<nav class="pagination">
    <?php
    for($p=1; $p<=$totalPagesB; $p++){
        echo ($p == $pageB)
            ? "<strong>$p</strong> "
            : "<a href='?pageA={$pageA}&pageB={$p}&pageC={$pageC}'>$p</a> ";
    }
    ?>
</nav>
<?php } ?>
<!-- ========================== -->
<!-- 제안 내역 (Type C) -->
<!-- ========================== -->
<?php if ($is_admin) { ?>
<div style="margin-bottom:10px;">
    <a href='/adm/excel.php?bo_table=email_data&type=C' class="btn_admin btn2" target='_blank'>
        Excel (전체받기)
    </a>
</div>
<?php } ?>
<h2 class="h2_frm">제안 내역</h2>
<div class="tbl_head01 tbl_wrap">
    <table>
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
        <tbody>
            <?php
            for ($i=0; $row=sql_fetch_array($resultC); $i++) {
                echo "<tr>
                    <td>{$row['name']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['budget']}</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['content']}</td>
                    <td>{$row['regDate']}</td>
                </tr>";
            }
            if ($i == 0) echo '<tr><td colspan="6">자료가 없습니다.</td></tr>';
            ?>
        </tbody>
    </table>
</div>

<?php if($totalPagesC > 1) { ?>
<nav class="pagination">
    <?php
    for($p=1; $p<=$totalPagesC; $p++){
        echo ($p == $pageC)
            ? "<strong>$p</strong> "
            : "<a href='?pageA={$pageA}&pageB={$pageB}&pageC={$p}'>$p</a> ";
    }
    ?>
</nav>
<?php } ?>

<!-- 삭제 버튼 스타일 -->
<style>
.emaildelete {
    background: #80808029;
    color: black;
    width: 100%;
    text-align: center;
    padding: 4%;
    font-size: 0.5vw;
    cursor: pointer;
}
</style>

<!-- 삭제 Ajax 스크립트 -->
<script>
$('.emaildelete').on('click', function() {
    if(confirm("삭제하시겠습니까?")){
        $.ajax({
            url: "/bbs/maildelete.php",
            type: "post",
            data: {
                wr_id: $(this).data('value'),
            }
        }).done(function(data) {
            alert("삭제가 완료 되었습니다.");
            location.reload();
        });
    }
});
</script>

<?php
include_once('./admin.tail.php');
?>
