<?php

include '../wxModel.php';
$model = new wxModel();
$access_token = $model->getAccessToken();
$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
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
$json = json_encode($arr);


$postStr = <<<EOT
<xml>
<ToUserName><![CDATA[gh_7237c02b0548]]></ToUserName>
<FromUserName><![CDATA[oB6JlwP78nQ1owkToEYXAaXr517Y]]></FromUserName>
<CreateTime>1496632049</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[CLICK]]></Event>
<EventKey><![CDATA[welfare]]></EventKey>
</xml>
EOT;


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


// 消息应该是结合数据库拿到数据信息，实现实时的动态消息
//模拟文章列表数据
/*$arr = array(
    array(
        'title'=>'欧盟不满美国退出巴黎协定 考虑停止贸易谈判',
        'date'=>'2017-06-04',
        'url'=>'http://www.cankaoxiaoxi.com/roll10/bd/20170604/2078175.shtml',
        //文章的描述信息
        'description'=>'美国总统特朗普当地时间6月1日宣布退出《巴黎协定》，深受影响的欧洲联盟眼下考虑对美国实施经济应对措施',
        'picUrl'=>'https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=2959146431,3308998127&fm=23&gp=0.jpg'
    ),
    array(
        'title'=>'欧盟不满美国退出巴黎协定 考虑停止贸易谈判',
        'date'=>'2017-06-04',
        'url'=>'http://www.cankaoxiaoxi.com/roll10/bd/20170604/2078175.shtml',
        //文章的描述信息
        'description'=>'美国总统特朗普当地时间6月1日宣布退出《巴黎协定》，深受影响的欧洲联盟眼下考虑对美国实施经济应对措施',
        'picUrl'=>'https://ss0.bdstatic.com/70cFvHSh_Q1YnxGkpoWK1HF6hhy/it/u=2959146431,3308998127&fm=23&gp=0.jpg'
    ),
    array(
        'title'=>'互联网世界的神奇逻辑',
        'date'=>'2017-06-04',
        'url'=>'http://www.chinaz.com/start/2017/0602/714890.shtml',
        'description'=>'常有论调说，中国互联网的人口红利期已然结束。增量少，各家都在抢余量',
        'picUrl'=>'http://upload.chinaz.com/2017/0602/6363199188586819816089374.jpg'
    )
);*/
$textTpl = <<<EOT
<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Image>
<MediaId><![CDATA[%s]]></MediaId>
</Image>
</xml>
EOT;

/*$str = '';
foreach( $arr as $v )
{
    $str .= "<item>";
    $str .= "<Title><![CDATA[".$v['title']."]]></Title>";
    $str .= "<Description><![CDATA[".$v['description']."]]></Description>";
    $str .= "<PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>";
    $str .= "<Url><![CDATA[".$v['url']."]></Url>";
    $str .= "</item>";
}
$textTpl .= $str;
$textTpl .= "</Articles></xml>";*/

$time = time();
$msgtype = 'image';
$nums = count($arr);
$content = "欢迎来到风骚705空间__小黎子开发空间";
$mediaid = "Whl7tAFVhyWFOAL9ctiStnM5A1W_ZE-IRvgKKxXzIw1G6R_xYbj_Nmgn2aNRMbZd";
$resStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $mediaid);

file_put_contents('../../1.txt',$resStr);
var_dump($resStr);