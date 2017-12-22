<?php
/**
  * wechat php test
  */
require "./wx_sample.php";
//define your token
define('APPID','wxb86c7455601c0779');
define('APPSECRET','5d92f0f6778b6f185b603ab45f32354c');
//公众号
//define('APPID','wx673677d67f6f4999');
//define('APPSECRET','3f414073fc8f6171bedd4dbb49255a27');
//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->responseMsg();
$data = $wechatObj->data;
/**
 * 发送post请求
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return string
 */
function send_post($url, $post_data) {
    $postdata = http_build_query($post_data);
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $result;
}

//使用方法
$post_data = array(
    'appkey' => 'BC-62615b4e8f2b417f95d01c7dad82577b',
    'channel' => 'sfx',
    'content' => "$data",
);
send_post('http://goeasy.io/goeasy/publish', $post_data);
?>



