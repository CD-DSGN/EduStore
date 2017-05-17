<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2017/5/11
 * Time: 16:09
 */
define('INIT_NO_USERS', true);
require(EC_PATH . '/includes/init.php');

GZ_Api::authSession();
$user_id = GZ_Api::$session['uid'];

$page_size = GZ_Api::$pagination['count'];
$page = GZ_Api::$pagination['page'];

$start_row = ($page-1)*$page_size;

//$sql = 'SELECT `students_user_id`FROM ' . $ecs->table('subscription') .
//    "where `teacher_user_id`='$user_id'";
//$res = $db->getCol($sql);
//
//$stu_ids = $res;
//
//$sql = 'SELECT  u.user_id,u.nickname as student_name, sum(a.direct_point) as student_points FROM ' .
//    $ecs->table('affiliate_log') . ' as a  join ' . $ecs->table('order_info') .
//    " as o  on o.order_id=a.order_id  join" .
//    $ecs->table('users') . " as u on  u.user_id=o.user_id  " .
//    "  WHERE a.user_id = '$user_id' AND  a.direct_point > 0 and  separate_type>=0
//    and o.user_id  " . db_create_in($stu_ids) . " group by o.user_id";
//
//$res = $db->getAll($sql);
//
//$info = $res;
//
//$sql = 'SELECT u.user_id, `nickname` as student_name, 0 as student_points FROM ' . $ecs->table('subscription') .
//    " as s join " . $ecs->table('users') . " as u on s.students_user_id=u.user_id " .
//    " where `teacher_user_id`='$user_id'";
//
//$res = $db->getAll($sql);
//
//foreach ($info as $info_item) {
//    for ($i = 0; $i < count($res); $i++) {
//        if ($info_item['user_id'] == $res[$i]['user_id']) {
//            $res[$i]['student_points'] = $info_item['student_points'];
//            break;
//        }
//    }
//}
$host = "http://" . $_SERVER['HTTP_HOST'] . "/";

$sql = "SELECT  CONCAT(\"$host\",sub.avatar) as avatar,sub.nickname as student_name, sum(IFNULL(a.direct_point, 0)) as student_points FROM " .
    $ecs->table('affiliate_log') . ' as a join ' . $ecs->table('order_info') .
    " as o on o.order_id = a.order_id and a.user_id = $user_id  and a.direct_point > 0 and  separate_type>=0  right join 
    (select u.user_id,u.nickname,u.avatar from  " .
    $ecs->table('subscription') . " as s join " .
    $ecs->table('users') . " as u on s.teacher_user_id = $user_id and s.students_user_id = u.user_id) 
    as sub on o.user_id = sub.user_id   " .
    " group by sub.user_id order by student_points desc limit $start_row,$page_size";

$data = $db->getAll($sql);

$sql = 'SELECT count(students_user_id) FROM ' . $ecs->table('subscription') .
    "where `teacher_user_id`='$user_id'";
$count = $db->getOne($sql);  //计算总数

$page_count = ($count > 0) ? intval(ceil($count / $page_size)) : 1; //计算总页数

$pager = array(
    "total"  => $count,
    "count"  => count($data),
    "more"   => $page < $page_count ? 1 : 0
);

GZ_Api::outPut($data,$pager);





