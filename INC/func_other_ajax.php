<?php
 include_once ($_SERVER[DOCUMENT_ROOT]."/new/INC/get_session.php");
 include_once ($_SERVER[DOCUMENT_ROOT]."/new/INC/Function.php");
 include_once ($_SERVER[DOCUMENT_ROOT]."/new/INC/dbConn.php");
 include_once ($_SERVER[DOCUMENT_ROOT]."/new/INC/arr_data.php");
 include_once ($_SERVER[DOCUMENT_ROOT]."/new/INC/func_other.php");


    $code = 0;
    $data = "";

    $mode = escape_string($_REQUEST['mode']);

    switch( $mode ){ // ######################################################   
   

        case 'popup_photoview' :
			
			$get_uid  = escape_string($_REQUEST['selNum']);

			$query = "select * from tb_board1 where uid='$get_uid' ";
			$result = $db->row( $query);
			
			$result[content] = iconv("euc-kr","utf-8",nl2br($result[content]));			
			$result[title] = iconv("euc-kr","utf-8",$result[title]);			
			
			$file_size=GetImageSize("$ROOT_PATH/upload/board1/$result[fileadd1_name]");
			if($file_size[0] > 650) $img_width = "650";
			else  $img_width = "$file_size[0]";
			
			$mov_text .= "
				<img src='$HOME_PATH/upload/board1/$result[fileadd1_name]' width='$img_width' alt=''>
				<div class='itemInfo'>
					<p class='tit'>[ $result[title] ]</p>
					<p class='summary'>$result[content]</p>
				</div>
			";				
			exit(json_encode(array('code' => $query, 'msg' => $data,  'movtext' => $mov_text)));

		 break;


  

    } //switch end 
exit;
?>
