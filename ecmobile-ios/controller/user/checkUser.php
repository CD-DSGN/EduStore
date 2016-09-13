<?php

require(EC_PATH . '/includes/init.php');

include_once(EC_PATH . '/includes/lib_passport.php');

$userName = _POST('username');

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
	if($is_exist == 0){     //用户名未被注册,可以使用
	    $out = array(
	    	'username' => $userName
	    );
	    GZ_API::outPut($out);
	}else{                  //已被注册
	  GZ_Api::outPut(11);
	}
}
