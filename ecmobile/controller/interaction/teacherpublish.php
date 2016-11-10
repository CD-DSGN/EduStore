<?php

define('INIT_NO_USERS', true);
require(EC_PATH . '/includes/init.php');
GZ_Api::authSession();
$result = false;
$content = _POST('publishcontent');
$uid = $_SESSION['user_id'];
$time = time();

$result = update_one_publish_content($content,$time,$uid);
if($result==true){
    GZ_Api::outPut(array());
}

function update_one_publish_content($content,$time,$uid)
{   
    global $db, $ecs;
    $sql = 'INSERT INTO '. $ecs->table('teacher_publish') . " SET news_content = '$content'"
        .', publish_time = '."$time"
        .', user_id = '."$uid";
    $db->query($sql);
    return true;
}