<?php 
/*
 * create by nhj
 */

require(EC_PATH . '/includes/init.php');


$sql = 'SELECT * FROM '. $ecs->table('school_grade') . 'ORDER BY `grade_id`';
$grade_info = $db->getAll($sql);
$grade = array();
$i = 0;
foreach ($grade_info as $item) {
    
    $grade[$i]['grade_id'] = $item['grade_id'];
    $grade[$i]['grade_name'] = $item['grade'];
    $i++;
}
GZ_Api::outPut($grade);