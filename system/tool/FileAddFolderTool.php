<?php
/**
 * 文件和文件夹工具类
 * 创建人：田洪强
 */
class FileAddFolderTool {
	
	/**
	 * 添加文件夹
	 * 接收：$url:文件夹路径
	 * 返回：success：成功， exist：已经存在
	 */
	public function addFolder($url) {
		if (!file_exists($url)){
			try {

				mkdir ($url, 0777, true);
				return "70";
			} catch (Exception $e) {
				mkdir($url, 0777, true);
				return "70";
			}
			
		} else {
			return "71";
		}
	}
	
	/**
	 *添加文件 
	 *接收：$file:要创建的文件，包括路径
	 * 返回：success：成功， exist：已经存在
	 */
	public function addFile($file) {
		if (file_exists($file) == true) {
			return "72";
		} else {
			$fp=fopen($file, "w+"); //打开文件指针，创建文件
			if ( !is_writable($file) ){
				die("73");
			}
			fclose($fp);  //关闭指针
			return "74";
		}
	}
	
	/**
	 * 向文件中写入值
	 * 接收：$fiel: 文件夹   $content:内容
	 * 
	 * 返回：success：成功， fail:失败， noexist：文件不存在
	 * 
	 */
	public function writFile($file, $content) {
		if (file_exists($file) == true) {
			return "75";
		} else {
			$fJuBing = fopen($file, 'w'); //创建指定文件写操作的句柄
			fwrite($fJuBing, $content);
			fclose($fJuBing);
			return "76";
		}
	}
	
	/**
	 * 删除文件
	 * 
	 * 接收：$file:要删除的文件
	 * 返回：success：成功，  noexist：文件不存在
	 */
	public function deleteFile($file) {
		if (file_exists($file)){
			unlink($file);
			return "77";
		} else {
			return "75";
		}
	}
	
	/**
	 * 创建文件并向其中写入值
	 *
	 * 接收：$file:要创建的文件
	 * 返回：success：成功，  noexist：文件不存在
	 */
	public function createAndWirteFile($file, $content) {
		if (file_exists($file)){
			unlink($file);
		}
		$fp=fopen($file, "w+"); //打开文件指针，创建文件
		fwrite($fp, $content);
		return "78";
	}
}
?>

