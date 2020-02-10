<?php include "../include/header.php"; 
@extract($_GET); 
@extract($_POST); 

############ 해당 부분 환경 설정 파일 ######
if($conf) {
	include "./conf/conf_".$conf.".php";
}


	//인젝션
	$board_num	= escape_string($_REQUEST['board_num'],1);	
	$content	= escape_string($_REQUEST['content'],1);	

	$reg_date = date("Y-m-d H:i:s");


    switch( $formmode ){        
        case 'save' :  

			if(!$content) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}
			########### 저장하기 처리 ##################		
			$query1= "SELECT max(uid), max(fidnum) FROM $memo_tablename";
			$row1 =  $db->fetch_row($query1);
				if($row1[0])	$new_uid = $row1[0] + 1; else $new_uid = 1;
				if($row1[1]) $new_fidnum = $row1[1] + 1; else $new_fidnum = 1;

			 
			$tran_query[0] = "INSERT INTO $memo_tablename (uid,board_uid,tablename,mid,pass,uname,content,fidnum,thread,reg_date) VALUES ('$new_uid','$board_uid','$tablename','$SITE_ADMIN_MID','$SITE_ADMIN_MID','$SITE_ADMIN_NAME','$content','$new_fidnum','A','$reg_date')";
			$tran_result = $db->tran_query( $tran_query );

			if ( $tran_result == "1" ) {			
				$common->error("처리 되었습니다.","goto_no_alert","$_SERVER[PHP_SELF]?bmain=list&conf=$conf&board_uid=$board_uid");
			} else {
				$common->error("등록 실패 되었습니다","previous","");
			}
			
        break;
       

        case 'reply' :  

		########### 답변 하기 처리 ##################		
		$reply_content_a = "reply_content_".$g;
		$reply_content = $$reply_content_a;

			if(!$reply_content) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}

			$query = "SELECT thread,right(thread,1) as thread_1 FROM $memo_tablename WHERE fidnum = $fidnum AND length(thread) = length('$thread')+1 AND locate('$thread',thread) = 1 ORDER BY thread DESC LIMIT 1";
			$result =  $db->select_one($query); 
	
			if($result[thread]) {    
				$row =  $db->fetch_row($query); 
				$thread_head = substr($row[0],0,-1);
				$thread_foot = ++$row[1];       
				$new_thread = $thread_head . $thread_foot;
			} else {
				$new_thread = $thread . "A";
			}

			########### 저장하기 처리 ##################		
			$query1= "SELECT max(uid) FROM $memo_tablename";
			$row1 =  $db->fetch_row($query1);
				if($row1[0])	$new_uid = $row1[0] + 1; else $new_uid = 1;

				
			$tran_query[0] = "INSERT INTO $memo_tablename (uid,board_uid,tablename,mid,pass,uname,content,fidnum,thread,reg_date) VALUES ('$new_uid','$board_uid','$tablename','$SUPLUS_ADMIN_MID','$SUPLUS_ADMIN_MID','$SUPLUS_ADMIN_NAME','$reply_content','$fidnum','$new_thread','$reg_date')";
			$tran_result = $db->tran_query( $tran_query );

			if ( $tran_result == "1" ) {
				$common->error("처리 되었습니다.","goto_no_alert","$_SERVER[PHP_SELF]?bmain=list&conf=$conf&board_uid=$board_uid");
			} else {
				$common->error("등록 실패 되었습니다","previous","");
			}
			

        break;


        case 'delete' :  

		########### 삭제하기 하기 처리 ##################		
			if(!$uid) {
				$common->error("내용이 없습니다. ","previous","");	
			}
	
			########## 선택한 글을 삭제 한다 ################
			$tran_query[0] = "DELETE FROM  $memo_tablename WHERE uid='$uid'";
			$tran_result = $db->tran_query( $tran_query );

			$common->error("삭제 되었습니다.","goto_no_alert","$_SERVER[PHP_SELF]?bmain=list&conf=$conf&board_uid=$board_uid");

        break;

        case 'delete_all' :  
		########### 선택 삭제하기 하기 처리 ##################		
			if(!$uid) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}

			$uid_value = explode(",",$uid);	//선택한 메세지를 배열로 저장 해서 순서대로 지운다		

			while(list($key,$uid) = each($uid_value)) {				


				########## 선택한 글을 삭제 한다 ################
				$tran_query[0] = "DELETE FROM  $memo_tablename WHERE uid='$uid'";
				$tran_result = $db->tran_query( $tran_query );

			}

			
			$suss_msg = "선택 게시물이 삭제 되었습니다.";	
			
			
        break;

		?>


<?
    } //switch end

?>

<?if($formmode=="delete_all") {?>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<!-- 본문컨텐츠부분 시작 -->
	<table width="300" height="150" border="0" cellpadding="0" cellspacing="0">
	  <tr> 
		<td valign="top" bgcolor="#FFFFFF">
		  <table width="300" height="32" border="0" cellpadding="10" cellspacing="0">
			<tr> 
			  <td width="275" height="32" bgcolor="50a7e1"><font color="#FFFFFF" class="T3">상태처리 </font></td>
			  <td width="25" bgcolor="50a7e1"><a href="javascript:parent.fancyboxClose();parent.location.reload();"><img src="../images/btn_1.gif" width="17" height="17" border="0"></a></td>
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
				<a href="javascript:parent.fancyboxClose();parent.location.reload();"><img src="../images/btn_2.gif" width="55" height="25" border="0"></a> 
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
<?}?>