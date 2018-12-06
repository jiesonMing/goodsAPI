<?php
/*
* jieson 2018.08.21
* 小程序员商品首页api接口
*/
header("Content-type:text/html;charset=utf-8");

require_once "IndexClass.php";

$appkey  = $_POST['appid'];
$Index = new Index($appkey);

//分支
$action = $_POST['act'];
switch ($action) {
	case 'ajax_index':
		$Index->index();
		break;
	case 'ajax_banner':
		$Index->banner();
		break;
	default:
		# code...
		break;
}
 