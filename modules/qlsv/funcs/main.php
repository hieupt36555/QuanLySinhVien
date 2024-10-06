<?php


if (!defined('NV_IS_MOD_DEMO')) {
    exit('Stop!!!');
}
    // require_once '/modules/qlsv/action_mysql.php';
    $get_all_products = 'SELECT * FROM ' . NV_PREFIXLANG . '_qlsv';

    //lấy tất cả sản phẩm từ database 
    $array_data = [];
    $query = $db->query($get_all_products);
    while ($row = $query->fetch()) {
        $array_data[$row['id']] = $row;
    }
    $contents = nv_demo_list($array_data);
    
    //nếu url có id -> hiển thị chi tiết sp ngược lại hiện thị tất cả sản phẩm
    $product_id = $nv_Request->get_int('id', 'get', 0);
    if ($product_id > 0) {
        $contents = view_product_details($product_id);
    } else {
        $contents = nv_demo_list($array_data);
    }

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';



