<?php 
header("Content-type:text/html;charset=utf-8");
//页面逻辑分配
if(isset($_POST['name']) || isset($_POST['content'])){
	leave_message();
}else{
	index();
}
//index方法
function index(){
	define('DIR',dirname(__FILE__));
	require DIR."/bin/Template.php";
	$tpl=new Template();
	$tpl->show('article/article');
}
?>