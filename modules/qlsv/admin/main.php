<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['list'];
$array = [];

// Xử lý xóa sinh viên
if ($nv_Request->isset_request('action', 'post, get')) {
    $row['id'] = $nv_Request->get_int('id', 'post, get', 0);
    $checksess = $nv_Request->get_title('checksess', 'post, get', '');

    if ($row['id'] > 0  and $checksess == md5($row['id'] . NV_CHECK_SESSION)) {
        $db->query('DELETE FROM `nv4_vi_qlsv` WHERE id=' . $row['id']);
    }
}



$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

// Tính Năng Phân Trang & tìm kiếm
$page = $nv_Request->get_int('page', 'get', 1); 
$limit = 5;
$offset = ($page - 1) * $limit;


// Lấy id_class từ request
$selected_class_id = $nv_Request->get_int('id_class', 'get', 0);
// Truy vấn danh sách sinh viên theo lớp học
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_qlsv WHERE 1';
if ($selected_class_id > 0) {
    $sql .= ' AND id_class = ' . $selected_class_id;
}
$sql .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;

$query = $db->query($sql);
while ($row = $query->fetch()) {
    $array[$row['id']] = $row;
}

// Truy vấn tổng số sinh viên
$total_items = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_qlsv WHERE 1' . ($selected_class_id > 0 ? ' AND id_class = ' . $selected_class_id : ''))->fetchColumn();
$total_pages = ceil($total_items / $limit);
$prev_page = ($page > 1) ? $page - 1 : 1;
$next_page = ($page < $total_pages) ? $page + 1 : $total_pages;

// Tìm kiếm
$keyword = $nv_Request->get_title('keyword', 'get', '');
if (!empty($keyword)) {
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_qlsv WHERE name LIKE :keyword LIMIT ' . $limit . ' OFFSET ' . $offset;
    $query = $db->prepare($sql);
    $query->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $query->execute();
    $array = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_items = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_qlsv WHERE name LIKE :keyword');
    $total_items->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $total_items->execute();
    $total_items = $total_items->fetchColumn();
} else {
    $query = $db->query($sql);
    $array = $query->fetchAll(PDO::FETCH_ASSOC);
}

// Phân trang
$xtpl->assign('CURRENT_PAGE', $page);
$xtpl->assign('TOTAL_PAGES', $total_pages);
$xtpl->assign('PREV_PAGE_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&nv=qlsv&page=' . $prev_page . '&id_class=' . $selected_class_id . '&keyword=' . urlencode($keyword));
$xtpl->assign('NEXT_PAGE_URL', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&nv=qlsv&page=' . $next_page . '&id_class=' . $selected_class_id . '&keyword=' . urlencode($keyword));
$xtpl->assign('KEYWORD', htmlspecialchars($keyword, ENT_QUOTES));

// Lấy danh sách lớp học
$class_list = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_qlsv_class")->fetchAll();
foreach ($class_list as $class) {
    $xtpl->assign('CLASS', [
        'id' => $class['id'],
        'name' => $class['name'],
        'selected' => ($selected_class_id == $class['id']) ? 'selected="selected"' : ''
    ]);
    $xtpl->parse('main.class');
}

// Hiển thị sinh viên
if (!empty($array)) {
    $stt = 1;
    foreach ($array as $value) {
        $value['stt'] = $stt++;
        $value['birth'] = nv_date('d/m/y', $value['birth']);
        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=add_student&id=' . $value['id'];
        $value['url_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main&id=' . $value['id'] . '&action=delete&checksess=' . md5($value['id'] . NV_CHECK_SESSION);
        $value['confirm_delete'] = 'return confirm("Bạn có chắc chắn muốn xóa sinh viên này không?");';
        $value['image'] = NV_BASE_SITEURL . $value['image'];
        $value['class_name'] = isset($class_list[$value['id_class']]) ? $class_list[$value['id_class']]['name'] : 'Chưa có lớp';
        $xtpl->assign('DATA', $value);
        $xtpl->parse('main.loop');
    }
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
