<?php
/*
 *  Copyright (c) 2014 The CCP project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a Beijing Speedtong Information Technology Co.,Ltd license
 *  that can be found in the LICENSE file in the root of the web site.
 *
 *   http://www.yuntongxun.com
 *
 *  An additional intellectual property rights grant can be found
 *  in the file PATENTS.  All contributing project authors may
 *  be found in the AUTHORS file in the root of the source tree.
 */
//session_start();    //开启session会话

include_once("CCPRestSmsSDK.php");
require(EC_PATH . '/includes/init.php');
//主帐号,对应开官网发者主账号下的 ACCOUNT SID
$accountSid= '8a216da855d8c5050155d928953600c9';
//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
$accountToken= 'e9d1f3eb74e647778099b211e4e676b1';
//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
$appId='8aaf070855e333c00155e863037205d5';
//请求地址
//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
//生产环境（用户应用上线使用）：app.cloopen.com
$serverIP='app.cloopen.com';
//请求端口，生产环境和沙盒环境一致
$serverPort='8883';
//REST版本号，在官网文档REST介绍中获得。
$softVersion='2013-12-26';
echo $sql;
/**
  * 发送模板短信
  * @param to 手机号码集合,用英文逗号分开
  * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
  * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
  */       
function sendTemplateSMS($to,$datas,$tempId,$identifyCode)
{
     // 初始化REST SDK
     global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
     $rest = new REST($serverIP,$serverPort,$softVersion);
     $rest->setAccount($accountSid,$accountToken);
     $rest->setAppId($appId);
    
     // 发送模板短信
     // echo "Sending TemplateSMS to $to <br/>";
     $result = $rest->sendTemplateSMS($to,$datas,$tempId);
     if($result == NULL ) {
         // echo "result error!";
         // break;
        $out = "result error!";
        GZ_Api::outPut(3);
     }
     if($result->statusCode!=0) {
         // echo "error code :" . $result->statusCode . "<br>";
         // echo "error msg :" . $result->statusMsg . "<br>";
         //TODO 添加错误处理逻辑
        $out = $result->statusCode;
        GZ_Api::outPut(4);
     }else{
        //成功，通过 AJAX 返回 success，其余情况为发送错误。
        // echo "success";
         // echo "Sendind TemplateSMS success!<br/>";
         // // 获取返回信息
         // $smsmessage = $result->TemplateSMS;
         // echo "dateCreated:".$smsmessage->dateCreated."<br/>";
         // echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
         //TODO 添加成功处理逻辑
        $out = array(
            'identifyCode' => $identifyCode
        );
        GZ_Api::outPut($out);
     }
}
/*begin nahuanjie*/
/*发送随机短信验证码*/
function sendIdentifyCode()
{
    $phone = _post('mobilePhone');
    $reg = "/^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/";
    if(preg_match($reg, $phone)){
        $sql = "SELECT user_id FROM " .$GLOBALS['ecs']->table('users') . " WHERE mobile_phone = '$phone'";
        $res = $GLOBALS['db']->query($sql);
        $is_exist = mysql_num_rows($res);
        if($is_exist == 0){     //未被注册,发送验证码
            $randomIdentifyCode = rand(1000,9999);
            sendTemplateSMS($phone, array($randomIdentifyCode,'5'),"142535",$randomIdentifyCode);
        }else{                  //已被注册
          GZ_Api::outPut(1);
        }
    }else {     //电话不符合规则
        GZ_Api::outPut(2);
    }

//     $randomIdentifyCode = rand(1000,9999);
//     sendTemplateSMS($phone, array($randomIdentifyCode,'5'),"141220",$randomIdentifyCode);
}
//     $identifyCode = rand(1000,9999);
//     $out = array(
//             'identifyCode' => '8888'
//         );
//     GZ_Api::outPut($out);
sendIdentifyCode();
/*end nahuanjie*/
?>