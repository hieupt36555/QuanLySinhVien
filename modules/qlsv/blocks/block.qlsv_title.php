<?php

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

function nv_block_qlsv_title($block_config)
{
    global $module_name, $module_info, $module_file;

    if ($module_name == 'qlsv') {
        // Lấy tiêu đề của module
        $title = $module_info['custom_title'];

        // Load template và truyền dữ liệu vào template
        $xtpl = new XTemplate('block_qlsv_title.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/qlsv');
        $xtpl->assign('TITLE', $title);
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    return '';
}
