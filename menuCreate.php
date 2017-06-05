<?php

include('./wxModel.php');
include('./vendor/autoload.php');

$wechatObj = new wxModel();

$arr = array(
    "button"=>array(
        array(
            "type"=>"click",
            "name"=>"最新新闻",
            "key"=>"news_zero"
        ),
        array(
            "name"=>"menu",
            "sub_button"=> array(
                array(
                    "type"=>"click",
                    "name"=>"福利",
                    "key"=>"welfare"
                ),
                array(
                    "type"=>"click",
                    "name"=>"广告",
                    "key"=>"advent"
                )
            )
        ),
        array(
            "type" => "view",
            "name" => "商城" ,
            "url" => "https://kdt.im/Kok8Nr"
        )
    )
);
// dump(json_encode($arr));
$jsonData = urlencode(json_encode($arr));

$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$wechatObj->getAccessToken();

$res = $wechatObj->getCurlData($url,"POST",$jsonData);

echo $res;