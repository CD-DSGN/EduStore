<?php

define('INIT_NO_USERS', true);

require(EC_PATH . '/includes/init.php');
require(EC_PATH . '/includes/cls_image.php');

GZ_Api::authSession();

$result = false;

$content = _POST('publishcontent');

$images_array = _POST('publish_images', array());

$uid = $_SESSION['user_id'];

$time = time();

$res1 = false;

//如果没有上传图片 则只处理文字
if(count($images_array) == 0 || $images_array == null){
    $result = update_one_publish_content($content,$time,$uid);

    if($result != false){
        GZ_Api::outPut(array());
    }

}else{
    //上传内容含有图片
    $dir = EC_PATH.'/images/comments_images/'.$uid.'/';
    if (!file_exists($dir))
    {
        if (!make_dir($dir))
        {
            GZ_Api::outPut(700);// 创建/打开目录失败，无权限
        }
    }
    $thumb_width  = 150;
    $thumb_height = 150;

    $images_result = array();

    foreach ($images_array as $key => $value){
        if($value != null){
            //图片文件名称
            $image_file_name = "$key". '_'. "$time".".jpg";
            //服务器目录文件路径
            $image_file_path = $dir.$image_file_name;
            //数据库存储字段内容 原图
            $image_mysql_path = "images/comments_images/" .$uid .'/' ."$image_file_name";
            //数据库存储字段内容 缩略图
            $image_thumb_mysql_path = "images/comments_images/" .$uid .'/' .'thumb_'."$image_file_name";

            $images_result[$key][] = $image_mysql_path;
            $images_result[$key][] = $image_thumb_mysql_path;

            $decode_image= base64_decode($value);

            if ($fp = @fopen($image_file_path, "wb")){
                @fwrite($fp, $decode_image);
                @fclose($fp);
            }

            $image_size=getimagesize($image_file_path);
            $weight = $image_size["0"];////获取图片的宽
            $height = $image_size["1"];///获取图片的高
            $rate = $height/$weight;
            $thumb_height = (int)ceil($thumb_width  * $rate);
            $image = new cls_image($_CFG['bgcolor']);
            $image_thumb = $image->make_huishi_circle_thumb($key, $time, $image_file_path, $thumb_width,  $thumb_height, $dir);
            if ($image_thumb != false )
            {
                $res1 = true;
            }
        }
    }
    $result = update_one_publish_content($content,$time,$uid);

    if($result != false){
        foreach($images_result as $key =>$value){

            if(!update_one_publish_image($value[0], $value[1], $result)){
                $res1 = false;
            }
        }

    }

    if($res1 == true){
        GZ_Api::outPut(array());
    }else{
        GZ_Api::outPut(600);
    }
}

function update_one_publish_content($content,$time,$uid)
{   
    global $db, $ecs;
    $sql = 'INSERT INTO '. $ecs->table('teacher_publish') . " SET news_content = '$content'"
        .', publish_time = '."$time"
        .', user_id = '."$uid";
    $db->query($sql);

    $sql = 'SELECT LAST_INSERT_ID()';
    $res = $db->getOne($sql);
    return $res;
}

function update_one_publish_image($image, $image_thumb ,$news_id)
{
    global $db, $ecs;
    $sql = 'INSERT INTO '. $ecs->table('teacher_publish_images') . " SET `image`  = '$image'"
            .", `image_thumb` = '$image_thumb'" .", `news_id` = $news_id";
    $db->query($sql);
    return true;
}
