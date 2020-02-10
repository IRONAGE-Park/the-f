  <?
############### DB 정보를 가지고 온다 ####################
  if($uid) {		 
	 $row_board = get_tb_board($uid,$tablename); //func_other.php 에서 호출 해서 게시판 정보 가지고 온다 
	 if(!$row_board['uid']) {
		 $common->error("관련된 정보가 없습니다.","previous","");
	 }

  }
  ?>
  <?if($row_board['uid']) {?>
	  <!-- 삭제인경우 -->
	  <form name="signform" method="post" action="<?echo"$_SERVER[PHP_SELF]"?>" onSubmit="return boardDelcheck()"  ENCTYPE="multipart/form-data">
	  <input type="hidden" name="uid" value="<?=$uid?>">
	  <input type="hidden" name="conf" value="<?=$conf?>"><!-- 환경설정파일  -->
	  <input type="hidden" name="bmain" value="login_ok">
  <?}?>


	<table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
	 <td height="440" valign="top" style="background-image:url(../img/pw.jpg); background-position:top left; background-repeat:no-repeat; padding:40px 0">
	  
		  <table border="0" cellspacing="0" cellpadding="0">

		   <tr>
			<td height="52"><span class="b f16 c333">비밀번호를 입력해주세요.</span></td>
		   </tr>
		   <tr>
			<td><input type="password" name="pass" id="" class="input2"></td>
		   </tr>
		   <tr>
			<td style="padding:5px 0"><a class='thef-button' href="javascript:;" onClick="boardDelcheck();" >확인</a></td>
		   </tr>
		  </table>
		  
	  </td>
     </tr>
    </table>

</form>
