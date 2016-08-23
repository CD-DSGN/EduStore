<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2016/8/22
 * Time: 11:06
 */
require(EC_PATH . '/includes/init.php');

include_once(EC_PATH . '/includes/lib_order.php');
include_once(EC_PATH . '/includes/lib_passport.php');

$username = _POST('name');
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

if (register($username, $password, $email, $other) === false) {
	GZ_Api::outPut(11);
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

//获取json中的信息
$teacher_info = array();
$teacher_info['real_name'] = isset($_POST['real_name']) ? trim($_POST['real_name']): '';
$teacher_info['school'] = isset($_POST['school']) ? trim($_POST['school']): '';
$teacher_info['course_id'] = isset($_POST['course']) ? $_POST['course'] : '';

//防止sql注入
$teacher_info['real_name'] = addslashes($teacher_info['real_name']);
$teacher_info['school'] = addslashes($teacher_info['school']);
$teacher_info['course_id'] = addslashes($teacher_info['course_id']);
$other['mobile_phone'] = addslashes($other['mobile_phone']);

//修改相应的数据库
$values = array();
$values[] = $_SESSION['user_id'];
$values[] = $teacher_info['course_id'];
$values[] = $teacher_info['real_name'];
$values[] = $teacher_info['school'];

$sql = 'INSERT INTO '. $ecs->table('teachers') . ' (`user_id`, `course_id`, `real_name`, `school`)'. " VALUES ('" . implode("', '", $values) . "')";
$db->query($sql);
//更新教师字段信息
$sql = 'UPDATE ' . $ecs->table('users') . " SET `is_teacher`='1' WHERE `user_id`='" . $_SESSION['user_id'] . "'";
$db->query($sql);

// 插入手机信息
if( isset($_POST['mobile_phone'])) {
    $mobile_phone = $_POST['mobile_phone'];
    $sql = 'UPDATE '. $ecs->table('users') . "SET `mobile_phone` = '$mobile_phone' WHERE `user_id`='" . $_SESSION['user_id'] . "'";
    $db->query($sql);
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
