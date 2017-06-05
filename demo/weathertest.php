<?php

    include('../vendor/autoload.php');

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

    $postObj = simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA);

//var_dump($postObj);
    $tousername = $postObj->ToUserName;
    $fromusername = $postObj->FromUserName;
//    $createtime = $postObj->CreateTime;
//    $msgtype = $postObj->MsgType;
//    $content = $postObj->Content;
//    $msgid = $postObj->MsgId;

    $json = '{
    "resultcode": "200",
    "reason": "查询成功!",
    "result": {
        "sk": {
            "temp": "21",
            "wind_direction": "西风",
            "wind_strength": "2级",
            "humidity": "4%",
            "time": "14:25"	
        },
        "today": {
            "city": "天津",
            "date_y": "2014年03月21日",
            "week": "星期五",
            "temperature": "8℃~20℃",
            "weather": "晴转霾",	
            "weather_id": {	
                "fa": "00",
                "fb": "53"
            },
            "wind": "西南风微风",
            "dressing_index": "较冷",
            "dressing_advice": "建议着大衣、呢外套加毛衣、卫衣等服装。",
            "uv_index": "中等",
            "comfort_index": "",
            "wash_index": "较适宜",
            "travel_index": "适宜",
            "exercise_index": "较适宜",	
            "drying_index": ""
        },
        "future": [
            {
                "temperature": "28℃~36℃",
                "weather": "晴转多云",
                "weather_id": {
                "fa": "00",
                    "fb": "01"
                },
                "wind": "南风3-4级",
                "week": "星期一",
                "date": "20140804"
            },
            {
                "temperature": "28℃~36℃",
                "weather": "晴转多云",
                "weather_id": {
                "fa": "00",
                    "fb": "01"
                },
                "wind": "东南风3-4级",
                "week": "星期二",
                "date": "20140805"
            },
            {
                "temperature": "27℃~35℃",
                "weather": "晴转多云",
                "weather_id": {
                "fa": "00",
                    "fb": "01"
                },
                "wind": "东南风3-4级",
                "week": "星期三",
                "date": "20140806"
            },
            {
                "temperature": "27℃~34℃",
                "weather": "多云",
                "weather_id": {
                "fa": "01",
                    "fb": "01"
                },
                "wind": "东南风3-4级",
                "week": "星期四",
                "date": "20140807"
            },
            {
                "temperature": "27℃~33℃",
                "weather": "多云",
                "weather_id": {
                "fa": "01",
                    "fb": "01"
                },
                "wind": "东北风4-5级",
                "week": "星期五",
                "date": "20140808"
            },
            {
                "temperature": "26℃~33℃",
                "weather": "多云",
                "weather_id": {
                "fa": "01",
                    "fb": "01"
                },
                "wind": "北风4-5级",
                "week": "星期六",
                "date": "20140809"
            },
            {
                "temperature": "26℃~33℃",
                "weather": "多云",
                "weather_id": {
                "fa": "01",
                    "fb": "01"
                },
                "wind": "北风4-5级",
                "week": "星期日",
                "date": "20140810"
            }
        ]
    },
    "error_code": 0
}';
    $arr = json_decode($json,1);
    dump($arr);
//    echo "<pre>";
//    print_r($arr);

//    dump($arr['result']['sk']['temp']);

/*
 * sk      wind_direction   wind_strength 西风两级
* today            city
*                  weather 天气
*                  temperature 温度
*                  dressing_index  穿衣指数
 * */

$textTpl = <<<EOT
        <xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[%s]]></MsgType>
        <Content><![CDATA[%s]]></Content>
        <FuncFlag>0</FuncFlag>
        </xml>
EOT;

$content = '城市:'.$arr['result']['today']['city']."\r\n";
$content .= '天气:'.$arr['result']['today']['weather']."\r\n";
$content .= '温度:'.$arr['result']['today']['temperature']."\r\n";
$content .= '气候:'.$arr['result']['today']['dressing_index']."\r\n";
$content .= '风力:'.$arr['result']['sk']['wind_direction'].$arr['result']['sk']['wind_strength'];
//echo $content;

$time = time();
$msgtype = 'text';
//返回一个拼接好的xml的字符串
$resStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);
dump($resStr);
