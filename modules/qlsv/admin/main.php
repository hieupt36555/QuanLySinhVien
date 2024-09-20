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

// $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . NV_LANG_DATA . '_demo');
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_qlsv');
while ($row = $query->fetch()) {
    $array[$row['id']] = $row;
}

if($nv_Request-> isset_request('action', 'post, get')){
    $row['id'] = $nv_Request->get_int('id', 'post, get', 0);
    $checksess = $nv_Request->get_title('checksess', 'post, get', '');
    if($row['id'] > 0  and $checksess == md5($row['id']. NV_CHECK_SESSION) ){
        $db->query('DELETE FROM `nv4_vi_qlsv` WHERE id='. $row['id']);
    }
}


$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

if(!empty($array)){
    foreach($array as $value){
        $value['birth']= nv_date( 'd/m/y' ,$value['birth']);
        $value['url_edit']= NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name.'&'. NV_OP_VARIABLE. '=add&id='.$value['id'];
        $value['url_delete']= NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name.'&'. NV_OP_VARIABLE. '=main&id='.$value['id']. '&action=delete&checksess='. md5($row['id']. NV_CHECK_SESSION);
        $xtpl->assign('DATA', $value);
        $xtpl->parse('main.loop');
    }
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
