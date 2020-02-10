<?  require_once("../include/header.php");
	require_once("./common_head.html");

$reg_date = date("Y-m-d H:i:s");

if($uid) {

	//일괄 변경인 경우 처리 
	if($state=="OUT") {
		### 탈퇴 상태로 변경 
		$uid_value = explode(",",$uid);	//선택한 저장 해서 순서대로 처리

		while(list($key,$uid) = each($uid_value)) {

			$tran_query[0] = "UPDATE $tablecode SET state='O',out_date='$reg_date' WHERE uid='$uid'";
			$tran_result = $db->tran_query( $tran_query );
			$suss_msg = "탈퇴 상태로 변경 되었습니다.";
		}

	} else if($state=="IN") {	
		### 탈퇴회원 복원
		$uid_value = explode(",",$uid);	//선택한 저장 해서 순서대로 처리
		while(list($key,$uid) = each($uid_value)) {
			$tran_query[0] = "UPDATE $tablecode SET state='Y',out_date='' WHERE uid='$uid'";
			$tran_result = $db->tran_query( $tran_query );
			$suss_msg = "탈퇴회원을 복원 되었습니다.";
		}
	} else if($state=="DEL") {	
		### 탈퇴회원 완전 삭제
		$uid_value = explode(",",$uid);	//선택한 저장 해서 순서대로 처리
		while(list($key,$uid) = each($uid_value)) {
			
			//탈퇴 상태에서 완전삭제
			$query_s= "SELECT * FROM $tablecode WHERE uid='".$uid."' ORDER BY uid DESC LIMIT 1";
			$result_s = $db->row( $query_s );
			if($result_s[state]=="O") {
				
				### 탈퇴테이블에 정보 삽입 ########
				$tran_query[0] = "INSERT INTO tb_memberout (uid,mid,state,ulevel,uname,tb_cname_uid,content,reg_date,out_date) VALUES ('$new_uid','$result_s[mid]','$result_s[state]','$result_s[ulevel]','$result_s[uname]','$result_s[tb_cname_uid]','$result_s[content]','$result_s[reg_date]','$result_s[out_date]')";
				$tran_result = $db->tran_query( $tran_query );

				$tran_query[0] = "DELETE FROM  $tablecode WHERE uid='$uid'";
				$tran_result = $db->tran_query( $tran_query );

				$suss_msg = "탈퇴회원을 완전히 삭제 하였습니다.";
			}
		}

	} else if($state=="ADMINDEL") {	
		### 탈퇴회원 완전 삭제
		$uid_value = explode(",",$uid);	//선택한 저장 해서 순서대로 처리
		while(list($key,$uid) = each($uid_value)) {
			
			//탈퇴 상태에서 완전삭제
			$query_s= "SELECT * FROM $tablecode WHERE uid='".$uid."' ORDER BY uid DESC LIMIT 1";
			$result_s = $db->row( $query_s );
			if($result_s[state]=="O") {
			
				$tran_query[0] = "DELETE FROM  $tablecode WHERE uid='$uid'";
				$tran_result = $db->tran_query( $tran_query );

				$suss_msg = "탈퇴회원을 완전히 삭제 하였습니다.";
			}
		}
	}
} else {

	if($tablecode=="tb_member") {
		$row_member = get_tb_member($uid); //func_other.php 에서 호출 해서 학습관 정보 가지고 온다 
	} else if($tablecode=="tb_master") {
		$row_member = get_tb_master($mid); //func_other.php 에서 호출 해서 학생 정보 가지고 온다 
	}

	if($row_member[state]=="Y" and $state=="Y") {
		### 정상 경우 불량 상태로 변경 
		$tran_query[0] = "UPDATE $tablecode SET state='N' WHERE uid='$uid'";
		$tran_result = $db->tran_query( $tran_query );
		$suss_msg = "미승인 상태로 변경 되었습니다.";
	}else if($row_member[state]=="N" and $state=="N") {
		### 불량상태인 경우 승인 상태로 변경 	
		$tran_query[0] = "UPDATE $tablecode SET state='Y' WHERE uid='$uid'";
		$tran_result = $db->tran_query( $tran_query );
		$suss_msg = "정상 회원으로 변경 되었습니다";

	}else if($row_member[state]=="O" and $state=="O" and $uid) {
		### 미승인상태인 경우 승인 상태로 변경 
		$tran_query[0] = "UPDATE $tablecode SET state='Y',out_date='' WHERE uid='$uid'";
		$tran_result = $db->tran_query( $tran_query );
		$suss_msg = "정상 회원으로 변경 되었습니다.";
	}else if($row_member[state]=="D" and $state=="D" and $uid) {
		### 삭제상태인 경우 승인 상태로 변경 
		$tran_query[0] = "UPDATE $tablecode SET state='Y',out_date='' WHERE uid='$uid'";
		$tran_result = $db->tran_query( $tran_query );
		$suss_msg = "정상 회원으로 변경 되었습니다.";
	}else if($row_member[state]=="O" and $state=="O" and !$uid) {
		### 탈퇴상태인 경우 승인 상태로 변경  
		$tran_query[0] = "UPDATE $tablecode SET state='Y',out_date='' WHERE mid='$mid'";
		$tran_result = $db->tran_query( $tran_query );
		$suss_msg = "정상 회원으로 변경 되었습니다.";
	}
}

?>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<!-- 본문컨텐츠부분 시작 -->
<table width="300" height="150" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top" bgcolor="#FFFFFF">
	  <table width="300" height="32" border="0" cellpadding="10" cellspacing="0">
        <tr> 
          <td width="275" height="32" bgcolor="a6c070"><font color="#FFFFFF" class="T8">상태변경처리 </font></td>
          <td width="25" bgcolor="a6c070"><a href="javascript:parent.fancyboxClose();parent.location.reload();"><img src="./img/admin_38.gif"  border="0"></a></td>
        </tr>
      </table>
      <br> <table width="300" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="275" height="22"><div align="center"><strong><?=$suss_msg?></strong></div></td>
        </tr>
      </table>
      <br> <table width="117" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td  align="center">
            <a href="javascript:parent.fancyboxClose();parent.location.reload();"><img src="./img/btn_1.gif" width="55" height="25" border="0"></a> 
        </tr>
      </table>
    </td>
  </tr>
</table>
<!-- 본문컨텐츠부분 끝 -->
</body>
</html>
<?
if($suss_msg) {
	$common->error("$suss_msg","parent_reload","");
}
?>
