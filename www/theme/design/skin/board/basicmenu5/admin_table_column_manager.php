<?php
// admin_table_column_manager.php
// 그누보드5 관리자: 테이블 선택 후 컬럼 목록, 추가/수정/삭제 기능

$sub_menu = '999999';
include_once('./_common.php');

if ($is_admin !== 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

$token = get_token();

function valid_ident($s) { return (bool)preg_match('/^[A-Za-z0-9_]+$/', $s); }
function qi($ident) { return '`' . str_replace('`', '``', $ident) . '`'; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_admin_token();

    $mode  = $_POST['mode'] ?? '';
    $table = trim($_POST['table'] ?? '');
    $col   = trim($_POST['col_name'] ?? '');

    if (!valid_ident($table)) alert('테이블명이 잘못되었습니다.');

    if ($mode === 'add') {
        $new_name = trim($_POST['new_name'] ?? '');
        $new_type = trim($_POST['new_type'] ?? '');
        if (!valid_ident($new_name)) alert('컬럼명이 잘못되었습니다.');
        if ($new_type === '') alert('타입을 선택하세요.');
        $sql = 'ALTER TABLE ' . qi($table) . ' ADD ' . qi($new_name) . ' ' . $new_type;
        sql_query($sql);
        alert('컬럼이 추가되었습니다.', $_SERVER['PHP_SELF'] . '?table=' . urlencode($table));
    } elseif ($mode === 'modify') {
        $new_name = trim($_POST['mod_name'] ?? '');
        $new_type = trim($_POST['mod_type'] ?? '');
        if (!valid_ident($col) || !valid_ident($new_name)) alert('컬럼명이 잘못되었습니다.');
        if ($new_type === '') alert('타입을 선택하세요.');
        $sql = 'ALTER TABLE ' . qi($table) . ' CHANGE ' . qi($col) . ' ' . qi($new_name) . ' ' . $new_type;
        sql_query($sql);
        alert('컬럼이 수정되었습니다.', $_SERVER['PHP_SELF'] . '?table=' . urlencode($table));
    } elseif ($mode === 'drop') {
        if (!valid_ident($col)) alert('컬럼명이 잘못되었습니다.');
        $sql = 'ALTER TABLE ' . qi($table) . ' DROP ' . qi($col);
        sql_query($sql);
        alert('컬럼이 삭제되었습니다.', $_SERVER['PHP_SELF'] . '?table=' . urlencode($table));
    }
    exit;
}

// 테이블 목록
$tables = [];
$sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = DATABASE() ORDER BY table_name";
$qry = sql_query($sql);
while ($row = sql_fetch_array($qry)) $tables[] = $row['table_name'];

$selected_table = trim($_GET['table'] ?? '');
if ($selected_table && !valid_ident($selected_table)) alert('잘못된 테이블명');

$cols = [];
if ($selected_table) {
    $csql = "SELECT COLUMN_NAME, COLUMN_TYPE, ORDINAL_POSITION FROM information_schema.columns
             WHERE table_schema = DATABASE() AND table_name = '".sql_escape_string($selected_table)."'
             ORDER BY ORDINAL_POSITION";
    $cqry = sql_query($csql);
    while ($r = sql_fetch_array($cqry)) $cols[] = $r;
}

include_once('./admin.head.php');
?>
<style>
.g5-tcm-wrap{max-width:900px;margin:20px auto;}
.g5-tcm-card{background:#fff;border:1px solid #ddd;border-radius:12px;padding:16px;margin-bottom:20px}
.g5-tcm-table{width:100%;border-collapse:collapse;margin-top:14px}
.g5-tcm-table th,.g5-tcm-table td{border:1px solid #ddd;padding:8px 10px;font-size:13px;text-align:left}
.g5-tcm-input,.g5-tcm-select{padding:6px 10px;border:1px solid #ccc;border-radius:6px}
.g5-tcm-btn{padding:6px 12px;border-radius:6px;border:1px solid #333;background:#333;color:#fff;cursor:pointer}
</style>
<div class="g5-tcm-wrap">
  <h2>테이블/컬럼 관리</h2>

  <div class="g5-tcm-card">
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label>테이블 선택: 
        <select name="table" class="g5-tcm-select" onchange="this.form.submit()">
          <option value="">-- 선택 --</option>
          <?php foreach($tables as $t): ?>
            <option value="<?php echo $t; ?>" <?php echo $selected_table===$t?'selected':''; ?>><?php echo $t; ?></option>
          <?php endforeach; ?>
        </select>
      </label>
    </form>
  </div>

  <?php if($selected_table): ?>
  <div class="g5-tcm-card">
    <h3>컬럼 목록 (<?php echo $selected_table; ?>)</h3>
    <table class="g5-tcm-table">
      <thead>
        <tr>
          <th>#</th>
          <th>컬럼명</th>
          <th>타입</th>
          <th>작업</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($cols as $c): ?>
        <tr>
          <td><?php echo $c['ORDINAL_POSITION']; ?></td>
          <td><?php echo $c['COLUMN_NAME']; ?></td>
          <td><?php echo $c['COLUMN_TYPE']; ?></td>
          <td>
            <details>
              <summary>수정/삭제</summary>
              <form method="post" style="margin:6px 0">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input type="hidden" name="mode" value="modify">
                <input type="hidden" name="table" value="<?php echo $selected_table; ?>">
                <input type="hidden" name="col_name" value="<?php echo $c['COLUMN_NAME']; ?>">
                새 컬럼명: <input class="g5-tcm-input" name="mod_name" value="<?php echo $c['COLUMN_NAME']; ?>">
                타입:
                <select name="mod_type" class="g5-tcm-select">
                  <option value="INT(11)" <?php echo stripos($c['COLUMN_TYPE'],'int')!==false?'selected':''; ?>>INT(11)</option>
                  <option value="BIGINT" <?php echo stripos($c['COLUMN_TYPE'],'bigint')!==false?'selected':''; ?>>BIGINT</option>
                  <option value="VARCHAR(255)" <?php echo stripos($c['COLUMN_TYPE'],'varchar')!==false?'selected':''; ?>>VARCHAR(255)</option>
                  <option value="TEXT" <?php echo stripos($c['COLUMN_TYPE'],'text')!==false?'selected':''; ?>>TEXT</option>
                  <option value="DATETIME" <?php echo stripos($c['COLUMN_TYPE'],'datetime')!==false?'selected':''; ?>>DATETIME</option>
                </select>
                <button type="submit" class="g5-tcm-btn">수정</button>
              </form>
              <form method="post" onsubmit="return confirm('삭제하시겠습니까?')">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <input type="hidden" name="mode" value="drop">
                <input type="hidden" name="table" value="<?php echo $selected_table; ?>">
                <input type="hidden" name="col_name" value="<?php echo $c['COLUMN_NAME']; ?>">
                <button type="submit" class="g5-tcm-btn" style="background:#900">삭제</button>
              </form>
            </details>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="g5-tcm-card">
    <h3>컬럼 추가</h3>
    <form method="post">
      <input type="hidden" name="token" value="<?php echo $token; ?>">
      <input type="hidden" name="mode" value="add">
      <input type="hidden" name="table" value="<?php echo $selected_table; ?>">
      컬럼명: <input class="g5-tcm-input" name="new_name" required>
      타입: 
      <select name="new_type" class="g5-tcm-select" required>
        <option value="">--선택--</option>
        <option value="INT(11)">INT(11)</option>
        <option value="BIGINT">BIGINT</option>
        <option value="VARCHAR(255)">VARCHAR(255)</option>
        <option value="TEXT">TEXT</option>
        <option value="DATETIME">DATETIME</option>
      </select>
      <button type="submit" class="g5-tcm-btn">추가</button>
    </form>
  </div>
  <?php endif; ?>
</div>
<?php include_once('./admin.tail.php'); ?>
