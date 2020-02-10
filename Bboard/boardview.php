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
		 $row_board_mode = "[".$ARR_BOARD_TYPE[$row_board[mode]]."]";
	 }
  }


?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
	<td width="60" align="center" class="qna_view01"><span class="b c333">제목</span></td>
	<td colspan="3" class="qna_view01"><span class="b c666"><?=$row_board['title']?></span></td>
	</tr>
   <tr>
	<td width="60" align="center" class="qna_view02"><span class="b c333">작성자</span></td>
	<td class="qna_view02"><?=$row_board['uname']?></td>
	<td width="130" class="qna_view02 m_dis"><span class="b c333">작성일</span>&nbsp;&nbsp;&nbsp;<?=$common->dateStyle(substr($row_board['reg_date'],0,10),".")?></td>
	<td width="80" class="qna_view02 m_dis"><span class="b c333">조회</span>&nbsp;&nbsp;&nbsp;<?=$row_board['ref']?></td>
	</tr>
   <tr>
	<td width="60" align="center" class="qna_view02"><span class="b c333">첨부파일</span></td>
	<td colspan="3" class="qna_view02">
		<?if($row_board['fileadd_name'] OR $row_board['fileadd1_name']) {
			if($row_board['fileadd_name']) $row_board['fileadd_size'] = filesize("$ROOT_PATH/$tablefile/$row_board[fileadd_name]");	
			if($row_board['fileadd1_name']) $row_board['fileadd1_size'] = filesize("$ROOT_PATH/$tablefile/$row_board[fileadd1_name]");	
		?>
		  <? if($row_board['fileadd_name']) { echo"<a href='$PHP_SELF?down=$row_board[fileadd_name]&file_name=$row_board[fileadd_name]&size=$row_board[fileadd_size]&board_name=$tablefile' class='file'>"?><?=$row_board[fileadd_org]?> (<?=number_format($row_board[fileadd_size])?>)</a><?}?>
		  
		   <? if($row_board['fileadd1_name']) { echo"<a href='$PHP_SELF?down=$row_board[fileadd1_name]&file_name=$row_board[fileadd1_name]&size=$row_board[fileadd1_size]&board_name=$tablefile' class='file'>"?><?=$row_board[fileadd1_org]?> (<?=number_format($row_board[fileadd1_size])?>)</a><?}?>

		<?}?>							
	</td>
	</tr>
   <tr>
	<td width="60" align="center" class="qna_view02"><span class="b c333">내용</span></td>
	<td colspan="3" class="qna_view02_01">
			<?if($BOARD_TYPE!="PHOTO") {
				###### 포토게시판인 경우 이미지 출력 ######
				if($row_board['fileadd_name']) {
					$file_size=GetImageSize("$ROOT_PATH/$tablefile/$row_board[fileadd_name]");
					if($file_size[0] > 650) $img_width = "650";
					else  $img_width = "$file_size[0]";
					$board_img = "<a class=\"fancybox-effects-d\" href=\"$HOME_PATH/$tablefile/$row_board[fileadd_name]\" title=\"$row_board[title]\"><img src='$HOME_PATH/$tablefile/$row_board[fileadd_name]' border=0  width='$img_width'></a><br><br>";
					echo "$board_img";
				}
				if($row_board['fileadd1_name']) {
					$file_size=GetImageSize("$ROOT_PATH/$tablefile/$row_board[fileadd1_name]");
					if($file_size[0] > 650) $img_width1 = "650";
					else  $img_width1 = "$file_size[0]";
					$board_img = "<a class=\"fancybox-effects-d\" href=\"$HOME_PATH/$tablefile/$row_board[fileadd1_name]\" title=\"$row_board[title]\"><img src='$HOME_PATH/$tablefile/$row_board[fileadd1_name]' border=0  width='$img_width1'></a><br><br>";
					echo "$board_img";
				}
			}?>
			  <?
				if($row_board['tegtype']=="N") {
					$row_board['content'] = nl2br($row_board['content']);
				}

				$row_board['content'] = stripslashes($row_board['content']);
			  ?>

			  <?=$row_board['content']?>
	</td>
	</tr>
