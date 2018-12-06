<?php
// 用户类 2018.08.29
class User
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
        require_once './common.php';
    }
    //微信登录
    public function wxlogin($userInfo)
    {
        //1、是否存在用户，不存在则新增，2、查询存在返回用户id
        // 登录2.0 调用接口获取用户openid,使用openid来确认用户是否存在
        $wxloginurl = "https://api.weixin.qq.com/sns/jscode2session?appid=wx7735814e842d1013&secret=793dc2b55b6d72868c98ae02ff023d34&js_code={$userInfo['code']}&grant_type=authorization_code";
        $wxopenid = Common::curl_get($wxloginurl);
        $userInfo['openid'] = $wxopenid['openid'];
        $db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');
        $sql= "select user_id as id,username,avatar,code from j_users where openid='{$userInfo['openid']}'";
        $user = $db->query($sql);
        if (!$user) {
            //$sql = "insert into {$this->prefix}users (username, avatar, code) values ('{$userInfo['username']}', '{$userInfo['avatar']}', '{$userInfo['code']}')";
            $user_id = $db->insert('j_users', $userInfo);
            $userInfo['id'] = $user_id;
            if ($user_id) {
                $this->exitJson(1, 'success', $userInfo);
            } else {
                $this->exitJson(1003, 'failed');
            }
        } else {
            $this->exitJson(1, 'success', $user[0]);
        }
        
    }
    //用户收货地址
    public function address($data)
    {
        $db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');
        if ($data['id']) {
            $where = "user_id=".$data['userid']." and addressid=".$data['id'];
        } else {
            $where = "user_id=".$data['userid'];
        }
        $sql= "select addressId as id,consignee as username,mobile,address,isfirst from j_address where ".$where;
        $address = $db->query($sql);
        if ($address) {
            if($data['id']){
                $this->exitJson(1, 'success', $address[0]);
            }
            $this->exitJson(1, 'success', $address);
        } else {
            $this->exitJson(1002, 'failed');
        }
    }
    //新增用户地址
    public function addAddress($address)
    {    
        $db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');
        $db->beginTransaction();
        try {
            $addresId = $db->insert('j_address', $address);
            $address['id'] = $addressId;
            $db->commit();
            $this->exitJson(1, 'success', $address);
        } catch (Exception $e) {
            $db->rollback();
            $this->exitJson(1003, 'failed');
        }
    }
    //编辑地址
    public function editAddress($address)
    {
        $db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');
        $db->beginTransaction();
        try {
            $order_id = $db->update($this->prefix.'address', $address, 'addressid='.$address['addressid']);
            $db->commit();
            $this->exitJson(1, 'success', '');
        } catch (Exception $e) {
            $db->rollback();
            $this->exitJson(1003, 'failed', $e->getMessage());
        } 
    }
    //删除地址
    public function deleteAddress($address)
    {
        $db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');
        $db->beginTransaction();
        try {
            $order_id = $db->delete($this->prefix.'address', 'addressid='.$address['addressid'].' and user_id='.$address['userid']);
            $db->commit();
            $this->exitJson(1, 'success', '');
        } catch (Exception $e) {
            $db->rollback();
            $this->exitJson(1003, 'failed', $e->getMessage());
        } 
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