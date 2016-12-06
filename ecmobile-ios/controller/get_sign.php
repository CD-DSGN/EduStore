<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2016/10/24
 * Time: 15:51
 */

define('INIT_NO_USERS', true);
require(EC_PATH . '/includes/init.php');
require(EC_PATH . '/ecmobile-ios/payment/alipay/sdk/lib/alipay_rsa.function.php');


GZ_Api::authSession();

//$content = stripslashes(_POST('content'));
$order_id = _POST('order_id');
$user_id = $_SESSION['user_id'];

// $order_id = 87;
// $user_id = 7;

$order_info = getOrderInfo($order_id, $user_id);

$out = array(
    'sign' => rsaSign($order_info, EC_PATH . '/ecmobile-ios/payment/alipay/key/rsa_private_key.pem'),
);

GZ_Api::outPut($out);

//获取订单的必要信息
function getOrderInfo($order_id, $user_id)
{
    require_once(EC_PATH . '/ecmobile-ios/payment/alipay/sdk/alipay.config.php');
    $sql = "SELECT order_id, order_sn, order_amount
     " .
        " FROM " . $GLOBALS['ecs']->table('order_info') .
        " WHERE user_id = '$user_id' " . "and order_id = '$order_id'";
    $res = $GLOBALS['db']->getRow($sql);
    $arr = $res;

    $sql = "SELECT goods_id, goods_name " .
        "FROM " . $GLOBALS['ecs']->table('order_goods') .
        " WHERE order_id = '$order_id'";
    $res = $GLOBALS['db']->getALL($sql);
    $arr['subject'] = $res[0]['goods_name'] . '等' . count($res) . '种商品';


    $strOrderInfo = "partner=\"" . $alipay_config['partner'] . "\"" .
        "&" .
        "seller_id=" . "\"" . $alipay_config['partner'] . "\"" .
        "&" .
        "out_trade_no=" . "\"" . $arr['order_sn'] . "\"" .
        "&" .
        "subject=" . "\"" . $arr['subject'] . "\"" .
        "&" .
        "body=" . "\"" . $arr['subject'] . "\"" .
        "&" .
        "total_fee=" . "\"" . $arr['order_amount'] . "\"" .
        "&" .
        "notify_url=" . "\"" .
        $alipay_config['notify_url'] . "\"" .
        "&service=\"mobile.securitypay.pay\"" .
        "&payment_type=\"1\"" .
        "&_input_charset=\"utf-8\"";

    return $strOrderInfo;
}
