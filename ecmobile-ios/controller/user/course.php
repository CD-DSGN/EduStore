<?php

/*
 *
 *       _/_/_/                      _/        _/_/_/_/_/
 *    _/          _/_/      _/_/    _/  _/          _/      _/_/      _/_/
 *   _/  _/_/  _/_/_/_/  _/_/_/_/  _/_/          _/      _/    _/  _/    _/
 *  _/    _/  _/        _/        _/  _/      _/        _/    _/  _/    _/
 *   _/_/_/    _/_/_/    _/_/_/  _/    _/  _/_/_/_/_/    _/_/      _/_/
 *
 *
 *  Copyright 2013-2014, Geek Zoo Studio
 *  http://www.ecmobile.cn/license.html
 *
 *  HQ China:
 *    2319 Est.Tower Van Palace
 *    No.2 Guandongdian South Street
 *    Beijing , China
 *
 *  U.S. Office:
 *    One Park Place, Elmira College, NY, 14901, USA
 *subs
 *  QQ Group:   329673575
 *  BBS:        bbs.ecmobile.cn
 *  Fax:        +86-10-6561-5510
 *  Mail:       info@geek-zoo.com
 */

require(EC_PATH . '/includes/init.php');

include_once(EC_PATH . '/includes/lib_order.php');
include_once(EC_PATH . '/includes/lib_passport.php');

$student_id = _POST('student_id');
// $student_id = 8;

$sql = 'SELECT * FROM ' . $ecs->table('courses') . ' ORDER BY course_id';
$course_info = $db->getAll($sql);
$course = array();
foreach ($course_info as $item) {
	$course['course_id'][] = $item['course_id'];
    $course['course_name'][] = $item['course_name'];
    // 查询教师姓名
    $sql = "SELECT `teacher_user_id` FROM ". $ecs->table('subscription') ." WHERE `students_user_id` = '". $student_id ."' AND `course_id` = '". $item['course_id'] ."'";
    $res = $db->getAll($sql);
    if ( !empty( $res) ) {
    	foreach ($res as $item) {
    		// echo $item['teacher_user_id'] ."</br>";
    		$sql = "SELECT `real_name` FROM ". $ecs->table('teachers') ."WHERE `user_id` = '". $item['teacher_user_id'] ."'";
	    	$res = $db->getAll($sql);
	    	if ( !empty($res) ) {
	    		foreach ($res as $item) {
	    			$course['teacher_name'][] = $item['real_name'];
	    		}
	    	} else {
	    		$course['teacher_name'][] = "";
	    	}
    	}
    } else {
    	$course['teacher_name'][] = "";
    }
}
if(empty($course)) {
    GZ_API::outPut(11);
} else {
	$out = array(
		'data'=>$course
	);

    GZ_API::outPut($out);
}

