<?php
/**
 * Created by PhpStorm.
 * User: chenggaoyuan
 * Date: 2017/3/6
 * Time: 14:15
 */

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
    GZ_Api::outPut(array());
}else{
    GZ_Api::outPut(708);
}
