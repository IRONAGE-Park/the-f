<?
############### DB 정보를 가지고 온다 ####################
  if($uid) {		 
	 $row_board = get_tb_board($uid,$tablename); //func_other.php 에서 호출 해서 게시판 정보 가지고 온다 
	 if(!$row_board['uid']) {
		 $common->error("관련된 정보가 없습니다.","previous","");
	 }

	 ##### 게시물 조회수 올림 #########
	 get_tb_ref($tablename,"ref",$uid);

	 if($MODEUSETYPE=="Y") {
		 $row_board_mode = "[".$ARR_BOARD_TYPE[$row_board['mode']]."]";
	 }
  }
?>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td align="center" valign="top" style="padding:0 0 30px 0">
	<?
		###### 포토게시판인 경우 이미지 출력 ######
		if($row_board['fileadd_name']) {
			$file_size=GetImageSize("$ROOT_PATH/$tablefile/$row_board[fileadd_name]");
			if($file_size[0] > 830) $img_width = "830";
			else  $img_width = "$file_size[0]";
			//<a class=\"fancybox-effects-d\" href=\"$HOME_PATH/$tablefile/$row_board[fileadd_name]\" title=\"$row_board[title]\">
			$board_img = "<img src='$HOME_PATH/$tablefile/$row_board[fileadd_name]' border=0  width='$img_width'><br><br>";
			//echo "$board_img";
		}
		if($row_board['fileadd1_name']) {
			$file_size=GetImageSize("$ROOT_PATH/$tablefile/$row_board[fileadd1_name]");
			if($file_size[0] > 830) $img_width1 = "830";
			else  $img_width1 = "$file_size[0]";
			//<a class=\"fancybox-effects-d\" href=\"$HOME_PATH/$tablefile/$row_board[fileadd1_name]\" title=\"$row_board[title]\">
			$board_img = "<img src='$HOME_PATH/$tablefile/$row_board[fileadd1_name]' border=0  width='$img_width1'><br><br>";
			echo "$board_img";
		}
	?>
	  <?
		if($row_board['tegtype']=="N") {
			$row_board['content'] = nl2br($row_board['content']);
		}
		$row_board['content'] = stripslashes($row_board['content']);
	  ?>
		<?=$row_board['content']?>
	  </td>
     </tr>
     <tr>
      <td align="center" class="last_border"><a href="list.php"><img src="../img/button/list.gif"></a></td>
     </tr>
    </table>