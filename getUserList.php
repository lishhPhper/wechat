<?php

include('./wxModel.php');
include('./vendor/autoload.php');

$wechatObj = new wxModel();

echo $wechatObj->getUserOpenIdList();