<?if($row_board['content1']) {?>	
   <tr>
	<td width="60" align="center" class="qna_view03"><span class="b c333">답변 <?if($row_board['reply_date'] and $row_board['content1']){?><b>[답변날짜 : <?=$row_board['reply_date']?>]</b><br><br><?}?></span></td>
	<td colspan="3" class="qna_view03_01">
	<?if($BOARD_TYPE!="PHOTO") {
				###### 포토게시판인 경우 이미지 출력 ######
				if($row_board['fileadd_name']) {
					$file_size=GetImageSize("$ROOT_PATH/$tablefile/$row_board[fileadd_name]");
					if($file_size[0] > 650) $img_width = "650";
					else  $img_width = "$file_size[0]";
					$board_img = "<a class=\"fancybox-effects-d\" href=\"$HOME_PATH/$tablefile/$row_board[fileadd_name]\" title=\"$row_board[title]\"><img src='$HOME_PATH/$tablefile/$row_board[fileadd_name]' border=0  width='$img_width'></a><br><br>";
					echo "$board_img";
				}
				if($row_board['fileadd1_name']) {
					$file_size=GetImageSize("$ROOT_PATH/$tablefile/$row_board[fileadd1_name]");
					if($file_size[0] > 650) $img_width1 = "650";
					else  $img_width1 = "$file_size[0]";
					$board_img = "<a class=\"fancybox-effects-d\" href=\"$HOME_PATH/$tablefile/$row_board[fileadd1_name]\" title=\"$row_board[title]\"><img src='$HOME_PATH/$tablefile/$row_board[fileadd1_name]' border=0  width='$img_width1'></a><br><br>";
					echo "$board_img";
				}
			}?>
			  <?
				if($row_board['tegtype']=="N") {
					$row_board['content1'] = nl2br($row_board['content1']);
				}

				$row_board['content1'] = stripslashes($row_board['content1']);
			  ?>
	<?=$row_board['content1']?></td>
	</tr>   
<?}?>
  </table>
	
	<br><br>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td align="center" style="padding:20px 0 50px 0">
			<a class='thef-button' href="<?echo"$_SERVER[PHP_SELF]?bmain=list"?>">목록</a>
			<?if($MEMBER_WRITE=="Y") {?>
				<a class='thef-button' href="<?echo"$_SERVER[PHP_SELF]?bmain=write"?>">글쓰기</a>
			<?}?> 
			<?if($SITE_USER_MID==$row_board['mid']) {?>	
				<a class='thef-button' href="<?echo"$_SERVER[PHP_SELF]?bmain=write&uid=$uid"?>">수정</a>
			<?}?>
			<?if($MEMBER_REPLY=="Y") {?>
				<a class='thef-button' href="<?echo"$_SERVER[PHP_SELF]?bmain=reply&uid=$uid"?>" >답변</a>
			<?}?>

			<?if(!$SITE_USER_MID) {?>
				<?if($MEMBER_WRITE=="Y") {?>
					<a class='thef-button' href="<?echo"$_SERVER[PHP_SELF]?bmain=delete&uid=$uid"?>">삭제</a>
				<?}?>
			<?} else {?>
				<?if($SITE_USER_MID==$row_board['mid']) {?>	
					<a class='thef-button' href="javascript: onClick=contentDel('<?echo"$_SERVER[PHP_SELF]?bmain=ok&conf=$conf&uid=$uid&formmode=delete"?>');" >삭제</a>
				<?}?>
			<?}?>

	 </td>
     </tr>
	</table>


	
	<?
	######## 이전/다음 ##########
	$back_next = Nummove_title($uid,$tablename,"answer");
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td valign="top" style="padding:0 0 50px 0"><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="60" align="center" class="qna_view_list01"><span class="b c333">이전</span></td>
        <td class="qna_view_list01"><a class='thef-button' href="<?if($back_next['backuid']) {?><?echo"$_SERVER[PHP_SELF]?bmain=view&uid=$back_next[backuid]"?><?} else {?>#<?}?>" ><?=$back_next['backtitle']?></a></td>
       </tr>
       <tr>
        <td width="60" align="center" class="qna_view_list02"><span class="b c333">다음</span></td>
        <td class="qna_view_list02"><a class='thef-button' href="<?if($back_next['nextuid']) {?><?echo"$_SERVER[PHP_SELF]?bmain=view&uid=$back_next[nextuid]"?><?} else {?>#<?}?>"><?=$back_next['nexttitle']?></a></td>
       </tr>
    </table>
	</td></tr></table>