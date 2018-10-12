<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/global.php';

//if (!empty($_SESSION['openid'])) {
	$method = $_REQUEST['method'];
	//网站根目录
	include_once ROOT_PATH . '/system/system.php';
	include_once ROOT_PATH . '/l_db/drive/mysql.class.php';
	include_once ROOT_PATH . '/l_db/config/database.php';
	$db = DB::getDBClass();
	$code = 0;
	$msg = "OK";
	$content = null;
	switch($method) {

		case 'getlist' :
			$code = 1;
			//获取用户列表
			$page = $_REQUEST['page'];
			$keyword = $_REQUEST['keyword'];
			$id = $_REQUEST['id'];
			if (!empty($keyword)) {
				$sql = " `xm` like '%" . $keyword . "%' OR `nums` like '%" . $keyword . "%' ";
				$db -> where($sql);
			}
			if (!empty($id)) {
				$db -> where(array('id' => $id));
			}
			$content['list'] = $db->select('partner');
			$content['page']['total'] = count($db->select('partner'));
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
			$content = $db -> select('partner');
			//$content = $content[0];
			break;

		case 'add':
			$xm = $_REQUEST['xm'];
			$phone = $_REQUEST['phone'];
			$school = $_REQUEST['school'];
			if (!empty($xm) && !empty($phone) && !empty($school)) {
				//查询电话是否重复
				$isuser = $db->where(array('phone'=>$phone))->select('partner');
				if (count($isuser) <= 0) {
					$res = $db->add('partner', array('xm'=>$xm, 'phone'=>$phone, 
							'school'=>$school, 'addtime'=>date('Y-m-d H:i:s',time())));
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
		default :
			//echo null;
			break;
	}
//}

echo json_encode(array('code' => $code, 'msg' => $msg, 'content' => $content), JSON_UNESCAPED_UNICODE);
exit();
?>