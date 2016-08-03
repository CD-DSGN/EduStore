/* 使用一组全局变量，存储每一个输入框的状态 */
var username_status = 0;		
var phone_status = 0;
var identifyCode_status = 0;
var realName_status = 0;
var school_status = 0;
var course_status = 0;
var password_status = 0;
var confirmPassword_status = 0;
/* 默认为0，表示为空/错误，1：正确 */

function checkMobileNumber() {
	var mobile_phone = $.trim($("#mobileNumber").val());
	var reg = /^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/;
	if(mobile_phone.length == 11){
		if(mobile_phone.match(reg) != null){
			 $.post("../../user.php",
					{"mobile_phone" : mobile_phone}, 
		   			function(data){
			   			if(data == 0){
							$("#mobileNumber_correct").css({'display':'block'});
							$("#mobileNumber_tips").html("");
							phone_status = 1;
						}
						else{	//电话已被注册
							$("#mobileNumber_correct").css({'display':'none'});
							$("#mobileNumber_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 该电话已被注册');
							phone_status = 0;
						}
			});
		}
		else{	//电话不符合规则
			$("#mobileNumber_correct").css({'display':'none'});
			$("#mobileNumber_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 该电话格式不符合规则');
			phone_status = 0;
		}
	}
	else{	//电话位数错误
		$("#mobileNumber_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 请输入11位电话号码');
		$("#mobileNumber_correct").css({'display':'none'});
		phone_status = 0;
	}
}

function checkUsername() {
	var username = $.trim($("#username").val());
	var unlen = username.replace(/[^\x00-\xff]/g, "**").length;

    if ( !chkstr( username ) )
    {
        $("#username_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 用户名中含有非法字符');
        $("#username_correct").css({'display' : 'none'});
        username_status = 0;
    }
    else if ( unlen < 3 || unlen > 20 )
    { 
       $("#username_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 请输入3-20字符的用户名');
       $("#username_correct").css({'display' : 'none'});
       username_status = 0;
    }
    else {
		$.get( "../../user.php?act=is_registered",
	    		{"username" : username},
	    		function(data) {
	    			if ( data == "true" )
					{
						$("#username_tips").html('');
						$("#username_correct").css({'display' : 'block'});
						username_status = 1;
					}
					else
					{
					    $("#username_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 用户名已被注册');
					    $("#username_correct").css({'display' : 'none'});
					    username_status = 0;
					}
	    		}
	    );
    }
   
}

function chkstr(str)
{
  	for (var i = 0; i < str.length; i++)
  	{
    	if (str.charCodeAt(i) < 127 && !str.substr(i,1).match(/^\w+$/ig))
    	{
      		return false;
    	}
 	}
 	return true;
}

function getIdentifyCode() {
	var mobile_phone = $.trim($("#mobileNumber").val());
	var reg = /^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/;
	if(mobile_phone.length == 11){
		if(mobile_phone.match(reg) != null){
			 $.post("../../user.php",
					{"mobile_phone" : mobile_phone}, 
		   			function(data){
			   			if(data == 0){
							$.post("../../sms/SendTemplateSMS.php",
									{"mobile_phone" : mobile_phone},
									function(data){
										console.log(data);	
									});
							var count = 60;
							var countDown = setInterval( function() {
								$(".get_identifyCode").html(count+"秒后重新获取").attr({'disabled':true}).css({'background-color' : '#fafafa', 'color' : '#c4c4c4'});
								count--;
								if(count == -1) {
									$(".get_identifyCode").html("重新获取").attr({'disabled':false}).css({'background-color' : '#f1f1f1', 'color' : '#353032'});
									clearInterval(countDown);
								}
							} ,1000); 
						}
						else{	//电话已被注册
							$("#mobileNumber_correct").css({'display':'none'});
							$("#mobileNumber_tips").html("该电话已被注册");
							$("#mobileNumber").focus().select();
						}
			});
		}
		else{	//电话不符合规则
			$("#mobileNumber_correct").css({'display':'none'});
			$("#mobileNumber_tips").html("该电话格式不符合规则");
			$("#mobileNumber").focus().select();
		}
	}
	else{	//电话位数错误
		$("#mobileNumber_correct").css({'display':'none'});
		$("#mobileNumber_tips").html("请输入11位电话号码");
		$("#mobileNumber").focus().select();
	}
}

function checkIdentifyCode() {
	var identifyCode = $("#identifyCode").val();
	if(identifyCode.length == 4) {
	    $.post("../../user.php",
	          {'code':identifyCode},
	          function(data) {
	            console.log(data);
	            if(data == 'correct') {
	            	$("#identifyCode_tips").html("");
	            	$("#identifyCode_correct").css({'display' : 'block'});
	            	identifyCode_status = 1;
	            }else if(data == 'error') {
	            	$("#identifyCode_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 验证码错误');
	            	$("#identifyCode_correct").css({'display' : ''});
	            	identifyCode_status = 0;
	            }else if(data == 'timeout') {
	            	$("#identifyCode_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 验证码已超时，请重新获取');
	            	$("#identifyCode_correct").css({'display' : ''});
	            	identifyCode_status = 0;
	            }
	        }
	    );
	}else {
	    //验证码长度不正确
	    $("#identifyCode_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 请输入4位验证码');
	    $("#identifyCode_correct").css({'display' : ''});
	    identifyCode_status = 0;
	}
}

function nextStep() {
	if( username_status != 1) {
		$("#username").focus().select();
		return 0;
	}else if( phone_status != 1) {
		$("#mobileNumber").focus().select();
		return 0;
	}else if( identifyCode_status != 1) {
		$("#identifyCode").focus().select();
		return 0;
	}else {
		$(".step_one").css({'color' : '#666'});
		$("#img_step_one").attr({'src' : '../../data/images/register/icon_gray1.png'});
		$(".step_two").css({'color' : '#65bf92'});
		$("#img_step_two").attr({'src' : '../../data/images/register/icon2.png'});
		$("#create_account").css({'display' : 'none'});
		$("#improve_info").css({'display' : 'block'});
	}
}

function checkRealName() {
	var realName = $.trim($("#real_name").val());
	if(realName == '') {
		$("#real_name_correct").css({'display':'none'});
		$("#real_name_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 教师姓名不能为空');
		realName_status = 0;
	}else {
		$("#real_name_correct").css({'display':'block'});
		$("#real_name_tips").html("");
		realName_status = 1;
	}
}

function checkSchool() {
	var school = $.trim($("#school").val());
	if(school == '') {
		$("#school_correct").css({'display':'none'});
		$("#school_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 学校不能为空');
		school_status = 0;
	}else {
		$("#school_correct").css({'display':'block'});
		$("#school_tips").html("");
		school_status = 1;
	}
}

function checkCourseName() {
	var course = $("#course_name").val();
	//可能根据实际情况设置value来更改判断条件
	if(course == 0) {
		$("#select_correct").css({'display':'none'});
		$("#select_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 请选择课程');
		course_status = 0;
	}else {
		$("#select_correct").css({'display':'block'});
		$("#select_tips").html("");
		course_status = 1;
	}
}

function checkPassword() {
	var password = $.trim($("#password").val());
	var confirmPassword = $.trim($("#confirm_password").val());
	var Modes = 0;  //密码的模式，1/3/5/7
	var m = 0;
	if( confirmPassword != '') {
		if( password == confirmPassword) {
			$("#confirm_password_correct").css({'display' : 'block'});
			$("#confirm_password_tips").html('');
			confirmPassword_status = 1;
		}else {
			$("#confirm_password_correct").css({'display' : 'none'});
			$("#confirm_password_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 两次密码不一致');
			confirmPassword_status = 0;
		}
	}

	//遍历密码，获取其存在类型
	for( i = 0; i < password.length; i++ ) {
		var charType = 0;
		var t = password.charCodeAt(i);
		if(t >= 48 && t <= 57) {	//数字类型
			charType = 1;
		}else if(t >= 65 && t <= 90) {	//大写字母
			charType = 2;
		}else if(t >= 97 && t <= 122) {	//小写字母
			charType = 4;
		}else {
			charType = 8;
		}
		Modes |= charType;
	}
	//遍历Modes，得到密码类型数
	for( i = 0; i < 5; i++) {
		if(Modes & 1) {
			m++;
		}
		Modes >>>= 1;	//右移
	}
	//通过密码长度和类型数确定其强度
	if( password.length < 6) {
		//小于6位，不可注册
		$("#password_correct").css({'display' : 'none'});
		$("#password_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 密码长度过短');
		password_status = 0;
		return 0;
	}else if( password.length < 10) {
		//小于10位，密码强度弱
		$("#password_correct").css({'display' : 'block'});
		$("#password_tips").html('<img height="16px" width="16px" src="../../data/images/register/low.png" style="float:left; padding-right: 10px;" /> 密码强度弱');
		password_status = 1;
		return 0;
	}else if( password.length < 14){
		//小于14位，密码强度中、弱
		if( m >= 2) {
			$("#password_correct").css({'display' : 'block'});
			$("#password_tips").html('<img height="16px" width="16px" src="../../data/images/register/middle.png" style="float:left; padding-right: 10px;" /> 密码强度中');
			password_status = 1;
			return 0;
		}else {
			$("#password_correct").css({'display' : 'block'});
			$("#password_tips").html('<img height="16px" width="16px" src="../../data/images/register/low.png" style="float:left; padding-right: 10px;" /> 密码强度弱');
			password_status = 1;
			return 0;
		}
	}else {
		if( m >= 3) {
			$("#password_correct").css({'display' : 'block'});
			$("#password_tips").html('<img height="16px" width="16px" src="../../data/images/register/high.png" style="float:left; padding-right: 10px;" /> 密码强度强');
			password_status = 1;
			return 0;
		}else if( m == 2) {
			$("#password_correct").css({'display' : 'block'});
			$("#password_tips").html('<img height="16px" width="16px" src="../../data/images/register/middle.png" style="float:left; padding-right: 10px;" /> 密码强度中');
			password_status = 1;
			return 0;
		}else {
			$("#password_correct").css({'display' : 'block'});
			$("#password_tips").html('<img height="16px" width="16px" src="../../data/images/register/low.png" style="float:left; padding-right: 10px;" /> 密码强度弱');
			password_status = 1;
			return 0;
		}
	}
}

function checkConfirmPassword() {
	var confirmPassword = $.trim($("#confirm_password").val());
	var password = $.trim($("#password").val());

	if( password != '') {
		if( password == confirmPassword) {
			$("#confirm_password_correct").css({'display' : 'block'});
			$("#confirm_password_tips").html('');
			confirmPassword_status = 1;
		}else {
			$("#confirm_password_correct").css({'display' : 'none'});
			$("#confirm_password_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 两次密码不一致');
			confirmPassword_status = 0;
		}
	}else {
		$("#confirm_password_correct").css({'display' : 'none'});
		$("#confirm_password_tips").html('<img height="16px" width="16px" src="../../data/images/register/error.png" style="float:left; padding-right: 10px;" /> 两次密码不一致');
		confirmPassword_status = 0;
	}
}

function register() {
	if( realName_status != 1) {
				$("#real_name").focus().select();
				return false;
			}else if( school_status != 1) {
				$("#school").focus().select();
				return false;
			}else if(course_status != 1) {
				$("#course_name").focus().select();
				return false;
			}else if(password_status != 1) {
				$("#password").focus().select();
				return false;
			}else if(confirmPassword_status != 1) {
				$("#confirm_password").focus().select();
				return false;
			}else {
				$("#formTeacher").ajaxSubmit({
	        		success : function() {
	        			$(".step_two").css({'color' : '#666'});
						$("#img_step_two").attr({'src' : '../../data/images/register/icon_gray2.png'});
						$(".step_three").css({'color' : '#65bf92'});
						$("#img_step_three").attr({'src' : '../../data/images/register/icon3.png'});
						$("#register_success").css({'display' : ''});
						$("#improve_info").css({'display' : 'none'});
						var count = 2;
						var countDownIndex = setInterval(function() {
							$("#goIndex").html(count);
							count--;
							if(count == -1) {
								clearInterval(countDownIndex);
								//最后修改为网站首页域名
								window.location.href = '../../';
							}
						}, 1000) 
	        		}
	        	});
			}
        	return false;
}

function usernameTips() {
	$("#username_tips").html('<img height="16px" width="16px" src="../../data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 支持中文、英文、数字，3-20个字符');
}

function mobileNumberTips() {
	$("#mobileNumber_tips").html('<img height="16px" width="16px" src="../../data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请输入电话号码');
}

function identifyCodeTips() {
	$("#identifyCode_tips").html('<img height="16px" width="16px" src="../../data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请输入验证码');
}

function realNameTips() {
	$("#real_name_tips").html('<img height="16px" width="16px" src="../../data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请输入您的姓名');
}

function schoolTips() {
	$("#school_tips").html('<img height="16px" width="16px" src="../../data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请输入您的学校');
}

function passwordTips() {
	$("#password_tips").html('<img height="16px" width="16px" src="../../data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请输入密码');
}

function confirmPasswordTips() {
	$("#confirm_password_tips").html('<img height="16px" width="16px" src="../../data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请再次输入密码');
}

// function focusTips( message ) {
// 	console.log($(this).next('span'));
// 	$(this).nextAll('.input_tip').html('<img height="16px" width="16px" src="../../data/images/register/notice.png" style="float:left; padding-right: 10px;" /> ' + message);
// }