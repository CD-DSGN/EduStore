<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2016/12/28
 * Time: 11:29
 */
define('INIT_NO_USERS', true);

require(EC_PATH . '/includes/init.php');
GZ_Api::simple_authSession();
$sql = 'SELECT is_teacher FROM ' . $GLOBALS['ecs']->table('users') .
    " WHERE `user_id` = " . $_SESSION['user_id'];
$is_teacher = $GLOBALS['db']->getOne($sql);
$data = array();
$data['is_teacher'] = $is_teacher;
GZ_Api::outPut($data);

