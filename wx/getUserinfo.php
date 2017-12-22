<?php
/**
 * Created by PhpStorm.
 * User: DeLL
 * Date: 2017/12/3
 * Time: 19:38
 */
require './Network.class.php';

//$url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxb86c7455601c0779&redirect_uri=http://www.sfx520.top/wx_wall/wx/getUserinfo.php&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
$param = array(
    'code' => $_GET['code'],
    'appid' => 'wxb86c7455601c0779',
    'appsercet'  =>'5d92f0f6778b6f185b603ab45f32354c'
);
 $res = new Network($param);
 $userinfo = $res->getUserinfo();
 $userinfo = json_decode($userinfo,true);

    $nickname = isset($userinfo['nickname'])?$userinfo['nickname']:"";
    $openid = isset($userinfo['openid'])?$userinfo['openid']:"";
    $city = isset($userinfo['city'])?$userinfo['city']:"";
    $province = isset($userinfo['province'])?$userinfo['province']:"";
    $country = isset($userinfo['country'])?$userinfo['country']:"";
    $headimgurl = isset($userinfo['headimgurl'])?$userinfo['headimgurl']:"";
    $created_at=$updated_at = time();

 $link  = @mysql_connect('localhost','root','505050');
 mysql_query('use test');
 mysql_query('set names utf8');

    $sql = "select nickname from users where openid = '$openid'";
    $res =  mysql_query($sql);
    $data =  mysql_fetch_assoc($res);
    if($data){
        echo '你已经签到了';
    }else{
        if($nickname){
            $sql ="insert into users (`nickname`,`openid`,`city`,`province`,`country`,`headeimgurl`,`created_at`,`updated_at`) values ('$nickname','$openid','$city','$province','$country','$headimgurl',$created_at,$created_at)";
            $res =  mysql_query($sql);
            if($res){
                echo '签到成功!';
            }else{
                echo '签到失败';
            }

        }
    }






