<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_ADMIN')) {
    exit('Stop!!!');
}
$submenu['add_student'] = 'Thêm Sinh Viên';
$submenu[''] = 'Danh Sách Sinh Viên';
$submenu['add_class'] = 'Thêm Lớp';
$submenu['listclass'] = 'Danh Sách Lớp';



if (defined('NV_IS_SPADMIN')) {
    $submenu['config'] = $lang_module['config'];
}
