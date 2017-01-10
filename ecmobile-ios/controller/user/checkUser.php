<?php

require(EC_PATH . '/includes/init.php');

include_once(EC_PATH . '/includes/lib_passport.php');

$userName = _POST('username');
$inviteCode = _POST('inviteCode');
$invite_user_id = '0';

if (admin_registered($userName))
{
    GZ_API::outPut(11);
}

if(empty($userName)) {
	GZ_API::outPut(11);
}else {
	$sql = "SELECT * FROM " .$GLOBALS['ecs']->table('users') . " WHERE user_name = '$userName'";
	$res = $GLOBALS['db']->query($sql);
	$is_exist = mysql_num_rows($res);

	// 邀请码不为空时才进行判断
	// echo "||||".$inviteCode;
	if(!empty($inviteCode) && $inviteCode != '0') {
		$sql = "SELECT user_id FROM ". $GLOBALS['ecs']->table('teachers') ."WHERE `recommend_code` = '". $inviteCode ."'";
		$res = $GLOBALS['db']->getRow($sql);
		if ($res) {
			$invite_user_id = $res['user_id'];
		} else {
			$out = array('invite_error' => '邀请码错误');
			GZ_Api::outPut($out);
		}
	}
	
	if($is_exist == 0){     //用户名未被注册,可以使用
	    $out = array(
	    	'username' => $userName,
	    	'invite_user_id' => $invite_user_id
	    );
	    GZ_API::outPut($out);
	}else{                  //已被注册
	  GZ_Api::outPut(11);
	}
}
