<?php
// 公共函数

class Common
{
    # 接收方法
    public static function Input($name)
    {
        return $val = htmlspecialchars(strip_tags($_POST[$name]));
    }

    # 返回方法 
    # 错误码：
    # 1000-只接受post的json
    # 1001-验证码secretKet不对
    # 1002-获取数据出错
    # 1-success
    function exitJson($code, $msg, $data='')
    {
        $arr = array('code'=>$code, 'msg'=>$msg, 'data'=>$data);
        exit(json_encode($arr));
    }

    # 加密
    public static function encryption($val)
    {
        return $val = sha1(md5($val));
    }

    /**
     * curl请求
     * 
     * @param int    $uid     用户UID
     * @param array  $data    发送数据data
     * @param string $url     请求地址url
     * @param int    $timeout 请求时间默认5秒
     * @param string $http_type 传送方式
     * jieson 2018.06.25
     */
    public static function curl_request($data, $url, $http_type, $json='json', $timeout=3)
    {
        //设置抓取的url
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出 1信息流 , 0 不是
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //设置方式提交
        if ($http_type == 'post') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            if($json == 'json'){
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: '.strlen($data)));
            }
                        
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
        //执行命令
        $res = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //返回数据
        return $res;
    }

    public static function curl_get($url)
    {
        return json_decode(file_get_contents($url),true);

        //$curl = curl_init();//这有问题
        // curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_HEADER, 1);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // $data = curl_exec($curl);
        // curl_close($curl);
        //return  json_decode($data);
    }
}
