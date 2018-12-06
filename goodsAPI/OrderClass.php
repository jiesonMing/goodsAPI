<?php
// 订单类 2018.08.30 订单列表，下单，支付，更新订单状态，退换货，退款，物流，售后
class Order
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
        //require_once "../myPDO.php";//这里引入文件有问题
        //$db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');
    }
    //订单列表
    public function orderList($userId)
    {
        require_once "../myPDO.php";
        $db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');
        
        $sql = "select order_id as id,orderNo as code,status,amount,gid from {$this->prefix}order where user_id={$userId} order by order_id desc";
        $res = $db->query($sql);
        try {
            foreach ($res as $k=>$v) {
                $goodsData = $db->query("select goods_id as id,goods_img as thumb from {$this->prefix}goods where goods_id in (".$v['gid'].")");
                foreach ($goodsData as $kk=>$val) {
                    $goodsData[$kk]['thumb']= 'https://'.$_SERVER['HTTP_HOST'].'/'.$val['thumb'];
                    $goodsData[$kk]['id']   = $val['id'];
                }
                $res[$k]['goods'] = $goodsData;
            }
            $this->exitJson(1, 'success', $res);
        } catch (Exception $e) {
            $this->exitJson(1002, 'failed', $e->getMessage());
        }
        
    }
    //下单
    public function createOrder($orderInfo)
    {
        require_once "../myPDO.php";
        $db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');

        $data['orderNo']      = 'j'.date('YmdHis', time()).rand(1111,9999);
        $data['user_id']      = $orderInfo['userid'];
        $data['amount']       = $orderInfo['amount'];
        $data['discount']     = $orderInfo['discount'];
        $data['payamount']    = $orderInfo['payamount'];
        $data['gid']          = $orderInfo['gid'];
        $data['number']       = $orderInfo['number'];
        $data['status']       = 0;
        $data['addressid']    = $orderInfo['addressid'];
        //$data['userMsg']      = trim(strip_tags($orderInfo['userMsg']));
        //$data['express']      = $orderInfo['express'];
        //$data['expressPrice'] = $orderInfo['expressPrice'];

        $db->beginTransaction();
        try {
            $order_id = $db->insert('j_order', $data);
            //更新商品库存
            $this->updateGoodsStore($data['gid'], $data['number']);
            $db->commit();
            $this->exitJson(1, 'success', $order_id);
        } catch (Exception $e) {
            $db->rollback();
            $this->exitJson(1003, 'failed', $e->getMessage());
        } 
    }

    //更新订单
    public function updateOrder($orderInfo)
    {
        $data['status']   = $orderInfo['status'];

        require_once "../myPDO.php";
        $db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');
        $db->beginTransaction();
        try {
            $db->update($this->prefix.'order', $data, 'order_id='.$orderInfo['id'].' and user_id='.$orderInfo['userid']);
            $db->commit();
            $this->orderList($orderInfo['userid']);
        } catch (Exception $e) {
            $db->rollback();
            $this->exitJson(1004, 'failed', $e->getMessage());
        }
    }

    //更新商品库存
    private function updateGoodsStore($goodsIds, $numbers)
    {
        require_once "../myPDO.php";
        $db=myPDO::getInstance('47.106.87.58','root','star19950414','jieson_mall');

        if (strlen($goodsIds) > 1) {
            $goodsIdsArr = explode(',', $goodsIds);
            $numbersArr  = explode(',', $numbers);
        } else {
            $goodsIdsArr = [$goodsIds];
            $numbersArr  = [$numbers];
        }
        
        $sqlArr = [];
        foreach ($goodsIdsArr as $k =>$v) {
            $sqlArr[] = "update {$this->prefix}goods set inventory=inventory-{$numbersArr[$k]},sold=sold+{$numbersArr[$k]}, takingInventory=takingInventory+{$numbersArr[$k]},updateTime=".time()." where goods_id={$v} and inventory>0";
            $sqlArr[] = "insert into {$this->prefix}goods_logs (user_id,type,goods_id,number,logsDesc) values (0,2,{$v},{$numbersArr[$k]},'用户下单扣减商品库存，商品ID-{$v},数量-{$numbersArr[$k]}')";
        }

        try {
            $ret = false;
            foreach ($sqlArr as $sql) {
                $ret = $db->execSql($sql);
            }
            if ($ret) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            $this->exitJson(1004, '更新商品库存失败', $e->getMessage());
        }

    }
    

    // 返回方法 
	// 错误码：
	// 1000-只接受post的json
	// 1001-验证码secretKet不对
    // 1002-获取数据出错
    // 1003-新增数据出错
    // 1004-更新数据出错
    // 1005-删除数据出错
	// 1-success
    public function exitJson($code, $msg, $data='')
	{
		$arr = array('code'=>$code, 'msg'=>$msg, 'data'=>$data);
		exit(json_encode($arr));
	}
}