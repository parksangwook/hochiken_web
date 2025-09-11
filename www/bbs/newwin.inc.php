<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (!defined('_SHOP_')) {
    $pop_division = 'comm';
} else {
    $pop_division = 'comm';
}

// co_id GET 값 받기
$current_co_id = isset($_GET['co_id']) ? $_GET['co_id'] : '';
if ($current_co_id === '') {
    $current_co_id = 'main';
}

// 기기 확인
$is_mobile = G5_IS_MOBILE; // true: 모바일, false: PC

// 팝업 노출 SQL
$sql = "SELECT * FROM {$g5['new_win_table']}
        WHERE '".G5_TIME_YMDHIS."' BETWEEN nw_begin_time AND nw_end_time
          AND nw_division IN ('both', '{$pop_division}')
        ORDER BY nw_order ASC, nw_id ASC";
$result = sql_query($sql, false);
?>
<style>
.hd_pops_footer{
    display: flex;
    justify-content: space-around;
    align-items: center;
    width: 100%;
    font-family: pretendard-bold !important;
}
.hd_pops_footer button{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 33%;
    position: relative !important;
    color: #666 !important;
    background: #f7f7f7 !important;
    font-family: pretendard-regular !important;
}
.hd_pops_footer .hd_pops_reject{}
.hd_pops_close_all{
    border-left: 1px solid rgba(0,0,0,0.07) !important;
    border-right: 1px solid rgba(0,0,0,0.07) !important;
}
.hd_pops_con >p{
    display: flex;
}
.hd_pops_footer {
    background: #f7f7f7 !important;
}
#hd_pop > div {
    overflow: hidden;
    background: #f7f7f7 !important;
    border-radius: unset !important;
}
</style>

<div id="hd_pop">
    <h2>팝업레이어 알림</h2>

<?php
$i = 0;
while ($nw = sql_fetch_array($result)) {

    // 쿠키 체크
    if (isset($_COOKIE["hd_pops_{$nw['nw_id']}"]) && $_COOKIE["hd_pops_{$nw['nw_id']}"])
        continue;

    // nw_pages 조건 처리
    $nw_pages = trim($nw['nw_pages']);
    if ($nw_pages !== 'all') {
        $pages = array_map('trim', explode(',', $nw_pages));
        if (!in_array($current_co_id, $pages)) continue;
    }

    // nw_device 조건 처리 (서버 사이드)
    $nw_device = strtolower(trim($nw['nw_device'])); // 'both', 'pc', 'mobile'
    if ($is_mobile && $nw_device === 'pc') continue;       // 모바일이면 PC 전용 제외
    if (!$is_mobile && $nw_device === 'mobile') continue;  // PC이면 모바일 전용 제외
    // 'both'는 그대로 노출

    $i++;
?>
    <div id="hd_pops_<?php echo $nw['nw_id'] ?>" class="hd_pops" style="top:<?php echo $nw['nw_top']?>px;left:<?php echo $nw['nw_left']?>px">
        <div class="hd_pops_con" style="width:<?php echo $nw['nw_width'] ?>px;height:<?php echo $nw['nw_height'] ?>px">
            <?php echo conv_content($nw['nw_content'], 1); ?>
        </div>
        <div class="hd_pops_footer">
            <button class="hd_pops_reject hd_pops_<?php echo $nw['nw_id']; ?> <?php echo $nw['nw_disable_hours']; ?>">
                <strong><?php echo $nw['nw_disable_hours']; ?></strong>시간 닫기
            </button>
            <button class="hd_pops_close_all hd_pops_close">팝업전체닫기</button>
            <button class="hd_pops_close hd_pops_<?php echo $nw['nw_id']; ?>">닫기</button>
        </div>
    </div>
<?php }

if ($i == 0) echo '<span class="sound_only">팝업레이어 알림이 없습니다.</span>';
?>
</div>

<script>
$(function() {
    $(".hd_pops_reject").click(function() {
        var id = $(this).attr('class').split(' ');
        var ck_name = id[1];
        var exp_time = parseInt(id[2]);
        $("#"+id[1]).css("display", "none");
        set_cookie(ck_name, 1, exp_time, g5_cookie_domain);
    });

    $('.hd_pops_close').click(function() {
        var idb = $(this).attr('class').split(' ');
        $('#'+idb[1]).css('display','none');
    });

    $("#hd").css("z-index", 1000);

    $('.hd_pops_close_all').on('click',function(){
        $('#hd_pop div').hide();
        var sections = document.querySelectorAll('section');
        sections.forEach(function(section) {
            section.style.removeProperty('filter');
            section.style.removeProperty('pointer-events');
        });
    });
});
</script>
