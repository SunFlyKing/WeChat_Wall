<?php
/**
 * Created by PhpStorm.
 * User: DeLL
 * Date: 2017/12/6
 * Time: 20:39
 */
$link  = @mysql_connect('localhost','root','505050');
mysql_query('use test');
mysql_query('set names utf8');

$sql = "select nickname,headeimgurl from users";
$res =  mysql_query($sql);
$result =[];
while ($data =  mysql_fetch_row($res)){
    array_push($result,$data);
}
$result= json_encode($result);
echo $result;