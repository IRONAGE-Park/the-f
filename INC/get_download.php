<?php
 require_once($_SERVER[DOCUMENT_ROOT]."/INC/get_session.php");
 require_once($_SERVER[DOCUMENT_ROOT]."/INC/dbConn.php");

        $nums_val = escape_string($_REQUEST['n']);

            $que = "select * FROM splus_study_qna WHERE uid='".$nums_val."'";
            $viewName = $db->row($que);

        $fileDiv = explode("/",$viewName[filename]);
        $fileDivCnt = count($fileDiv);
        $filename = $fileDiv[$fileDivCnt-1];

        $path = "..".$viewName[filename];

        #파일 읽기 ------------------------------------------------------------------------------------
        if (is_file($path)) {
            $fp = fopen($path,"r");
            $filedata = fread($fp,filesize($path));
            fclose($fp);
        }

        header("Content-type: application/octet-stream");
        header("Content-Transfer-Encoding: binary\n");
        header("Content-disposition: attachment; filename=".$filename);
        header("Pragma: no-cache");
        header("Expires: 0");
        print $filedata;
        exit;

?>
