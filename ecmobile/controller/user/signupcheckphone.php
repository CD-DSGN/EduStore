<?php
/**
 * create for checking phone number and sending verification code
 * @author chenggaoyuan
 */
include_once(EC_PATH . '/sms/CCPRestSmsSDK.php');
require(EC_PATH . '/includes/init.php');
require(EC_PATH . '/sms/SendSmsForVerificationCode.php');
$phone_num = _POST('phonenum');
$time='5';//验证码有效时间
if ($_CFG['shop_reg_closed']) {
    GZ_Api::outPut(10);
}

$sql = 'SELECT user_id FROM '.$ecs->table('users').' WHERE mobile_phone = '.$phone_num;
$user_id_all=$db->getAll($sql);

if(!empty($user_id_all)){
    GZ_Api::outPut(12);
}else{
    $sendSms = new SendSmsForVerificationCode($phone_num, $time);
    $sendSms->sendSmsForVeriCode();
    //$out = array(
    //    'veri_code' => '888888'
    //);
    //GZ_Api::outPut($out);
}

