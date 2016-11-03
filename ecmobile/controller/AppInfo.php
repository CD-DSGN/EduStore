<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2016/11/1
 * Time: 14:26
 */
//require(EC_PATH . '/includes/init.php');
require(EC_PATH . '/ecmobile/payment/alipay/sdk/alipay.config.php');
require(EC_PATH . '/ecmobile/payment/wxpay/tenpay_config.php');

$out = array();
//支付宝相关参数
$out['config']['alipay_key']['parterID'] = $alipay_config['partner'];
$out['config']['alipay_key']['sellerID'] = $alipay_config['partner'];
$out['config']['alipay_key']['rsa_alipay_public'] = $alipay_config['public_key_client'];
$out['config']['alipay_key']['callback'] = $alipay_config['notify_url'];

//微信相关参数
$out['config']['weixin_key']['app_id'] = $APP_ID;
$out['config']['weixin_key']['partner_id'] = $PARTNER;

//网址
$out['config']['site_url'] = "http://www.huishiclub.com";
//友盟
$out['config']['umeng_aos_key'];
//快递100
$out['config']['kuaidi100_key'];
//讯飞
$out['config']['ifly_aos_key'];


//百度推送
$out['config']['bae_push_key']['api_key'];
$out['config']['bae_push_key']['secret_key'];

//新浪微博
$out['config']['weibo_key']['app_key'];
$out['config']['weibo_key']['app_secret'];
$out['config']['weibo_key']['callback'];

//腾讯微博
$out['config']['tencent_key']['app_key'];
$out['config']['tencent_key']['app_secret'];
$out['config']['tencent_key']['callback'];

$out['succeed'] = 1;
die(json_encode($out));
//    file_put_contents();