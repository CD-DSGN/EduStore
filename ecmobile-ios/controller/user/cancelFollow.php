<?php

/*
 *  added by nhj  
 *  do follow
 */

require(EC_PATH . '/includes/init.php');

include_once(EC_PATH . '/includes/lib_order.php');
include_once(EC_PATH . '/includes/lib_passport.php');

$student_user_id = _POST('student_user_id');
$course_id = _POST('course_id');
if ($_CFG['shop_reg_closed']) {
	GZ_Api::outPut(11);
}

$status = array();

$sql = 'DELETE FROM ' . $ecs->table('subscription') . " WHERE `students_user_id` = '". $student_user_id ."' AND `course_id` = '". $course_id ."'";
$db->query($sql);
$row = mysql_affected_rows();
if ( $row > 0 ) {
	$status['canceled'] = 'success';
} else {
	$status['canceled'] = 'no follow';
}
$out = array(
	'data' => $status
);
GZ_Api::outPut($out);
