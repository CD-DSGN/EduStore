<?php
//mod by coolvee.com 酷唯软件出品
function can_refund($order_id)
{
    $row = $GLOBALS['db']->getRow("select shipping_status,order_status from " . $GLOBALS['ecs']->table("order_info") . " where order_id='$order_id'");
    return $row['shipping_status'] == SS_RECEIVED;
}

//mod by coolvee.com 酷唯软件出品
function refund_apply_order_goods($refund, $rec_id)
{
    if ($rec_id <= 0 || $GLOBALS['db']->getOne("select refund_status from " . $GLOBALS['ecs']->table("order_goods") . " where rec_id='$rec_id'") > 0) {
        die("invalid");
    }

    $upload_size_limit = $GLOBALS['_CFG']['upload_size_limit'] == '-1' ? ini_get('upload_max_filesize') : $GLOBALS['_CFG']['upload_size_limit'];

    $last_char = strtolower($upload_size_limit{strlen($upload_size_limit) - 1});

    switch ($last_char) {
        case 'm':
            $upload_size_limit *= 1024 * 1024;
            break;
        case 'k':
            $upload_size_limit *= 1024;
            break;
    }

    if (empty($refund['refund_reason'])) {
        $GLOBALS['err']->add("必须选择退款原因");
        return false;
    }
    if (empty($refund['refund_desc'])) {
        $GLOBALS['err']->add("必须选择退款说明");
        return false;
    }

    $refund['refund_pic1'] = refund_apply_order_goods_upload_ex($refund, 'refund_pic1', $upload_size_limit);
    $refund['refund_pic2'] = refund_apply_order_goods_upload_ex($refund, 'refund_pic2', $upload_size_limit);
    $refund['refund_pic3'] = refund_apply_order_goods_upload_ex($refund, 'refund_pic3', $upload_size_limit);
    if ($refund['refund_pic1'] < 0 || $refund['refund_pic2'] < 0 || $refund['refund_pic3'] < 0) {
        return false;
    }
    $refund['refund_status'] = 1;
    $refund['refund_add_time'] = gmtime();
    $GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_goods'), $refund, 'UPDATE', "rec_id = '" . $rec_id . "'");

    return true;
}

//mod by coolvee.com 酷唯软件出品
function refund_apply_order_goods_upload_ex($refund, $pic_name, $upload_size_limit)
{
    if ($refund[$pic_name]) {
        if ($_FILES[$pic_name]['size'] / 1024 > $upload_size_limit) {
            $GLOBALS['err']->add(sprintf($GLOBALS['_LANG']['upload_file_limit'], $upload_size_limit));
            return -1;
        }
        $refund_pic1 = upload_file($_FILES[$pic_name], 'feedbackimg');

        if ($refund_pic1 === false) {
            $GLOBALS['err']->add("无法上传");
            return -1;
        }
    } else {
        $refund_pic1 = '';
    }
    return $refund_pic1;
}

//mod by coolvee.com 酷唯软件出品
function get_order_goods_list($order_id, $where_ex = "")
{
    $sql = "select g.goods_name,g.goods_thumb,g.goods_id,og.goods_price,g.shop_price,og.refund_status,og.goods_number,og.refund_add_time,og.refund_confirm_time,og.goods_price*og.goods_number as refund_money,og.refund_reason,og.refund_desc,og.rec_id,og.refund_pic1,og.refund_pic2,og.refund_pic3 from " . $GLOBALS['ecs']->table("order_goods") . " as og left join " . $GLOBALS['ecs']->table("goods") . " as g on g.goods_id=og.goods_id where og.order_id='$order_id' " . $where_ex;
    $arr = $GLOBALS['db']->getAll($sql);
    foreach ($arr as $k => $v) {
        $arr[$k]['url'] = build_uri('goods', array('gid' => $v['goods_id']));
        $arr[$k]['shop_price_fmt'] = price_format($v['shop_price']);
        $arr[$k]['goods_price_fmt'] = price_format($v['goods_price']);
        $arr[$k]['refund_add_time_fmt'] = local_date('Y-m-d H:i:s', $v['refund_add_time']);
        $arr[$k]['refund_confirm_time_fmt'] = local_date('Y-m-d H:i:s', $v['refund_confirm_time']);
        $arr[$k]['refund_pic1'] = empty($v['refund_pic1']) ? "" : "../data/feedbackimg/" . $v['refund_pic1'];
        $arr[$k]['refund_pic2'] = empty($v['refund_pic2']) ? "" : "../data/feedbackimg/" . $v['refund_pic2'];
        $arr[$k]['refund_pic3'] = empty($v['refund_pic3']) ? "" : "../data/feedbackimg/" . $v['refund_pic3'];

    }
    return $arr;

}

