<?php
/**
* $Author: dzf $
* ============================================================================
* smarty开发自定义数据库查询模板标签
* 网站地址: http://www.jinjingw.com
* ============================================================================
*/
function smarty_block_get($params, $content, $template, &$repeat) {
	global $_TGLOBAL;
	extract($params);

	if (!isset($return))
		$return = 'r'; // 返回的变量数组名,
	if (!isset($sql))
		return '';

	$rows = isset($rows) ? (int) $rows : 20;

	// 对象$_TGLOBAL['tpl']上注册一个数组以供block使用
	if (!isset($_TGLOBAL['tpl']->blocksdata)) {
		$_TGLOBAL['tpl']->blocksdata = array();
	}
	
	// 得一个本区块的专属数据存储空间
	$dataindex = md5( __FUNCTION__ . md5(serialize($params)));
	$dataindex = substr($dataindex, 0, 16 );
	// 使用$_TGLOBAL['tpl']->blocksdata[$dataindex]来存储
	// 充数据
	if (!$_TGLOBAL['tpl']->blocksdata[$dataindex]) {
		// ***********************************************************************
		// 要数据填充区

		// 是否分页
		if (isset($pages)) {

			$pagestr = $pages;
			global $$pages; // 传递分页变量,如:page=2中的page
			$page = $_GET[$pages];
			$page = (int) $page;
			$page<1 && $page = 1;
			$page_num = ($page - 1) * $rows;

			//include_once (CMS_PATH . 'includes/page.class.php');

			$total_num = $_TGLOBAL['db']->num_rows($_TGLOBAL['db']->query($sql));
			//$total_page = ceil($total_num / $rows);
			//$total_page = (!$total_page) ? 1 : $total_page;
			//$pagesset = new pages ( $total_num, $rows, "page", $page );
			//$pagesset->setAnotherpage ( 0 ); // 0为不显示下拉分页
			//$pagesstr = $pagesset->show ( 2 );
			$pagesstr = multi($total_num, $rows, $page, get_current_url());
			$_TGLOBAL['tpl']->assign($pagestr . 's', $pagesstr);

			// 页数大于总页数自动跳转到尾页
			if ($page > $total_page && $total_page > 0) {
				$url = basename($_SERVER ["PHP_SELF"]);
				$aqs = $_SERVER["QUERY_STRING"]; // 网址查询参数
				if (!empty($aqs))
				@header ( 'location:' . $url . '?' . preg_replace ( '/page=(\d+)/i', "page={$total_page}", $aqs ) );
			}

			$rs = $_TGLOBAL['db']->getall( $sql . ' LIMIT ' . $page_num . ',' . $rows );
		} else {
			$rs = $_TGLOBAL['db']->getall( $sql . ' LIMIT 0,' . $rows );
		}
		//echo $sql;die;
		// 添加数组索引
		for($i = 0; $i < count($rs); $i++) {
			$rs[$i]['thumb'] = getthumbimg($rs[$i]['img']);;
			$rs[$i]['index'] = $i;
			$rs[$i]['iteration'] = $i + 1;
			$rs[$i]['first'] = $i === 0;
			$rs[$i]['last'] = $i === count($rs) - 1;
		}

		$_TGLOBAL['tpl']->blocksdata [$dataindex] = $rs;

		// 充区完成
		// ***********************************************************************
	}
	// 果没有数据，直接返回null,不必再执行了
	if (!$_TGLOBAL['tpl']->blocksdata [$dataindex]) {
		$repeat = false;
		return '';
	}
	// 一条数据出栈，并把它指派给$return，重复执行开关置位1

	if (list($key, $item) = each($_TGLOBAL['tpl']->blocksdata[$dataindex])) {
		$_TGLOBAL['tpl']->assign($return, $item );
		$repeat = true;
	}
	// 果已经到达最后，重置数组指针，重复执行开关置位0
	if (!$item) {
		reset($_TGLOBAL['tpl']->blocksdata[$dataindex]);
		$repeat = false;
	}
	// 印内容
	print $content;
}
?>