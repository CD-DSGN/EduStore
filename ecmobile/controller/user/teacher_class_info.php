<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2017/5/17
 * Time: 18:23
 */

define('INIT_NO_USERS', true);
require(EC_PATH . '/includes/init.php');

GZ_Api::authSession();
$user_id = GZ_Api::$session['uid'];

$is_teacher = judge_user_status($user_id);

if ($is_teacher) {
    $sql = "SELECT `info_id`, `school_name`, g.grade, `class` as class_no FROM ".
        $GLOBALS['ecs']->table('teacher_class_info') ." as t join " . $GLOBALS['ecs']->table('schools').
        " as s on t.school_id = s.school_id "  .
        " and `user_id` = $user_id  join " . $GLOBALS['ecs']->table('school_grade') .
        " as g on g.grade_id =  t.grade" ;

    $data = $GLOBALS['db']->getAll($sql);
}else{
    $data = Array();
}

GZ_Api::outPut($data);


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