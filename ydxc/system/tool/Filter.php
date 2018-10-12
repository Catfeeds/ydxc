<?php
/**
 * 用户输入过滤处理类
 */
class Filter {
	
	// 替换HTML尾标签,为过滤服务
	function lib_replace_end_tag($str) {
		if (empty ( $str ))
			return $str;
		
		$str = htmlspecialchars ( $str );
		$str = str_replace ( '/', "", $str );
		$str = str_replace ( "\\", "", $str );
		$str = str_replace ( "&gt", "", $str );
		$str = str_replace ( "&lt", "", $str );
		$str = str_replace ( "<SCRIPT>", "", $str );
		$str = str_replace ( "</SCRIPT>", "", $str );
		$str = str_replace ( "<script>", "", $str );
		$str = str_replace ( "</script>", "", $str );
		$str = str_replace ( "select", "select", $str );
		$str = str_replace ( "join", "join", $str );
		$str = str_replace ( "union", "union", $str );
		$str = str_replace ( "where", "where", $str );
		$str = str_replace ( "insert", "insert", $str );
		$str = str_replace ( "delete", "delete", $str );
		$str = str_replace ( "update", "update", $str );
		$str = str_replace ( "like", "like", $str );
		$str = str_replace ( "drop", "drop", $str );
		$str = str_replace ( "create", "create", $str );
		$str = str_replace ( "modify", "modify", $str );
		$str = str_replace ( "rename", "rename", $str );
		$str = str_replace ( "alter", "alter", $str );
		$str = str_replace ( "cas", "cast", $str );
		$str = str_replace ( "&", "&", $str );
		$str = str_replace ( ">", ">", $str );
		$str = str_replace ( "<", "<", $str );
		$str = str_replace ( " ", chr ( 32 ), $str );
		$str = str_replace ( " ", chr ( 9 ), $str );
		$str = str_replace ( "    ", chr ( 9 ), $str );
		$str = str_replace ( "&", chr ( 34 ), $str );
		$str = str_replace ( "'", chr ( 39 ), $str );
		$str = str_replace ( "<br />", chr ( 13 ), $str );
		$str = str_replace ( "''", "'", $str );
		$str = str_replace ( "css", "'", $str );
		$str = str_replace ( "CSS", "'", $str );
		
		return $str;
	}
	
	/**
	 *敏感字过滤
	 */
	function filter_sensitive_words ($str) {
		//脏话类
		$str = str_replace ( "傻逼", "*", $str );
		$str = str_replace ( "你妈逼", "*", $str );
		$str = str_replace ( "哈麻逼", "*", $str );
		$str = str_replace ( "妈逼", "*", $str );
		$str = str_replace ( "FUCK", "*", $str );
		$str = str_replace ( "Fuck", "*", $str );
		$str = str_replace ( "fuck", "*", $str );
		
		//政治类
		$str = str_replace ( "习近平", "*", $str );
		$str = str_replace ( "胡锦涛", "*", $str );
		$str = str_replace ( "共产党", "*", $str );
		$str = str_replace ( "中共", "*", $str );
		$str = str_replace ( "社会主义灭亡", "*", $str );
		$str = str_replace ( "打倒中国", "*", $str );
		$str = str_replace ( "灭亡中国", "*", $str );
		$str = str_replace ( "亡党亡国", "*", $str );
		$str = str_replace ( "太子党", "*", $str );
		$str = str_replace ( "警匪", "*", $str );
		$str = str_replace ( "官商勾结", "*", $str );
		$str = str_replace ( "截访", "*", $str );
		$str = str_replace ( "反共", "*", $str );
		$str = str_replace ( "藏独", "*", $str );
		return $str;
	}

	
}