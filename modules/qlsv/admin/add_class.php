<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['class_form']; // Tiêu đề trang
$row = [];
$error_name = '';
$success_message = ''; // Biến để lưu thông báo thành công

// Lấy ID lớp từ URL (nếu có)
$class_id = $nv_Request->get_int('id', 'get', 0);

// Nếu ID có sẵn, lấy thông tin lớp học để sửa
if ($class_id > 0) {
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_qlsv_class WHERE id = :id';
    $sth = $db->prepare($sql);
    $sth->bindParam(':id', $class_id, PDO::PARAM_INT);
    $sth->execute();
    $row = $sth->fetch();

    // Kiểm tra xem lớp học có tồn tại không
    if (empty($row)) {
        die('Lớp học không tồn tại!');
    }
} 

// Kiểm tra xem form có được submit không
if ($nv_Request->isset_request('submit1', 'post')) {
    // Lấy tên lớp từ form
    $row['name'] = nv_substr($nv_Request->get_title('name', 'post', ''), 0, 250);
    $row['id'] = $nv_Request->get_int('id', 'post', 0); // Lấy ID từ form hidden
    
    // Validate tên lớp
    if (empty($row['name'])) {
        $error_name = 'Tên lớp không được để trống';
    }

    // Nếu không có lỗi, thực hiện thêm hoặc sửa thông tin vào cơ sở dữ liệu
    if (empty($error_name)) {
        if ($row['id'] > 0) {
            // Cập nhật thông tin lớp học
            $_sql = 'UPDATE ' . NV_PREFIXLANG . '_qlsv_class SET name = :name WHERE id = :id';
            $sth = $db->prepare($_sql);
            $sth->bindParam(':id', $row['id'], PDO::PARAM_INT);
        } else {
            // Thêm lớp học mới
            $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_qlsv_class (name) VALUES (:name)';
            $sth = $db->prepare($_sql);
        }

        $sth->bindParam(':name', $row['name'], PDO::PARAM_STR);

        if ($sth->execute()) {
            $success_message = $row['id'] > 0 ? 'Sửa lớp học thành công!' : 'Thêm lớp học thành công!';
            $row['name'] = ''; // Đặt lại giá trị để form trống sau khi thêm hoặc sửa thành công
        } else {
            $errorInfo = $sth->errorInfo();
            die('Database Error: ' . $errorInfo[2]);
        }
    }
}

// Khởi tạo XTemplate
$xtpl = new XTemplate('add_class.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

// Truyền dữ liệu vào template
$xtpl->assign('DATA', $row);
$xtpl->assign('ERROR_NAME', $error_name);
$xtpl->assign('SUCCESS_MESSAGE', $success_message); // Thêm thông báo thành công vào template

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
