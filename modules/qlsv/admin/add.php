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

    // Xử lý file tải lên cho trường image
    if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        $upload = new NukeViet\Files\Upload(NV_UPLOADS_DIR . '/' . $module_upload, $global_config);        
        // Debug thông tin file
        var_dump($_FILES['image']);
        
        $row['image'] = $upload->upload_image($_FILES['image']);
        
        if ($row['image'] === false) {
            $row['image'] = ''; // Hoặc xử lý lỗi phù hợp
        }
    }

    // Câu lệnh SQL
    if ($row['id'] > 0) {
        $_sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET name=:name, birth=:birth, address=:address, email=:email, image=:image WHERE id=' . $row['id'];
    } else {
        $_sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' (name, birth, address, email, image) VALUES (:name, :birth, :address, :email, :image)';
    }
 
    $sth = $db->prepare($_sql);
    $sth->bindParam(':name', $row['name'], PDO::PARAM_STR);
    $sth->bindParam(':birth', $row['birth'], PDO::PARAM_STR);
    $sth->bindParam(':address', $row['address'], PDO::PARAM_STR);
    $sth->bindParam(':email', $row['email'], PDO::PARAM_STR);
    $sth->bindParam(':image', $row['image'], PDO::PARAM_STR);
    
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
}

$xtpl = new XTemplate('add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('DATA', $row);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('GLANG', $lang_global);

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
