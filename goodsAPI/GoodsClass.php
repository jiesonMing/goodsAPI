<?php

/**
 * 首页类 
 * jieson 2018.05.21
 */
class Goods 
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
	//首页商品数据
	public function goodsList()
	{
		require_once "../myPDO.php";
		$db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');

		$where = "on_sale=1 and is_show=1 and deleted=0";
		$data = $db->query("select goods_id as id,goods_img as thumb,goods_title as title,goods_price as price,market_price from j_goods where {$where} limit 0,10");
		if ($data) {
			foreach ($data as $k=>$val) {
				$data[$k]['thumb']= 'https://'.$_SERVER['HTTP_HOST'].'/'.$val['thumb'];
			}
			$this->exitJson(1, 'success', $data);
		} else {
			$this->exitJson(1002, '数据为空');
		}
	}
	//商品详情
	public function goodsInfo($goodsId)
	{
		require_once "../myPDO.php";
		$db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');
		$where = "on_sale=1 and is_show=1 and deleted=0 and goods_id=".$goodsId;
		$data = $db->query("select goods_id as id,goods_img as thumb,goods_title as title,goods_price as price,goods_desc as description,inventory from j_goods where {$where}");
		if ($data) {
			foreach ($data as $k=>$val) {
				$data[$k]['thumb']= 'https://'.$_SERVER['HTTP_HOST'].'/'.$val['thumb'];
			}
			$this->exitJson(1, 'success', $data[0]);
		} else {
			$this->exitJson(1002, '数据为空');
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