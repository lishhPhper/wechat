<?php

include('./wxModel.php');
include('./vendor/autoload.php');

$wechatObj = new wxModel();

echo $wechatObj->getUserOpenIdList();

$url = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token".$wechatObj->getAccessToken();

echo $wechatObj->getMediaID('./public/zhuren.jpg');




