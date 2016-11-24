<?php
include_once "./appid.php";
include_once "./wxfunction.php";
// $arr=Array ( 
//  'openid' => 'o6UDkwIppYchG79HknNe-9fuYugQ',
//  'nickname' => '✘' ,
//  'sex' => '1', 
//  'language' => 'zh_CN' ,
//  'city' => '',
//  'province' => '',
//  'country' => '中国' ,
//  'headimgurl' => 'http://wx.qlogo.cn/mmopen/16Q9aDojjfkMRfo7TSc9F3SEIiaLaLppczYn5sZ3ceZZUcxGryMH8G5M8bpYfdaQ0JlwNx2yaw9OLNrrrxqAebUFLN2voWlBib/0 ',
//  'privilege' => Array ( ) );
// print_r($arr);

$code=$_GET['code'];

$arr=OAuth($code);

print_r($arr);
echo $info=json_encode($arr);
header("location: http://item.redream.cn/cp_application/index.html?o=".$info); 
exit; 
?>