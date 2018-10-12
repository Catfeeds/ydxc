<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/global.php';
$method = $_REQUEST['method'];
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';
#include_once $_SERVER['DOCUMENT_ROOT'] . '/system/system.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_db/drive/mysql.class.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_db/config/database.php';
$wx = new Weixin_class();
$db = DB::getDBClass();

$code = 1;
$msg = "OK";
$content = null;
switch($method) {

	case 'addrq':
		
		if (!empty($_SESSION['openid'])) {
			$openid = $_SESSION['openid'];
			//查询当天的投票情况
			$touid = $_REQUEST['touid'];
			$starttime = strtotime(date('Y-m-d', time()) . '00:00:00');
			$list = $db->where(" `addtime` >= '" . $starttime . "' AND `addtime` <= '" . time() . "' AND `openid` = '" . $openid ."' ")->select('tplog');
			if (count($list) >= 3) {
				$msg = "今天投票用完";
			} else {
				if (!empty($touid)) {
					$list = $db->where(" `addtime` >= '" . $starttime . "' AND `addtime` <= '" . time() . "' AND `openid` = '" . $openid ."' AND `touid`='" . $touid . "' ")->select('tplog');
					if (count($list) >= 1) {
						$msg = "今天已经投过TA了";
					} else {
						$ps = 1;
						if ($db->add('tplog', array('openid'=>$openid, 'addtime'=>time(), 
										'touid'=>$touid))) {
							$db->where(array('id'=>$touid));
							if ($db->update('user', 'rq=rq+' . $ps)){
								$msg = "投票成功!";
							}
						}
					}
				}
			}
		} else {
			$code = -1;
		} 
		if  ('OK' == $msg) {
			$msg = "请在微信客户端或者公众号打开进行投票";
		}
		break;
		
	case 'getwxpz':
		$timeStamp = intval(time()/10);
		$url = $_SERVER[HTTP_REFERER];
		//echo $url;
		$nonceStr = $wx->getRandChar(15);
		$signature = $wx->get_js_signature($nonceStr, $timeStamp, $url);
		$package = "prepay_id=" . $unifiedOrderResult->prepay_id;
		$data = array("timeStamp"=>$timeStamp,"nonceStr"=>$nonceStr,
			"package"=>$package, "signType"=>"MD5", "appId"=>APPID);
		$paySign = $wx->get_signature($data);
		$content = array('appId'=>APPID, 'timestamp'=>$timeStamp, 'nonceStr'=>$nonceStr, 'signature'=>$signature,'test'=>$url);
		break;
		
	case "showxxds"://显示形象大使
			
			if (!empty($_REQUEST['data']) || !empty($_SESSION['openid'])) {
				$data = $_REQUEST['data'];
				echo $data;
				$data = json_encode($data, JSON_UNESCAPED_UNICODE);
				//$_SESSION['openid'] = $_SESSION['openid']?$_SESSION['openid']:$data['openid'];
				$db->add('wxuserinfo', array('openid'=>$data['openid'], 
								'info'=>json_encode($data, JSON_UNESCAPED_UNICODE)));
								
				$url = "zt2.html";
				header("Location:" . $url);
				exit();
			}
			
			/*if (!empty($_REQUEST['openid']) || !empty($_SESSION['openid'])) {
				$_SESSION['openid'] = $_SESSION['openid']?$_SESSION['openid']:$_REQUEST['openid'];
				$url = "zt2.html";
				header("Location:" . $url);
				exit();
			}*/
			$url = "/l_wx/getwxinfo.php?method=getUserInfo&state=showxxds";
			header("Location:" . $url);
			exit();
			break;
	case 'gettpinfolist':
		$db->where(array('touid'=>$_REQUEST['touid']));
		//$db->select('tplog');
		//$db->limit(1, 300);
		$db->order('addtime',"DESC");
		$tplog = $db->select('tplog');
		foreach ($tplog as $key=>$val) {
			$db->where(array('openid'=>$val['openid']));
			$userinfo = $db->select('wxuserinfo');
			if (!empty($userinfo)) {
				$tplog[$key]['wxinfo'] = $userinfo[0];
			} else {
				$tplog[$key]['wxinfo'] = null;
			}
		}
		$content = array('list'=>$tplog);
		break;
	
	default :
		//echo null;
		break;
}
echo json_encode(array('code' => $code, 'msg' => $msg, 'content' => $content), JSON_UNESCAPED_UNICODE);
exit();
?>
