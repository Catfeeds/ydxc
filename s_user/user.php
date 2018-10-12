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
		case 'getphb' :
			$code = 1;
			//查询排行榜
			$page = 1;
			if (!empty($_REQUEST['page'])) {
				$page = $_REQUEST['page'];
			}
			$db -> order('rq');
			$db -> limit($page, 10);
			$content = $db -> select('user');
			break;
		case 'getuserlist' :
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
			if (empty($_REQUEST['admin'])) {
				$db -> where(" '' != zp ");
			}
			$db -> order(array('rq'));
			if (empty($_REQUEST['admin'])) {
				$db -> limit($page, PAGE_SIZE);
			}
			$content['list'] = $db->select('user');
			$content['page']['total'] = count($db -> where(" '' != zp ")->select('user'));
			$content['page']['pagesize'] = PAGE_SIZE;
			break;

		case 'getuser' :
			//获取单个用户
			$id = $_REQUEST['id'];

			if (!empty($id)) {
				$db -> where(array('id' => $id));
			}
			$db->limit(1, 1);
			$code = 1;
			$content = $db -> select('user');
			//$content = $content[0];
			if (empty($_SESSION['openid']) && empty($_REQUEST['admin'])) {
				$code = -1;
			}
			break;

		case 'adduser':
			$xm = $_REQUEST['xm'];
			$phone = $_REQUEST['phone'];
			$school = $_REQUEST['school'];
			if (!empty($xm) && !empty($phone) && !empty($school)) {
				//查询电话是否重复
				$isuser = $db->where(array('phone'=>$phone))->select('user');
				if (count($isuser) <= 0) {
					$res = $db->add('user', array('xm'=>$xm, 'phone'=>$phone, 
							'school'=>$school, 'zp'=>"", "rq"=>1, 'nums'=>""));
					if ($res) {
						$id = $db->last_insert_id();
						
						if ($db->where(array('id'=>$id))->update('user', 'nums=' . (10000+$id))) {
							$code = 1;
							$msg = "我们会在两个工作日内联系您收集照片，请保持手机畅通，耐心等待，谢谢！";
						}
					}
				} else {
					$msg = "该电话已经报过名!";
				}
			} else {
				$msg = "信息填写不完整";
			}
			break;
		case "edituser":
			$id = $_REQUEST['id'];
			$xm = $_REQUEST['xm'];
			$phone = $_REQUEST['phone'];
			$school = $_REQUEST['school'];
			$zp = $_REQUEST['zp'];
			if (!empty($xm) && !empty($school)) {
				if (!empty($id)) {
					$db->where(array("id"=>$id));
					if ($db->update('user', array('xm'=>$xm, 'phone'=>$phone, 'school'=>$school, 'zp'=>$zp))) {
						$msg = '操作成功！';
					}
				} else {
					//查询电话是否重复
					$res = $db->add('user', array('xm'=>$xm, 'phone'=>$phone, 
							'school'=>$school, 'zp'=>$zp, "rq"=>1, 'nums'=>""));
					if ($res) {
						$id = $db->last_insert_id();
						
						if ($db->where(array('id'=>$id))->update('user', 'nums=' . (10000+$id))) {
							$code = 1;
							$msg = "操作成功！";
						}
					}
				}
			} else {
				$msg = "信息填写不完整";
			}
			break;
			
		case "deluser":
			$id = $_REQUEST['id'];
			
			if (!empty($id)) {
				$db->where(array("id"=>$id));
				if ($db->del('user')) {
					$msg = '操作成功！';
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