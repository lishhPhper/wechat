<?php

include('./wxModel.php');
include('./vendor/autoload.php');

$wechatObj = new wxModel();

$arr = array(
    "button"=>array(
        array(
            "type"=>"click",
            "name"=>urlencode("最新新闻"),
            "key"=>"news_zero"
        ),
        array(
            "name"=>"menu",
            "sub_button"=> array(
                array(
                    "type"=>"click",
                    "name"=>urlencode("福利"),
                    "key"=>"welfare"
                ),
                array(
                    "type"=>"click",
                    "name"=>urlencode("广告"),
                    "key"=>"advent"
                )
            )
        ),
        array(
            "type" => "view",
            "name" => urlencode("商城"),
            "url" => "https://kdt.im/Kok8Nr"
        )
    )
);
// dump(json_encode($arr));
$jsonData = urldecode(json_encode($arr));
//dump($jsonData);
$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$wechatObj->getAccessToken();

$res = $wechatObj->getCurlData($url,"POST",$jsonData);

echo $res;