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

$row['id'] = $nv_Request->get_int('id', 'post, get', 0);
if($nv_Request-> isset_request('submit1', 'post')){
    $row['name'] = nv_substr($nv_Request->get_title('name', 'post', ''), 0, 250);
    $row['birth'] = $nv_Request->get_int('birth', 'post', '');
    $row['address'] = nv_substr($nv_Request->get_title('address', 'post', ''), 0, 250);


    // $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' (
    //     name, birth, address) VALUES (
    //     :name, :birth, :address)';
    
    $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET name=:name,birth=:birth,address=:address WHERE id='.$row['id'];

    $sth = $db->prepare($_sql);
    $sth->bindParam(':name', $row['name'], PDO::PARAM_STR);
    $sth->bindParam(':birth', $row['birth'], PDO::PARAM_STR);
    $sth->bindParam(':address', $row['address'], PDO::PARAM_STR);
    $exe = $sth->execute();

    if($exe){
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
    }

}

$xtpl = new XTemplate('add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);


$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
