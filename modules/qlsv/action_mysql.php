<?php

/**
 * Custom Module for Student Management
 * @version 1.0
 * @author Your Name
 * @license GNU/GPL version 2 or any later version
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('Stop!!!');
}

// Mảng để chứa các câu lệnh SQL xóa bảng khi gỡ module
$sql_drop_module = [];
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_qlsv;';
$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $lang . '_qlsv_class;';

// Mảng để chứa các câu lệnh SQL tạo bảng khi cài đặt module
$sql_create_module = $sql_drop_module;

// Tạo bảng `qlsv`
$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_qlsv (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    birth INT(11) NOT NULL DEFAULT 0,
    address VARCHAR(255) NOT NULL,
    addtime INT(11) NOT NULL DEFAULT 0,
    updatetime INT(11) NOT NULL DEFAULT 0,
    weight INT(11) NOT NULL DEFAULT 0,
    image VARCHAR(255) DEFAULT NULL,
    email VARCHAR(255) DEFAULT NULL,
    id_class INT(11) NOT NULL,
    PRIMARY KEY (id),
    INDEX (name)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';

// Tạo bảng `qlsv_class`
$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_qlsv_class (
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;';

// Thêm một số dữ liệu mẫu cho bảng `qlsv_class`
$sql_create_module[] = 'INSERT INTO ' . $db_config['prefix'] . '_' . $lang . '_qlsv_class (name) VALUES
("Class 1"),
("Class 2"),
("Class 3")
';

