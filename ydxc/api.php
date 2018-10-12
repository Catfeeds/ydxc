<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: api.php 2013-11-24 23:43:29 jerry $
*/

include_once('./common.php');

define("TOKEN", $_TCONFIG['weixin_TOKEN']);

if($_GET['itype']=='dingyue'){ // 订阅号
	$_TCONFIG['weixin_AppId']      = '';
	$_TCONFIG['weixin_AppSecret']  = '';
}


$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            switch ($RX_TYPE)
            {
                case "text":
                    $resultStr = $this->receiveText($postObj);
                    break;
                /*case "image":
                    $resultStr = $this->receiveImage($postObj);
                    break;
                case "location":
                    $resultStr = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $resultStr = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $resultStr = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $resultStr = $this->receiveLink($postObj);
                    break;*/
                case "event":
                    $resultStr = $this->receiveEvent($postObj);
                    break;
                default:
                    $resultStr = "unknow msg type: ".$RX_TYPE;
                    break;
            }
            echo $resultStr;
        }else {
            echo "";
            exit;
        }
    }

    private function receiveText($object)
    {
        $funcFlag = 0;
		 global $_TGLOBAL;

		 //$resultStr = $this->transmitText($object, 'ddd', $funcFlag);
		 //return;

		 $content = $object->Content;
		 $query = $_TGLOBAL['db']->query("SELECT id, itype, title, intro, content, img, readno FROM ".tname('weixin')." WHERE keywords LIKE '%$content%' ORDER BY displayorder DESC, id DESC");
		 $info = $_TGLOBAL['db']->fetch_array($query);
		 $info['intro'] = str_replace('%', '%%', $info['intro']);
		 if ($info) {
			 switch($info['itype']) {
				 case 'text':
					 $resultStr = $this->transmitText($object, $info['content'], $funcFlag);					 
					 $_TGLOBAL['db']->query('UPDATE '.tname('weixin')." SET readno=readno+1 WHERE id='$info[id]'"); //更新阅读次数
					 break;

				 case 'image':
					 $info['img'] = str_replace('../', '', $info['img']);
					 $picurl = getsiteurl().$info['img'];
					 $resultStr = $this->transmitText($object, "<a href=\"$picurl\">点击查看图片</a>");
					 $_TGLOBAL['db']->query('UPDATE '.tname('weixin')." SET readno=readno+1 WHERE id='$info[id]'"); //更新阅读次数
					 break;

				 case 'voice':
					 $info['img'] = str_replace('../', '', $info['img']);
					$picurl = getsiteurl().$info['img'];
					 $array['Title'] = $info['title'];
					 $array['Description'] = $info['intro'];
					 $array['MusicUrl'] = $picurl;
					 $array['HQMusicUrl'] = $picurl;
					 $resultStr = $this->transmitMusic($object, $array);
					 $_TGLOBAL['db']->query('UPDATE '.tname('weixin')." SET readno=readno+1 WHERE id='$info[id]'"); //更新阅读次数
					 break;

				 case 'weixin':

					$dataArray = array();
			
					//得到第一组数据 start
					$info['img'] = str_replace('../', '', $info['img']);
					$picurl = $info['img'] ? (getsiteurl().$info['img']) : '';
					$url = getsiteurl().'index.php?do=show&id='.$info['id'];
					$dataArray[] = array("Title"=>$info['title'], "Description"=>$info['intro'], "Picurl"=>$picurl, "Url" =>$url);
					//得到第一组数据 end


					//取出其他的数据
					while ($info = $_TGLOBAL['db']->fetch_array($query)) {
						$info['intro'] = str_replace('%', '%%', $info['intro']);
						$info['img'] = str_replace('../', '', $info['img']);
						$picurl = $info['img'] ? (getsiteurl().$info['img']) : '';
						$url = getsiteurl().'index.php?do=show&id='.$info['id'];
						$dataArray[] = array("Title"=>$info['title'], "Description"=>$info['intro'], "Picurl"=>$picurl, "Url" =>$url);
					}

					$resultStr = $this->transmitNews($object, $dataArray, $funcFlag);
					break;
			 }
			//$contentStr = "你发送的是文本，内容为：".$object->Content;			
		} else { //关键字不匹配时应该有默认回复内容设置，如关联到关注时自动回复内容 或者 是其他内容；
			$resultStr = $this->getmismatch($object);
		}

        return $resultStr;
    }

    /*private function receiveImage($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是图片，地址为：".$object->PicUrl;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveLocation($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveVoice($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是语音，媒体ID为：".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveVideo($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是视频，媒体ID为：".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }

    private function receiveLink($object)
    {
        $funcFlag = 0;
        $contentStr = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $resultStr = $this->transmitText($object, $contentStr, $funcFlag);
        return $resultStr;
    }*/

    private function receiveEvent($object)
    {
		global $_TGLOBAL, $_CTB;
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
			case "SCAN":
                $resultStr = $this->getsubscribe($object); //当文本回复不存在，则取出图文信息
				//$resultStr  = $this->transmitText($object, $contentStr);
                break;
            case "unsubscribe":
					//取消关注 则更新用户的关注标识
					$openid = $object->FromUserName;
					$_TGLOBAL['db']->query("
								UPDATE ctb_wx_user SET 
									`subscribe` = 0,						
									`visit_time` = '$_TGLOBAL[timestamp]'
								WHERE openid = '$openid'
							");
					$contentStr = "";
                break;
            case "CLICK":
				$class_id = $object->EventKey;
				$dataArray = array();

				//前台点“我要缴费”
				if ($class_id == '001') {

				//如果用户有无注册
				if (!$info = $_TGLOBAL['db']->getrow("SELECT NULL FROM ".tname('members')." WHERE Openid='".$object->FromUserName."'")) {
					$url = $_CTB['siteurl']."index.php?do=auth";	 
					$content = "你还未注册 <a href=\"$url\">点击完成注册</a>";
				 } else {

					//判断用户有无进场记录
					if ($info  = $_TGLOBAL['db']->getrow("SELECT s.ID msgid, s.FeeMoney, s.EnterExitType, s.ParkNumber, s.PlateNumber, s.PaidStatus, m.CustomerID, m.Openid 
														  FROM ".tname('park_enter_msg')." s 
														  LEFT JOIN ".tname('members')." m ON s.CustomerID=m.CustomerID
														  WHERE m.Openid='".$object->FromUserName."'
														  ORDER BY s.ID DESC LIMIT 0,1
														  ")) {
						//判断最后一条记录是否为进场
						if ($info['EnterExitType'] == 3) {
							
							/*if ($info['PaidStatus'] == 1) {
								$content = "您已缴费,请尽快离场.";
                                
                                //当用户每次点“我要缴费”时，都需要去判断是否还需要缴费
                                makeoutcar_weixin($info);
                                
							} else {*/
								$content = makeoutcar_weixin($info);
                                return ;
							//}
						
						} else {
							$content = "您还未进入停车场";
						}
						//echo $content;
						//return ;
					//$content = $info['PlateNumber']." 需要支付{$info[FeeMoney]}元 <a href=\"index.php?do=recharge\">点击支付</a>";
					} else {
						$content = "您还未进入停车场";
					}
				 }
					$resultStr  = $this->transmitText($object, $content);
					return $resultStr;
				}

				//取出类别的名称和图片
				 $query = $_TGLOBAL['db']->query("SELECT name, img FROM ".tname('weixin_class')." WHERE class_id='$class_id'");
				 $class = $_TGLOBAL['db']->fetch_array($query);
				$class['img'] = str_replace('../', '', $class['img']);
				$picurl = $class['img'] ? (getsiteurl().$class['img']) : '';

				$class_url = getsiteurl().'index.php?do=news&class_id='.$class_id;

				//*********** 取出新闻的内容 start
				$query = $_TGLOBAL['db']->query("SELECT id, title, intro, img, flag, jumpto FROM ".tname('weixin')." WHERE LEFT(class_id, ".strlen($class_id).")='$class_id' ORDER BY displayorder DESC, id DESC LIMIT 0,4");

				if ($_TGLOBAL['db']->num_rows($query) > 1) { //当文章个数大于１，则显示更多，类别的显示及链接
					$dataArray[] = array("Title"=>$class['name'], "Picurl"=>$picurl, "Url" =>$class_url);
				}

				while ($info = $_TGLOBAL['db']->fetch_array($query)) {
					$info['intro'] = str_replace('%', '%%', $info['intro']);
					//判断为文本时
					if ($info['flag'] == 10) {
						$openid = $object->FromUserName;
						$info['intro'] = str_replace('$openid', $openid, $info['intro']);
						$resultStr  = $this->transmitText($object, $info['intro']);
						return $resultStr;
					}

					$info['img'] = str_replace('../', '', $info['img']);
					$picurl = $info['img'] ? (getsiteurl().$info['img']) : '';

					//跳转至新闻的转向页，同时加上openid字段
					if ($info['jumpto']) {
						$openid = $object->FromUserName;
						$url = str_replace('$openid', $openid, $info['jumpto']);
					} else {
						$url = getsiteurl().'index.php?do=show&id='.$info['id'];
					}
					$dataArray[] = array("Title"=>$info['title'], "Description"=>$info['intro'], "Picurl"=>$picurl, "Url" =>$url);
					}


				if ($_TGLOBAL['db']->num_rows($query) > 1) { //当文章个数大于１，则显示更多 
					$dataArray[] = array("Title"=>'点击查看更多→', "Url" =>$class_url);
				}

				$resultStr = $this->transmitNews($object, $dataArray, $funcFlag);
		

                break;

			  case "LOCATION":
				  //$contentStr = "经度：".$object->Longitude;
				  //$contentStr .= "\n纬度：".$object->Latitude;
				  //$contentStr .= "\n精度：".$object->Precision;
				  //$contentStr .= "\n微信ID：".$object->FromUserName;
				  //$contentStr .= "成功";
				  //$resultStr  = $this->transmitText($object, $contentStr);

					//根据用户的opendid，更新业认证中，用户的经、纬度，以便商家联盟，根据此值，自动查找出附近的商家
					$openid = $object->FromUserName;
					if ($openid) {
						$_TGLOBAL['db']->query('UPDATE '.tname('owner')." SET `lng`='".$object->Longitude."', `lat`='".$object->Latitude."', `precision`='".$object->Precision."' WHERE weixin_id='$openid'"); //更新阅读次数
					}
				  break;
			
			default:
                $contentStr = "receive a new event: ".$object->Event;
                break;
        }
        //$resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }

    //得到关注时回复
	private function getsubscribe($object)
    {
		 global $_TGLOBAL, $_TCONFIG, $_CTB;


		//用户关注时，拉取用户个人信息，并且存入数据库，如果数据库己存在用户信息，则更新 start
		if (isset($object->EventKey)) {
			$shop_no = $object->EventKey; //带参二维码，得到用户的店铺编号 事件KEY值，qrscene_为前缀，后面为二维码的参数值
			$shop_no = str_replace('qrscene_', '', $shop_no);
		}

		$openid = $object->FromUserName;
		
		$ACCESS_LIST = $this->curl($_TCONFIG['weixin_AppId'],$_TCONFIG['weixin_AppSecret']);
		if($ACCESS_LIST['access_token']!='') {
			 $u = $this->user_info($ACCESS_LIST['access_token'],$openid);

			include_once('./source/function_image.php');
			$aryreturn = upload_http_img($u['headimgurl']);
			if (is_array($aryreturn)) { //返回数组则上传成功,取得文件名
				$img_url = $aryreturn['new_name'];
			}


			//*********** 用户扫描代理的带参二维码关注后，给此代理推送公众号信息 start
			if ($shop_no) {
				$query  = $_TGLOBAL['db']->query("SELECT openid FROM ".tname('members')." WHERE twocode='$shop_no'");
				$agent=$_TGLOBAL['db']->fetch_array($query);

				if ($agent['openid']) {			
					$first = '您有新的用户加入了';
					$keyword1 = $u[nickname];
					$remark = "您的好友$u[nickname]已经接受邀请";
					$keyword2 = date('Y年m月d日 H:i',$_TGLOBAL['timestamp']);

					$data = "
					  {
							   \"touser\":\"$agent[openid]\",
							   \"template_id\":\"7ao7aIqdDmzphliAk5D6KovpN0PKAsAC6trNUVFrC4s\",
							   \"url\":\"$_CTB[siteurl]\",
							   \"topcolor\":\"#FF0000\",
							   \"data\":{
									   \"first\": {
										   \"value\":\"$first\",
										   \"color\":\"#173177\"
									   },
									   \"keyword1\":{
										   \"value\":\"$keyword1\",
										   \"color\":\"#ff0000\"
									   },
									   \"keyword2\": {
										   \"value\":\"$keyword2\",
										   \"color\":\"#173177\"
									   },
									   \"remark\":{
										   \"value\":\"$remark\",
										   \"color\":\"#173177\"
									   }
							   }
						   }
					";
					$ACCESS_TOKEN = weixin_access_token();
					$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$ACCESS_TOKEN}"; 
					$return = weixin_post($url, $data);
					$ary = json_decode($return);

					//记录发送明细
					$arr = array(
							'title'            => 	$first,
							'content'          => 	$data,
							'is_read'          => 	1,
							'uid'              => 	$value['uid'],
							'date'             => 	$_TGLOBAL['timestamp']
							);
					inserttable('message', $arr);
				}
			}
			//*********** 用户扫描代理的带参二维码关注后，给此代理推送公众号信息 end

		}	

		//判断用户是否存在
		$sql = "SELECT NULL FROM ctb_wx_user WHERE openid='$openid'";
		$query = $_TGLOBAL['db']->query($sql);
		//用户存在，则更新
		if ($user = $_TGLOBAL['db']->fetch_array($query)) { 
			$_TGLOBAL['db']->query("
						UPDATE ctb_wx_user SET 
							`agent_no` = '$shop_no',
							`subscribe` = '$u[subscribe]',
							`nickname` = '$u[nickname]',
							`sex` = '$u[sex]',
							`city` = '$u[city]',
							`country` = '$u[country]',
							`province` = '$u[province]',
							`language` = '$u[language]',
							`headimgurl` = '$u[headimgurl]',
							`img` = '$img_url',
							`subscribe_time` = '$u[subscribe_time]',
							`visit_time` = '$_TGLOBAL[timestamp]'
							WHERE openid = '$openid'
					");

		} else { //添加用户信息

			$_TGLOBAL['db']->query("
						INSERT INTO ctb_wx_user (	
							`agent_no`,
							`subscribe`,
							`openid`,
							`nickname`,
							`sex`,
							`city`,
							`country`,
							`province`,
							`language`,
							`headimgurl`,
							`img`,
							`subscribe_time`,
							`visit_time`
							)	
						 VALUES (	
							'$shop_no',
							'$u[subscribe]',
							'$openid',
							'$u[nickname]',
							'$u[sex]',
							'$u[city]',
							'$u[country]',
							'$u[province]',
							'$u[language]',
							'$u[headimgurl]',
							'$img_url',
							'$u[subscribe_time]',
							'$_TGLOBAL[timestamp]'
							)
					");
		}
		//用户关注时，拉取用户个人信息，并且存入数据库，如果数据库己存在用户信息，则更新 end



	 $funcFlag = 0;
	 $query = $_TGLOBAL['db']->query("SELECT id, itype, title, intro, content, img, readno FROM ".tname('weixin')." WHERE FIND_IN_SET('1',cote)>0 ORDER BY displayorder DESC, id DESC");
	 $info = $_TGLOBAL['db']->fetch_array($query);
	 if ($info) {
		 switch($info['itype']) {
			 case 'text':
				 
				//如果用户未注册
				if ($info = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('members')." WHERE Openid='$openid'")) {
					$info['content'] = '欢迎回来';
				 } else { //己注册，显示
					$url = $_CTB['siteurl']."index.php?do=auth";	 
					$info['content'] .= " <a href=\"$url\"> 点击完成注册</a>";
				 }
				 $resultStr = $this->transmitText($object, $info['content'], $funcFlag);					 
				 $_TGLOBAL['db']->query('UPDATE '.tname('weixin')." SET readno=readno+1 WHERE id='$info[id]'"); //更新阅读次数
				 break;

			 case 'image':
				 $info['img'] = str_replace('../', '', $info['img']);
				 $picurl = getsiteurl().$info['img'];
				 $resultStr = $this->transmitText($object, "<a href=\"$picurl\">点击查看图片</a>");
				 $_TGLOBAL['db']->query('UPDATE '.tname('weixin')." SET readno=readno+1 WHERE id='$info[id]'"); //更新阅读次数
				 break;

			 case 'voice':
				 $info['img'] = str_replace('../', '', $info['img']);
				$picurl = getsiteurl().$info['img'];
				 $array['Title'] = $info['title'];
				 $array['Description'] = $info['intro'];
				 $array['MusicUrl'] = $picurl;
				 $array['HQMusicUrl'] = $picurl;
				 $resultStr = $this->transmitMusic($object, $array);
				 $_TGLOBAL['db']->query('UPDATE '.tname('weixin')." SET readno=readno+1 WHERE id='$info[id]'"); //更新阅读次数
				 break;

			 case 'weixin':

				$dataArray = array();
		
				//得到第一组数据 start
				$info['img'] = str_replace('../', '', $info['img']);
				$picurl = $info['img'] ? (getsiteurl().$info['img']) : '';
				$url = getsiteurl().'index.php?do=show&id='.$info['id'];
				$dataArray[] = array("Title"=>$info['title'], "Description"=>$info['intro'], "Picurl"=>$picurl, "Url" =>$url);
				//得到第一组数据 end


				//取出其他的数据
				while ($info = $_TGLOBAL['db']->fetch_array($query)) {
					$info['img'] = str_replace('../', '', $info['img']);
					$picurl = $info['img'] ? (getsiteurl().$info['img']) : '';
					$url = getsiteurl().'index.php?do=show&id='.$info['id'];
					$dataArray[] = array("Title"=>$info['title'], "Description"=>$info['intro'], "Picurl"=>$picurl, "Url" =>$url);
				}

				$resultStr = $this->transmitNews($object, $dataArray, $funcFlag);
				break;
		 }
		//$contentStr = "你发送的是文本，内容为：".$object->Content;			
	}
	return $resultStr;
    }

    //关键字不匹配时应该有默认回复内容设置，如关联到关注时自动回复内容 或者 是其他内容；
	private function getmismatch($object)
    {
	 global $_TGLOBAL;
	 $funcFlag = 0;
	 $query = $_TGLOBAL['db']->query("SELECT id, itype, title, intro, content, img, readno FROM ".tname('weixin')." WHERE FIND_IN_SET('5',cote)>0 ORDER BY displayorder DESC, id DESC");
	 $info = $_TGLOBAL['db']->fetch_array($query);
	 if ($info) {
		 switch($info['itype']) {
			 case 'text':
				 $resultStr = $this->transmitText($object, $info['content'], $funcFlag);					 
				 $_TGLOBAL['db']->query('UPDATE '.tname('weixin')." SET readno=readno+1 WHERE id='$info[id]'"); //更新阅读次数
				 break;

			 case 'image':
				 $info['img'] = str_replace('../', '', $info['img']);
				 $picurl = getsiteurl().$info['img'];
				 $resultStr = $this->transmitText($object, "<a href=\"$picurl\">点击查看图片</a>");
				 $_TGLOBAL['db']->query('UPDATE '.tname('weixin')." SET readno=readno+1 WHERE id='$info[id]'"); //更新阅读次数
				 break;

			 case 'voice':
				 $info['img'] = str_replace('../', '', $info['img']);
				$picurl = getsiteurl().$info['img'];
				 $array['Title'] = $info['title'];
				 $array['Description'] = $info['intro'];
				 $array['MusicUrl'] = $picurl;
				 $array['HQMusicUrl'] = $picurl;
				 $resultStr = $this->transmitMusic($object, $array);
				 $_TGLOBAL['db']->query('UPDATE '.tname('weixin')." SET readno=readno+1 WHERE id='$info[id]'"); //更新阅读次数
				 break;

			 case 'weixin':

				$dataArray = array();
		
				//得到第一组数据 start
				$info['img'] = str_replace('../', '', $info['img']);
				$picurl = $info['img'] ? (getsiteurl().$info['img']) : '';
				$url = getsiteurl().'index.php?do=show&id='.$info['id'];
				$dataArray[] = array("Title"=>$info['title'], "Description"=>$info['intro'], "Picurl"=>$picurl, "Url" =>$url);
				//得到第一组数据 end


				//取出其他的数据
				while ($info = $_TGLOBAL['db']->fetch_array($query)) {
					$info['img'] = str_replace('../', '', $info['img']);
					$picurl = $info['img'] ? (getsiteurl().$info['img']) : '';
					$url = getsiteurl().'index.php?do=show&id='.$info['id'];
					$dataArray[] = array("Title"=>$info['title'], "Description"=>$info['intro'], "Picurl"=>$picurl, "Url" =>$url);
				}

				$resultStr = $this->transmitNews($object, $dataArray, $funcFlag);
				break;
		 }
		//$contentStr = "你发送的是文本，内容为：".$object->Content;			
	}
	return $resultStr;
    }


    private function transmitText($object, $content, $flag = 0)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>%d</FuncFlag>
</xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }

    private function transmitNews($object, $arr_item, $flag = 0)
    {
        if(!is_array($arr_item))
            return;

        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['Picurl'], $item['Url']);

        $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
<FuncFlag>%s</FuncFlag>
</xml>";

        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item), $flag);
        return $resultStr;
    }

    private function transmitMusic($object, $musicArray, $flag = 0)
    {
        $itemTpl = "<Music>
    <Title><![CDATA[%s]]></Title>
    <Description><![CDATA[%s]]></Description>
    <MusicUrl><![CDATA[%s]]></MusicUrl>
    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
$item_str
<FuncFlag>%d</FuncFlag>
</xml>";

        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $flag);
        return $resultStr;
    }



	public function curl($appid,$secret)
    {
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret);
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$tmpInfo = curl_exec($ch);
    	if (curl_errno($ch)) {
    		echo 'Errno'.curl_error($ch);
    	}
    	curl_close($ch);
    	$arr= json_decode($tmpInfo,true);
    	return $arr;
    }

	//摘取用户信息
	private function user_info($access_token,$openid)
    {

    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid);
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	$tmpInfo = curl_exec($ch);
    	if (curl_errno($ch)) {
    		echo 'Errno'.curl_error($ch);
    	}
    	curl_close($ch);
    	$arr= json_decode($tmpInfo,true);
    	return $arr;
    }

}

?>