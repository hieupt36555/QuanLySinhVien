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
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_demo');
while ($row = $query->fetch()) {
    $array[$row['id']] = $row;
}
$xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

if(!empty($array)){
    foreach($array as $value){
        $value['birth']= nv_date( 'd/m/y' ,$value['birth']);
        $xtpl->assign('DATA', $value);
        $xtpl->parse('main.loop');
    }
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
