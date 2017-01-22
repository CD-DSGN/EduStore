<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2017/1/5
 * Time: 16:23
 */
require(EC_PATH . '/includes/init.php');
include_once(EC_PATH . '/includes/lib_order.php');
$cod_fee = 0;
$payment_list = available_payment_list(1, $cod_fee);
if(isset($payment_list))
{
    foreach ($payment_list as $key => $payment)
    {
        if ($payment['is_cod'] == '1')
        {
            $payment_list[$key]['format_pay_fee'] = '<span id="ECS_CODFEE">' . $payment['format_pay_fee'] . '</span>';
        }
        /* 如果有易宝神州行支付 如果订单金额大于300 则不显示 */
        if ($payment['pay_code'] == 'yeepayszx' && $total['amount'] > 300)
        {
            unset($payment_list[$key]);
        }
        /* 如果有余额支付 */
        if ($payment['pay_code'] == 'balance')
        {
            /* 如果未登录，不显示 */
            if ($_SESSION['user_id'] == 0)
            {
                unset($payment_list[$key]);
            }
            else
            {
                if ($_SESSION['flow_order']['pay_id'] == $payment['pay_id'])
                {
                    $smarty->assign('disable_surplus', 1);
                }
            }
        }
    }
}

$smarty->assign('payment_list', $payment_list);
$out['payment_list'] = $smarty->_var['payment_list'];

if (!empty($out['payment_list'])) {

    foreach ($out['payment_list'] as $key => $value) {
        unset($out['payment_list'][$key]['pay_config']);
        unset($out['payment_list'][$key]['pay_desc']);
        $out['payment_list'][$key]['pay_name'] = strip_tags($value['pay_name']);
        // cod 货到付款，alipay支付宝，bank银行转账
        if (in_array($value['pay_code'], array('bank', 'post', 'balance'))) {
            unset($out['payment_list'][$key]);
        }
        // $out['shipping_list'][$key]['configure'] = unserialize($value['configure']);
    }
    $out['payment_list'] = array_values($out['payment_list']);
}

GZ_API::outPut($out);
