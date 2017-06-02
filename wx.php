<?php

    include './wxModel.php';
    define("TOKEN", "wlforever");
    $wechatObj = new wxModel();

    if ($_GET['echostr']) {
        $wechatObj->valid();
    } else {
        $wechatObj->responseMsg();
    }