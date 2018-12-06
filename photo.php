<?php
header("Content-type:text/html;charset=utf-8");
index();
function index(){
	define('DIR',dirname(__FILE__));
	require DIR."/bin/Template.php";
	$tpl=new Template();
	//取照片并缓存
	require_once "myPDO.php";
	$model=myPDO::getInstance('120.77.209.158','root','star19950414','jieson');
	$sql="select img_path from photo where is_deleted=0 order by upload_time desc limit 0,20";
	$resPhoto=$model->query($sql);
	$resPhoto=array_column($resPhoto,'img_path');
	$tpl->assign('resPhoto',$resPhoto);//assign 单个变量，assignArray数组变量
	$tpl->show('photo/index');
}



?>