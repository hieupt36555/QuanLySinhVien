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

function nv_demo_list($array_data, $total_pages, $current_page, $keyword,$prev_page,$next_page )
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
            $value['url_detail'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=detail&id=' . $value['id'];
            $value['image'] = NV_BASE_SITEURL . $value['image'];
            $value['class_name'] = isset($value['class_name']) ? $value['class_name'] : 'Chưa có lớp'; // Hiển thị lớp học
            $xtpl->assign('DATA', $value);
            $xtpl->parse('main.loop');
        }
    }

    $xtpl->assign('CURRENT_PAGE', $current_page);
    $xtpl->assign('TOTAL_PAGES', $total_pages);
    $xtpl->assign('PREV_PAGE_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&nv=qlsv&page=' . $prev_page . '&keyword=' . urlencode($keyword));
    $xtpl->assign('NEXT_PAGE_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&nv=qlsv&page=' . $next_page . '&keyword=' . urlencode($keyword));
    $xtpl->parse('main.pagination');
    $xtpl->parse('main');
    return $xtpl->text('main');
}



