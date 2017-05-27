/* 使用一组全局变量，存储每一个输入框的状态 */
var username_status = 0;				// 0表示为空，1表示正确，2表示已被注册，3表示用户名中有非法字符，4表示位数错误
var phone_status = 0;					// 0表示为空，1表示正确，2表示电话已被注册，3表示电话不符合规则，4表示位数错误
var identifyCode_status = 0;			// 0表示为空，1表示正确，2表示验证码错误，3表示验证码超时，4表示验证码位数错误
var realName_status = 0;				// 0表示为空，1表示正确
var school_status = 0;					// 0表示为空，1表示正确
var course_status = 0;					// 0表示为空，1表示正确	
var password_status = 0;				// 0表示为空，1表示正确，2表示两次密码不一致,3表示密码过短
var confirmPassword_status = 0;			// 0表示为空，1表示正确，2表示两次密码不一致
var agreement_status = 1;				// 0表示为空，1表示正确
var address_status = 0;					// 0表示为空，1表示正确
var grade_class_status = 0;				// 0表示为空（请至少填写一组年级和班级），1表示正确，2表示班级有数字，3表示信息不完善（要么都填、要么都空）
var code_status = 1;
// 年级、班级的全局变量，传参时用
var gradeArray = Array();
var classArray = Array();
/* 默认为0，表示为空/错误，1：正确 */

/* 定义错误提示的图片语句 */
var error_info = '<img height="16px" width="16px" src="./data/images/register/error.png" style="float:left; padding-left: 10px; padding-right: 10px;" /> ';
var low_strength = '<img height="16px" width="16px" src="./data/images/register/low.png" style="float:left; padding-left: 10px; padding-right: 10px;" /> ';
var middle_strength = '<img height="16px" width="16px" src="./data/images/register/middle.png" style="float:left; padding-left: 10px; padding-right: 10px;" /> ';
var high_strength = '<img height="16px" width="16px" src="./data/images/register/high.png" style="float:left; padding-left: 10px; padding-right: 10px;" /> ';
var notice = '<img height="16px" width="16px" src="./data/images/register/notice.png" style="float:left; padding-left: 10px; padding-right: 10px;" /> ';


