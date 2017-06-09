<?php
/**
 * Created by nhj.
 */

define('INIT_NO_USERS', true);

require(EC_PATH . '/includes/init.php');
// EC_PATH = /Library/WebServer/Documents/edustore

GZ_Api::authSession();
$user_id = $_SESSION['user_id'];
// $user_id = 8;

$avatar = _POST('avatar');

$dir = EC_PATH . "/images/avatar";
$avatar_name = extend_user_id($user_id);				// 用户头像图片的名字
$img_name = $dir ."/". $avatar_name;					// 服务器上的路径
$user_avatar = "images/avatar/" .$avatar_name;			// 存数据库之内的路径

if (!file_exists($dir))
{
	if (!make_dir($dir))
	{
		GZ_Api::outPut(700);			// 创建/打开目录失败，无权限
	}
}

if (empty($avatar_name))
{
	GZ_Api::outPut(701);			// 图片路径生成失败
}

$avatar_binary_data = base64_decode($avatar);

if ($fp = @fopen($img_name, "wb"))
{
	@fwrite($fp, $avatar_binary_data);
	@fclose($fp);
	
	// 修改数据库所存储的值
	$sql = "UPDATE ". $GLOBALS['ecs']->table('users') ." SET `avatar` = '". $user_avatar ."' WHERE `user_id` = '". $user_id ."'";
	$GLOBALS['db']->query($sql);

	$out = array('update' =>  '1');
	GZ_Api::outPut($out);
}
else
{
	GZ_Api::outPut(702);			// 写文件失败，无权限
}





/**
 * 输出8位的带用户id的头像名称
 *
 * @param int $user_id 		用户id
 * @param str $img_name 	头像名称
 */
function extend_user_id($user_id)
{
	$length = strlen($user_id);
	switch ($length) {
		case '1':
			$img_name = "0000000". $user_id;
			break;
		case '2':
			$img_name = "000000". $user_id;
			break;
		case '3':
			$img_name = "00000". $user_id;
			break;
		case '4':
			$img_name = "0000". $user_id;
			break;
		case '5':
			$img_name = "000". $user_id;
			break;
		case '6':
			$img_name = "00". $user_id;
			break;
		case '7':
			$img_name = "0". $user_id;
			break;
		case '8':
			$img_name = $user_id;
			break;
		default:
			break;
	}
    $time =time();
    $img_name = $img_name .'_' .$time .".jpeg";
    return $img_name;
}




