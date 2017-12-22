<?php
/**
 * Created by PhpStorm.
 * User: DeLL
 * Date: 2017/12/4
 * Time: 21:09
 */
class Network
{
    private $appid;
    private $appsercet;
    private $code;
    public function __construct($param)
    {
        $this->code = $param['code'];
        $this->appid = $param['appid'];
        $this->appsercet = $param['appsercet'];
    }

    public function getAccess_token()
    {
        $file = './accesstoken';

//        if(file_exists($file)){
//            $content = file_get_contents($file); //读取文档
//            $content = json_decode($content,true); //解析json数据
////            var_dump($content->expires_in);die;
//            if(time() - filemtime($file) < ($content['expires_in'])) //判断access token是否过期
//                return $content;
//        }

        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->appsercet&code=$this->code&grant_type=authorization_code";
//        $data = json_decode(file_get_contents($url), true);
        $content=file_get_contents($url);
        file_put_contents($file, $content);//保存Access Token 到文件 
        $content = json_decode($content,true); //解析json
        return $content;

//        $res = $this->_request($url);
//        $data = json_decode($res,true);

    }

    public function getUserinfo()
    {
        $data =  $this->getAccess_token();
//        echo "<pre>";
//        var_dump($data);die;
        $access_token = $data["access_token"];
        if($access_token){
            $openid  = $data["openid"];
            $api = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=zh_CN";
            $Userinfo = file_get_contents($api);

            //$data = $this->_request($api);
            //$Userinfo = json_decode($data,true);

            return $Userinfo;
        }

    }


    private function _request($curl, $https = true, $method = 'GET', $data = null){
        $ch = curl_init(); // 初始化curl
//        curl_setopt ( $ch, CURLOPT_SAFE_UPLOAD, false);//php5.6yihou

        curl_setopt($ch, CURLOPT_URL, $curl); //设置访问的 URL
        curl_setopt($ch, CURLOPT_HEADER, false); //放弃 URL 的头信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //返回字符串，而不直接输出
        if($https){ //判断是否是使用 https 协议
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不做服务器的验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  //做服务器的证书验证
        }
        if($method == 'POST'){ //是否是 POST 请求
            curl_setopt($ch, CURLOPT_POST, true); //设置为 POST 请求
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); //设置POST的请求数据
        }
        $content = curl_exec($ch); //开始访问指定URL
        curl_close($ch);//关闭 cURL 释放资源
        return $content;
    }

}