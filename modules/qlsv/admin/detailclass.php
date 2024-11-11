<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = "Chi tiết lớp học";
$class_id = $nv_Request->get_int('id', 'get', 0);

// Kiểm tra nếu class_id không tồn tại
if ($class_id <= 0) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&nv=listclass');
}

// Lấy thông tin lớp học
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_qlsv_class WHERE id = ' . $class_id;
$class_info = $db->query($sql)->fetch();
if (!$class_info) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&nv=listclass');
}

// Phân trang
$per_page = 6; // Số sinh viên hiển thị mỗi trang
$page = $nv_Request->get_int('page', 'get', 1); // Lấy số trang từ URL, mặc định là trang 1
$start = ($page - 1) * $per_page; // Vị trí bắt đầu cho câu truy vấn

// Lấy tổng số sinh viên trong lớp
$sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_qlsv WHERE id_class = ' . $class_id;
$total_students = $db->query($sql)->fetchColumn();

// Lấy danh sách sinh viên theo trang
$query_students = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_qlsv WHERE id_class = ' . $class_id . ' LIMIT ' . $start . ', ' . $per_page);
$array_students = [];
while ($row = $query_students->fetch()) {
    $array_students[] = $row;
}

// Tạo phân trang
$pagination = nv_generate_page(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&nv=qlsv&op=detailclass&id=' . $class_id, $per_page, $total_students, $page);

// Tạo giao diện
$xtpl = new XTemplate('detailclass.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);
$xtpl->assign('CLASS_INFO', $class_info);
$xtpl->assign('CLASS_ID', $class_id);

// Hiển thị danh sách sinh viên của lớp
if (!empty($array_students)) {
    $stt = 1;
    foreach ($array_students as $student) {
        $student['stt'] = $stt++;
        $student['url_detail'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=detail&id=' . $student['id'];
        $xtpl->assign('STUDENT', $student);
        $xtpl->parse('main.students.student_loop');
    }
} else {
    $xtpl->assign('NO_STUDENTS', 'Không có sinh viên trong lớp này');
    $xtpl->parse('main.add_student.no_students');
}

$xtpl->assign('PAGINATION', $pagination); // Thêm phân trang vào template

$xtpl->parse('main.students');
$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
