<?php

if (!defined('NV_IS_MOD_DEMO')) {
    exit('Stop!!!');
}

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

// Tính toán tổng số trang
$total_pages = ceil($total_items / $limit);
$prev_page = ($page > 1) ? $page - 1 : 1; // Trang trước
$next_page = ($page < $total_pages) ? $page + 1 : $total_pages; // Trang sau

// Gọi hàm hiển thị danh sách hoặc chi tiết sản phẩm dựa trên tham số `id`
$product_id = $nv_Request->get_int('id', 'get', 0);
if ($product_id > 0) {
    $contents = view_product_details($product_id);
} else {
    $contents = nv_demo_list($array_data, $total_pages, $page, $keyword);
}

// Phân trang và URL tìm kiếm
$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
$xtpl->assign('CURRENT_PAGE', $page);
$xtpl->assign('TOTAL_PAGES', $total_pages);
$xtpl->assign('PREV_PAGE_URL', NV_BASE_SITEURL . 'index.php?language=' . NV_LANG_DATA . '&nv=qlsv&page=' . $prev_page . '&keyword=' . urlencode($keyword));
$xtpl->assign('NEXT_PAGE_URL', NV_BASE_SITEURL . 'index.php?language=' . NV_LANG_DATA . '&nv=qlsv&page=' . $next_page . '&keyword=' . urlencode($keyword));
$xtpl->assign('KEYWORD', htmlspecialchars($keyword, ENT_QUOTES));
$xtpl->assign('PAGINATION', generate_pagination_links($page, $total_pages, $keyword));

// Kết xuất nội dung ra ngoài site
include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
