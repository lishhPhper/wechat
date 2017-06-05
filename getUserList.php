<?php

include('./wxModel.php');
include('./vendor/autoload.php');

$wechatObj = new wxModel();

$userJson = $wechatObj->getUserOpenIdList();

$url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=".$wechatObj->getAccessToken();

$userArr = json_decode($userJson,1);

$arr = array(
    'touser'=>array(
        0=>"oB6JlwLVK8cmEBjIF9LI8vwGtWq8",
        1=>"oB6JlwP78nQ1owkToEYXAaXr517Y"
    ),
    'msgtype'=>'text',
    'text'=>array(
        'content'=>'hello from boxer'
    )
);
$json = json_encode($arr);
$res = $wechatObj->getCurlData($url,"POST",$json);

echo $res;
//dump($json);
/*$putJson = '{
    "touser":[
    "OPENID1",
    "OPENID2"
],
    "msgtype": "text",
    "text": { "content": "hello from boxer."}
}';
$putArr = json_decode($putJson,1);
dump($putArr);*/




