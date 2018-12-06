<?php
/*
* jieson 2018.08.21
* 小程序员商品api接口
*/
header("Content-type:text/html;charset=utf-8");

require_once "GoodsClass.php";

$appkey  = $_POST['appid'];
$Goods = new Goods($appkey);

//分支
$action = $_POST['act'];
$goods_id = $_POST['id'];
switch ($action) {
	case 'ajax_goodsList':
		$Goods->goodsList();
		break;
	case 'ajax_goodsInfo':
		$Goods->goodsInfo($goods_id);
	default:
		# code...
		break;
}
