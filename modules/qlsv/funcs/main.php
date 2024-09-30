<?php


if (!defined('NV_IS_MOD_DEMO')) {
    exit('Stop!!!');
}
// $array_data = [];

// $query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_qlsv');
// while ($row = $query->fetch()) {
//     $array_data[$row['id']] = $row;
// }
// $contents = nv_demo_list($array_data);

// //chức năng xem chi tiết
// $product_id = $nv_Request->get_int('id', 'get', 0);
// if ($product_id > 0) {
//     include NV_ROOTDIR . '/modules/qlsv/details.php';
//     $contents = view_product_details($product_id);
// } else {
//     $contents = nv_demo_list($array_data);
// }

// include NV_ROOTDIR . '/includes/header.php';
// echo nv_site_theme($contents);
// include NV_ROOTDIR . '/includes/footer.php';

include NV_ROOTDIR . '/modules/qlsv/functions.php';

$array_data = get_data_from_db();

$product_id = $nv_Request->get_int('id', 'get', 0);

if ($product_id > 0) {
    $contents = get_product_details($product_id);
} else {
    $contents = nv_demo_list($array_data);
}

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
?>
