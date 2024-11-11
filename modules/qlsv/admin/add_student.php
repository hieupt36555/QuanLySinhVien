<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['list'];
$array = [];
$row = [];
$error_name = '';
$error_birth = '';
$error_address = '';
$error_email = '';
$error_class = '';
$success_message = ''; // Biến để lưu thông báo thành công

// Lấy id từ request
$row['id'] = $nv_Request->get_int('id', 'post, get', 0);

// Lấy id_class từ URL nếu có, nếu không thì giữ nguyên giá trị mặc định từ request hoặc mặc định là 0
$row['id_class'] = $nv_Request->get_int('id_class', 'get', $row['id_class']);

// Nếu form được submit
if ($nv_Request->isset_request('submit1', 'post')) {
    // Lấy các dữ liệu từ form và thực hiện validate
    $row['name'] = nv_substr($nv_Request->get_title('name', 'post', ''), 0, 250);
    if (empty($row['name'])) {
        $error_name = 'Tên sinh viên không được để trống';
    }

    $row['birth'] = nv_substr($nv_Request->get_title('birth', 'post', ''), 0, 250);
    if (empty($row['birth'])) {
        $error_birth = 'Ngày tháng năm sinh không được để trống';
    }

    $row['address'] = nv_substr($nv_Request->get_title('address', 'post', ''), 0, 250);
    if (empty($row['address'])) {
        $error_address = 'Địa chỉ không được để trống';
    }

    $row['email'] = nv_substr($nv_Request->get_title('email', 'post', ''), 0, 250);
    if (empty($row['email'])) {
        $error_email = 'Email không được để trống';
    } elseif (!filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
        $error_email = 'Email không hợp lệ';
    }

    // Phần xử lý upload ảnh 
    if (isset($_FILES, $_FILES['image'], $_FILES['image']['tmp_name']) and is_uploaded_file($_FILES['image']['tmp_name'])) {
        $upload = new NukeViet\Files\Upload($admin_info['allow_files_type'], $global_config['forbid_extensions'], $global_config['forbid_mimes'], NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT);
        $upload->setLanguage($lang_global);
        $upload_info = $upload->save_file($_FILES['image'], NV_UPLOADS_REAL_DIR, false, $global_config['nv_auto_resize']);
        if (empty($upload_info['error'])) {
            $row['image'] = 'uploads/' . basename($upload_info['name']); // Đường dẫn tương đối
        } else {
            $error[] = 'Lỗi upload ảnh: ' . $upload_info['error'];
        }
    } else {
        $row['image'] = 'no_image.png';
    }
    // Nếu không có lỗi nào, thực hiện lưu thông tin vào cơ sở dữ liệu
    if (empty($error_name) && empty($error_birth) && empty($error_address) && empty($error_email) && empty($error_class)) {
        if ($row['id'] > 0) {
            // Cập nhật thông tin
            $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET name=:name, birth=:birth, address=:address, email=:email, image=:image, id_class=:id_class WHERE id=' . $row['id'];
        } else {
            // Thêm mới thông tin
            $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' (name, birth, address, email, image, id_class) VALUES (:name, :birth, :address, :email, :image, :id_class)';
        }

        $sth = $db->prepare($_sql);
        $sth->bindParam(':name', $row['name'], PDO::PARAM_STR);
        $sth->bindParam(':birth', $row['birth'], PDO::PARAM_STR);
        $sth->bindParam(':address', $row['address'], PDO::PARAM_STR);
        $sth->bindParam(':email', $row['email'], PDO::PARAM_STR);
        $sth->bindParam(':image', $row['image'], PDO::PARAM_STR);
        $sth->bindParam(':id_class', $row['id_class'], PDO::PARAM_INT);

        if ($sth->execute()) {
            $success_message = $row['id'] > 0 ? 'Sửa Thông Tin thành công!' : 'Thêm Sinh Viên thành công!';
            $row['name'] = '';
            $row['birth'] = '';
            $row['address'] = '';
            $row['email'] = '';
            $row['image'] = 'no_image.png';
            $row['id_class'] = 0;
        } else {
            $errorInfo = $sth->errorInfo();
            die('Database Error: ' . $errorInfo[2]);
        }
    }
} else if ($row['id'] > 0) {
    // Lấy thông tin sinh viên từ cơ sở dữ liệu khi sửa
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_qlsv WHERE id=" . $row['id'];
    $row = $db->query($sql)->fetch();
    if (empty($row['image'])) {
        $row['image'] = 'no_image.png';
    }
} else {
    // Nếu thêm mới, gán các giá trị mặc định
    $row['name'] = '';
    $row['birth'] = '';
    $row['address'] = '';
    $row['email'] = '';
    $row['image'] = 'no_image.png';
    $row['id_class'] = 0;
}

// Khởi tạo XTemplate và truyền dữ liệu vào template
$xtpl = new XTemplate('add_student.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

// Lấy danh sách lớp từ cơ sở dữ liệu để hiển thị trong form
$class_list = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_qlsv_class")->fetchAll();
foreach ($class_list as $class) {
    $xtpl->assign('CLASS', [
        'id' => $class['id'],
        'name' => $class['name'],
        'selected' => ($row['id_class'] == $class['id']) ? 'selected="selected"' : ''
    ]);
    $xtpl->parse('main.class');
}

// Truyền dữ liệu vào template và hiển thị
$xtpl->assign('DATA', $row);
$xtpl->assign('ERROR_NAME', $error_name);
$xtpl->assign('ERROR_BIRTH', $error_birth);
$xtpl->assign('ERROR_ADDRESS', $error_address);
$xtpl->assign('ERROR_EMAIL', $error_email);
$xtpl->assign('ERROR_CLASS', $error_class);
$xtpl->assign('SUCCESS_MESSAGE', $success_message); // Thêm thông báo thành công vào template

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
