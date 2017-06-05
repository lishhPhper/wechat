<?php
/**
  * wechat php test
  */

class wxModel
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function content($str) 
    {
        $data = ['time'=>date('Y-m-d H:i:s',time()),'str'=>$str];
        //微信服务器发送的消息都将在1.txt里
        file_put_contents('../tmp/1.txt', json_encode($data)."\r\n",FILE_APPEND);
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
        //php版本小于5,6以下的用该函数接收微信服务器发送的xml信息
        //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //php版本大于7.0版本的使用file_get_contents('php://input');
        $postStr = file_get_contents('php://input');

        //将接收的信息存储在文件里
        $this->content($postStr);
      	//extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
                // 接收到微信服务器发送过来的数据，分为：事件、消息，按照MsgType分
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

                $tousername = $postObj->ToUserName;
                $fromusername = $postObj->FromUserName;
                $msgtype = $postObj->MsgType;
                $keyword = trim($postObj->Content);

                //先根据用发送的消息类型，再识别其发送给的关键字，根据不同的关键字返回不同的消息内容
                if($msgtype == 'text')
                {
                    // 当关键字为“新闻”返回一段图文消息
                    if($keyword == "新闻")
                    {
                        $arr = array(
                            array(
                                'title'=>'欧盟不满美国退出巴黎协定 考虑停止贸易谈判',
                                'date'=>'2017-06-04',
                                'url'=>'http://www.chinaz.com/news/2017/0603/716624.shtml',
                                'description'=>'美国总统特朗普当地时间6月1日宣布退出《巴黎协定》',
                                'picUrl'=>'http://upload.chinaz.com/2017/0603/6363210883952321635316200.jpeg'
                            ),
                            array(
                                'title'=>'欧盟不满美国退出巴黎协定 考虑停止贸易谈判',
                                'date'=>'2017-06-04',
                                'url'=>'http://www.chinaz.com/news/2017/0603/716624.shtml',
                                'description'=>'美国总统特朗普当地时间6月1日宣布退出《巴黎协定》',
                                'picUrl'=>'http://upload.chinaz.com/2017/0603/6363210883952321635316200.jpeg'
                            ),
                            array(
                                'title'=>'互联网世界的神奇逻辑',
                                'date'=>'2017-06-04',
                                'url'=>'http://www.chinaz.com/start/2017/0602/714890.shtml',
                                'description'=>'常有论调说，中国互联网的人口红利期已然结束。增量少，各家都在抢余量',
                                'picUrl'=>'http://upload.chinaz.com/2017/0602/6363199188586819816089374.jpg'
                            )
                        );
                        $textTpl = <<<EOT
                            <xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <ArticleCount>%s</ArticleCount>
                            <Articles>
EOT;
                        $str = '';
                        foreach($arr as $v)
                        {
                            $str .= "<item>";
                            $str .= "<Title><![CDATA[".$v['title']."]]></Title>";
                            $str .= "<Description><![CDATA[".$v['description']."]]></Description>";
                            $str .= "<PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>";
                            $str .= "<Url><![CDATA[".$v['url']."]]></Url>";
                            $str .= "</item>";
                        }


                        $textTpl .= $str;
                        $textTpl .= "</Articles></xml>";


                        $time = time();
                        $msgtype = 'news';
                        $nums = count($arr);

                        $resStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $nums);
                        echo $resStr;
                    }
                    if($keyword == '福利')
                    {
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
                        $time = time();
                        $msgtype = 'image';
                        $mediaid = "Whl7tAFVhyWFOAL9ctiStnM5A1W_ZE-IRvgKKxXzIw1G6R_xYbj_Nmgn2aNRMbZd";
                        $resStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $mediaid);
                        echo $resStr;
                    }
                }

                if($msgtype == 'event')
                {
                    $event = $postObj->Event;
                    $key = $postObj->EventKey;
                    if($event == 'subscribe')
                    {
                        $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";

                        $time = time();
                        $msgtype = 'text';
                        $content = "欢迎来到骚黎的福利空间，发送(福利)取得图片";

                        $resStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);
                        echo $resStr;

                    }
                    if($event == 'CLICK')
                    {
                        if($key == 'welfare')
                        {
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
                            $time = time();
                            $msgtype = 'image';
                            $mediaid = "Whl7tAFVhyWFOAL9ctiStnM5A1W_ZE-IRvgKKxXzIw1G6R_xYbj_Nmgn2aNRMbZd";
                            $resStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $mediaid);
                            echo $resStr;
                        }
                        if($key == 'news_zero')
                        {
                            $arr = array(
                                array(
                                    'title'=>'欧盟不满美国退出巴黎协定 考虑停止贸易谈判',
                                    'date'=>'2017-06-04',
                                    'url'=>'http://www.chinaz.com/news/2017/0603/716624.shtml',
                                    'description'=>'美国总统特朗普当地时间6月1日宣布退出《巴黎协定》',
                                    'picUrl'=>'http://upload.chinaz.com/2017/0603/6363210883952321635316200.jpeg'
                                ),
                                array(
                                    'title'=>'欧盟不满美国退出巴黎协定 考虑停止贸易谈判',
                                    'date'=>'2017-06-04',
                                    'url'=>'http://www.chinaz.com/news/2017/0603/716624.shtml',
                                    'description'=>'美国总统特朗普当地时间6月1日宣布退出《巴黎协定》',
                                    'picUrl'=>'http://upload.chinaz.com/2017/0603/6363210883952321635316200.jpeg'
                                ),
                                array(
                                    'title'=>'互联网世界的神奇逻辑',
                                    'date'=>'2017-06-04',
                                    'url'=>'http://www.chinaz.com/start/2017/0602/714890.shtml',
                                    'description'=>'常有论调说，中国互联网的人口红利期已然结束。增量少，各家都在抢余量',
                                    'picUrl'=>'http://upload.chinaz.com/2017/0602/6363199188586819816089374.jpg'
                                )
                            );
                            $textTpl = <<<EOT
                            <xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <ArticleCount>%s</ArticleCount>
                            <Articles>
EOT;
                            $str = '';
                            foreach($arr as $v)
                            {
                                $str .= "<item>";
                                $str .= "<Title><![CDATA[".$v['title']."]]></Title>";
                                $str .= "<Description><![CDATA[".$v['description']."]]></Description>";
                                $str .= "<PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>";
                                $str .= "<Url><![CDATA[".$v['url']."]]></Url>";
                                $str .= "</item>";
                            }


                            $textTpl .= $str;
                            $textTpl .= "</Articles></xml>";


                            $time = time();
                            $msgtype = 'news';
                            $nums = count($arr);

                            $resStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $nums);
                            echo $resStr;
                        }
                    }
                }
                $time = time();
                $msgtype = $postObj->MsgType;
                $content = "欢迎来到风骚705空间__小黎子开发空间";

                /*
                 * <xml>
                    <ToUserName><![CDATA[toUser]]></ToUserName>
                    <FromUserName><![CDATA[fromUser]]></FromUserName>
                    <CreateTime>12345678</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[你好]]></Content>
                    </xml>
                 * */

                // 发送消息的xml模板，此模板为一段文本消息
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";

            $time = time();
            $msgtype = 'text';
            $content = "欢迎来到风骚705空间__小黎子开发空间";

            //返回一个拼接好的xml的字符串
            $resStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgtype, $content);
            echo $resStr;
        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        /*
        1）将token、timestamp、nonce三个参数进行字典序排序
        2）将三个参数字符串拼接成一个字符串进行sha1加密
        3）开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
         */
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
		$token = TOKEN;
		
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	//curlget请求，获取返回的数据
	public function getCurlData($url, $method='GET',$arr='')
    {
        $ch = curl_init();

        // 2. 设置cURL选项
        /*
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        */
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        if(strtoupper($method) == 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }
        // 3. 执行cURL请求
        $ret = curl_exec($ch);

        // 4. 关闭资源
        curl_close($ch);

        return $ret;

    }

    //将json数据转化为数组
    public function jsonToArray($json)
    {
        $arr = json_decode($json,true);
        return $arr;
    }

    //将access_token值放到session里，不重复请求（每天限制2000）；
	public function getAccessToken()
    {
        session_start();

        if( isset($_SESSION['access_token']) && (time()-$_SESSION['expire_time']) <7000 )
        {
            return $_SESSION['access_token'];
        } else {
            $appid = "wx4798240534cc014b";
            $appsecret = "60619753f72d3dcdd704e48c5aa589db";

            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
            $access_token = $this->jsonToArray($this->getCurlData($url))['access_token'];

            $_SESSION['access_token'] = $access_token;
            $_SESSION['expire_time'] = time();

            return $access_token;
        }
    }



    /*public function createMenu($token,$data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }

        curl_close($ch);
        return $tmpInfo;
    }

    public function getMenu($token)
    {
            return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$token);
    }*/

}

?>