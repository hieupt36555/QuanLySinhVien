<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_SYSTEM')) {
    exit('Stop!!!');
}

define('NV_IS_MOD_DEMO', true);

function nv_demo_list($array_data, $total_pages, $current_page, $keyword)
{
    global $module_name, $lang_module, $lang_global, $module_info, $meta_property, $client_info, $page_config, $global_config;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('KEYWORD', htmlspecialchars($keyword, ENT_QUOTES));



    // Kiểm tra nếu mảng không rỗng
    if (!empty($array_data)) {
        $stt = 1;
        foreach ($array_data as $value) {
            $value['stt'] = $stt++;
            $value['birth'] = nv_date('d/m/y', $value['birth']); // Chuyển đổi định dạng ngày tháng
            $value['url_detail'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=detail&id=' . $value['id'];
            $value['image'] = NV_BASE_SITEURL . $value['image'];
            $value['class_name'] = isset($value['class_name']) ? $value['class_name'] : 'Chưa có lớp'; // Hiển thị lớp học
            $xtpl->assign('DATA', $value);
            $xtpl->parse('main.loop');
        }
    }

    // Thêm phân trang
    $pagination_links = generate_pagination_links($current_page, $total_pages, $keyword);
    $xtpl->assign('PAGINATION', $pagination_links);

    $xtpl->parse('main');
    return $xtpl->text('main');
}
function view_product_details($product_id)
{
    global $db, $module_name, $module_info, $lang_module, $module_file;

    // Lấy thông tin sinh viên theo id từ database
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_qlsv WHERE id = ' . intval($product_id);
    $product = $db->query($sql)->fetch();

    if (empty($product)) {
        return false;
    }

    // Lấy thông tin lớp học
    $class_id = intval($product['id_class']); // ID lớp học
    $class_query = $db->query('SELECT name FROM ' . NV_PREFIXLANG . '_qlsv_class WHERE id = ' . $class_id);
    $class = $class_query->fetch();

    // Gán thông tin cho biến
    $product['class_name'] = !empty($class) ? $class['name'] : 'Chưa có lớp'; // Tên lớp
    $product['birth'] = nv_date('d/m/y', $product['birth']);
    $product['image'] = NV_BASE_SITEURL . $product['image'];

    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('DATA', $product);

    $xtpl->parse('main');
    return $xtpl->text('main');
}


function generate_pagination_links($current_page, $total_pages, $keyword)
{
    $pagination_html = '<nav aria-label="Page navigation example"><ul class="pagination">';

    // Link trang trước
    if ($current_page > 1) {
        $prev_page = $current_page - 1;
        $pagination_html .= '<li class="page-item"><a class="page-link" href="' . NV_BASE_SITEURL . 'index.php?language=' . NV_LANG_DATA . '&nv=qlsv&page=' . $prev_page . '&keyword=' . urlencode($keyword) . '">Trang trước</a></li>';
    }

    // Thêm các liên kết đến các trang
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $current_page) {
            $pagination_html .= '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>'; // Trang hiện tại
        } else {
            $pagination_html .= '<li class="page-item"><a class="page-link" href="' . NV_BASE_SITEURL . 'index.php?language=' . NV_LANG_DATA . '&nv=qlsv&page=' . $i . '&keyword=' . urlencode($keyword) . '">' . $i . '</a></li>';
        }
    }

    // Link trang kế tiếp
    if ($current_page < $total_pages) {
        $next_page = $current_page + 1;
        $pagination_html .= '<li class="page-item"><a class="page-link" href="' . NV_BASE_SITEURL . 'index.php?language=' . NV_LANG_DATA . '&nv=qlsv&page=' . $next_page . '&keyword=' . urlencode($keyword) . '">Trang sau</a></li>';
    }

    $pagination_html .= '</ul></nav>';

    return $pagination_html;
}
