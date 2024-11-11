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


$xtpl = new XTemplate('listclass.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);


//hiển thị danh sách lớp
$query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_qlsv_class');
while ($row = $query->fetch()) {
    $array[$row['id']] = $row;
}

if (!empty($array)) {
    $stt = 1;
    foreach ($array as $value) {
        $value['stt'] = $stt++;
        $value['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=add_class&id=' . $value['id'];
        $value['url_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main&id=' . $value['id'] . '&action=delete&checksess=' . md5($row['id'] . NV_CHECK_SESSION);
        $value['url_detail'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=detailclass&id=' . $value['id'];
        $xtpl->assign('DATA', $value);

        // Truy vấn để lấy danh sách sinh viên của lớp hiện tại
        $query_students = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_qlsv WHERE id_class = ' . $value['id']);
        $students = $query_students->fetchAll();

        if (!empty($students)) {
            foreach ($students as $student) {
                $xtpl->assign('STUDENT', $student);
                $xtpl->parse('main.loop.student_loop'); // Parse sinh viên trong mỗi lớp
            }
        } else {
            $xtpl->assign('NO_STUDENTS', 'Không có sinh viên trong lớp này');
            $xtpl->parse('main.loop.no_students'); // Nếu không có sinh viên
        }

        $xtpl->parse('main.loop');
    }
}


$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
