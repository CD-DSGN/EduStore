<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2017/3/4
 * Time: 14:54
 */
//身份验证
define('INIT_NO_USERS', true);
require(EC_PATH . '/includes/init.php');
GZ_Api::authSession();


$refund = $_POST;

$rec_id = $refund['rec_id'];

//获取退货参数，修改相应的数据库
if ($rec_id <= 0 ||
    $GLOBALS['db']->getOne("select refund_status from " . $GLOBALS['ecs']->table("order_goods") . " where rec_id='$rec_id'") > 0 ||
    empty($refund['refund_reason']) ||
    empty($refund['refund_desc'])) {
    GZ_Api::outPut(20000); //参数错误
}


$refund['refund_status'] = 1;
$refund['refund_add_time'] = gmtime();
//操作成功
if ($GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_goods'), $refund, 'UPDATE', "rec_id = '" . $rec_id . "'")) {
    $out = array();
    GZ_Api::outPut($out);
}else{
    GZ_Api::outPut(20001); //提交申请失败
}






