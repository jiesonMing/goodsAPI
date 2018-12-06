<?php
/*
* 用户
* jieson 2018.08.29
* 小程序员用户api接口
*/
header("Content-type:text/html;charset=utf-8");

require_once "UserClass.php";
require_once "common.php";

$appkey  = $_POST['appid'];
$User = new User($appkey);

//分支
$action = $_POST['act'];
switch ($action) {
    case 'ajax_wxlogin':
        $userInfo['username'] = $_POST['username'];
        $userInfo['avatar']   = $_POST['avatar'];
        $userInfo['code']     = $_POST['code'];
		$User->wxlogin($userInfo);
        break;
    case 'ajax_address':
        $data['userid'] = $_POST['userid'];
        $data['id']     = isset($_POST['id'])?$_POST['id']:'';
        $User->address($data);
        break;
    case 'ajax_addAddress':
        $address['user_id']   = $_POST['userid'];
        $address['consignee'] = Common::input('username');
        $address['mobile']    = Common::input('mobile');
        $address['address']   = Common::input('address');
		$User->addAddress($address);
        break;
    case 'ajax_editAddress':
        $address['addressid'] = Common::input('id');
        $address['user_id']   = $_POST['userid'];
        $address['consignee'] = Common::input('username');
        $address['mobile']    = Common::input('mobile');
        $address['address']   = Common::input('address');
        $User->editAddress($address);
        break;
    case 'ajax_deleteAddress':
        $address['addressid'] = $_POST['id'];
        $address['userid']    = $_POST['userid'];
        $User->deleteAddress($address);
	default:
		# code...
		break;
}

