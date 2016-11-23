<?php
/**
 * Created by nhj.
 */

define('INIT_NO_USERS', true);

require(EC_PATH . '/includes/init.php');

GZ_Api::authSession();
$user_id = $_SESSION['user_id'];

$content 	=   _POST('content');
$time 		=	_POST('time');

$sql = "INSERT INTO ". $GLOBALS['ecs']->table('teacher_publish') ."(`news_content`, `publish_time`, `user_id`) VALUES('". $content ."', '". $time ."', '". $user_id ."')";
$GLOBALS['db']->query($sql);

$row = mysql_affected_rows();
$out = array('data' => $row);
GZ_Api::outPut($out);
if($row == 1) {
	// 插入成功
	$data = array(array('status' => array('succeed' => '1')));
	echo json_encode($data);
} else {
	// 插入失败
	GZ_Api::outPut(600);
}























