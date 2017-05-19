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

//拿到info_id
$info_id = _POST('info_id', 0);
if ($info_id == 0) {
    $data = array();
    GZ_Api::outPut($data);
}

$sql = "select `school_id`, `grade` , `class`  from " . $ecs->table('teacher_class_info') . "where `info_id` = $info_id";
$class_info = $db->getRow($sql);
$school_id = $class_info['school_id'];
$class_id = $class_info['class'];
$grade = $class_info['grade'];

if (empty($school_id) || empty($class_id) || empty($grade)) {
    $data = array();
    GZ_Api::outPut($data);
}


$host = "http://" . $_SERVER['HTTP_HOST'] . "/";

$sql = "SELECT  CONCAT(\"$host\",sub.avatar) as avatar,sub.nickname as student_name, sum(IFNULL(a.direct_point, 0)) as student_points FROM " .
    $ecs->table('affiliate_log') . ' as a join ' . $ecs->table('order_info') .
    " as o on o.order_id = a.order_id and a.user_id = $user_id  and a.direct_point > 0 and  separate_type>=0  right join 
    (select u.user_id,u.nickname,u.avatar from  " .
    $ecs->table('subscription') . " as s join " .
    $ecs->table('users') . " as u on s.teacher_user_id = $user_id and s.students_user_id = u.user_id 
    join " . $ecs->table('student_class_info') .
    " as ss on u.user_id = ss.user_id and ss.school_id = $school_id and ss.grade = $grade and ss.class = $class_id ) 
    as sub on o.user_id = sub.user_id   " .
    " group by sub.user_id order by student_points desc";

$data = $db->getAll($sql);

GZ_Api::outPut($data);





