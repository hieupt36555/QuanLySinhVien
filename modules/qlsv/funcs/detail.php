<?php

if (!defined('NV_SYSTEM')) {
    exit('Stop!!!');
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
    $class_id = intval($product['id_class']);
    $class_query = $db->query('SELECT name FROM ' . NV_PREFIXLANG . '_qlsv_class WHERE id = ' . $class_id);
    $class = $class_query->fetch();

    // Gán thông tin cho biến
    $product['class_name'] = !empty($class) ? $class['name'] : 'Chưa có lớp';
    $product['birth'] = nv_date('d/m/y', $product['birth']);
    $product['image'] = NV_BASE_SITEURL . $product['image'];

    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('DATA', $product);

    $xtpl->parse('main');
    return $xtpl->text('main');
}
