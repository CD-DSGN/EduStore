<?php

define('INIT_NO_USERS', true);

require(EC_PATH . '/includes/init.php');

GZ_Api::authSession();
$target_comment_id = _POST('target_comment_id');

$news_id = _POST('news_id');

$time = time();

$uid = $_SESSION['user_id'];

$content = _POST('comment_content');

if($news_id == null || $content == null){
    GZ_Api::outPut(707);
}
$sql_target_comment_id = $target_comment_id == null ? " " : ", target_comment_id = $target_comment_id";
$sql = 'INSERT INTO ' .$ecs->table('huishi_circle_comment') ." SET 
        news_id = $news_id,
        comment_content = '$content', 
        user_id = $uid,
        publish_time = $time"
        .$sql_target_comment_id;
$res = $db->query($sql);
if($res == true){
    
	$comment = get_teacher_publish_comments($news_id);
	// var_dump($comment);
    GZ_Api::outPut(array('commentInfo' => $comment));

}else{
    GZ_Api::outPut(708);
}

function get_teacher_publish_comments($news_id){
    $sql = "SELECT * FROM ". $GLOBALS['ecs']->table('huishi_circle_comment') ." WHERE `news_id` = $news_id ORDER BY publish_time ASC";
    $comment_info = $GLOBALS['db']->getAll($sql);
    $comments = array();
    foreach ($comment_info as $key =>$value){
        $uid = get_user_id_by_comment_id($value['target_comment_id']);
        $target_username = get_username_by_user_id($uid);
        if($target_username == null){
            $target_username = '';
        }

        $show_target_name = get_showname_by_user_id($uid);
        $show_name = get_showname_by_user_id($value['user_id']);

        $comments[] = array(
            'comment_id' => $value['comment_id'],
            'username' => get_username_by_user_id($value['user_id']),
            'target_username' => $target_username,
            'comment_content' => $value['comment_content'],
            'show_name' =>  $show_name,
            'show_target_name' =>$show_target_name,
            // add nhj, 在这里同时返回news_id
            'news_id' => $news_id);
    }
    return $comments;
}

function get_username_by_user_id($uid){
    $sql = "SELECT user_name FROM ". $GLOBALS['ecs']->table('users') ."WHERE `user_id` = '". $uid ."'";
    $res = $GLOBALS['db']->getRow($sql);
    $user_name = $res['user_name'];
    return $user_name;
}
function get_user_id_by_comment_id($comment_id){
    $sql = "SELECT user_id FROM ". $GLOBALS['ecs']->table('huishi_circle_comment') ."WHERE `comment_id` = '". $comment_id ."'";
    $res = $GLOBALS['db']->getOne($sql);
    return $res;
}
function get_teacher_name_by_user_id($uid){
    $sql = "SELECT real_name FROM ". $GLOBALS['ecs']->table('teachers') ."WHERE `user_id` = '". $uid ."'";
    $res = $GLOBALS['db']->getRow($sql);
    $teacher_name = $res['real_name'];
    return $teacher_name;
}


function get_nickname_by_user_id($uid)
{
    $sql = "SELECT nickname FROM ". $GLOBALS['ecs']->table('users') ."WHERE `user_id` = '". $uid ."'";
    $res = $GLOBALS['db']->getone($sql);
    return $res;
}

function get_showname_by_user_id($uid)
{
    $is_teacher = judge_user_status($uid);
    if ($is_teacher) {
        $name = get_teacher_name_by_user_id($uid);
    }else{
        $name = get_nickname_by_user_id($uid);
    }
    return $name;
}

function judge_user_status($user_id)
{
	$sql = "SELECT is_teacher FROM ". $GLOBALS['ecs']->table('users') ." WHERE `user_id` = '". $user_id ."'";
	$row = $GLOBALS['db']->getRow($sql);
	$is_teacher = $row['is_teacher'];

	return $is_teacher;
}
