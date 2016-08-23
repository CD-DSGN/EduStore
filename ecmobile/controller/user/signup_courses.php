<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2016/8/18
 * Time: 11:26
 */

require(EC_PATH . '/includes/init.php');

$sql = 'SELECT * FROM ' . $ecs->table('courses') ;
$course_info = $db->getAll($sql);

$out = array();
foreach ($course_info as $val) {
    $out[] = array(
        'course_id' => $val['course_id'],
        'course_name' => $val['course_name'],
    );
}

GZ_Api::outPut($out);