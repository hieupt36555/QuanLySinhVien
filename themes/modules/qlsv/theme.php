<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_MOD_DEMO')) {
    exit('Stop!!!');
}

/**
 * nv_page_main()
 *
 * @param array  $row
 * @param array  $ab_links
 * @param string $content_comment
 * @return string
 */
function nv_demo_list($array_data)
{
    global $module_name, $lang_module, $lang_global, $module_info, $meta_property, $client_info, $page_config, $global_config;

    $xtpl = new XTemplate('main.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('CONTENT', $row);
 
    if(!empty($array_data)){
        foreach($array_data as $value){
            $value['birth']= nv_date( 'd/m/y' ,$value['birth']);
            $xtpl->assign('DATA', $value);
            $xtpl->parse('main.loop');
        }
    }
    

    $xtpl->parse('main');

    return $xtpl->text('main');
}

