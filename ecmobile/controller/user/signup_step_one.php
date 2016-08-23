<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2016/8/17
 * Time: 16:33
 */

require(EC_PATH . '/includes/init.php');

$username = $_REQUEST['username'];
$mobile_phone = $_REQUEST['mobile_phone'];

//$username = "zhangmengqi";
//$mobile_phone = "13518143569"; //为了测试方便

$sql1 = 'SELECT COUNT(*) FROM ' . $ecs->table('users') . ' WHERE user_name = ' . " '$username'";
$sql2 = 'SELECT COUNT(*) FROM ' . $ecs->table('users') . ' WHERE mobile_phone = ' . " '$mobile_phone'";

$username_exsit = $db->getOne($sql1); //判断用户名是否存在
$mobile_phone_exsit = $db->getOne($sql2); //判断手机号是否已经存在

if ($username_exsit > 0) {
    GZ_Api::outPut(15);  //用户名重复
} else if ($mobile_phone_exsit > 0) {
    GZ_Api::outPut(16);  //手机号重复
} else{                //校验通过，可以进行下一步注册
    $data = array();
    GZ_Api::outPut($data);
}


