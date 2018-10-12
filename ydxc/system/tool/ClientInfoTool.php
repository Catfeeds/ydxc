<?php
/**
 * 客户端工具
 * 创建人：张艺谋
 */
class ClientInfoTool {
	//获取客户端登录IP IV4地址
	function GetClientIP(){
		if (isset($_ENV["HOSTNAME"]))
			$MachineName = $_ENV["HOSTNAME"];
		else if  (isset($_ENV["COMPUTERNAME"]))
			$MachineName = $_ENV["COMPUTERNAME"];
		else $MachineName = "";
		return  gethostbyname($MachineName);
	}
}