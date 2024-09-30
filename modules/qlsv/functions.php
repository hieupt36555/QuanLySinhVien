<?php

/**
 * NukeViet Content Management System
 * @version 4.x
 * @author VINADES.,JSC <contact@vinades.vn>
 * @copyright (C) 2009-2021 VINADES.,JSC. All rights reserved
 * @license GNU/GPL version 2 or any later version
 * @see https://github.com/nukeviet The NukeViet CMS GitHub project
 */

if (!defined('NV_SYSTEM')) {
    exit('Stop!!!');
}

define('NV_IS_MOD_DEMO', true);


function get_data_from_db() {
    global $db;

    $array_data = [];

    $query = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_qlsv');
    while ($row = $query->fetch()) {
        $array_data[$row['id']] = $row;
    }

    return $array_data;
}
function get_product_details($product_id) {
    if ($product_id > 0) {
        include NV_ROOTDIR . '/modules/qlsv/details.php';
        return view_product_details($product_id);
    }
    return false;
}

