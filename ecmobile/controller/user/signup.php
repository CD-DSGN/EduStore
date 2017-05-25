<?php

/*
 *
 *       _/_/_/                      _/        _/_/_/_/_/
 *    _/          _/_/      _/_/    _/  _/          _/      _/_/      _/_/
 *   _/  _/_/  _/_/_/_/  _/_/_/_/  _/_/          _/      _/    _/  _/    _/
 *  _/    _/  _/        _/        _/  _/      _/        _/    _/  _/    _/
 *   _/_/_/    _/_/_/    _/_/_/  _/    _/  _/_/_/_/_/    _/_/      _/_/
 *
 *
 *  Copyright 2013-2014, Geek Zoo Studio
 *  http://www.ecmobile.cn/license.html
 *
 *  HQ China:
 *    2319 Est.Tower Van Palace
 *    No.2 Guandongdian South Street
 *    Beijing , China
 *
 *  U.S. Office:
 *    One Park Place, Elmira College, NY, 14901, USA
 *
 *  QQ Group:   329673575
 *  BBS:        bbs.ecmobile.cn
 *  Fax:        +86-10-6561-5510
 *  Mail:       info@geek-zoo.com
 */

require(EC_PATH . '/includes/init.php');

include_once(EC_PATH . '/includes/lib_order.php');
include_once(EC_PATH . '/includes/lib_passport.php');



$password = _POST('password');
$email = _POST('email');
// $fileld = _POST('fileld', array());
$fileld = isset($_POST['field'])?$_POST['field']:array();

if ($_CFG['shop_reg_closed']) {
	GZ_Api::outPut(11);
}

$other = array();
$filelds = array();

foreach ($fileld as $val) {
   $filelds[$val['id']] = $val['value'];
}

$other['msn'] = isset($filelds[1]) ? $filelds[1] : '';
$other['qq'] = isset($filelds[2]) ? $filelds[2] : '';
$other['office_phone'] = isset($filelds[3]) ? $filelds[3] : '';
$other['home_phone'] = isset($filelds[4]) ? $filelds[4] : '';
$other['mobile_phone'] = isset($filelds[5]) ? $filelds[5] : '';
//此处获取的应该是昵称
$other['nickname'] = _POST('name');
//学生学校信息
$student_school = _POST('student_school');
$student_grade = _POST('student_grade');
$student_class = _POST('student_class');

$username = $_POST['phoneNumber'];

if (register($username, $password, $email, $other) === false) {
	GZ_Api::outPut(11);
}

if( isset($_POST['phoneNumber'])) {
    $phoneNumber = $_POST['phoneNumber'];
    $sql = 'UPDATE '. $ecs->table('users') . "SET `mobile_phone` = '$phoneNumber' WHERE `user_id`='" . $_SESSION['user_id'] . "'";
    $db->query($sql);
}
/*把新注册用户的扩展信息插入数据库*/
$sql = 'SELECT id FROM ' . $ecs->table('reg_fields') . ' WHERE type = 0 AND display = 1 ORDER BY dis_order, id';   //读出所有自定义扩展字段的id
$fields_arr = $db->getAll($sql);

$extend_field_str = '';    //生成扩展字段的内容字符串
foreach ($fields_arr AS $val)
{
    $extend_field_index = $val['id'];
    if(!empty($filelds[$extend_field_index]))
    {
        $temp_field_content = strlen($filelds[$extend_field_index]) > 100 ? mb_substr($filelds[$extend_field_index], 0, 99) : $filelds[$extend_field_index];
        $extend_field_str .= " ('" . $_SESSION['user_id'] . "', '" . $val['id'] . "', '" . $temp_field_content . "'),";
    }
}
$extend_field_str = substr($extend_field_str, 0, -1);

if ($extend_field_str)      //插入注册扩展数据
{
    $sql = 'INSERT INTO '. $ecs->table('reg_extend_info') . ' (`user_id`, `reg_field_id`, `content`) VALUES' . $extend_field_str;
    $db->query($sql);
}

//学生注册自动匹配
if(isset($student_school) && isset($student_grade) && isset($student_class)){
    $stu_values = array();
    $stu_values[] = $_SESSION['user_id'];
    $stu_values[] = $student_school;
    $stu_values[] = $student_grade;
    $stu_values[] = $student_class;

    $sql = 'INSERT INTO ' . $ecs->table('student_class_info') . ' (`user_id`, `school_id`, `grade` , `class`)'. " VALUES ('" . implode("', '", $stu_values) . "')";
    if($db->query($sql) != false){
        $sql = 'SELECT user_id, course FROM ' .$ecs->table('teacher_class_info').
            " WHERE school_id = $student_school AND grade = $student_grade AND class = $student_class";

        $find_teacher = $db->getAll($sql);
        //如果找到注册过的教师 写入教师学生关注表
        if($find_teacher != false){
            foreach ($find_teacher AS $key => $value){
                $user_id = $value['user_id'];
                $course = $value['course'];
                $sql = 'INSERT INTO '. $ecs->table('subscription') . ' (`teacher_user_id` , `students_user_id`, `course_id`)'.
                    " VALUES ($user_id, $stu_values[0], $course)";
                $db->query($sql);
            }
        }

    }
}

$user_info = GZ_user_info($_SESSION['user_id']);

$out = array(
	'session' => array(
		'sid' => SESS_ID.$GLOBALS['sess']->gen_session_key(SESS_ID),
		'uid' => $_SESSION['user_id']
	),

	'user' => $user_info
);

GZ_Api::outPut($out);

