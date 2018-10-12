<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "./lib/WxPay.Api.php";
require_once './lib/WxPay.Notify.php';
require_once './example/log.php';

//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
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
		include_once('../common.php'); //************************* 2015-11-24 增加 网站通用文件
		global $_TGLOBAL;

		//************************* 2015-11-24 增加 start
		$total = $data['total_fee'];
		$out_trade_no = $data['out_trade_no'];
		
		//取出订单的应付款，判断订单金额是否与己付款金额相同
		$orderinfo   = $_TGLOBAL['db']->getrow("SELECT price
											FROM ".tname('orders')." 
											WHERE 
											order_no='$out_trade_no'
											");

		if ($total == $orderinfo['price']) {

			set_user_td_profit($out_trade_no); //判断订单里商品详情有无升级套餐，有则进行相应分佣

			//更新订单状态
			$arr = array(
				'ispay'			  =>	1,
				'state'			  =>	20,
				'pay_type'        => 	'weixin',
				);
			updatetable('orders', $arr, array('order_no' => $out_trade_no));	
		
		}
		//************************* 2015-11-24 增加 end	


		return true;
	}
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);
