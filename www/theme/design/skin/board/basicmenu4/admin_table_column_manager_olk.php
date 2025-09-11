<?php
// admin_table_column_manager.php
// 그누보드5 관리자: 현재 DB의 테이블 목록을 selectbox로 보여주고, 선택 테이블의 컬럼 생성/수정/삭제를 지원하는 단일 파일
// 배치 위치 예: /adm/admin_table_column_manager.php

$sub_menu = '999999'; // 임의 코드. 필요한 경우 메뉴권한에 등록해서 사용하세요.
include_once('./_common.php');

// 접근 권한 체크 (최고관리자 전용 권장)
if ($is_admin !== 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

// CSRF 토큰 준비
$token = get_token();

// 안전한 식별자(테이블/컬럼명) 검사
function valid_ident($s) {
    return (bool)preg_match('/^[A-Za-z0-9_]+$/', $s);
}

function qi($ident) { // Quote Identifier with backticks
    return '`' . str_replace('`', '``', $ident) . '`';
}

// POST 액션 처리 (컬럼 추가/수정/삭제)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_admin_token();

    $mode       = isset($_POST['mode']) ? $_POST['mode'] : '';
    $table      = isset($_POST['table']) ? trim($_POST['table']) : '';
    $col_name   = isset($_POST['col_name']) ? trim($_POST['col_name']) : '';

    if (!valid_ident($table)) alert('올바르지 않은 테이블명입니다.');

    if ($mode === 'add') {
        // 필수값
        $new_name   = trim($_POST['new_name'] ?? '');
        $new_type   = trim($_POST['new_type'] ?? ''); // 예: VARCHAR(255), INT(11) UNSIGNED, DATETIME 등
        $new_null   = isset($_POST['new_null']) ? (int)$_POST['new_null'] : 0; // 1=NULL 허용
        $new_default= $_POST['new_default'] ?? null;  // 문자열 그대로 처리
        $new_extra  = trim($_POST['new_extra'] ?? ''); // AUTO_INCREMENT 등
        $new_comment= trim($_POST['new_comment'] ?? '');
        $new_after  = trim($_POST['new_after'] ?? ''); // 배치 위치 (선택)

        if (!valid_ident($new_name)) alert('새 컬럼명이 올바르지 않습니다.');
        if ($new_after !== '' && !valid_ident($new_after)) alert('배치 기준 컬럼명이 올바르지 않습니다.');
        if ($new_type === '') alert('컬럼 타입을 입력하세요.');

        // DEFAULT 처리
        $default_sql = '';
        if ($_POST['default_mode'] === 'NONE') {
            $default_sql = '';
        } else if ($_POST['default_mode'] === 'NULL') {
            $default_sql = ' DEFAULT NULL';
        } else if ($_POST['default_mode'] === 'VALUE') {
            $default_sql = " DEFAULT '" . sql_escape_string($new_default) . "'";
        }

        $null_sql    = $new_null ? ' NULL' : ' NOT NULL';
        $extra_sql   = $new_extra ? ' ' . $new_extra : '';
        $comment_sql = $new_comment !== '' ? " COMMENT '" . sql_escape_string($new_comment) . "'" : '';
        $after_sql   = $new_after !== '' ? ' AFTER ' . qi($new_after) : ' FIRST';

        $sql = 'ALTER TABLE ' . qi($table) . ' ADD ' . qi($new_name) . ' ' . $new_type . $null_sql . $default_sql . $extra_sql . $comment_sql . $after_sql;
        sql_query($sql);
        alert('컬럼이 추가되었습니다.', $_SERVER['PHP_SELF'] . '?table=' . urlencode($table));

    } else if ($mode === 'modify') {
        if (!valid_ident($col_name)) alert('컬럼명이 올바르지 않습니다.');
        $new_name   = trim($_POST['mod_name'] ?? '');
        $new_type   = trim($_POST['mod_type'] ?? '');
        $new_null   = isset($_POST['mod_null']) ? (int)$_POST['mod_null'] : 0;
        $new_default= $_POST['mod_default'] ?? null;
        $new_extra  = trim($_POST['mod_extra'] ?? '');
        $new_comment= trim($_POST['mod_comment'] ?? '');
        $new_after  = trim($_POST['mod_after'] ?? '');

        if (!valid_ident($new_name)) alert('변경할 컬럼명이 올바르지 않습니다.');
        if ($new_after !== '' && !valid_ident($new_after)) alert('배치 기준 컬럼명이 올바르지 않습니다.');
        if ($new_type === '') alert('컬럼 타입을 입력하세요.');

        $default_sql = '';
        if ($_POST['default_mode'] === 'NONE') {
            $default_sql = '';
        } else if ($_POST['default_mode'] === 'NULL') {
            $default_sql = ' DEFAULT NULL';
        } else if ($_POST['default_mode'] === 'VALUE') {
            $default_sql = " DEFAULT '" . sql_escape_string($new_default) . "'";
        }

        $null_sql    = $new_null ? ' NULL' : ' NOT NULL';
        $extra_sql   = $new_extra ? ' ' . $new_extra : '';
        $comment_sql = $new_comment !== '' ? " COMMENT '" . sql_escape_string($new_comment) . "'" : '';
        $after_sql   = $new_after !== '' ? ' AFTER ' . qi($new_after) : '';

        $sql = 'ALTER TABLE ' . qi($table) . ' CHANGE ' . qi($col_name) . ' ' . qi($new_name) . ' ' . $new_type . $null_sql . $default_sql . $extra_sql . $comment_sql . $after_sql;
        sql_query($sql);
        alert('컬럼이 수정되었습니다.', $_SERVER['PHP_SELF'] . '?table=' . urlencode($table));

    } else if ($mode === 'drop') {
        if (!valid_ident($col_name)) alert('컬럼명이 올바르지 않습니다.');
        $sql = 'ALTER TABLE ' . qi($table) . ' DROP ' . qi($col_name);
        sql_query($sql);
        alert('컬럼이 삭제되었습니다.', $_SERVER['PHP_SELF'] . '?table=' . urlencode($table));

    } else {
        alert('알 수 없는 요청입니다.');
    }
    exit;
}

