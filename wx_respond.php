<?php

/**
 * ECSHOP 支付响应页面
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: respond.php 17217 2011-01-19 06:29:08Z liubo $
 */

define('IN_ECS', true);

require(dirname(__FILE__) . '/includes/init.php');
require(ROOT_PATH . 'includes/lib_payment.php');
require(ROOT_PATH . 'includes/lib_order.php');

require_once (ROOT_PATH . 'includes/modules/payment/lib/log.php');
//$logHandler= new CLogFileHandler(ROOT_PATH."/logs/".date('Y-m-d').'.log');
//$log = Log::Init($logHandler, 15);
/* 支付方式代码 */
$pay_code = !empty($_REQUEST['code']) ? trim($_REQUEST['code']) : '';

//begin zhangmengqi
//处理微信回调参数
$file_in = $HTTP_RAW_POST_DATA;
$xml = new DOMDocument();
$xml->loadXML($file_in);
$outTradeNos = $xml->getElementsByTagName('out_trade_no');
foreach ($outTradeNos as $outTradeNo) {
    $_POST['order_sn'] = $outTradeNo->nodeValue;
}
$resultCodes = $xml->getElementsByTagName('result_code');
foreach ($resultCodes as $resultCode) {
    $_POST['result_code'] = $resultCode->nodeValue;
}
$returnCodes = $xml->getElementsByTagName('return_code');
foreach ($returnCodes as $returnCode) {
    $_POST['return_code'] = $returnCode->nodeValue;
}
//end zhangmengqi

//获取微信支付方式
if (isset($_POST['return_code']) && isset($_POST['result_code']))
{
	$pay_code = 'wxpay';
}


/* 参数是否为空 */
if (empty($pay_code))
{
    $msg = $_LANG['pay_not_exist'];
}
else
{
    /* 判断是否启用 */
    $sql = "SELECT COUNT(*) FROM " . $ecs->table('payment') . " WHERE pay_code = '$pay_code' AND enabled = 1";
    if ($db->getOne($sql) == 0)
    {
        $msg = $_LANG['pay_disabled'];
    }
    else
    {
        $plugin_file = 'includes/modules/payment/' . $pay_code . '.php';

        /* 检查插件文件是否存在，如果存在则验证支付是否成功，否则则返回失败信息 */
        if (file_exists($plugin_file))
        {
            /* 根据支付方式代码创建支付类的对象并调用其响应操作方法 */
            include_once($plugin_file);

            $payment = new $pay_code();
            $msg     = @$payment->respond();
        }
        else
        {
            $msg = $_LANG['pay_not_exist'];
        }
    }
}


?>