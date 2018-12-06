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
	$tpl->show('index/index');
}
//首页留言
function leave_message(){	
	require_once "myPDO.php";
	$db=myPDO::getInstance('120.77.209.158','root','star19950414','jieson');
	if($_POST['name']!='' || $_POST['content']!=''){
		$name   =strip_tags(trim($_POST['name']));
		$content=strip_tags(trim($_POST['content']));
		$add_ip =strip_tags(trim($_SERVER["REMOTE_ADDR"]));
		$exist_ip=$db->query("select add_ip from message where add_ip='{$add_ip}'");
		if(!empty($exist_ip)){
			exit('抱歉,只能留言一次');
		}		
		$data=array('name'=>$name,'content'=>$content,'add_ip' =>$add_ip);
		$res=$db->insert('message',$data);
		if($res){		
			exit('留言成功');
		}else{
			exit('抱歉,留言失败');
		}
	}
}
// $sql="select * from message";
// $res=$db-> ($db->query("select * from message"));//返回一维数组，二位是fetchAll()