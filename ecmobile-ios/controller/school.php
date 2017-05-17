<?php
/*
 * creaty by nhj
 */

require(EC_PATH . '/includes/init.php');

$school_region = _POST('school_region');

$sql = "SELECT * FROM " . $ecs->table('schools') . "WHERE `school_regin` = '" . $school_region ."' ORDER BY `school_id`";
$school = $db->getAll($sql);
$school_array = array();
$i = 0;
foreach ($school as $item) {
    
    $school_array[$i]['school_name'] = $item['school_name'];
    $school_array[$i]['school_id'] = $item['school_id'];
    $i++;
}

GZ_Api::outPut($school_array);