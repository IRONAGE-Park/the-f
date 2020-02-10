<?
@extract($_GET); 
@extract($_POST); 

############### DB 정보를 가지고 온다 ####################
  if($uid) {		 
	 $row_board = get_tb_board($uid,$tablename); //func_other.php 에서 호출 해서 게시판 정보 가지고 온다 
	 if(!$row_board['uid']) {
		 $common->error("관련된 정보가 없습니다.","previous","");
	 }

	if($SITE_ADMIN_LEVEL!="1") {	
		if($row_board['pass']!=$SITE_ADMIN_MID) {
			 $common->error("수정 권한이 없습니다.","previous","");
		}
	}
  }
  ?>
<?if(!$row_board['uid']) {?>
<!-- 등록인경우 -->
<form name="signform" method="post" action="<?echo" $_SERVER[PHP_SELF]"?>" onSubmit="return boardWritecheck()"
	ENCTYPE="multipart/form-data">
	<input type="hidden" name="formmode" value="save">
	<input type="hidden" name="conf" value="<?=$conf?>"><!-- 환경설정파일  -->
	<input type="hidden" name="bmain" value="ok">
	<?} else {?>
	<!-- 수정인경우 -->
	<form name="signform" method="post" action="<?echo" $_SERVER[PHP_SELF]"?>" onSubmit="return boardWritecheck()"
		ENCTYPE="multipart/form-data">
		<input type="hidden" name="formmode" value="modify">
		<input type="hidden" name="uid" value="<?=$uid?>">
		<input type="hidden" name="conf" value="<?=$conf?>"><!-- 환경설정파일  -->
		<input type="hidden" name="bmain" value="ok">
		<?}?>

		<table align="center" cellpadding="0" cellspacing="0">
			<?if($TOPTYPE=="Y"){?>
			<tr>
				<td width="150" height="50">
					<font class="T4">ㆍ상단출력</font>
				</td>
				<td width="730"><input type="checkbox" name="topview" value="Y" class="border"
						<?if($row_board['topview']=="Y" ) echo"checked";?>></td>
			</tr>
			<?}?>

			<?if($MODEUSETYPE=="Y"){?>
			<tr>
				<td height="50">
					<font class="T4">ㆍ분류</font>
				</td>
				<td>
					<select name="mode" class="FORM1">
						<option value="">- 분류 -</option>
						<? for($j=1;$j<=count($ARR_BOARD_TYPE);$i++,$j++) { ?>
						<option value="<?=$j?>" <?if($row_board['mode']=="$j" ) echo"selected";?>
							><?=$ARR_BOARD_TYPE[$j]?></option>
						<?}?>
					</select>
				</td>
			</tr>
			<?}?>
			<!-- 비밀번호 --><input type="hidden" name="pass" size="30" maxlength="20" class="FORM1"
				value="<?=$SITE_ADMIN_MID?>">
			<?if($KEYUSETYPE=="Y") {?>
			<tr>
				<td height="50">
					<font class="T4">ㆍ비밀글설정</font>
				</td>
				<td><input type="checkbox" name="keytype" value="Y" <?if($row_board['keytype']=="Y" ) echo"checked" ?> >
				</td>
			</tr>
			<?}?>

			<tr>
				<td height="50">
					<font class="T4">ㆍ출력여부</font>
				</td>
				<td>
					<input type="radio" name="viewtype" value="Y" <?if($row_board['viewtype']=="Y" ) echo"checked";
						if(!$row_board['viewtype'])echo"checked";?> > 출력
					<input type="radio" name="viewtype" value="N" <?if($row_board['viewtype']=="N" ) echo"checked"; ?>>
					숨기기
				</td>
			</tr>
			<tr>
				<td height="50">
					<font class="T4">ㆍ이름</font>
				</td>
				<td><input type="text" name="uname" size="20" maxlength="30" class="FORM1"
						value="<?if($row_board['uname'])echo" $row_board[uname]"; else echo"$SITE_ADMIN_NAME";?>"></td>
			</tr>
			<tr>
				<td height="50" width="150">
					<font class="T4">ㆍ제목</font>
				</td>
				<td width="730"><input type="text" name="title" size="80" maxlength="250" class="FORM1"
						value="<?=$row_board['title']?>"></td>
			</tr>
			<?if($CONTENT2TYPE=="Y") { ?>
			<tr>
				<td height="140" width="150">
					<font class="T4">ㆍ요약글</font>
				</td>
				<td width="730"><textarea name="content1" rows=8
						cols=60><?=stripslashes($row_board['content1'])?></textarea></td>
			</tr>
			<?}?>
			<tr>
				<td height="50" width="150">
					<font class="T4">ㆍ내용</font>
				</td>
				<td>
					<textarea id="editor1" name="content"
						class="ckeditor"><?=stripslashes($row_board['content'])?></textarea>
					<script>
						CKEDITOR.replace('editor1', {
							customConfig: '<?=$PATH_INFO?>/ckeditor/config.js',
							width: '900',
							height: '350',
							filebrowserImageUploadUrl: '<?=$PATH_INFO?>/ckeditor/ckeditor_upload.php?type=Images&CKEditor=editor1&CKEditorFuncNum=1&langCode=ko'
						});
					</script>
				</td>
			</tr>
			<?if($REFUSETYPE=="Y") {?>
			<tr>
				<td height="50">
					<font class="T4">ㆍ조회수</font>
				</td>
				<td><input type="text" name="ref" size="15" maxlength="10" class="FORM1"
						value="<?if(!$row_board['ref'])echo" 0"; else echo"$row_board[ref]";?>"></td>
			</tr>
			<?} else {?>
			<input type="hidden" name="ref" size="15" maxlength="10" class="FORM1" value="<?if(!$row_board['ref'])echo"
				0"; else echo"$row_board[ref]";?>">
			<?}?>

			<tr>
				<td height="50">
					<font class="T4">ㆍ등록일자</font>
				</td>
				<td><input type="text" name="reg_date" size="20" maxlength="70"
						<?if($row_board['reg_date']){?>value="<?=$row_board['reg_date']?>"
					<?} else {?>value="<?=date("Y-m-d H:i:s");?>"
					<?}?> class="FORM1" readonly></td>
			</tr>
			<tr>
				<td height="50">
					<font class="T4">ㆍ첨부파일</font>
				</td>
				<td>
					<?if($tablename=="tb_board1") echo "리스트&nbsp;&nbsp;&nbsp;";?>
					<input type="file" name="fileadd" size=50>
					<?if($row_board['fileadd_name']) {
				$row_board['fileadd_size'] = filesize("$ROOT_PATH/$tablefile/$row_board[fileadd_name]");	
			?>
					삭제 <input type="checkbox" name="delimg_1" value="Y" class="border">
					<?echo"<a href='$PHP_SELF?down=$row_board[fileadd_name]&file_name=$row_board[fileadd_name]&size=$row_board[fileadd_size]&board_name=$tablefile'>"?><?=$row_board['fileadd_org']?></a>
					<?}?>
					<?if($tablename=="tb_board1") echo "내용보기";?>
					<input type="file" name="fileadd1" size=50>
					<?if($row_board['fileadd1_name']) {
				$row_board['fileadd1_size'] = filesize("$ROOT_PATH/$tablefile/$row_board[fileadd1_name]");	
			?>
					삭제 <input type="checkbox" name="delimg_2" value="Y" class="border">
					<?echo"<a href='$PHP_SELF?down=$row_board[fileadd1_name]&file_name=$row_board[fileadd1_name]&size=$row_board[fileadd1_size]&board_name=$tablefile'>"?><?=$row_board['fileadd1_org']?></a>
					<?}?>
				</td>
			</tr>
		</table>
		<table border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="right">
					<button class="admin-button submit">제출</button>
					<a class="admin-button" href="<?echo" $_SERVER[PHP_SELF]?bmain=list"?>">취소</a>
				</td>
			</tr>
		</table>
	</form>