// 테이블 목록 조회
$tables = [];
$sql = "SELECT table_name FROM information_schema.tables WHERE table_schema = DATABASE() AND table_type='BASE TABLE' ORDER BY table_name";
$qry = sql_query($sql);
while ($row = sql_fetch_array($qry)) {
    $tables[] = $row['table_name'];
}

// 선택된 테이블
$selected_table = isset($_GET['table']) ? trim($_GET['table']) : '';
if ($selected_table && !valid_ident($selected_table)) {
    alert('올바르지 않은 테이블명입니다.');
}

// 선택 테이블의 컬럼 목록
$cols = [];
if ($selected_table) {
    $csql = "SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT, COLUMN_KEY, EXTRA, COLUMN_COMMENT, ORDINAL_POSITION
             FROM information_schema.columns
             WHERE table_schema = DATABASE() AND table_name = '".sql_escape_string($selected_table)."'
             ORDER BY ORDINAL_POSITION";
    $cqry = sql_query($csql);
    while ($r = sql_fetch_array($cqry)) {
        $cols[] = $r;
    }
}

include_once('./admin.head.php');
?>
<style>
.g5-tcm-wrap{max-width:1100px;margin:20px auto;}
.g5-tcm-card{background:#fff;border:1px solid #e5e7eb;border-radius:16px;padding:18px;box-shadow:0 2px 6px rgba(0,0,0,.04)}
.g5-tcm-row{display:flex;gap:12px;align-items:center;flex-wrap:wrap}
.g5-tcm-row + .g5-tcm-row{margin-top:12px}
.g5-tcm-select{padding:8px 12px;border:1px solid #d1d5db;border-radius:10px}
.g5-tcm-btn{padding:8px 12px;border:1px solid #111827;border-radius:10px;background:#111827;color:#fff;cursor:pointer}
.g5-tcm-btn.sub{background:#fff;color:#111827}
.g5-tcm-table{width:100%;border-collapse:collapse;margin-top:14px}
.g5-tcm-table th, .g5-tcm-table td{border:1px solid #e5e7eb;padding:8px 10px;font-size:13px;vertical-align:middle}
.g5-tcm-table th{background:#f9fafb}
.g5-tcm-input{padding:6px 8px;border:1px solid #d1d5db;border-radius:8px;width:100%}
.g5-tcm-small{font-size:12px;color:#6b7280}
.g5-tcm-danger{color:#b91c1c}
</style>
<div class="g5-tcm-wrap">
  <h2>테이블/컬럼 관리</h2>
  <div class="g5-tcm-card">
    <form method="get" class="g5-tcm-row" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="table">테이블 선택</label>
      <select id="table" name="table" class="g5-tcm-select" onchange="this.form.submit()">
        <option value="">-- 테이블을 선택하세요 --</option>
        <?php foreach($tables as $t): ?>
          <option value="<?php echo htmlspecialchars($t); ?>" <?php echo $selected_table===$t?'selected':''; ?>><?php echo htmlspecialchars($t); ?></option>
        <?php endforeach; ?>
      </select>
      <?php if($selected_table): ?>
        <div class="g5-tcm-small">현재 DB: <?php echo htmlspecialchars(G5_MYSQL_DB); ?> · 선택 테이블: <b><?php echo htmlspecialchars($selected_table); ?></b></div>
      <?php endif; ?>
    </form>
  </div>

  <?php if($selected_table): ?>
  <div class="g5-tcm-card" style="margin-top:16px">
    <h3>컬럼 목록</h3>
    <table class="g5-tcm-table">
      <thead>
        <tr>
          <th>#</th>
          <th>컬럼명</th>
          <th>타입</th>
          <th>NULL</th>
          <th>기본값</th>
          <th>KEY</th>
          <th>EXTRA</th>
          <th>설명</th>
          <th>작업</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($cols as $i=>$c): ?>
          <tr>
            <td><?php echo (int)$c['ORDINAL_POSITION']; ?></td>
            <td><?php echo htmlspecialchars($c['COLUMN_NAME']); ?></td>
            <td><?php echo htmlspecialchars($c['COLUMN_TYPE']); ?></td>
            <td><?php echo $c['IS_NULLABLE']==='YES'?'YES':'NO'; ?></td>
            <td><?php echo is_null($c['COLUMN_DEFAULT'])?'NULL':htmlspecialchars($c['COLUMN_DEFAULT']); ?></td>
            <td><?php echo htmlspecialchars($c['COLUMN_KEY']); ?></td>
            <td><?php echo htmlspecialchars($c['EXTRA']); ?></td>
            <td><?php echo htmlspecialchars($c['COLUMN_COMMENT']); ?></td>
            <td>
              <details>
                <summary>수정/삭제</summary>
                <div style="padding:8px 0">
                  <form method="post" class="g5-tcm-row" onsubmit="return confirm('해당 컬럼을 수정하시겠습니까?')">
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <input type="hidden" name="mode" value="modify">
                    <input type="hidden" name="table" value="<?php echo htmlspecialchars($selected_table); ?>">
                    <input type="hidden" name="col_name" value="<?php echo htmlspecialchars($c['COLUMN_NAME']); ?>">

                    <div style="min-width:120px"><label>새 컬럼명<br><input class="g5-tcm-input" name="mod_name" value="<?php echo htmlspecialchars($c['COLUMN_NAME']); ?>" required></label></div>
                    <div style="min-width:180px"><label>타입<br><input class="g5-tcm-input" name="mod_type" value="<?php echo htmlspecialchars($c['COLUMN_TYPE']); ?>" placeholder="예: VARCHAR(255), INT(11) UNSIGNED, DATETIME" required></label></div>
                    <div><label>NULL 허용<br>
                      <select name="mod_null" class="g5-tcm-input">
                        <option value="1" <?php echo $c['IS_NULLABLE']==='YES'?'selected':''; ?>>YES</option>
                        <option value="0" <?php echo $c['IS_NULLABLE']!=='YES'?'selected':''; ?>>NO</option>
                      </select>
                    </label></div>
                    <div><label>기본값 모드<br>
                      <select name="default_mode" class="g5-tcm-input">
                        <option value="NONE">미지정</option>
                        <option value="NULL" <?php echo is_null($c['COLUMN_DEFAULT'])?'selected':''; ?>>NULL</option>
                        <option value="VALUE" <?php echo !is_null($c['COLUMN_DEFAULT'])?'selected':''; ?>>값</option>
                      </select>
                    </label></div>
                    <div style="min-width:160px"><label>기본값(값 모드일 때)<br><input class="g5-tcm-input" name="mod_default" value="<?php echo !is_null($c['COLUMN_DEFAULT'])?htmlspecialchars($c['COLUMN_DEFAULT']):''; ?>"></label></div>
                    <div style="min-width:140px"><label>EXTRA<br><input class="g5-tcm-input" name="mod_extra" value="<?php echo htmlspecialchars($c['EXTRA']); ?>" placeholder="AUTO_INCREMENT 등"></label></div>
                    <div style="min-width:160px"><label>설명(Comment)<br><input class="g5-tcm-input" name="mod_comment" value="<?php echo htmlspecialchars($c['COLUMN_COMMENT']); ?>"></label></div>
                    <div style="min-width:140px"><label>배치 위치 AFTER<br>
                      <select name="mod_after" class="g5-tcm-input">
                        <option value="">(변경 안 함)</option>
                        <option value="">FIRST로 이동 안 함</option>
                        <?php foreach($cols as $cc){ echo '<option value="'.htmlspecialchars($cc['COLUMN_NAME']).'"'.($cc['COLUMN_NAME']===$c['COLUMN_NAME']?' selected':'').'>'.htmlspecialchars($cc['COLUMN_NAME'])."</option>"; } ?>
                      </select>
                    </label></div>

                    <div><button type="submit" class="g5-tcm-btn">수정</button></div>
                  </form>

                  <form method="post" onsubmit="return confirm('정말 이 컬럼을 삭제하시겠습니까? 되돌릴 수 없습니다.')">
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <input type="hidden" name="mode" value="drop">
                    <input type="hidden" name="table" value="<?php echo htmlspecialchars($selected_table); ?>">
                    <input type="hidden" name="col_name" value="<?php echo htmlspecialchars($c['COLUMN_NAME']); ?>">
                    <button type="submit" class="g5-tcm-btn sub"><span class="g5-tcm-danger">삭제</span></button>
                  </form>
                </div>
              </details>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="g5-tcm-card" style="margin-top:16px">
    <h3>컬럼 추가</h3>
    <form method="post" class="g5-tcm-row" onsubmit="return confirm('새 컬럼을 추가하시겠습니까?')">
      <input type="hidden" name="token" value="<?php echo $token; ?>">
      <input type="hidden" name="mode" value="add">
      <input type="hidden" name="table" value="<?php echo htmlspecialchars($selected_table); ?>">

      <div style="min-width:140px"><label>컬럼명<br><input class="g5-tcm-input" name="new_name" required></label></div>
      <div style="min-width:220px"><label>타입<br><input class="g5-tcm-input" name="new_type" placeholder="예: VARCHAR(255), INT(11) UNSIGNED, DATETIME" required></label></div>
      <div><label>NULL 허용<br>
        <select name="new_null" class="g5-tcm-input">
          <option value="1">YES</option>
          <option value="0" selected>NO</option>
        </select>
      </label></div>
      <div><label>기본값 모드<br>
        <select name="default_mode" class="g5-tcm-input">
          <option value="NONE">미지정</option>
          <option value="NULL">NULL</option>
          <option value="VALUE">값</option>
        </select>
      </label></div>
      <div style="min-width:160px"><label>기본값(값 모드일 때)<br><input class="g5-tcm-input" name="new_default"></label></div>
      <div style="min-width:140px"><label>EXTRA<br><input class="g5-tcm-input" name="new_extra" placeholder="AUTO_INCREMENT 등"></label></div>
      <div style="min-width:160px"><label>설명(Comment)<br><input class="g5-tcm-input" name="new_comment"></label></div>
      <div style="min-width:160px"><label>배치 위치<br>
        <select name="new_after" class="g5-tcm-input">
          <option value="">FIRST</option>
          <?php foreach($cols as $cc){ echo '<option value="'.htmlspecialchars($cc['COLUMN_NAME']).'">AFTER '.htmlspecialchars($cc['COLUMN_NAME'])."</option>"; } ?>
        </select>
      </label></div>

      <div><button type="submit" class="g5-tcm-btn">컬럼 추가</button></div>
    </form>
    <p class="g5-tcm-small" style="margin-top:8px">* 타입 예시: VARCHAR(255), INT(11) UNSIGNED, BIGINT, TEXT, DATETIME, DATE, TINYINT(1) 등</p>
  </div>
  <?php endif; ?>

  <div class="g5-tcm-card" style="margin-top:16px">
    <details>
      <summary>주의사항 & 힌트</summary>
      <ul style="margin-top:8px;line-height:1.6">
        <li>실서버에서 구조 변경 전, <b>반드시 DB 백업</b>을 하세요. (mysqldump 또는 phpMyAdmin 내보내기)</li>
        <li>타입/기본값/NULL 설정은 MySQL 문법을 그대로 따릅니다.</li>
        <li>AUTO_INCREMENT는 정수형(PK) 컬럼에서만 사용하세요.</li>
        <li>그누보드 코어 테이블 구조 변경 시, 향후 업데이트/플러그인 호환성에 유의하세요.</li>
      </ul>
    </details>
  </div>
</div>

<?php
include_once('./admin.tail.php');
