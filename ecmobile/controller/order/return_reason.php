<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2017/3/6
 * Time: 9:29
 */

define('INIT_NO_USERS', true);
require(EC_PATH . '/includes/init.php');

$arr_reason = array('无理由退货','质量问题', '与描述不符');
GZ_Api::outPut($arr_reason);