<?php
/**
 * create for checking phone number and sending verification code
 * @author chenggaoyuan
 */
include_once(EC_PATH . '/sms/CCPRestSmsSDK.php');
require(EC_PATH . '/includes/init.php');
require(EC_PATH . '/sms/SendSmsForVerificationCode.php');

$phone_num = _POST('phonenum');
$invite_code = isset($_POST['invite_code']) ? addslashes(trim($_POST['invite_code'])): 0;

$time='5';//验证码有效时间

if ($_CFG['shop_reg_closed']) {
    GZ_Api::outPut(10);
}
if(isset($phone_num)){
    $sql = 'SELECT user_id FROM '.$ecs->table('users').' WHERE mobile_phone = '.$phone_num;
    $user_id_all=$db->getAll($sql);
}
if(isset($invite_code) && $invite_code != 0){
    $sql = "SELECT recommend_code FROM" . $ecs->table('teachers') . "WHERE recommend_code = '" . $invite_code . "' ";
    $res = $db->query($sql);
    $is_exist = mysql_num_rows($res);
}

if(!empty($user_id_all)){
    GZ_Api::outPut(12);
}else if($invite_code != 0 && $is_exist == 0){
    GZ_Api::outPut(15);
}else{
    $sendSms = new SendSmsForVerificationCode($phone_num, $time);
    $sendSms->sendSmsForVeriCode();
    //$out = array(
    //    'veri_code' => '888888'
    //);
    //GZ_Api::outPut($out);
}

