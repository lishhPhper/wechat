<?php

    include './wxModel.php';
    define("TOKEN", "wlforever");
    $wechatObj = new wxModel();
    $access_token = $wechatObj->getAccessToken();
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
                "name" => "搜索" ,
                "url" => "http://www.soso.com/"
            )
        )
    );
    $data = json_encode($arr);

    echo $wechatObj->createMenu($access_token,$data);
    echo $wechatObj->getMenu($access_token);
    if ($_GET['echostr']) {
        $wechatObj->valid();
    } else {

        //接收微信服务器发过来的xml信息
        $wechatObj->responseMsg();
    }