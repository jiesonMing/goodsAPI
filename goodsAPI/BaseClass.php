<?php
// 基础类 2018.08.30 
class Base
{
    private $appkey;
    private $validation = "jieson_Api";
    protected $prefix = 'j_';

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
		require_once "../myPDO.php";
		$db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');
    }
    

    // 返回方法 
	// 错误码：
	// 1000-只接受post的json
	// 1001-验证码secretKet不对
    // 1002-获取数据出错
    // 1003-新增数据出错
	// 1-success
    public function exitJson($code, $msg, $data='')
	{
		$arr = array('code'=>$code, 'msg'=>$msg, 'data'=>$data);
		exit(json_encode($arr));
	}
}