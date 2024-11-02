<?php

if (!defined('NV_IS_MOD_DEMO')) {
    exit('Stop!!!');
}
require_once NV_ROOTDIR . '/modules/qlsv/funcs/detail.php';


// Lấy trang hiện tại từ URL
$page = $nv_Request->get_int('page', 'get', 1);
$limit = 5;  // Số lượng sinh viên hiển thị trên mỗi trang
$offset = ($page - 1) * $limit;
$array_data = [];

// Lấy từ khóa tìm kiếm từ URL
$keyword = $nv_Request->get_title('keyword', 'get', '');

// Nếu có từ khóa, chuẩn bị truy vấn với điều kiện LIKE
if (!empty($keyword)) {
    $sql = 'SELECT s.*, c.name AS class_name FROM ' . NV_PREFIXLANG . '_qlsv s 
            LEFT JOIN ' . NV_PREFIXLANG . '_qlsv_class c ON s.id_class = c.id 
            WHERE s.name LIKE :keyword LIMIT ' . $limit . ' OFFSET ' . $offset;
    $query = $db->prepare($sql);
    $query->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $query->execute();
    $array_data = $query->fetchAll(PDO::FETCH_ASSOC);

    // Cập nhật tổng số sinh viên tìm được
    $total_items_query = $db->prepare('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_qlsv WHERE name LIKE :keyword');
    $total_items_query->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $total_items_query->execute();
    $total_items = $total_items_query->fetchColumn();
} else {
    // Nếu không có từ khóa, lấy tất cả sinh viên
    $sql = 'SELECT s.*, c.name AS class_name FROM ' . NV_PREFIXLANG . '_qlsv s 
            LEFT JOIN ' . NV_PREFIXLANG . '_qlsv_class c ON s.id_class = c.id 
            LIMIT ' . $limit . ' OFFSET ' . $offset;
    $query = $db->query($sql);
    $array_data = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_items = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_qlsv')->fetchColumn();
}

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


// Tính toán tổng số trang
$total_items = $db->query('SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_qlsv WHERE 1' . ($selected_class_id > 0 ? ' AND id_class = ' . $selected_class_id : ''))->fetchColumn();
$total_pages = ceil($total_items / $limit);
$prev_page = ($page > 1) ? $page - 1 : 1;
$next_page = ($page < $total_pages) ? $page + 1 : $total_pages;

// Gọi hàm hiển thị danh sách hoặc chi tiết sản phẩm dựa trên tham số `id`
$product_id = $nv_Request->get_int('id', 'get', 0);
if ($product_id > 0) {
    // Nếu có ID sản phẩm, gọi hàm để lấy thông tin chi tiết
    $contents = view_product_details($product_id);
} else {
    // Nếu không có ID sản phẩm, lấy danh sách sinh viên
    $contents = nv_demo_list($array_data, $total_pages, $page, $keyword,$prev_page,$next_page);
}

// Phân trang và URL tìm kiếm
$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
$xtpl->assign('CURRENT_PAGE', $page);
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
// Kết xuất nội dung ra ngoài site
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
