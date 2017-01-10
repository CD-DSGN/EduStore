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

$username = _POST('name');
$password = _POST('password');
$mobilePhone = _POST('mobilePhone');
$email = '';
$country = _POST('country');
$province_name = _POST('provinceName');
$city_name = _POST('cityName');
$town_name = _POST('townName');
//$email = _POST('email');
// $fileld = _POST('fileld', array());
$fileld = isset($_POST['field'])?$_POST['field']:array();
$teacher_info = array();
$teacher_info['real_name'] = _POST('realname');
$teacher_info['school'] = _POST('school');
$teacher_info['course_id'] = _POST('course');
$is_teacher = _POST('isTeacher');
$invite_user_id = _POST('invite_user_id');      // 邀请者的user_id，不存在为0

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
//$other['mobile_phone'] = isset($filelds[5]) ? $filelds[5] : '';
$other['mobile_phone'] = $mobilePhone;

if (register($username, $password, $email, $other) === false) {
	GZ_Api::outPut(11);
}

if($is_teacher == '1') {
    $values = array();
    $values[] = $_SESSION['user_id'];
    $values[] = $teacher_info['course_id'];
    $values[] = $teacher_info['real_name'];
    $values[] = $teacher_info['school'];
    $values[] = $country;

    // $values[] = $teacher_info['province_name'];
    // $values[] = $teacher_info['city_name'];
    // $values[] = $teacher_info['town_name'];

    // 查询省的region_id，非空判断、错误判断就先不加了
    $sql = 'SELECT region_id FROM'. $ecs->table('region') ."WHERE `region_name` = '" . $province_name ."' AND `region_type`  = '1'";
    $province = $db->getAll($sql);
    // $province_id = $province['region_id'];
    $values[] = $province[0]['region_id'];

    // 查询市的region_id
    $sql = 'SELECT region_id FROM'. $ecs->table('region') ."WHERE `region_name` = '" . $city_name ."' AND `region_type`  = '2'";
    $city = $db->getAll($sql);
    $values[] = $city[0]['region_id'];

    // 查询县的region_id 
    $sql = 'SELECT region_id FROM'. $ecs->table('region') ."WHERE `region_name` = '" . $town_name ."' AND `region_type`  = '3'";
    $town = $db->getAll($sql);
    $values[] = $town[0]['region_id'];

    $recommend_code = generate_recommend_code($values[0]);
    $values[] = $recommend_code;

    $sql = 'INSERT INTO '. $ecs->table('teachers') . ' (`user_id`, `course_id`, `real_name`, `school`, `country`, `province`, `city`, `district`, `recommend_code`)'. " VALUES ('" . implode("', '", $values) . "')";
    $db->query($sql);
    
    // 更新users表：is_teacher字段和parent_id字段
    $sql = 'UPDATE ' . $ecs->table('users') . " SET `is_teacher`='$is_teacher' WHERE `user_id`='" . $_SESSION['user_id'] . "'";
    $db->query($sql);
}

/*邀请码推荐处理*added by chenggaoyuan*/
$affiliate  = unserialize($GLOBALS['_CFG']['affiliate']);
if($invite_user_id !=0){
    if (isset($affiliate['on']) && $affiliate['on'] == 1)
    {
        // $up_uid = get_user_id_from_recommend_code($invite_code);

        empty($affiliate) && $affiliate = array();
        $affiliate['config']['level_register_all'] = intval($affiliate['config']['level_register_all']);
        $affiliate['config']['level_register_up'] = intval($affiliate['config']['level_register_up']);
        // if ($up_uid)
        // {
        if (!empty($affiliate['config']['level_register_all']))
        {
            if (!empty($affiliate['config']['level_register_up']))
            {
                $rank_points = $GLOBALS['db']->getOne("SELECT rank_points FROM " . $GLOBALS['ecs']->table('users') . " WHERE user_id = '$invite_user_id'");
                if ($rank_points + $affiliate['config']['level_register_all'] <= $affiliate['config']['level_register_up'])
                {
                    log_account_change($invite_user_id, 0, 0, $affiliate['config']['level_register_all'], 0, sprintf($GLOBALS['_LANG']['register_affiliate'], $_SESSION['user_id'], $username));
                }
            }
            else
            {
                log_account_change($invite_user_id, 0, 0, $affiliate['config']['level_register_all'], 0, $GLOBALS['_LANG']['register_affiliate']);
            }
            // }

            //设置推荐人
            $sql = 'UPDATE '. $GLOBALS['ecs']->table('users') . ' SET parent_id = ' . $invite_user_id . ' WHERE user_id = ' . $_SESSION['user_id'];

            $GLOBALS['db']->query($sql);
        }
    }

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

$user_info = GZ_user_info($_SESSION['user_id']);

$out = array(
	'session' => array(
		'sid' => SESS_ID.$GLOBALS['sess']->gen_session_key(SESS_ID),
		'uid' => $_SESSION['user_id']
	),

	'user' => $user_info
);

GZ_Api::outPut($out);

function generate_recommend_code($num) {
    $num = intval($num) + 1260;
    if ($num <= 0)
        return false;
        $charArr = array("1","2","3","4","5","6","7","8","9",'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $char = '';
        do {
            $key = ($num - 1) % 35;
            $char= $charArr[$key] . $char;
            $num = floor(($num - $key) / 35);
        } while ($num > 0);
        return $char;
}

