<?php
header("Content-type:text/html;charset=utf-8");
if($_FILES){
	upload();
}else{
	index();
}


function index(){
	define('DIR',dirname(__FILE__));
	require DIR."/bin/Template.php";
	$tpl=new Template();
	$tpl->show('user/upload');
}
function upload(){
	set_time_limit(0);
	require "Image.class.php";
	//var_dump( $_FILES);exit;
	$file = $_FILES['fileList'];//得到传输的数据
	//return $file;exit;
	$name = $file['name'];
	$upload_path = "images/uploadtmp/"; //上传文件的存放路径
	//开始移动文件到相应的文件夹
	$resUpload=move_uploaded_file($file['tmp_name'],$upload_path.$name);//这是上传原文件，大小还是没有改变
	//压缩上传的文件
	if($resUpload){
		$src = $upload_path.$name;
		$image = new Image($src);
		$image->percent = 0.4;//压缩的比例，数值越小压缩之后的大小就越小
		$image->openImage();//打开
		$image->thumpImage();//操作
		//$image->showImage();//显示
		$date=date('Ymd',time());
		$dir = iconv("UTF-8", "GBK", "images/photo/$date");
	    if (!file_exists($dir)){
	        mkdir ($dir);
	    }
		$path=$dir.'/';
		//获取图片类型
		$imgType=$image->getImgType();
		$reallyPath=$path.md5($name).'.'.$imgType;
		if(file_exists($reallyPath)){
			//exit(json_encode(array('state'=>0,'errmsg'=>'图片已存在')));
			exit('图片已存在');
		}
		$image->saveImage($path.md5($name));//保存 ，md5加密图片的名称
		
		//删除上传的原图
		unlink($src);
		//保存到数据库
		require_once "myPDO.php";
		$model=myPDO::getInstance('120.77.209.158','root','star19950414','jieson');
		$data=array('img_path'=>$reallyPath);
		$model->insert('photo',$data);
		//exit(json_encode(array('state'=>1,'path'=>$path)));
		exit($path);
	}else{
		//exit(json_encode(array('state'=>0,'errmsg'=>'图片上传出错')));
		exit('图片上传出错');
	}
	
}
?>