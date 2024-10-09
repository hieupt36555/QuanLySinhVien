<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['list'];
$array = [];


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

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_qlsv LIMIT ' . $limit . ' OFFSET ' . $offset);
while ($row = $query->fetch()) {
    $array[$row['id']] = $row;
}
$total_items = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_qlsv')->fetchColumn();
$total_pages = ceil($total_items / $limit);

$prev_page = ($page > 1) ? $page - 1 : 1;
$next_page = ($page < $total_pages) ? $page + 1 : $total_pages;


$xtpl->assign('CURRENT_PAGE', $page);
$xtpl->assign('TOTAL_PAGES', $total_pages);
$xtpl->assign('PREV_PAGE_URL', NV_BASE_ADMINURL . 'index.php?language=' . NV_LANG_DATA . '&nv=qlsv&page=' . $prev_page . '&keyword=' . urlencode($keyword));
$xtpl->assign('NEXT_PAGE_URL', NV_BASE_ADMINURL . 'index.php?language=' . NV_LANG_DATA . '&nv=qlsv&page=' . $next_page . '&keyword=' . urlencode($keyword));
$xtpl->assign('KEYWORD', htmlspecialchars($keyword, ENT_QUOTES));


if (!empty($array)) {
    $stt = 1;
    // Lấy danh sách danh mục vào một mảng để sử dụng sau
    $category_list_query = $db->query("SELECT id, name FROM " . NV_PREFIXLANG . "_qlsv_class");
    $category_list = $category_list_query->fetchAll(PDO::FETCH_KEY_PAIR);

    // Kiểm tra nếu danh mục tồn tại
    if ($category_list === false) {
        // Xử lý trường hợp không lấy được danh mục
        die('Error fetching categories');
    }
    foreach ($array as $value) {
        $value['stt'] = $stt++;
        $value['birth'] = nv_date('d/m/y', $value['birth']);
        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=add&id=' . $value['id'];
        $value['url_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main&id=' . $value['id'] . '&action=delete&checksess=' . md5($row['id'] . NV_CHECK_SESSION);
        $value['image'] = NV_BASE_SITEURL . $value['image'];
        $value['class_name'] = isset($category_list[$value['id_class']]) ? $category_list[$value['id_class']] : 'Chưa có lớp';
        $xtpl->assign('DATA', $value);
        $xtpl->parse('main.loop');
    }
}


// tìm kiếm
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
if (!empty($keyword)) {
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_qlsv WHERE name LIKE :keyword LIMIT ' . $limit . ' OFFSET ' . $offset;
    $query = $db->prepare($sql);
    $query->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $query->execute();
} else {
    $query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_qlsv LIMIT ' . $limit . ' OFFSET ' . $offset);
}




$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
