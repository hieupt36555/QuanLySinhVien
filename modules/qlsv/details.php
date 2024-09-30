<?php

if (!defined('NV_IS_MOD_DEMO')) {
    die('Stop!!!');
}

function view_product_details($product_id)
{
    global $db, $module_name, $module_info, $lang_module, $module_file;

    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_qlsv WHERE id = ' . intval($product_id);

    $product = $db->query($sql)->fetch();

    if (empty($product)) {
        return false; 
    }

    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('DATA', $product);
    
    $xtpl->parse('main');
    return $xtpl->text('main');

    $product_id = $nv_Request->get_int('id', 'get', 0);
if ($product_id > 0) {
    $contents = view_product_details($product_id);
} else {
    $contents = 'Sản phẩm không tồn tại.';
}

}