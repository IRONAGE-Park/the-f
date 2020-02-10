<?
	require_once($doc_root."/INC/get_session.php");
	require_once($doc_root."/INC/dbConn.php");
	require_once($doc_root."/INC/Function.php");
	require_once($doc_root."/INC/arr_data.php");
	require_once($doc_root."/INC/func_other.php");
	require_once($doc_root."/INC/down.php");			//파일 다운로드
	require_once("./common_head.html");

############ 해당 부분 환경 설정 파일 ######
if($conf) {
	include "./conf/conf_".$conf.".php";
}

	//인젝션
	$tcode		= escape_string($_REQUEST['tcode'],1);	
	$title		= escape_string($_REQUEST['title'],1);	
	$mode		= escape_string($_REQUEST['mode'],1);	
	$viewtype	= escape_string($_REQUEST['viewtype'],1);	
	$pass		= escape_string($_REQUEST['pass'],1);	
	$uname		= escape_string($_REQUEST['uname'],1);	
	$uemail		= escape_string($_REQUEST['uemail'],1);	
	$content	= escape_string($_REQUEST['content'],1);		
	$topview	= escape_string($_REQUEST['topview'],1);	
	$ref		= escape_string($_REQUEST['ref'],1);	
	$keytype	= escape_string($_REQUEST['keytype'],1);	
	$fileadd_name = escape_string($_REQUEST['fileadd_name'],1);	
	$fileadd1_name = escape_string($_REQUEST['fileadd1_name'],1);	
	//$content = addslashes($content);

	$fileadd_name	= $_FILES['fileadd']['name'];		//등록파일명
	$fileadd		= $_FILES['fileadd']['tmp_name'];	//파일임지저장소 
	$fileadd_size	= $_FILES['fileadd']['size'];		//파일크기

	$fileadd1_name	= $_FILES['fileadd1']['name'];		//등록파일명
	$fileadd1		= $_FILES['fileadd1']['tmp_name'];	//파일임지저장소 
	$fileadd1_size	= $_FILES['fileadd1']['size'];		//파일크기


	if(!$reg_date) $reg_date = date("Y-m-d H:i:s");
	$ip_addrs = getenv("REMOTE_ADDR");

	if(!$topview) $topview="N";
	if(!$keytype) $keytype="N";
	if(!$datetype) $datetype="N";
	if($edate)	  $datetype="Y";

    switch( $formmode ){        
        case 'save' :  

			if(!$title) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}

		########### 저장하기 처리 ##################		

			$query1= "SELECT max(uid), max(fidnum) FROM $tablename";
			$row1 =  $db->fetch_row($query1);
				if($row1[0])	$new_uid = $row1[0] + 1; else $new_uid = 1;
				if($row1[1]) $new_fidnum = $row1[1] + 1; else $new_fidnum = 1;

			list($fileadd_name_1,$fileadd_size,$fileadd_org)=$common->Fileadd($new_uid,$tablefile, $fileadd, $fileadd_name);
			list($fileadd_name_2,$fileadd1_size,$fileadd1_org)=$common->Fileadd($new_uid."_1", $tablefile, $fileadd1, $fileadd1_name);
			
		
			 
			$tran_query[0] = "INSERT INTO $tablename (uid,mid,title,mode,viewtype,pass,uname,uemail,content,content1,topview,ref,fidnum,thread,fileadd_name,fileadd_org,fileadd1_name,fileadd1_org,keytype,reg_date) VALUES ('$new_uid','$SITE_ADMIN_MID','$title','$mode','$viewtype','$pass','$uname','$uemail','$content','$content1','$topview','$ref','$new_fidnum','A','$fileadd_name_1','$fileadd_org','$fileadd_name_2','$fileadd1_org','$keytype','$reg_date')";
			
			$tran_result = $db->tran_query( $tran_query );

			if ( $tran_result == "1" ) {
				$common->error("처리 되었습니다.","goto_no_alert","$_SERVER[PHP_SELF]?bmain=list&conf=$conf");
			} else {
				$common->error("등록 실패 되었습니다","previous","");
			}
			
        break;
        case 'modify' :  
		########### 수정 하기 처리 ##################		
			if(!$uid) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}
		

			$query= "SELECT fileadd_name,fileadd1_name FROM $tablename WHERE uid='$uid' ORDER BY uid DESC LIMIT 1";
			$row = $db->row( $query );
				$delimg = "$ROOT_PATH/$tablefile/$row[fileadd_name]";				
				$delimg1 = "$ROOT_PATH/$tablefile/$row[fileadd1_name]";

			####  파일을 다시 등록 했으면 저장한다. ####
			if ($fileadd != ""){	
				############ 첨부화일 저장 하기 ######################
				list($fileadd_name_1,$fileadd_size,$fileadd_org)=$common->Fileadd($uid,$tablefile, $fileadd, $fileadd_name);
				$file_sql = ",fileadd_name='$fileadd_name_1',fileadd_org='$fileadd_org'";
			} else {
				$file_sql = "";
			} 
			if ($fileadd1 != ""){	
				############ 첨부화일 저장 하기 ######################
				list($fileadd_name_2,$fileadd1_size,$fileadd1_org)=$common->Fileadd($uid."_1",$tablefile, $fileadd1, $fileadd1_name);
				$file_sql_1 = ",fileadd1_name='$fileadd_name_2',fileadd1_org='$fileadd1_org'";
			} else {
				$file_sql_1 = "";
			} 

			#### 파일 삭제 체크한 경우 실행 ########
			if($delimg_1=="Y") {				
					######## 이미지 파일들을 삭제 한다 ###################
					if($row['fileadd_name']){ 
						######## 이미지 파일들 삭제 한다 ###################
						if(file_exists($delimg)) {
							if(!unlink($delimg)) {
								$common->error("파일삭제가 실패 되었습니다","previous","");
							}
						}
					}
				$tran_query[0] = "UPDATE $tablename SET  fileadd_name='',fileadd_org='' WHERE uid='$uid'";
				$tran_result = $db->tran_query( $tran_query );
			} 
			if($delimg_2=="Y") {				
					######## 이미지 파일들을 삭제 한다 ###################
					if($row['fileadd1_name']){ 
						######## 이미지 파일들 삭제 한다 ###################
						if(file_exists($delimg1)) {
							if(!unlink($delimg1)) {
								$common->error("파일삭제가 실패 되었습니다","previous","");
							}
						}
					}
				$tran_query[0] = "UPDATE $tablename SET  fileadd1_name='',fileadd1_org='' WHERE uid='$uid'";
				$tran_result = $db->tran_query( $tran_query );
			} 

			if($CONTENT2TYPE=="Y") {
				$content_slq = ",content1='$content1'";
			}


			$tran_query[0] = "UPDATE $tablename SET mid='$SITE_ADMIN_MID',title='$title',mode='$mode',viewtype='$viewtype',pass='$pass',uname='$uname',uemail='$uemail',content='$content',topview='$topview',ref='$ref',keytype='$keytype',reg_date='$reg_date' $file_sql $file_sql_1 $content_slq WHERE uid='$uid'";
			$tran_result = $db->tran_query( $tran_query );

			//echo "<br><Br> $tran_query[0] <br>";

			if ( $tran_result == "1" ) {
				$common->error("수정 되었습니다.  ","goto_no_alert","$_SERVER[PHP_SELF]?bmain=list&conf=$conf");
			} else {
				$common->error("등록 실패 되었습니다","previous","");
			}			

        break;


        case 'modify1' :  
		########### 답변 하기 처리 ##################		
			if(!$uid) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}					

			$tran_query[0] = "UPDATE $tablename SET  content1='$content',reply_date='$reg_date' WHERE uid='$uid'";
			$tran_result = $db->tran_query( $tran_query );

			//echo "<br><Br> $tran_query[0] <br>";

			if ( $tran_result == "1" ) {
				$common->error("답변 되었습니다.  ","goto_no_alert","$_SERVER[PHP_SELF]?bmain=list&conf=$conf");
			} else {
				$common->error("등록 실패 되었습니다","previous","");
			}			

        break;
        case 'reply' :  

		########### 답변 하기 처리 ##################		
			if(!$title) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}

			$query = "SELECT thread,right(thread,1) as thread_1 FROM $tablename WHERE fidnum = $fidnum AND length(thread) = length('$thread')+1 AND locate('$thread',thread) = 1 ORDER BY thread DESC LIMIT 1";
			$result =  $db->select_one($query); 
	
			if($result[thread]) {    
				$row =  $db->fetch_row($query); 
				$thread_head = substr($row[0],0,-1);
				$thread_foot = ++$row[1];       
				$new_thread = $thread_head . $thread_foot;
			} else {
				$new_thread = $thread . "A";
			}


			$query1= "SELECT max(uid) FROM $tablename";
			$row1 =  $db->fetch_row($query1);
				if($row1[0])	$new_uid = $row1[0] + 1; else $new_uid = 1;

			list($fileadd_name_1,$fileadd_size,$fileadd_org)=$common->Fileadd($new_uid,$tablefile, $fileadd, $fileadd_name);
			list($fileadd_name_2,$fileadd1_size,$fileadd1_org)=$common->Fileadd($new_uid."_1", $tablefile, $fileadd1, $fileadd1_name);
	
			 
			$tran_query[0] = "INSERT INTO $tablename (uid,mid,title,mode,viewtype,pass,uname,uemail,content,topview,ref,fidnum,thread,fileadd_name,fileadd_org,fileadd1_name,fileadd1_org,keytype,reg_date) VALUES ('$new_uid','$SITE_ADMIN_MID','$title','$mode','$viewtype','$pass','$uname','$uemail','$content','$topview','$ref','$fidnum','$new_thread','$fileadd_name_1','$fileadd_org','$fileadd_name_2','$fileadd1_org','$keytype','$reg_date')";
			$tran_result = $db->tran_query( $tran_query );

			if ( $tran_result == "1" ) {
				$common->error("처리 되었습니다.","goto_no_alert","$_SERVER[PHP_SELF]?bmain=list&conf=$conf");
			} else {
				$common->error("등록 실패 되었습니다","previous","");
			}
			

        break;


        case 'delete' :  
		########### 삭제하기 하기 처리 ##################		
			if(!$uid) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}

			$query= "SELECT fileadd_name,fileadd1_name,pass FROM $tablename WHERE uid='$uid' ORDER BY uid DESC LIMIT 1";
			$row = $db->row( $query );
				$delimg = "$ROOT_PATH/$tablefile/$row[fileadd_name]";				
				$delimg1 = "$ROOT_PATH/$tablefile/$row[fileadd1_name]";

			
			if($SITE_ADMIN_LEVEL!="1") {	//본사가 아닌경우 권한 확인 
				if($row['pass']!=$SITE_ADMIN_MID) {
					$common->error("삭제 권한이 없는 게시물이 있습니다. 확인후 삭제해 주세요.","previous");
				}
			} 

			#### 파일 삭제 체크한 경우 실행 ########
			if($row['fileadd_name']){ 
				######## 이미지 파일들 삭제 한다 ###################
				if(file_exists($delimg)) {
					if(!unlink($delimg)) {
						$common->error("파일삭제가 실패 되었습니다","previous","");
					}
				}
			}

			if($row['fileadd1_name']){ 
				######## 이미지 파일들 삭제 한다 ###################
				if(file_exists($delimg1)) {
					if(!unlink($delimg1)) {
						$common->error("파일삭제가 실패 되었습니다","previous","");
					}
				}
			}

			########## 선택한 글을 삭제 한다 ################
			$tran_query[0] = "DELETE FROM  $tablename WHERE uid='$uid'";
			$tran_result = $db->tran_query( $tran_query );

			if($MEMOUSETYPE=="Y") {
				########## 선택한 글을 메모글 삭제 한다 ################
				$tran_query[0] = "DELETE FROM  $memo_tablename WHERE board_uid='$uid'";
				$tran_result = $db->tran_query( $tran_query );
			}


			$common->error("삭제 되었습니다.","goto_no_alert","$_SERVER[PHP_SELF]?bmain=list&conf=$conf");
			

        break;

        case 'delete_all' :  
		########### 선택 삭제하기 하기 처리 ##################		
			if(!$uid) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}

			$uid_value = explode(",",$uid);	//선택한 메세지를 배열로 저장 해서 순서대로 지운다		

			while(list($key,$uid) = each($uid_value)) {				

				$query= "SELECT fileadd_name,fileadd1_name,pass FROM $tablename WHERE uid='$uid' ORDER BY uid DESC LIMIT 1";
				$row = $db->row( $query );
					$delimg = "$ROOT_PATH/$tablefile/$row[fileadd_name]";				
					$delimg1 = "$ROOT_PATH/$tablefile/$row[fileadd1_name]";

				if($SITE_ADMIN_LEVEL!="1") {	//본사가 아닌경우 권한 확인 
					if($row['pass']!=$SITE_ADMIN_MID) {
						$common->error("삭제 권한이 없는 게시물이 있습니다. 확인후 삭제해 주세요.","fancy_parent_close");
					}
				} 

				#### 파일 삭제 체크한 경우 실행 ########
				if($row['fileadd_name']){ 
					######## 이미지 파일들 삭제 한다 ###################
					if(file_exists($delimg)) {
						if(!unlink($delimg)) {
							$common->error("파일삭제가 실패 되었습니다","previous","");
						}
					}
				}

				if($row['fileadd1_name']){ 
					######## 이미지 파일들 삭제 한다 ###################
					if(file_exists($delimg1)) {
						if(!unlink($delimg1)) {
							$common->error("파일삭제가 실패 되었습니다","previous","");
						}
					}
				}

				########## 선택한 글을 삭제 한다 ################
				$tran_query[0] = "DELETE FROM  $tablename WHERE uid='$uid'";
				$tran_result = $db->tran_query( $tran_query );

				if($MEMOUSETYPE=="Y") {
					########## 선택한 글을 메모글 삭제 한다 ################
					$tran_query[0] = "DELETE FROM  $memo_tablename WHERE board_num='$uid'";
					$tran_result = $db->tran_query( $tran_query );
				}
			}

			
			$suss_msg = "선택 게시물이 삭제 되었습니다.";	
			
			
        break;


        case 'chviewtype' :  
		########### 선택 숨김처리하기 ##################		
			if(!$uid) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}

			$uid_value = explode(",",$uid);	//선택한 메세지를 배열로 저장 해서 순서대로 지운다		
			while(list($key,$uid) = each($uid_value)) {				

				$tran_query[0] = "UPDATE $tablename SET viewtype='N' WHERE uid='$uid'";
				$tran_result = $db->tran_query( $tran_query );
				//echo "<br><Br> $tran_query[0] <br>";
				$suss_msg = "숨기기 상태로 변경 되었습니다.";	

			}
		?>


<?
		 break;
    } //switch end

?>

<?if($formmode=="chviewtype" OR $formmode=="delete_all") {?>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<!-- 본문컨텐츠부분 시작 -->
	<table width="300" height="150" border="0" cellpadding="0" cellspacing="0">
	  <tr> 
		<td valign="top" bgcolor="#FFFFFF">
		  <table width="300" height="32" border="0" cellpadding="10" cellspacing="0">
			<tr> 
			  <td width="275" height="32" bgcolor="a6c070"><font color="#FFFFFF" class="T8">상태처리 </font></td>
			  <td width="25" bgcolor="a6c070"><a href="javascript:parent.fancyboxClose();parent.location.reload();"><img src="./img/admin_38.gif" border="0"></a></td>
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
				<a href="javascript:parent.fancyboxClose();parent.location.reload();"><img src="./img/btn_1.gif"  border="0"></a> 
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
