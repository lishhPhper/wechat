<?php
    include "../vendor/autoload.php";

    $json = <<<EOT
        {
             "button":[
             {	
                  "type":"click",
                  "name":"今日歌曲",
                  "key":"V1001_TODAY_MUSIC"
             },
             {
                   "name":"菜单",
                   "sub_button":[
                   {	
                       "type":"view",
                       "name":"搜索",
                       "url":"http://www.soso.com/"
                   },
                   {
                         "type":"miniprogram",
                         "name":"wxa",
                         "url":"http://mp.weixin.qq.com",
                         "appid":"wx286b93c14bbf93aa",
                         "pagepath":"pages/lunar/index.html"
                   },
                   {
                       "type":"click",
                       "name":"赞一下我们",
                       "key":"V1001_GOOD"
                   }]
             }]
         }
EOT;

    $arr = json_decode($json,true);

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
    dump($arr);
    dump($json);
