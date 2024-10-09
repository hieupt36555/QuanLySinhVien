<?php

if (!defined('NV_IS_FILE_ADMIN')) {
    exit('Stop!!!');
}

$page_title = $lang_module['list'];
$array = [];

$row['id'] = $nv_Request->get_int('id', 'post, get', 0);



if ($nv_Request->isset_request('submit1', 'post')) {
    $row['name'] = nv_substr($nv_Request->get_title('name', 'post', ''), 0, 250);
    $row['birth'] = nv_substr($nv_Request->get_title('birth', 'post', ''), 0, 250); // Thay đổi nếu cần
    $row['address'] = nv_substr($nv_Request->get_title('address', 'post', ''), 0, 250);
    $row['email'] = nv_substr($nv_Request->get_title('email', 'post', ''), 0, 250);
    $row['id_class'] = $nv_Request->get_int('id_class', 'post', 0);  // Lấy giá trị id_class từ form


    // Khởi tạo Class upload
    if (isset($_FILES, $_FILES['image'], $_FILES['image']['tmp_name']) and is_uploaded_file($_FILES['image']['tmp_name'])) {
        $upload = new NukeViet\Files\Upload($admin_info['allow_files_type'], $global_config['forbid_extensions'], $global_config['forbid_mimes'], NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT);
        // // Thiết lập ngôn ngữ, nếu không có dòng này thì ngôn ngữ trả về toàn tiếng Anh
        $upload->setLanguage($lang_global);
        // // Tải file lên server
        $upload_info = $upload->save_file($_FILES['image'], NV_UPLOADS_REAL_DIR, false, $global_config['nv_auto_resize']);
        // $upload_info = ($_FILES['image']);
        if (empty($upload_info['error'])) {
            // Gán đường dẫn ảnh vào row['image']
            $row['image'] = 'uploads/' . basename($upload_info['name']); // Đường dẫn tương đối
        } else {
            // Nếu có lỗi khi upload
            die('Upload Error: ' . $upload_info['error']);
        }
    } else {
        $row['image'] = 'no_image.png';
    }

    // Xử lý SQL: nếu có id thì cập nhật, nếu không thì thêm mới
    if ($row['id'] > 0) {
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET name=:name, birth=:birth, address=:address, email=:email, image=:image, id_class=:id_class WHERE id=' . $row['id'];
    } else {
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' (name, birth, address, email, image, id_class) VALUES (:name, :birth, :address, :email, :image, :id_class)';
    }

    $sth = $db->prepare($_sql);
    $sth->bindParam(':name', $row['name'], PDO::PARAM_STR);
    $sth->bindParam(':birth', $row['birth'], PDO::PARAM_STR);
    $sth->bindParam(':address', $row['address'], PDO::PARAM_STR);
    $sth->bindParam(':email', $row['email'], PDO::PARAM_STR);
    $sth->bindParam(':image', $row['image'], PDO::PARAM_STR);
    $sth->bindParam(':id_class', $row['id_class'], PDO::PARAM_INT);

    if (!$sth->execute()) {
        // Xử lý lỗi nếu có
        $errorInfo = $sth->errorInfo();
        die('Database Error: ' . $errorInfo[2]);
    }

    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name);
} else if ($row['id'] > 0) {
    $sql = "SELECT * FROM " . NV_PREFIXLANG . "_qlsv WHERE id=" . $row['id'];
    $row = $db->query($sql)->fetch();

    // Nếu không có giá trị image, giữ nguyên giá trị cũ
    if (empty($row['image'])) {
        $row['image'] = '';
    }
} else {
    $row['name'] = "";
    $row['birth'] = 0;
    $row['address'] = "";
    $row['email'] = "";
    $row['image'] = "";
    $row['id_class'] = 0;  // Giá trị mặc định của lớp

}
$xtpl = new XTemplate('add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);

// Lấy danh sách lớp để hiển thị trong select
$class_list = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_qlsv_class")->fetchAll();

//vòng lặp hiển thị tất cả các lớp
foreach ($class_list as $class) {
    $xtpl->assign('CLASS', [
        'id' => $class['id'],
        'name' => $class['name'],
        'selected' => ($row['id_class'] == $class['id']) ? 'selected="selected"' : ''
    ]);
    $xtpl->parse('main.class');
    $xtpl->parse('main.loop'); 
}


$xtpl->assign('DATA', $row);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
