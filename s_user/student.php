<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/global.php';

	$method = $_REQUEST['method'];
	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';	
	include_once ROOT_PATH . '/system/system.php';
	include_once ROOT_PATH . '/l_db/drive/mysql.class.php';
	include_once ROOT_PATH . '/l_db/config/database.php';
	$wx = new Weixin_class();
	$db = DB::getDBClass();
	$code = 0;
	$msg = "OK";
	$content = null;
	switch($method) {
		case 'getOpenid':
			$url = "/l_wx/getwxinfo?method=getUserInfo";
			header("Location:" . $url);
			break;
		case 'getlist' :
			$code = 1;
			//获取用户列表
			$page = $_REQUEST['page'];
			$keyword = $_REQUEST['keyword'];
			$id = $_REQUEST['id'];
			if (!empty($keyword)) {
				$sql = " `xm` like '%" . $keyword . "%' ";
				$db -> where($sql);
			}
			if (!empty($id)) {
				$db -> where(array('id' => $id));
			}
			//$db -> limit($page, PAGE_SIZE);
			$db->order('ispay','ASC');
			$content['list'] = $db->select('student');
			$content['page']['total'] = count($db->select('student'));
			$content['page']['pagesize'] = PAGE_SIZE;
			break;

		case 'getone' :
			//获取单个用户
			$id = $_REQUEST['id'];

			if (!empty($id)) {
				$db -> where(array('id' => $id));
			}
			$db->limit(1, 1);
			$code = 1;
			$content = $db -> select('student');
			//$content = $content[0];
			break;

		case 'add':
			$xm = $_REQUEST['xm'];
			$phone = $_REQUEST['phone'];
			$school = $_REQUEST['school'];
			$yqm = $_REQUEST['yqm'];
			if (!empty($xm) && !empty($phone) && !empty($school)) {
				//查询电话是否重复
				$isuser = $db->where(array('phone'=>$phone,'ispay'=>1))->select('student');
				if (count($isuser) <= 0) {
					$res = $db->add('student', array('yqm'=>$yqm, 'xm'=>$xm, 'phone'=>$phone, 
							'school'=>$school, 'addtime'=>date('Y-m-d H:i:s', time())));
					if ($res) {
						$code = 1;
						$msg = "我们会在两个工作日内联系您，请保持手机畅通，耐心等待，谢谢！";
					}
				} else {
					$msg = "该电话已经报过名!";
				}
			} else {
				$msg = "信息填写不完整";
			}
			break;
			
		case "showbm"://显示报名
			if (!empty($_REQUEST['openid']) || !empty($_SESSION['openid'])) {
				$_SESSION['openid'] = $_SESSION['openid']?$_SESSION['openid']:$_REQUEST['openid'];
				$url = "/client/zt4.html";
				header("Location:" . $url);
				exit();
			} 
			$url = "/l_wx/getwxinfo.php?method=getOpenId&state=addStudent";
			header("Location:" . $url);
			exit();
			break;
			
		case 'unifiedorder' :
			$openid = $_SESSION['openid'];
			$out_trade_no = "yd_".time().$wx->getRandChar(8);
			$total_fee = 100*100;
			if (!empty($total_fee) && $total_fee > 0 && !empty($openid)) {
				$xm = $_REQUEST['xm'];
				$phone = $_REQUEST['phone'];
				//$school = $_REQUEST['school'];
				$yqm = $_REQUEST['yqm'];
				if (!empty($xm) && !empty($phone) && !empty($yqm)) {
					//查询电话是否重复
					$isuser = $db->where(array('phone'=>$phone,'ispay'=>1))->select('student');
					if (count($isuser) <= 0) {
						$res = $db->add('student', array('yqm'=>$yqm, 'xm'=>$xm, 'phone'=>$phone, 'out_trade_no'=>$out_trade_no, 'addtime'=>date('Y-m-d H:i:s', time())));
						if ($res) {
							$code = 1;
							$msg = "我们会在两个工作日内联系您，请保持手机畅通，耐心等待，谢谢！";
							if ($res) {
								$unifiedOrderResult = $wx->unifiedorder($total_fee, $openid, '加人气', $out_trade_no);
								//var_dump($unifiedOrderResult);
								$timeStamp = intval(time()/10);
								$url = $_SERVER[HTTP_REFERER];
								//echo $url;
								$nonceStr = $wx->getRandChar(15);
								$signature = $wx->get_js_signature($nonceStr, $timeStamp, $url);
								//var_dump($unifiedOrderResult);exit();
								$package = "prepay_id=".$unifiedOrderResult->prepay_id;
								$data = array("timeStamp"=>$timeStamp,"nonceStr"=>$nonceStr,
									"package"=>$package, "signType"=>"MD5", "appId"=>APPID);
									
								$paySign = $wx->get_signature($data);
								$code = 1;
								$content = array('package'=>$package, 'paySign'=>$paySign, 'appId'=>APPID, 'timestamp'=>$timeStamp, 'nonceStr'=>$nonceStr, 'signature'=>$signature);
							} else {
								$msg = "FAIL";
							}
						}
					} else {
						$msg = "该电话已经报过名!";
					}
				} else {
					$msg = "信息填写不完整";
				}
			}
			if (empty($_SESSION['openid'])) {
				$code = -1;
			}
		
		break;	
		
		default :
			//echo null;
			break;
	}
//}
echo json_encode(array('code' => $code, 'msg' => $msg, 'content' => $content), JSON_UNESCAPED_UNICODE);
exit();
?>