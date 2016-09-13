<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2016/9/7
 * Time: 10:56
 */

define('INIT_NO_USERS', true);
require(EC_PATH . '/includes/init.php');

//require_once(EC_PATH . '/Utils.php');
//GZ_Api::authSession();

$simpleTeacherInfo = _POST(simpleTeacherInfo, array());
$teacher_id = $simpleTeacherInfo['teacher_id'];
$course_id = $simpleTeacherInfo['course'];
$user_id = GZ_Api::$session['uid']; //学生编号

if (isset($teacher_id) && isset($course_id) && isset($user_id)) {
    $sql = 'SELECT teacher_user_id FROM ' . $ecs->table('subscription') . " WHERE course_id = '$course_id' AND students_user_id = '$user_id'";
    $old_teacher_id = $db->getOne($sql);
    //putString($old_teacher_id);
    //此学生这门课程没有关注教师
    if (false == $old_teacher_id) {
        $sql = 'INSERT INTO '. $ecs->table('subscription') . " VALUES ('$teacher_id', '$user_id', '$course_id')";
        $db->query($sql);
    } //此学生这门课程已有关注教师
    else {
        $sql = 'UPDATE ' . $ecs->table('subscription') . " SET teacher_user_id = '$teacher_id' WHERE course_id = '$course_id' AND students_user_id = '$user_id'";
        $db->query($sql);
        //putString($sql);
    }
}

$data = array();
GZ_Api::outPut($data);



