<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2016/9/7
 * Time: 16:25
 */

function putString($str)
{
    file_put_contents("d:\\1.txt", $str, FILE_APPEND);
}
