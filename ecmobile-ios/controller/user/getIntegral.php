<?php

/*
 *  added by nhj  
 *  do follow
 */

require(EC_PATH . '/includes/init.php');

include_once(EC_PATH . '/includes/lib_order.php');
include_once(EC_PATH . '/includes/lib_passport.php');

$user_id = _POST('user_id');

if ($_CFG['shop_reg_closed']) {
	GZ_Api::outPut(11);
}

$integral = array();

$sql = 'SELECT `teacher_integral` FROM ' . $ecs->table('users') . " WHERE `user_id` = '". $user_id ."'";
$res = $db->getAll($sql);
foreach ($res as $key => $value) {
	foreach ($value as $keys => $values) {
		if ( $keys == 'teacher_integral' )
		{
			$integral['integral'] = $values;
		}
	}
}

// if ( empty($integral) )
// {
// 	GZ_Api::outPut(11);
// }

$out = array(
	'data' => $integral
);
GZ_Api::outPut($out);
