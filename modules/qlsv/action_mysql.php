<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_IS_FILE_MODULES')) {
    exit('aStop!!!');
}

$get_all_student = 'SELECT * FROM ' . NV_PREFIXLANG . '_qlsv';
$get_all_class_student = 'SELECT * FROM ' . NV_PREFIXLANG . '_qlsv_class';