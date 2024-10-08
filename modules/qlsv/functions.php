<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_SYSTEM')) {
    exit('Stop!!!');
}

define('NV_IS_MOD_DEMO', true);


function nv_demo_list($array_data)
{
    global $module_name, $lang_module, $lang_global, $module_info, $meta_property, $client_info, $page_config, $global_config;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
 
    // Kiểm tra nếu mảng không rỗng
    if(!empty($array_data)){
        foreach($array_data as $value){
            $value['birth']= nv_date( 'd/m/y' ,$value['birth']); //chuyển đổi định dạnh ngày tháng
            $value['url_detail']= nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name.'&'. NV_OP_VARIABLE. '=details&id='.$value['id']); //làm đẹp url
            $xtpl->assign('DATA', $value);
            $xtpl->parse('main.loop');
        }
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}


//hàm chi tiết sản phẩm 
function view_product_details($product_id)
{
    global $db, $module_name, $module_info, $lang_module, $module_file;

    //lấy 1 sản phẩm theo id từ database
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_qlsv WHERE id = ' . intval($product_id);
    $product = $db->query($sql)->fetch();
    if (empty($product)) {
        return false; 
    }

    $xtpl = new XTemplate('detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('DATA', $product);
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}