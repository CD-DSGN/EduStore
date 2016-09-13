<?php

define('INIT_NO_USERS', true);

require(EC_PATH . '/includes/init.php');

GZ_Api::authSession();

//include_once(EC_PATH . '/includes/lib_order.php');

$user_subscription = subscribed(GZ_Api::$session['uid']);
GZ_Api::outPut($user_subscription);


function subscribed($user_id)
{
    global $db, $ecs;
    $sql = 'SELECT * FROM ' . $ecs->table('courses') . ' ORDER BY course_id';
    $course_info = $db->getAll($sql);
    for ($i = 0; $i < sizeof($course_info); $i++) {
        $j = $i + 1;
        $sql = 'SELECT teacher_user_id FROM ' . $ecs->table('subscription') . " WHERE students_user_id = '$user_id' AND course_id = '$j'";
        $tch_id = $db->getOne($sql);
        if (false == $tch_id) {
//            $course_info[$i]['tch_name'] = "";
        } else {
            $sql = 'SELECT real_name,school FROM ' . $ecs->table('teachers') . " WHERE user_id = '$tch_id'";
            $res = $db->getRow($sql);
            $course_info[$i]['teacher_name'] = $res['real_name'];
            $course_info[$i]['school'] = $res['school'];
            $course_info[$i]['teacher_id'] = $tch_id;
        }
    }
    return $course_info;
}

?>