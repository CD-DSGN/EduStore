<?php
/**
 * 
 * 微信支付API异常类
 * @author widyhu
 *
 */
if (!defined('IN_ECS'))
{
	die('Hacking attempt');
}

class WxPayException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
