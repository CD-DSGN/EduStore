<?php

/*
 *                                                                          
 *       _/_/_/                      _/        _/_/_/_/_/                     
 *    _/          _/_/      _/_/    _/  _/          _/      _/_/      _/_/    
 *   _/  _/_/  _/_/_/_/  _/_/_/_/  _/_/          _/      _/    _/  _/    _/   
 *  _/    _/  _/        _/        _/  _/      _/        _/    _/  _/    _/    
 *   _/_/_/    _/_/_/    _/_/_/  _/    _/  _/_/_/_/_/    _/_/      _/_/       
 *                                                                          
 *
 *  Copyright 2013-2014, Geek Zoo Studio
 *  http://www.ecmobile.cn/license.html
 *
 *  HQ China:
 *    2319 Est.Tower Van Palace 
 *    No.2 Guandongdian South Street 
 *    Beijing , China
 *
 *  U.S. Office:
 *    One Park Place, Elmira College, NY, 14901, USA
 *
 *  QQ Group:   329673575
 *  BBS:        bbs.ecmobile.cn
 *  Fax:        +86-10-6561-5510
 *  Mail:       info@geek-zoo.com
 */

require(EC_PATH . '/includes/init.php');

$parent_id = _POST('parent_id', 0);


$sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('region') .
        " WHERE parent_id = '$parent_id'";

$result =  $GLOBALS['db']->GetAll($sql);

$out = array();

foreach ($result as $val) {
    $out[] = array(
        'id' => $val['region_id'],
        'name' => $val['region_name'],
		'parent_id' => $val['parent_id'],
		'type' => $val['region_type']
    );
}
$out = array(
    'more' => intval(!empty($out)),		// 最后一项的判断，省市（县）
    'regions' => $out
);
GZ_Api::outPut($out);