<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

include_once('./common.php'); //************************* 2015-11-24 增加 网站通用文件

require_once "./wxpay/lib/WxPay.Api.php";
require_once './wxpay/lib/WxPay.Notify.php';
require_once './wxpay/example/log.php';

//初始化日志
$logHandler= new CLogFileHandler("./wxpay/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}

		//处理订单成功				

		//************************* 2015-11-24 增加 start
		global $_TGLOBAL;
		swritefile('aa.txt', print_r($data, true)); //写入文件（路径文件名，内容）
		
		$total        = $data['total_fee']/100;
		$out_trade_no = $data['out_trade_no'];
		$ary          = @explode('_', $out_trade_no);
		$sign_id      = $ary[1];
		//$pmount = $ary[2]; //取出原价金额
		//!$pmount && $pmount = $total; //原价不存在，则为实充金额
		

		//以出此用户ID
		/*$userinfo   = $_TGLOBAL['db']->getrow("SELECT money_future, uid FROM ".tname('members')." WHERE uid = '$uid'");
		
		$total = $userinfo['money_future'] + $pmount;
		//添加到记录表
		$arr = array(  'userid'      => $userinfo['uid'],
					   'op'          => 'recharge',
					   'money'       => $pmount,
					   'cur_money'   => $total,
					   'remark'      => '微信单号：'.$data['transaction_id'],
					   'date'        => $_TGLOBAL['timestamp'],
					  );
		$money_id = inserttable('member_money', $arr);*/
		$sql = "UPDATE ".tname('sign')." SET ispay=1, money='$total', paydate='$_TGLOBAL[timestamp]' WHERE id = '$sign_id' ";
		swritefile('sql.txt', $sql); //写入文件（路径文件名，内容）
		$_TGLOBAL['db']->query($sql);

		return true;
	}
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);

