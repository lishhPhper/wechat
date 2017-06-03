<?php

    include './wxModel.php';
    define("TOKEN", "wlforever");
    $wechatObj = new wxModel();

    if ($_GET['echostr']) {
        $wechatObj->valid();
    } else {

        //接收微信服务器发过来的xml信息
        $wechatObj->responseMsg();
    }