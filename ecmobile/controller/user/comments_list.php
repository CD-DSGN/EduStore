<?php
/**
 * Created by nhj.
 */

define('INIT_NO_USERS', true);
require(EC_PATH . '/includes/init.php');

GZ_Api::authSession();
$user_id = $_SESSION['user_id'];

$page_parm = GZ_Api::$pagination;
$page = $page_parm['page'];

// $user_id = 8;
// $page = 1;

$out = array();

// judege students or teacher
$is_teacher = judge_user_status($user_id);

// 如果该用户是教师用户，则展示其发送的历史消息
if ($is_teacher) {
	$publish_info = get_publish_info($user_id, $page);
} else {
	// get followed teacher(teacher's user id) by user id
	$teachers = get_followed_teacher($user_id);

	// when student's follow none
	if (empty($teachers)) {
		$out['no_follow'] = 1;
	} else {
		$out['no_follow'] = 0;
	}

	// get teacher's publish by time and page
	$publish_info = get_publish_info($teachers, $page);
}

// get teacher's info(username, avatar, and so on)
foreach ($publish_info as $key => $item) {
	$out['info'][$key]['publish_info'] = $item;
	$out['info'][$key]['teacher_info'] = get_teacher_info($item['user_id']);
}

// process pagination
$pagero = array(
		"total"  => count($publish_info),	 
		"count"  => 10,
		"more"	 => 10 > count($publish_info) ? 0 : 1
);

GZ_Api::outPut($out, $pagero);




/**
* 	@param 		int 		$user_id 		用户id
*   @return 	bool 		$is_teacher		该用户是否为教师
*/
function judge_user_status($user_id)
{
	$sql = "SELECT is_teacher FROM ". $GLOBALS['ecs']->table('users') ." WHERE `user_id` = '". $user_id ."'";
	$row = $GLOBALS['db']->getRow($sql);
	$is_teacher = $row['is_teacher'];

	return $is_teacher;
}

/**
* 	@param 		int 		$user_id 		用户id
*   @return 	arr 		$teachers		用户所关注的教师id数组
*/
function get_followed_teacher($user_id)
{
	$sql = "SELECT teacher_user_id FROM ". $GLOBALS['ecs']->table('subscription') ."WHERE `students_user_id` = '". $user_id ."'";
	$res = $GLOBALS['db']->getAll($sql);

	foreach ($res as $item) {
		$teachers[] = $item['teacher_user_id'];
	}

	return $teachers;
}

/**
*	@param 		int 		$teacher_user_id		教师的用户id
*	@return 	arr 		$teacher_info	 		汇师圈中所需要的教师信息
*/
function get_teacher_info($teacher_user_id)
{
	// 获取用户真名
	$sql = "SELECT real_name FROM ". $GLOBALS['ecs']->table('teachers') ."WHERE `user_id` = '". $teacher_user_id ."'";
	$res = $GLOBALS['db']->getRow($sql);
	$teacher_info['real_name'] = $res['real_name'];

	$sql = "SELECT avatar FROM ". $GLOBALS['ecs']->table('users') ."WHERE `user_id` = '". $teacher_user_id ."'";
	$res = $GLOBALS['db']->getRow($sql);
	$teacher_info['avatar'] = "http://". $_SERVER['HTTP_HOST'] ."/". $res['avatar'];

	return $teacher_info;
}

/**
*	@param 		arr 		$teachers_user_id		所有被关注的教师的用户id
*	@param 		int 		$page 					页面数，控制查询范围
*	@return 	arr 		$publish_info	 		汇师圈教师发布相关
*/
function get_publish_info($teachers_user_id, $page)
{
	// page_count默认为10（每次查询10条内容）
	$page_count = 10;
	$start = ($page - 1) * $page_count;

	// 所关注教师组装的查询条件
	if (is_array($teachers_user_id)) {
		$where = " WHERE 0 ";
		foreach ($teachers_user_id as $item) {
			$where .= "OR `user_id` = '" . $item ."' ";
		}
	} else {
		$where = " WHERE `user_id` = '". $teachers_user_id ."' ";
	}

	$sql = "SELECT * " .
			"FROM ". $GLOBALS['ecs']->table('teacher_publish');
	$sql .= $where;
	$sql .= "ORDER BY publish_time DESC ";
	$sql .= "LIMIT " . $start .", " . $page_count;

	$res = $GLOBALS['db']->query($sql);

	while ($row = $GLOBALS['db']->fetchRow($res))
	{
		//$photo = get_publish_photo($row['news_id']);

		$publish_info[] = array('news_content'		=> 		$row['news_content'],
							  'publish_time'		=>		$row['publish_time'],		// 需要格式化时间
							  'user_id'				=>		$row['user_id'],
							  /*'photo_array'			=>		$photo*/);
	}

	return $publish_info;
}

/**
*	通过 news_id 来查询所上传的图片
*	@param 		int 		$news_id 				消息id
*	@return 	arr 		$photo 			 		该消息下对应的图片
*/
/* function get_publish_photo($news_id)
{
	$sql = "SELECT * FROM ". $GLOBALS['ecs']->table('teacher_publish_photo') ."WHERE `news_id` = '". $news_id ."'";
	$photo_info = $GLOBALS['db']->getAll($sql);

	$photo = array();

	foreach ($photo_info as $key => $value) {
		$photo[] = array('img' 		=>   $value['photo_image'],
				   	   'thumb'		=>   $value['photo_thumb'],
				   	   'small'		=>   '',
				   	   'url'		=> 	 '');
	}

	return $photo;
} */





