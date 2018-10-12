<?php
/**
* $Author: dzf $
* ============================================================================
* smarty�����Զ������ݿ��ѯģ���ǩ
* ��վ��ַ: http://www.jinjingw.com
* ============================================================================
*/
function smarty_block_get($params, $content, $template, &$repeat) {
	global $_TGLOBAL;
	extract($params);

	if (!isset($return))
		$return = 'r'; // ���صı���������,
	if (!isset($sql))
		return '';

	$rows = isset($rows) ? (int) $rows : 20;

	// ����$_TGLOBAL['tpl']��ע��һ�������Թ�blockʹ��
	if (!isset($_TGLOBAL['tpl']->blocksdata)) {
		$_TGLOBAL['tpl']->blocksdata = array();
	}
	
	// ��һ���������ר�����ݴ洢�ռ�
	$dataindex = md5( __FUNCTION__ . md5(serialize($params)));
	$dataindex = substr($dataindex, 0, 16 );
	// ʹ��$_TGLOBAL['tpl']->blocksdata[$dataindex]���洢
	// ������
	if (!$_TGLOBAL['tpl']->blocksdata[$dataindex]) {
		// ***********************************************************************
		// Ҫ���������

		// �Ƿ��ҳ
		if (isset($pages)) {

			$pagestr = $pages;
			global $$pages; // ���ݷ�ҳ����,��:page=2�е�page
			$page = $_GET[$pages];
			$page = (int) $page;
			$page<1 && $page = 1;
			$page_num = ($page - 1) * $rows;

			//include_once (CMS_PATH . 'includes/page.class.php');

			$total_num = $_TGLOBAL['db']->num_rows($_TGLOBAL['db']->query($sql));
			//$total_page = ceil($total_num / $rows);
			//$total_page = (!$total_page) ? 1 : $total_page;
			//$pagesset = new pages ( $total_num, $rows, "page", $page );
			//$pagesset->setAnotherpage ( 0 ); // 0Ϊ����ʾ������ҳ
			//$pagesstr = $pagesset->show ( 2 );
			$pagesstr = multi($total_num, $rows, $page, get_current_url());
			$_TGLOBAL['tpl']->assign($pagestr . 's', $pagesstr);

			// ҳ��������ҳ���Զ���ת��βҳ
			if ($page > $total_page && $total_page > 0) {
				$url = basename($_SERVER ["PHP_SELF"]);
				$aqs = $_SERVER["QUERY_STRING"]; // ��ַ��ѯ����
				if (!empty($aqs))
				@header ( 'location:' . $url . '?' . preg_replace ( '/page=(\d+)/i', "page={$total_page}", $aqs ) );
			}

			$rs = $_TGLOBAL['db']->getall( $sql . ' LIMIT ' . $page_num . ',' . $rows );
		} else {
			$rs = $_TGLOBAL['db']->getall( $sql . ' LIMIT 0,' . $rows );
		}
		//echo $sql;die;
		// �����������
		for($i = 0; $i < count($rs); $i++) {
			$rs[$i]['thumb'] = getthumbimg($rs[$i]['img']);;
			$rs[$i]['index'] = $i;
			$rs[$i]['iteration'] = $i + 1;
			$rs[$i]['first'] = $i === 0;
			$rs[$i]['last'] = $i === count($rs) - 1;
		}

		$_TGLOBAL['tpl']->blocksdata [$dataindex] = $rs;

		// �������
		// ***********************************************************************
	}
	// ��û�����ݣ�ֱ�ӷ���null,������ִ����
	if (!$_TGLOBAL['tpl']->blocksdata [$dataindex]) {
		$repeat = false;
		return '';
	}
	// һ�����ݳ�ջ��������ָ�ɸ�$return���ظ�ִ�п�����λ1

	if (list($key, $item) = each($_TGLOBAL['tpl']->blocksdata[$dataindex])) {
		$_TGLOBAL['tpl']->assign($return, $item );
		$repeat = true;
	}
	// ���Ѿ����������������ָ�룬�ظ�ִ�п�����λ0
	if (!$item) {
		reset($_TGLOBAL['tpl']->blocksdata[$dataindex]);
		$repeat = false;
	}
	// ӡ����
	print $content;
}
?>