<?php
/**
 * Created by PhpStorm.
 * User: zhangmengqi
 * Date: 2016/9/5
 * Time: 18:48
 */
require(EC_PATH . '/includes/init.php');
$keywords = $_POST['keywords'];
$course_id = $_POST['course_id'];

$_REQUEST['page_size'] = GZ_Api::$pagination['count'];
$_REQUEST['page'] = GZ_Api::$pagination['page'];

$page = !empty($_REQUEST['page']) && intval($_REQUEST['page']) > 0 ? intval($_REQUEST['page']) : 1;
$size = !empty($_REQUEST['page_size']) && intval($_REQUEST['page_size']) > 0 ? intval($_REQUEST['page_size']) : 10;

$sql = 'SELECT count(*) FROM ' . $ecs->table('teachers') . " WHERE `school` LIKE '%$keywords%' or `real_name` LIKE '%$keywords%' AND `course_id` = $course_id";
$count = $db->getOne($sql);

$max_page = ($count > 0) ? ceil($count / $size) : 1;

if ($page > $max_page) {
    $page = $max_page;
}

//$sql = 'SELECT t.*, c.course_name FROM ' . $ecs->table('teachers') . "as t join" . $ecs->table('courses') . " as c on t.course_id=c.course_id
//WHERE `school` LIKE '%$keywords%' or `real_name` LIKE '%$keywords%' ";

$sql = 'SELECT * FROM ' . $ecs->table('teachers') . "  WHERE `school` 
LIKE '%$keywords%' or `real_name` LIKE '%$keywords%' AND `course_id`=$course_id";

$res = $db->selectLimit($sql, $size, ($page - 1) * $size);

$sql1 = 'SELECT `course_name` FROM ' . $ecs->table('courses') . "where `course_id`=$course_id";
$res1 = $db->getOne($sql1);

$data = array();
$i = 0;
while ($row = $db->fetchRow($res)) {
    $data[$i]['teacher_name'] = $row['real_name'];
    $data[$i]['school'] = $row['school'];
    $data[$i]['course_id'] = $row['course_id'];
//    $data[$i]['course_name'] = $row['course_name'];
    $data[$i]['course_name'] = $res1;
    $data[$i]['teacher_id'] = $row['user_id'];
    $i++;
}

if (!empty($data)) {
    $pager = array(
        "total" => $count,
        "count" => count($data),
        "more" => ($page == $max_page) ? 0 : 1
    );
} else {
    $pager = NULL;
}

GZ_Api::outPut($data, $pager);
