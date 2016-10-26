<?php

/**
 * ECSHOP 微信扫码支付插件
 * author fengzhizi
 */

//if (!defined('IN_ECS'))
//{
//    die('Hacking attempt');
//}

require_once ROOT_PATH . 'includes/modules/payment/lib/WxPay.Api.php';
require_once ROOT_PATH . 'includes/modules/payment/lib/WxPay.Notify.php';
require_once ROOT_PATH . 'includes/modules/payment/lib/log.php';

//调试用
$logHandler= new CLogFileHandler(ROOT_PATH . "/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

$payment_lang = ROOT_PATH . 'languages/' .$GLOBALS['_CFG']['lang']. '/payment/wxpay.php';

if (file_exists($payment_lang))
{
    global $_LANG;

    include_once($payment_lang);
}
/* 模块的基本信息 */
if (isset($set_modules) && $set_modules == TRUE)
{
    $i = isset($modules) ? count($modules) : 0;

    /* 代码 */
    $modules[$i]['code']    = basename(__FILE__, '.php');

    /* 描述对应的语言项 */
    $modules[$i]['desc']    = 'wxpay_desc';

    /* 是否支持货到付款 */
    $modules[$i]['is_cod']  = '0';

    /* 是否支持在线支付 */
    $modules[$i]['is_online']  = '1';

    /* 作者 */
    $modules[$i]['author']  = 'FENGZHIZI';

    /* 网址 */
    $modules[$i]['website'] = 'http://weixin.qq.com';

    /* 版本号 */
    $modules[$i]['version'] = '1.0.0';

    /* 配置信息 */
    $modules[$i]['config']  = array(
        array('name' => 'wx_appid',           'type' => 'text',   'value' => ''),
        array('name' => 'wx_mchid',            'type' => 'text',   'value' => ''),
		array('name' => 'wx_key',            'type' => 'text',   'value' => ''),
		array('name' => 'wx_appsecret',            'type' => 'text',   'value' => ''),
    );

    return;
}

/**
 * 类
 */
class wxpay extends  WxPayNotify
{

    /**
     * 构造函数
     *
     * @access  public
     * @param
     *
     * @return void
     */
	 function __construct()
    {
        $this->wxpay();
    }
    function wxpay()
    {
    }

    

    /**
     * 生成支付二维码
     * @param   array   $order      订单信息
     * @param   array   $payment    支付方式信息
     */
    function get_code($order, $payment)
    {
        if (!defined('EC_CHARSET'))
        {
            $charset = 'utf-8';
        }
        else
        {
            $charset = EC_CHARSET;
        }
		
        $parameter = array(
//            'appid' 			=> 'wx426b3015555a46be',
//            'mch_id'			=> '1225312702',
//            'nonce_str'			=> strtolower(md5(mt_rand())),
            'product_id'		=> $order['order_sn'],
//            'time_stamp' 		=> time(),
            //begin zhangmengqi
//            'out_trade_no'      => $order['order_sn'] . "_" . $order['log_id'],
//            'price'             => $order['order_amount'],
            //end zhangmengqi
        );


        $param = '';

        foreach ($parameter AS $key => $val)
        {
            $param .= "$key=" .urlencode($val). "&";
        }

        //去掉结尾多余的&
        $param = substr($param, 0, -1);
		
//        $button = '<div style="text-align:center"><input type="button" class="pay_a" onclick="window.open(\'flow.php?step=wxpay&'.$param.'\')" value="' .$GLOBALS['_LANG']['pay_button']. '" /></div>';
        $button = '<div style="text-align:center"><input type="button" class="pay_a" onclick="location.href=\'flow.php?step=wxpay&'.$param.'\'" value="' .$GLOBALS['_LANG']['pay_button']. '" /></div>';

        return $button;
    }

    /**
     * 响应操作
     */
    function respond()
    {
//        Log::DEBUG("wxpay.php: respond");
        $this->Handle(false);
    }

    //查询订单函数
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
//        Log::DEBUG("query:" . json_encode($result));
        if(array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS")
        {
            return true;
        }
        return false;
    }

    //begin zhangmengqi
    function respond_callback($data, $msg){
        //先要检查支付金额是否和订单一致
        $out_trade_no = $data['out_trade_no'];
        $pos = strpos($out_trade_no, '_');
//        $order_sn = substr($out_trade_no, 0, $pos); //订单序列号
        $log_id = substr($out_trade_no, $pos + 1);
//        log::DEBUG("log_id:" . $log_id);
//        log::DEBUG("total_fee:" . $data['total_fee']);
        $total_fee = $data['total_fee']/100;
        if (!check_money($log_id, $total_fee))
        {
            return false;
        }

        //修改数据库,改变订单的支付状态
        order_paid($log_id, 2);
//        Log::DEBUG("order_paid", 2);
        return true;
    }
    //end zhangmengqi

    public function NotifyProcess($data, &$msg)
    {
//        Log::DEBUG("call back:" . json_encode($data));

        if(!array_key_exists("transaction_id", $data)){
            $msg = "输入参数不正确";
            return false;
        }
        //查询订单，判断订单真实性
        if(!$this->Queryorder($data["transaction_id"])){
            $msg = "订单查询失败";
            return false;
        }
        $this->respond_callback($data, $msg); //此时再来修改数据库
        return true;
    }
}

