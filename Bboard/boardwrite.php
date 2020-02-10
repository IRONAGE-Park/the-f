  <?
############### DB 정보를 가지고 온다 ####################
  if($uid) {		 
	 $row_board = get_tb_board($uid,$tablename); //func_other.php 에서 호출 해서 게시판 정보 가지고 온다 
	 if(!$row_board['uid']) {
		 $common->error("관련된 정보가 없습니다.","previous","");
	 }

	############ 수정 권한이 있는지 확인 ###########
	/*
	if($row_board[mid]!=$SITE_USER_MID) {
		$common->error("수정 권한이 없습니다.","previous","");
	}*/
  }
  ?>
  <?if(!$row_board['uid']) {?>
	  <!-- 등록인경우 -->
	  <form name="signform" method="post" action="<?echo"$_SERVER[PHP_SELF]"?>"  onSubmit="return boardWritecheck()" ENCTYPE="multipart/form-data">
	  <input type="hidden" name="formmode" value="save">	  
	  <input type="hidden" name="conf" value="<?=$conf?>"><!-- 환경설정파일  -->
	  <input type="hidden" name="bmain" value="ok">
	  <input type="hidden" name="ref" value='0'>
  <?} else {?>
	  <!-- 수정인경우 -->
	  <form name="signform" method="post" action="<?echo"$_SERVER[PHP_SELF]"?>" onSubmit="return boardWritecheck()"  ENCTYPE="multipart/form-data">
	  <input type="hidden" name="formmode" value="modify">
	  <input type="hidden" name="uid" value="<?=$uid?>">
	  <input type="hidden" name="conf" value="<?=$conf?>"><!-- 환경설정파일  -->
	  <input type="hidden" name="bmain" value="ok">
  <?}?>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	   <tr>
		<td width="70" class="qna_write01"><span class="b c333">제목</span></td>
		<td colspan="3" class="qna_write01"><input type="text" name="title" size="80" maxlength="250" class="input" value="<?=$row_board['title']?>" style="width:700px"></td>
		</tr>
	<?if($KEYUSETYPE=="Y") {?>
	   <tr>
		<td width="70" class="qna_write02"><span class="b c333">비밀글설정</span></td>
		<td colspan="3" class="qna_write02">
		<?if(!$row_board['keytype']) $row_board['keytype']="Y";?>
		<input type="checkbox" name="keytype" value="Y" <?if($row_board['keytype']=="Y") echo"checked" ?> >
		</td>
		</tr>
	<?}?>
	   <tr>
		<td width="70" class="qna_write02"><span class="b c333">작성자</span></td>
		<td class="qna_write02">
			<input type="text" name="uname" size="20" maxlength="30" class="input" style="width:200px;" value="<?if($row_board['uname'])echo"$row_board[uname]"; else echo"$SUPLUS_ADMIN_NAME";?>">
		</td>
		<td width="70" class="qna_write02"><span class="b c333">비밀번호</span></td>
		<td class="qna_write02">
			<input type="password" id="input03" class="input" name="pass" maxlength="10" style="width:100px;"> <span class="guide">(숫자 4자리)</span>
		</td>
		</tr>
	   <tr>
		<td colspan="4" class="qna_write02">
			<textarea id="editor1" name="content" class="ckeditor"><?=stripslashes($row_board['content'])?></textarea>
			<script>
			CKEDITOR.replace('editor1', {
			customConfig : '/ckeditor/config.js',
			width:'98%',
			height:'350',
			filebrowserImageUploadUrl: '/ckeditor/ckeditor_upload.php?type=Images&CKEditor=editor1&CKEditorFuncNum=1&langCode=ko'
			});
			</script>
		</td>
		</tr>
	   <tr>
		<td width="70" class="qna_write03"><span class="b c333">첨부파일</span></td>
		<td colspan="3" class="qna_write03">
			<input type="file" name="fileadd" size=50 > 
			<?if($row_board['fileadd_name']) {
				$row_board['fileadd_size'] = filesize("$ROOT_PATH/$tablefile/$row_board[fileadd_name]");	
			?>
				삭제 <input type="checkbox" name="delimg_1" value="Y" class="border"> <?echo"<a class='thef-button' href='$PHP_SELF?down=$row_board[fileadd_name]&file_name=$row_board[fileadd_name]&size=$row_board[fileadd_size]&board_name=$tablefile'>"?><?=$row_board['fileadd_org']?></a><?}?>
			<input type="file" name="fileadd1" size=50> 
			<?if($row_board['fileadd1_name']) {
				$row_board['fileadd1_size'] = filesize("$ROOT_PATH/$tablefile/$row_board[fileadd1_name]");	
			?>
				삭제 <input type="checkbox" name="delimg_2" value="Y" class="border"> <?echo"<a class='thef-button' href='$PHP_SELF?down=$row_board[fileadd1_name]&file_name=$row_board[fileadd1_name]&size=$row_board[fileadd1_size]&board_name=$tablefile'>"?><?=$row_board['fileadd1_org']?></a><?}?>
		</td>
		</tr>
	  </table></td>
	 </tr>
	 <tr>
	  <td align="center" style="padding:20px 0 50px 0">
		  <a class='thef-button' href="javascript:;" onClick="boardWritecheck();" >확인</a><a class='thef-button' href="<?echo"$_SERVER[PHP_SELF]?bmain=list"?>">목록</a></td>
	 </tr>
	</table>
	</form>
 