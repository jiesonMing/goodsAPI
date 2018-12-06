<?php

/**
 * 首页类 
 * jieson 2018.05.21
 */
class Index 
{
	private $appkey;
	private $validation = "jieson_Api";

	public function __construct($appkey)
	{
		//验证
		if (empty($appkey)) {
			$this->exitJson(1002, 'appid数据不能为空', $appkey.'--'.$this->validation);
		}
		if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			$this->exitJson(1000, '请使用post传送json数据');
		}
		$appkey_md5 = md5(base64_encode($appkey));
		$validate   = md5(base64_encode($this->validation));
		if ($appkey_md5 !== $validate) {
			$this->exitJson(1001, '验证秘钥错误');
		}
	}
	//首页数据
	public function index()
	{
		require_once "../myPDO.php";
		$db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson');
		$src = $db->query("select img_path from photo limit 0,10");
		if ($src) {
			$data = array_column($src, 'img_path');
			foreach ($data as $k=>$val) {
				$data[$k]= 'https://'.$_SERVER['HTTP_HOST'].'/'.$val;
			}
			$this->exitJson(1, 'success', $data);
		} else {
			$this->exitJson(1002, '获取数据出错');
		}
	}

	//首页banner
	public function banner()
	{
		require_once "../myPDO.php";
		$db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');
		$src = $db->query("select banner_id as bid,src,title from j_banner where is_show=1 and deleted=0 order by is_sort asc");
		if ($src) {
			foreach ($src as $k=>$val) {
				$src[$k]['src']= 'https://'.$_SERVER['HTTP_HOST'].'/'.$val['src'];
			}
			$this->exitJson(1, 'success', $src);
		} else {
			$this->exitJson(1002, '获取数据出错');
		}
	}

	// 返回方法 
	// 错误码：
	// 1000-只接受post的json
	// 1001-验证码secretKet不对
	// 1002-获取数据出错
	// 1-success
	public function exitJson($code, $msg, $data='')
	{
		$arr = array('code'=>$code, 'msg'=>$msg, 'data'=>$data);
		exit(json_encode($arr));
	}

}