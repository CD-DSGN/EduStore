<?php

/*
 *  added by nhj  
 *  for user to search teacher to focus on
 */

require(EC_PATH . '/includes/init.php');

include_once(EC_PATH . '/includes/lib_order.php');
include_once(EC_PATH . '/includes/lib_passport.php');

$username = _POST('name');
$course_id = _POST('course_id');
$user_id = _POST('user_id');

if ($_CFG['shop_reg_closed']) {
	GZ_Api::outPut(11);
}

// $username = "ghhhgf";   //测试数据
// $course_id = 5;
// 需要从users和teachers两个表中查询所需要的数据
$teacherInfo = array();
$teacher_user_id = array();
$teacher_count = 0;

$sql = "SELECT user_id, course_id,real_name,school FROM ". $ecs->table('teachers') ."WHERE `real_name` LIKE '%". $username ."%' AND `course_id` = '". $course_id ."'";
$row = mysql_num_rows($db->query($sql));
if ( $row > 0 ) {
	$result = $db->getAll($sql);
	foreach ($result as $key => $value) {
		foreach ($value as $keys => $values) {
			if ( $keys == "user_id" ) {
				$teacher_user_id[] = $values;
				$teacher_count++;
			}
			$teacherInfo[$key][$keys] = $values;
		}
	}
} else {
	// 搜索结果为空
	$out = array();
	GZ_Api::outPut($out);
}
// 循环嵌套有点厉害了，后期有时间修改写法
for ( $i=0; $i < $teacher_count;  $i++) { 
	// 查教师的个人信息
	$sql = "SELECT user_name,mobile_phone,teacher_integral FROM ". $ecs->table('users') ."WHERE `user_id` = '". $teacher_user_id[$i] ."'";
	$result = $db->getAll($sql); 
	foreach ($result as $key => $value) {
		foreach ($value as $keys => $values) {
			$teacherInfo[$i][$keys] = $values;
		}
	}
	// 查该教师是否被该学生关注
	$sql = "SELECT * FROM ". $ecs->table('subscription') ."WHERE `teacher_user_id` = '". $teacher_user_id[$i] ."' AND `students_user_id` = '". $user_id ."' AND `course_id` = '". $course_id ."'";
	$row = mysql_num_rows($db->query($sql));
	if ( $row > 0 )
	{
		$teacherInfo[$i]['isFollowed'] = 1;
	}
	else
	{
		$teacherInfo[$i]['isFollowed'] = 0;
	}
}

$out = array(
	'data' => $teacherInfo
);
GZ_Api::outPut($out);

// foreach ($teacherInfo as $key => $value) {
// 	foreach ($value as $keys => $values) {
// 		echo $keys ."=>". $values ."<br/>";
// 	}
// }