function checkMobileNumber() {
	var mobile_phone = $.trim($("#mobileNumber").val());
	var reg = /^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$/;
	if(mobile_phone.length == 11){
		if(mobile_phone.match(reg) != null){
			 $.post("./user.php?act=check_mobile_phone",
					{"mobile_phone" : mobile_phone}, 
		   			function(data){
			   			if(data == 0){
							$("#mobileNumber_correct").css({'display':'block'});
							$("#mobileNumber_tips").html("");
							phone_status = 1;
						}
						else{	//电话已被注册
							$("#mobileNumber_correct").css({'display':'none'});
							$("#mobileNumber_tips").html(error_info + '该电话已被注册');
							phone_status = 2;
						}
			});
		}
		else{	//电话不符合规则
			$("#mobileNumber_correct").css({'display':'none'});
			$("#mobileNumber_tips").html(error_info + '该电话格式不符合规则');
			phone_status = 3;
		}
	}
	else{	//电话位数错误
		$("#mobileNumber_tips").html(error_info + '请输入11位电话号码');
		$("#mobileNumber_correct").css({'display':'none'});
		phone_status = 4;
	}
}
function checkUsername() {
	var username = $.trim($("#username").val());
	var unlen = username.replace(/[^\x00-\xff]/g, "**").length;
	console.log(username +'...'+ unlen);

    if ( !chkstr( username ) )
    {
        $("#username_tips").html(error_info + '用户名中含有非法字符');
        $("#username_correct").css({'display' : 'none'});
        username_status = 3;
    }
    else if ( unlen < 3 || unlen > 20 )
    { 
       $("#username_tips").html(error_info + '请输入3-20字符的用户名');
       $("#username_correct").css({'display' : 'none'});
       username_status = 4;
    }
    else {
		$.get( "./user.php?act=is_registered",
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
					    $("#username_tips").html(error_info + '用户名已被注册');
					    $("#username_correct").css({'display' : 'none'});
					    username_status = 2;
					}
	    		}
	    );
    }
   
}
function check_invite_code(){
	var invite_code = $.trim($("#invite_code").val());
	if(invite_code.length==0){
		$("#invite_code_tips").html('');
		$("#invite_code_correct").css({'display' : 'none'});
		code_status = 1;
	}
	else{
		$.post("./user.php?act=check_invite_code",
			   {"invite_code":invite_code},
			   function(data){
				   if(data ==0){
						$("#invite_code_tips").html(error_info + '邀请码有误，请重新输入!');
						$("#invite_code_correct").css({'display' : 'none'});
						code_status = 0;
					}
					else if(data ==1){
						$("#invite_code_tips").html('');
						$("#invite_code_correct").css({'display' : 'block'});
						code_status = 1;
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
			 $.post("./user.php?act=check_mobile_phone",
					{"mobile_phone" : mobile_phone}, 
		   			function(data){
			   			if(data == 0){
			   				$(".get_identifyCode").attr({'disabled':true}).css({'background-color' : '#fafafa', 'color' : '#c4c4c4'});
							$.post("./sms/SendTemplateSMS.php",
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
	    $.post("./user.php?act=check_identifyCode",
	          {'code':identifyCode},
	          function(data) {
	            console.log(data);
	            if(data == 'correct') {
	            	$("#identifyCode_tips").html("");
	            	$("#identifyCode_correct").css({'display' : 'block'});
	            	identifyCode_status = 1;
	            }else if(data == 'error') {
	            	$("#identifyCode_tips").html(error_info + '验证码错误');
	            	$("#identifyCode_correct").css({'display' : ''});
	            	identifyCode_status = 2;
	            }else if(data == 'timeout') {
	            	$("#identifyCode_tips").html(error_info + '验证码已超时，请重新获取');
	            	$("#identifyCode_correct").css({'display' : ''});
	            	identifyCode_status = 3;
	            }
	        }
	    );
	}else {
	    //验证码长度不正确
	    $("#identifyCode_tips").html(error_info + '请输入4位验证码');
	    $("#identifyCode_correct").css({'display' : ''});
	    identifyCode_status = 4;
	}
}

function checkAgreement() {
	if(document.getElementById('agreement').checked == false) {
		$("#agreement_tips").html(error_info + '请同意用户协议后再进行注册');
		agreement_status = 0;
	}else {
		$("#agreement_tips").html('');
		agreement_status = 1;
	}
}

function nextStep() {
 if( phone_status != 1) {
		$("#mobileNumber").focus().select();
		switch(phone_status) {
		case 0:case 4:
			$("#mobileNumber_correct").css({'display':'none'});
			$("#mobileNumber_tips").html(error_info + '请输入11位电话号码');
			break;
		case 2:
			$("#mobileNumber_correct").css({'display':'none'});
			$("#mobileNumber_tips").html(error_info + '该电话已被注册');
			break;
		case 3:
			$("#mobileNumber_correct").css({'display':'none'});
			$("#mobileNumber_tips").html(error_info + '该电话格式不符合规则');
			break;
		default:
			break;
		}
		return 0;
	}else if( identifyCode_status != 1) {
		$("#identifyCode").focus().select();
		switch (identifyCode_status) {
		case 0: case 4:
        	$("#identifyCode_tips").html(error_info + '请输入4位验证码');
	        $("#identifyCode_correct").css({'display' : ''});
	        break;
		case 2:
			$("#identifyCode_tips").html(error_info + '验证码错误');
	        $("#identifyCode_correct").css({'display' : ''});
	        break;
		case 3:
			$("#identifyCode_tips").html(error_info + '验证码已超时，请重新获取');
	        $("#identifyCode_correct").css({'display' : ''});
	        break;
		default:
			break;
		}
		return 0;
	} else if (password_status != 1) {

		$("#password").focus().select();
		$("#confirm_password").val('');
		switch (password_status) {
			case 0:
				$("#password_correct").css({'display' : 'none'});
				$("#confirm_password_correct").css({'display' : 'none'});
				$("#password_tips").html(error_info + '密码不能为空');
				break;
			case 2:
				$("#password_correct").css({'display' : 'none'});
				$("#confirm_password_correct").css({'display' : 'none'});
				$("#password_tips").html(error_info + '两次密码不一致');
				break;
			case 3:
				$("#password_correct").css({'display' : 'none'});
				$("#confirm_password_correct").css({'display' : 'none'});
				$("#password_tips").html(error_info + '密码长度过短');
				break;
			default:
				break;
		}
		return 0;
	} else if (confirmPassword_status != 1) {

		$("#confirm_password").focus().select();
		switch (confirmPassword_status) {
			case 0:
				$("#confirm_password_correct").css({'display' : 'none'});
				$("#confirm_password_tips").html(error_info + '密码不能为空');
				break;
			case 2:
				$("#confirm_password_correct").css({'display' : 'none'});
				$("#confirm_password_tips").html(error_info + '两次密码不一致');
				break;
			default:
				break;
		}
		return 0;
	} else if (code_status != 1) {

		$("#invite_code").focus().select();
		$("#invite_code_correct").css({'display' : 'none'});
		$("#invite_code_tips").html(error_info + '邀请码有误，请重新输入!');
		return 0;
	} else if( agreement_status != 1) {
		$("#agreement_tips").html(error_info + '同意用户协议才可以进行注册');
		return 0;
	}else {
		$(".step_one").css({'color' : '#666'});
		$("#img_step_one").attr({'src' : './data/images/register/icon_gray1.png'});
		$(".step_two").css({'color' : '#65bf92'});
		$("#img_step_two").attr({'src' : './data/images/register/icon2.png'});
		$("#create_account").css({'display' : 'none'});
		$("#improve_info").css({'display' : 'block'});
	}
}

function checkRealName() {
	var realName = $.trim($("#real_name").val());
	if(realName == '') {
		$("#real_name_correct").css({'display':'none'});
		$("#real_name_tips").html(error_info + '教师姓名不能为空');
		realName_status = 0;
	}else {
		$("#real_name_correct").css({'display':'block'});
		$("#real_name_tips").html("");
		realName_status = 1;
	}
}

function checkSchool() {
	// var school = $.trim($("#school").val());
	// if(school == '') {
	// 	$("#school_correct").css({'display':'none'});
	// 	$("#school_tips").html(error_info + '学校不能为空');
	// 	school_status = 0;
	// }else {
	// 	$("#school_correct").css({'display':'block'});
	// 	$("#school_tips").html("");
	// 	school_status = 1;
	// }
	var school = $("#school").val();
	if (school == 0) {
		$("#school_correct").css({'display':'none'});
		$("#school_tips").html(error_info + '学校不能为空');
		school_status = 0;
	} else {
		$("#school_correct").css({'display':'block'});
		$("#school_tips").html("");
		school_status = 1;
	}

}
function checkAddressName(){
	var province = document.getElementById("province").value;
	var city =document.getElementById("city").value;
	var town = document.getElementById("town").value;
	if(province == 0||city == 0||town == 0){
		$("#address_correct").css({'display':'none'});
		$("#address_notice").html(error_info + '请选择所在地');
		address_status = 0;
	}
	else if(province != 0&&city != 0&&town != 0){
		$("#address_correct").css({'display':'block'});
		$("#address_notice").html("");
		address_status = 1;
	}
}
function checkCourseName() {
	var course = $("#course_name").val();
	//可能根据实际情况设置value来更改判断条件
	if(course == 0) {
		$("#select_correct").css({'display':'none'});
		$("#course_name_tips").html(error_info + '请选择课程');
		course_status = 0;
	}else {
		$("#select_correct").css({'display':'block'});
		$("#course_name_tips").html("");
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
			$("#confirm_password_tips").html(error_info + '两次密码不一致');
			confirmPassword_status = 2;
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
		$("#password_tips").html(error_info + '密码长度过短');
		password_status = 3;
		return 0;
	}else if( password.length < 10) {
		//小于10位，密码强度弱
		$("#password_correct").css({'display' : 'block'});
		$("#password_tips").html(low_strength + '密码强度弱');
		password_status = 1;
		return 0;
	}else if( password.length < 14){
		//小于14位，密码强度中、弱
		if( m >= 2) {
			$("#password_correct").css({'display' : 'block'});
			$("#password_tips").html(middle_strength + '密码强度中');
			password_status = 1;
			return 0;
		}else {
			$("#password_correct").css({'display' : 'block'});
			$("#password_tips").html(low_strength + '密码强度弱');
			password_status = 1;
			return 0;
		}
	}else {
		if( m >= 3) {
			$("#password_correct").css({'display' : 'block'});
			$("#password_tips").html(high_strength + '密码强度强');
			password_status = 1;
			return 0;
		}else if( m == 2) {
			$("#password_correct").css({'display' : 'block'});
			$("#password_tips").html(middle_strength + '密码强度中');
			password_status = 1;
			return 0;
		}else {
			$("#password_correct").css({'display' : 'block'});
			$("#password_tips").html(low_strength + '密码强度弱');
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
			$("#confirm_password_tips").html(error_info + '两次密码不一致');
			confirmPassword_status = 2;
		}
	}else {
		$("#confirm_password_correct").css({'display' : 'none'});
		$("#confirm_password_tips").html(error_info + '两次密码不一致');
		confirmPassword_status = 2;
	}
}

function checkGradeClass() {

	var grade = $(".grade");
	var school_class = $(".school_class");
	var isComplete = 1;			// 判断每一行要么都填、要么都不填的状态；当某一行填写不完全时为0
	var classIsNum = 1;			// 班级只能填写数字的状态；班级不为数字时为0
	var hasGradeAndClass = 0;	// 至少得有一组年级或班级的状态值；有一组值之后置1
	for (var i = 0; i < grade.length; i++) {
		if ($(grade[i]).val() != 0 &&  $(school_class[i]).val() != '') {	// 不为0与空的状态
			hasGradeAndClass = 1;
			if (isNaN($(school_class[i]).val())) {
				// 不是数字
				classIsNum = 0;
			} else {
				// 是数字
				classIsNum = 1;
				gradeArray[i] = $(grade[i]).val();
				classArray[i] = $(school_class[i]).val();
			}

		} else if ($(grade[i]).val() == 0 && $(school_class[i]).val() == 0) {

		} else if ($(grade[i]).val() == 0 &&  $(school_class[i]).val() == '') {  	// 同时为0或空的状态
			gradeArray[i] = 0;
			classArray[i] = 0;
		} else {									// 一项有值，一项没值得状态
			isComplete = 0;
		}
	}
	//console.log('isComplete->' + isComplete + ', classIsNum->' + classIsNum + ', hasGradeAndClass->' + hasGradeAndClass);
	
	// 错误消息的提示与去除
	var gradeClassTips = $(".grade_class_tips");
	for (var i = 0; i < gradeClassTips.length; i++) {
		$(gradeClassTips[i]).html('');
	}
	/*
	* 判断的过程
	* 1、要么都填，要么都不填的判断isComplete
	* 2、填写的班级只能为数字
	* 3、至少得有一组班级和年级，应付数据全为空的状态
	*/
	if (isComplete) {
		grade_class_status = 1;
	} else {
		$(gradeClassTips[gradeClassTips.length - 1]).html(error_info + '年级与班级不能为空');
		grade_class_status = 0;
		$(gradeClassTips[gradeClassTips.length - 1]).html(error_info + '年级和班级要么都填，要么都不填');
		grade_class_status = 3;
		return;
	}
	if (classIsNum) {
		grade_class_status = 1;
	} else {
		$(gradeClassTips[gradeClassTips.length - 1]).html(error_info + '班级只能填写数字');
		grade_class_status = 2;
		return;
	}
	if (!hasGradeAndClass) {
		$(gradeClassTips[gradeClassTips.length - 1]).html(error_info + '请至少填写一组年级和班级');
		grade_class_status = 0;
		return;
	}
}


// function usernameTips() {
// 	$("#username_tips").html('<img height="16px" width="16px" src="./data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 支持中文、英文、数字，3-20个字符');
// }

// function mobileNumberTips() {
// 	$("#mobileNumber_tips").html('<img height="16px" width="16px" src="./data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请输入电话号码');
// }

// function identifyCodeTips() {
// 	$("#identifyCode_tips").html('<img height="16px" width="16px" src="./data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请输入验证码');
// }

// function realNameTips() {
// 	$("#real_name_tips").html('<img height="16px" width="16px" src="./data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请输入您的姓名');
// }

// function schoolTips() {
// 	$("#school_tips").html('<img height="16px" width="16px" src="./data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请输入您的学校');
// }

// function passwordTips() {
// 	$("#password_tips").html('<img height="16px" width="16px" src="./data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请输入密码');
// }

// function confirmPasswordTips() {
// 	$("#confirm_password_tips").html('<img height="16px" width="16px" src="./data/images/register/notice.png" style="float:left; padding-right: 10px;" /> 请再次输入密码');
// }

function focusTips( id, message ) {
	var tips = id + '_tips';
	document.getElementById(tips).innerHTML = notice + message;
}

function jumpToIndex() {
	window.location.href = "./index.php";
}


/*pj ajax判断*/
function showAll(){
	var rr=$('#school').val();
	var tt=$('#course_name').val(); 
    $(".gradeAndClass").each(function(index) {
 //    	pp=$(this);
 //    	pp.css('background','red');
 //          if (pp.find(".grade").val()!=0 && pp.find(".school_class").val()!="" && rr!=0 && tt!=0) {
 //            console.log("grade="+pp.find(".grade").val()+"class="+pp.find(".school_class").val() +"school="+ rr+"course="+ tt);
 // }
 //    	})
    	//console.log(this);
    //$(this).css('background','red');
     if ($(this).find(".grade").val()!=0 && $(this).find(".school_class").val()!="" && rr!=0 && tt!=0) {
     	 var request = new XMLHttpRequest();
           request.open("post","user.php?act=check_teacher_grade_class");
	      request.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");
           request.send("grade="+$(this).find(".grade").val()+"&class="+$(this).find(".school_class").val() +"&school="+ rr+"&course="+ tt);
 	      request.onreadystatechange=function(){
 	      if(request.readyState===4){
	      if(request.status===200){
	 		   if(request.responseText==1) {
		 	    alert("注册信息重复，请重新填写");
		 	 }else{
		 	 	return true;
		 	 }
	    
 }
 }
}

console.log("grade="+$(this).find(".grade").val()+"class="+$(this).find(".school_class").val() +"school="+ rr+"course="+ tt);
}
})
}