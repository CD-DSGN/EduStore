<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2016/9/10
 * Time: 14:46
 */


define('INIT_NO_USERS', true);
require(EC_PATH . '/includes/init.php');
//require_once(EC_PATH . '/Utils.php');

GZ_Api::authSession();
$user_id = GZ_Api::$session['uid'];
$sql = 'SELECT * FROM ' . $ecs->table('users') . " WHERE `user_id` = '$user_id'";
$res = $db->getRow($sql);
$data = array();
if ($res) {
    $data['pay_points'] = $res['pay_points'];
    $data['teacher_integral'] = $res['teacher_integral'];
    $data['rank_points'] = $res['rank_points'];
}
$sql = 'select count(*) from ' . $ecs->table('subscription') . " where `teacher_user_id` = '$user_id'";
$res = $db->getOne($sql);

if ($res) {
    $data['subscription_student_num'] = $res; //获得关注学生的数目
}

$sql = 'select count(*) from ' . $ecs->table('users')  . " where `parent_id` = '$user_id'";
$res = $db->getOne($sql);

if ($res) {
    $data['recommanded_teacher_num'] = $res;  //获得推荐教师数目
}

//$affiliate_change_type = ACT_SUBSCRIPTION_TEACHER_INTEGRAL;
$sql = 'select sum(`direct_point`) from ' . $ecs->table('affiliate_log').  " as a 
where `user_id` = '$user_id' and   a.direct_point > 0 and  separate_type>=0 ";
//putString($sql);
$res = $db->getOne($sql);

if ($res) {
    $data['points_from_subscription'] = $res; // 取得因学生购买获得的积分
}else{
    $data['points_from_subscription'] = 0;
}


if (isset($data['teacher_integral']) && isset($data['points_from_subscription'])) {
    $data['points_from_affiliate'] = max($data['teacher_integral'] - $data['points_from_subscription'], 0);
}

//读数据库，获得自身邀请码
$sql = 'select `recommend_code` from ' . $ecs->table('teachers').  " where `user_id` = '$user_id' ";
$res = $db->getOne($sql);
if ($res) {
    $data['invitation_code'] = $res; //邀请码
}

GZ_Api::outPut($data);





