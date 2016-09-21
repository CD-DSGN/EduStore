<?php

/*
 *  added by nhj  
 *  do follow
 */

require(EC_PATH . '/includes/init.php');

include_once(EC_PATH . '/includes/lib_order.php');
include_once(EC_PATH . '/includes/lib_passport.php');

$teacher_user_id = _POST('teacher_user_id');
$student_user_id = _POST('student_user_id');
$course_id = _POST('course_id');

if ($_CFG['shop_reg_closed']) {
	GZ_Api::outPut(11);
}

$status = array();

$sql = 'SELECT teacher_user_id FROM ' . $ecs->table('subscription') . " WHERE `students_user_id` = '". $student_user_id ."' AND `course_id` = '". $course_id ."'";
$teacher_id = $db->getOne($sql);
//此学生这门课程没有关注教师
if(false == $teacher_id){
    $sql = 'INSERT INTO '. $ecs->table('subscription') . " VALUES ('$teacher_user_id', '$student_user_id', '$course_id')";
    $db->query($sql);
    $status['is_followed'] = 0;
}
//此学生这门课程已有关注教师，关注失败，不更新
else{
	$status['is_followed'] = 1;
    // $sql = 'UPDATE ' . $ecs->table('subscription') . " SET teacher_user_id = '$user_id_teacher' WHERE course_id = '$course' AND students_user_id = '$user_id'";
    // $db->query($sql);
}

$out = array(
	'data' => $status
);
GZ_Api::outPut($out);
