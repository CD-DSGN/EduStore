/* indpassword.js author:chenggaoyuan*/

/* *
 * 发送短信验证码
 */
 $(function(){
 	$("#sendMessageBtnId").attr('disabled',true).css('cursor','not-allowed').css("backgroundColor","grey");
 	if($("#fpw_mobilephoneId").val()!=null){
 		checkmobilephone();
 	}
 });
function startSendMessage(){
	var btn = $("#sendMessageBtnId");
	var count = 60;
	btn.val(count+"秒后可重新获取").attr('disabled',true).css('cursor','not-allowed').css("backgroundColor","grey");
	startSendMessage_ajaxAction();
	var resend = setInterval(function(){
			count--;
			if(count>0){
				btn.val(count+"秒后可重新获取");
			}else{
				clearInterval(resend);
				btn.val("获取验证码").removeAttr('disabled style');
			}		
		}	
	,1000);

}
/* *
 * 检查手机号是否已注册
 */
 function checkmobilephone(){
 	var mobile = $("#fpw_mobilephoneId").val();
 	var notice = $("#mobilePhone_notice");
 	if(true == validatemobile(mobile)){
 		var request = new XMLHttpRequest();
 		request.open("POST", "user.php?act=check_mobile_phone");
 		var data = "mobile_phone="+mobile;
 		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");
 		request.send(data);
 		request.onreadystatechange = function(){
 			if(request.readyState==4){
 				if(request.status==200){
 					if(request.responseText=="1"){
 						notice.html("OK 请获取并输入短信验证码");
 						$("#sendMessageBtnId").removeAttr('disabled style');
 					}else{
 						notice.html("此手机号码未被注册");
 					}
 				}
 			}
 		}

 	}else{
 		$("#sendMessageBtnId").attr('disabled',true).css('cursor','not-allowed').css("backgroundColor","grey");
 	}

}
/* *
 * 检查手机号格式
 */
 function validatemobile(mobile) {
   		var notice = $("#mobilePhone_notice"); 
        if(mobile.length==0) 
        { 
        	notice.html("请输入手机号")
          	return false; 
        }   
      
        var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
        if(!myreg.test(mobile)) 
        { 
            notice.html("请输入有效的手机号码！")
          	return false; 
        }
        return true; 
} 
/* *
 * 发送验证码
 */
 function startSendMessage_ajaxAction(){
 	var mobile = $("#fpw_mobilephoneId").val();
 	var request = new XMLHttpRequest();
 	request.open("POST","./sms/SendTemplateSMS.php");
 	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");
 	request.send("mobile_phone="+mobile);
 }

 function check_fpw_identifyCode(){
 	var code=$("#fpw_identifyCodeID");
 	var code_notice = $("#identifyCode_notice");
 	if(code.val().length==4){
 		var request = new XMLHttpRequest();
 		request.open("POST", "user.php?act=check_identifyCode");
 		var data = "code="+code.val();
 		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");
 		request.send(data);
 		request.onreadystatechange = function(){
 			if(request.readyState==4){
 				if(request.status==200){
 					if(request.responseText=="correct"){
 						code_notice.html("验证码正确");
 					}else if(request.responseText=="error"){
 						code_notice.html("验证码错误");
 					}else if(request.responseText=="timeout"){
 						code_notice.html("验证码已过期");
 					}
 				}
 			}
 		}
 	}else{
 		code_notice.html("");
 	}
 }