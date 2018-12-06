<?php
/*
* jieson 2018.08.30
* 小程序员订单api接口
*/
header("Content-type:text/html;charset=utf-8");

require_once "OrderClass.php";

$appkey  = $_POST['appid'];
$Order = new Order($appkey);

//分支
$action = $_POST['act'];
// $order_id = $_POST['id'];
switch ($action) {
	case 'ajax_createOrder':
		$Order->createOrder($_POST);
		break;
	case 'ajax_orderList':
		$Order->orderList($_POST['userid']);
		break;
	case 'ajax_updateOrder':
		$Order->updateOrder($_POST);
		break;
	default:
		# code...
		break;
}