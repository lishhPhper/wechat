<?php
$postStr = <<< EOT
<xml>
<ToUserName><![CDATA[gh_7237c02b0548]]></ToUserName>
<FromUserName><![CDATA[oB6JlwP78nQ1owkToEYXAaXr517Y]]></FromUserName>
<CreateTime>1496411183</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[123]]></Content>
<MsgId>6427037092769646065</MsgId>
</xml>
EOT;

var_dump($postStr);

$postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);

var_dump($postObj);

$tousername = $postObj->ToUserName;
$fromusername = $postObj->FromUserName;
$createtime = $postObj->CreateTime;
$msgtype = $postObj->MsgType;
$content = $postObj->Content;
$msgid = $postObj->MsgId;

//echo $tousername;

$textTpl = <<<EOT
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>
EOT;

$time = time();
$msgtype = 'text';
$content = "欢迎来到风骚705空间__小黎子开发空间";

$resStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);

var_dump($resStr);