//mod by coolvee.com 酷唯软件出品
function refund_confirm_order_goods($rec_id, $refund_status)
{
    $row = $GLOBALS['db']->getRow("select og.rec_id,o.user_id,og.goods_price*og.goods_number as refund_money,o.order_sn,og.goods_number,og.goods_name from " . $GLOBALS['ecs']->table("order_goods") . " as og," . $GLOBALS['ecs']->table("order_info") . " as o  where o.order_id=og.order_id and refund_status='1' and rec_id='$rec_id'");
    empty($row) ? die("inalid") : extract($row);
    if ($rec_id > 0) {
        if ($refund_status == 2) {
            $change_desc = "订单{$order_sn}中的{$goods_name}退款成功,返还余额";
            log_account_change($user_id, $refund_money, 0, 0, 0, $change_desc, ACT_OTHER);
        }
        $GLOBALS['db']->query("update " . $GLOBALS['ecs']->table("order_goods") . " set refund_status='$refund_status',refund_confirm_time='" . gmtime() . "' where rec_id='$rec_id'");
    }
}

//mod by coolvee.com 酷唯软件出品
function get_order_goods_info($rec_id)
{
    $sql = "select og.goods_name,og.goods_price,og.goods_price*og.goods_number as subtotal,og.goods_number,og.goods_id,g.goods_thumb,og.refund_status,og.rec_id,o.order_id from " . $GLOBALS['ecs']->table("order_goods") . " as og," . $GLOBALS['ecs']->table("order_info") . " as o," . $GLOBALS['ecs']->table("goods") . " as g where og.goods_id=g.goods_id and og.order_id=o.order_id and og.rec_id='$rec_id'";
    $row = $GLOBALS['db']->getRow($sql);
    $row['url'] = build_uri('goods', array('gid' => $row['goods_id']));
    return $row;
}

//mod by coolcps.com 酷盟软件出品
function get_user_orders_ex($user_id, $num = 10, $start = 0)
{
    /* 取得订单列表 */
    $arr = array();

    $sql = "SELECT order_id, order_sn, order_status, shipping_status, pay_status, add_time, " .
        "(goods_amount + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee + tax - discount) AS total_fee " .
        " FROM " . $GLOBALS['ecs']->table('order_info') .
        " WHERE user_id = '$user_id' ORDER BY add_time DESC";
    $res = $GLOBALS['db']->SelectLimit($sql, $num, $start);

    while ($row = $GLOBALS['db']->fetchRow($res)) {
        if ($row['order_status'] == OS_UNCONFIRMED) {
            $row['handler'] = "<a href=\"user.php?act=cancel_order&order_id=" . $row['order_id'] . "\" onclick=\"if (!confirm('" . $GLOBALS['_LANG']['confirm_cancel'] . "')) return false;\">" . $GLOBALS['_LANG']['cancel'] . "</a>";
        } else if ($row['order_status'] == OS_SPLITED) {
            /* 对配送状态的处理 */
            if ($row['shipping_status'] == SS_SHIPPED) {
                @$row['handler'] = "<a href=\"user.php?act=affirm_received&order_id=" . $row['order_id'] . "\" onclick=\"if (!confirm('" . $GLOBALS['_LANG']['confirm_received'] . "')) return false;\">" . $GLOBALS['_LANG']['received'] . "</a>";
            } elseif ($row['shipping_status'] == SS_RECEIVED) {
                @$row['handler'] = '<span style="color:red">' . $GLOBALS['_LANG']['ss_received'] . '</span>';
            } else {
                if ($row['pay_status'] == PS_UNPAYED) {
                    @$row['handler'] = "<a href=\"user.php?act=order_detail&order_id=" . $row['order_id'] . '">' . $GLOBALS['_LANG']['pay_money'] . '</a>';
                } else {
                    @$row['handler'] = "<a href=\"user.php?act=order_detail&order_id=" . $row['order_id'] . '">' . $GLOBALS['_LANG']['view_order'] . '</a>';
                }

            }
        } else {
            $row['handler'] = '<span style="color:red">' . $GLOBALS['_LANG']['os'][$row['order_status']] . '</span>';
        }

        $row['shipping_status'] = ($row['shipping_status'] == SS_SHIPPED_ING) ? SS_PREPARING : $row['shipping_status'];
        $row['order_status'] = $GLOBALS['_LANG']['os'][$row['order_status']] . ',' . $GLOBALS['_LANG']['ps'][$row['pay_status']] . ',' . $GLOBALS['_LANG']['ss'][$row['shipping_status']];

        //mod by coolvee.com 酷唯软件出品
        $row['goods_list'] = get_order_goods_list($row['order_id']);
        $row['can_refund'] = can_refund($row['order_id']);

        $arr[] = array('order_id' => $row['order_id'],
            'order_sn' => $row['order_sn'],
            'goods_list' => $row['goods_list'],
            'goods_num' => count($row['goods_list']),
            'order_time' => local_date($GLOBALS['_CFG']['time_format'], $row['add_time']),
            'order_status' => $row['order_status'],
            'total_fee' => price_format($row['total_fee'], false),
            'can_refund' => $row['can_refund'],
            'handler' => $row['handler']);
    }

    return $arr;
}

?>