<?
//2014-01-03 배종영
//	@extract($HTTP_POST_VARS);
//	@extract($_GET);
//	@extract($_POST);
//	@extract($_REQUEST);
//	@extract($_SERVER);

	$down			= $_REQUEST["down"];
	$board_name		= $_REQUEST["board_name"];
	$file_name		= $_REQUEST["file_name"];
	$size			= $_REQUEST["size"];

	if ($down) {
#	파일 읽기	 	------------------------------------------------------------------------------------
		if (is_file($_SERVER[DOCUMENT_ROOT]."/".$board_name."/".$down)) {
			$fp = fopen($_SERVER[DOCUMENT_ROOT]."/".$board_name."/".$down,"r");
			$filedata = fread($fp,$size);
			fclose($fp);
		}

		header("Content-type: application/octet-stream");
		header("Content-disposition: attachment; filename=".$file_name);
		header("Pragma: no-cache");
		header("Expires: 0");
		print $filedata;
		exit;
	}
	$down = "";
?>
