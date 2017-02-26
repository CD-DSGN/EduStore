<?php
/**
 * Created by PhpStorm.
 * User: chenggaoyuan
 * Date: 2017/2/26
 * Time: 15:24
 */
define('INIT_NO_USERS', true);

require(EC_PATH . '/includes/init.php');

//GZ_Api::authSession();

$publish_time = _POST('publish_time');

$publish_uid = _POST('publish_uid');

$uid = $_SESSION['user_id'];

//if($publish_uid != $uid){
//    GZ_Api::outPut(703);
//}
$news_id = find_news_id_from_teacher_publish($publish_time,$publish_uid);

if($news_id){
    if(delete_one_publish_content($news_id)){
        $news_id_images =find_news_id_from_publish_images($news_id);
        if($news_id_images){
            if(delete_one_publish_images($news_id)){
                if(delete_images_files($publish_time,$publish_uid,$news_id_images)==true){
                    GZ_Api::outPut(array());
                }else{
                    GZ_Api::outPut(705);
                }

            }else{
                GZ_Api::outPut(705);
            }
        }else{
            GZ_Api::outPut(array());
        }
    }else{
        GZ_Api::outPut(705);
    }
}else{
    GZ_Api::outPut(704);
}

function find_news_id_from_teacher_publish($time,$uid){
    global $db, $ecs;
    $sql = 'SELECT news_id FROM '.$ecs->table('teacher_publish')." WHERE publish_time = '$time' AND user_id = '$uid'";
    $res = $db->getOne($sql);
    return $res;
}

function delete_one_publish_content($news_id){
    global $db, $ecs;
    $sql = 'DELETE FROM '.$ecs->table('teacher_publish')." WHERE news_id = '$news_id'";
    $res = $db->query($sql);
    return $res;
}

function find_news_id_from_publish_images($news_id){
    global $db, $ecs;
    $sql = 'SELECT COUNT(*) FROM '.$ecs->table('teacher_publish_images')." WHERE news_id= '$news_id'";
    $res = $db->getOne($sql);
    return $res;
}

function delete_one_publish_images($news_id){
    global $db, $ecs;
    $sql = 'DELETE FROM '.$ecs->table('teacher_publish_images')." WHERE news_id= '$news_id'";
    $res = $db->query($sql);
    return $res;
}

function delete_images_files($time,$uid,$count){
    $dir = EC_PATH.'/images/comments_images/'.$uid.'/';
    if (!file_exists($dir))
    {
        GZ_Api::outPut(706);
    }
    $res_count = 0;
    for($i=0; $i<$count; $i++){
        $filename = "$i".'_'."$time".'.jpg';
        $filename_thumb ='thumb_'. "$i". '_'. "$time". '.jpg';
        $res1=file_exists($dir.$filename);
        $res2=file_exists($dir.$filename_thumb);
        if($res1 && $res2){
            $res = @unlink ($dir.$filename);
            $res_th = @unlink ($dir.$filename_thumb);
        }

        if($res == true && $res_th == true ){
            $res_count++;
        }
    }
    if($res_count ==  $count){
        return true;
    }else{
        return false;
    }

}