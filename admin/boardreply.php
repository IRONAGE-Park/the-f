<?
@extract($_GET); 
@extract($_POST); 
############### DB 정보를 가지고 온다 ####################
  if($uid) {		 
	 $row_board = get_tb_board($uid,$tablename); //func_other.php 에서 호출 해서 게시판 정보 가지고 온다 
	 if(!$row_board[uid]) {
		 $common->error("관련된 정보가 없습니다.","previous","");
	 }
  }
  ?>
	  <!-- 등록인경우 -->
	  <form name="signform" method="post" action="<?echo"$_SERVER[PHP_SELF]"?>"  onSubmit="return boardWritecheck()" ENCTYPE="multipart/form-data">
	  <input type="hidden" name="formmode" value="reply">
	  <input type="hidden" name="conf" value="<?=$conf?>"><!-- 환경설정파일  -->
	  <input type="hidden" name="thread" value="<?=$row_board[thread]?>">
	  <input type="hidden" name="fidnum" value="<?=$row_board[fidnum]?>">
	  <input type="hidden" name="bmain" value="ok">
	  

      <table width="880" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="1" colspan="2" bgcolor="#b1b1b1"></td>
        </tr>
		
		<?if($TOPTYPE=="Y"){?>
        <tr> 
          <td height="35"><font class="T4">ㆍ상단출력</font></td>
          <td><input type="checkbox" name="topview" value="Y" class="border" ></td>
        </tr>
		<tr>
          <td height="1" colspan="2" bgcolor="#ebebeb"></td>
        </tr>
		<?}?>
		
		<?if($MODEUSETYPE=="Y"){?>
        <tr> 
          <td height="35"><font class="T4">ㆍ분류</font></td>
          <td>
			<select name="mode" class="FORM1">
					<option value="">- 분류 -</option>
				<? for($j=1;$j<=count($ARR_BOARD_TYPE);$i++,$j++) { ?>
					<option value="<?=$j?>" <?if($row_board[mode]=="$j") echo"selected";?>><?=$ARR_BOARD_TYPE[$j]?></option>
				<?}?>
			</select>
		  </td>
        </tr>
		<tr>
          <td height="1" colspan="2" bgcolor="#ebebeb"></td>
        </tr>
		<?}?>		
		<!-- 비밀번호 --><input type="hidden" name="pass" size="30" maxlength="20" class="FORM1" value="<?=$SITE_ADMIN_MID?>">
		<?if($KEYUSETYPE=="Y") {?>
        <tr> 
          <td height="35"><font class="T4">ㆍ비밀글설정</font></td>
          <td><input type="checkbox" name="keytype" value="Y"  ></td>
        </tr>
		<tr>
          <td height="1" colspan="2" bgcolor="#ebebeb"></td>
        </tr>
		<?}?>		
        <tr> 
          <td height="35"><font class="T4">ㆍ출력여부</font></td>
          <td>	
			<input type="radio" name="viewtype" value="Y" checked > 출력
			<input type="radio" name="viewtype" value="N"> 숨기기 
		  </td>
        </tr>
		<tr>
          <td height="1" colspan="2" bgcolor="#ebebeb"></td>
        </tr>
        <tr> 
          <td height="35"><font class="T4">ㆍ이름</font></td>
          <td><input type="text" name="uname" size="20" maxlength="30" class="FORM1" value="<?=$SITE_ADMIN_NAME?>"></td>
        </tr>
		<tr>
          <td height="1" colspan="2" bgcolor="#ebebeb"></td>
        </tr>
        <tr> 
          <td height="35" width="150"><font class="T4">ㆍ제목</font></td>
          <td width="730"><input type="text" name="title" size="80" maxlength="250" class="FORM1" ></td>
        </tr>
		<tr>
          <td height="1" colspan="2" bgcolor="#ebebeb"></td>
        </tr>
        <tr> 
          <td height="35"><font class="T4">ㆍ원글내용</font></td>
          <td style="padding:5px;5px;5px;5px;"><?=stripslashes($row_board[content])?></td>
        </tr>
		<tr>
          <td height="1" colspan="2" bgcolor="#ebebeb"></td>
        </tr>
        <tr> 
          <td colspan=2 align=center>
			<textarea id="editor1" name="content" class="ckeditor"></textarea>
			<script>
			CKEDITOR.replace('editor1', {
			customConfig : '/ckeditor/config.js',
			width:'870',
			height:'350',
			filebrowserImageUploadUrl: '/ckeditor/ckeditor_upload.php?type=Images&CKEditor=editor1&CKEditorFuncNum=1&langCode=ko'
			});
			</script>
		  </td>
        </tr>
        <tr> 
          <td height="1" colspan="2" background="../images/bbs1_3.gif"></td>
        </tr>
		<?if($REFUSETYPE=="Y") {?>
        <tr> 
          <td height="35"><font class="T4">ㆍ조회수</font></td>
          <td><input type="text" name="ref" size="15" maxlength="10" class="FORM1" value="0"></td>
        </tr>
		<tr>
          <td height="1" colspan="2" bgcolor="#ebebeb"></td>
        </tr>
		<?} else {?>
			<input type="hidden" name="ref" size="15" maxlength="10" class="FORM1" value="<?if(!$row_board[ref])echo"0"; else echo"$row_board[ref]";?>">
		<?}?>
        <tr> 
          <td height="35"><font class="T4">ㆍ등록일자</font></td>
          <td><input type="text" name="reg_date" size="20" maxlength="70" value="<?=date("Y-m-d H:i:s");?>" class="FORM1" readonly></td>
        </tr>
		<tr>
          <td height="1" colspan="2" bgcolor="#ebebeb"></td>
        </tr>
        <tr> 
          <td height="50"><font class="T4">ㆍ첨부파일</font></td>
          <td>
			<input type="file" name="fileadd" size=50 > 
			<br>
			<input type="file" name="fileadd1" size=50> 			
		  </td>
        </tr>
        <tr>
          <td height="1" colspan="2" bgcolor="#b1b1b1"></td>
        </tr>
      </table>
      <br /> <br /> 
	  <table width="880" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="55" align=right><input type="image"  src="./img/btn_9.gif" border="0" /> 
              <a href="<?echo"$_SERVER[PHP_SELF]?bmain=list"?>"><img src="./img/btn_2.gif" border="0" /> 
              </a></div></td>
        </tr>
      </table></form>
