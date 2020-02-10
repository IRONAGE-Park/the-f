<?

	$down			= $_REQUEST["down"];
	$board_name		= $_REQUEST["board_name"];
	$file_name		= $_REQUEST["file_name"];
	$size			= $_REQUEST["size"];

	$file_name = iconv("utf-8", "cp949",$file_name);

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
