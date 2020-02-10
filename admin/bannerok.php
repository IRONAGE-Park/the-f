<?
$doc_root = $_SERVER['DOCUMENT_ROOT'];
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
	$title		= escape_string($_REQUEST['title'],1);	
	$sdate		= escape_string($_REQUEST['sdate'],1);	
	$stime		= escape_string($_REQUEST['stime'],1);
	$fileadd_name = escape_string($_REQUEST['fileadd_name'],1);	
	//$content = addslashes($content);

	$fileadd_name	= $_FILES['fileadd']['name'];		//등록파일명
	$fileadd		= $_FILES['fileadd']['tmp_name'];	//파일임지저장소 
	$fileadd_size	= $_FILES['fileadd']['size'];		//파일크기

	if(!$reg_date) $reg_date = date("Y-m-d H:i:s");
	$stime =  $stime1.":".$stime2;

    switch( $formmode ){        
        case 'save' :  

			if(!$title) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}

		########### 저장하기 처리 ##################		

			$query1= "SELECT max(uid) FROM $tablename";
			$row1 =  $db->fetch_row($query1);
				if($row1[0])	$new_uid = $row1[0] + 1; else $new_uid = 1;

			list($fileadd_name_1,$fileadd_size,$fileadd_org)=$common->Fileadd($new_uid,$tablefile, $fileadd, $fileadd_name);
			 
			$tran_query[0] = "INSERT INTO $tablename (uid,mode,viewtype,title,fileadd_name,reg_date,moveurl,actiontype) VALUES ('$new_uid','$mode','$viewtype','$title','$fileadd_name_1','$reg_date','$moveurl','$actiontype')";
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
		

			$query= "SELECT fileadd_name FROM $tablename WHERE uid='$uid' ORDER BY uid DESC LIMIT 1";
			$row = $db->row( $query );
				$delimg = "$ROOT_PATH/$tablefile/$row[fileadd_name]";				

			####  파일을 다시 등록 했으면 저장한다. ####
			if ($fileadd != ""){	
				############ 첨부화일 저장 하기 ######################
				list($fileadd_name_1,$fileadd_size,$fileadd_org)=$common->Fileadd($uid,$tablefile, $fileadd, $fileadd_name);
				$file_sql = ",fileadd_name='$fileadd_name_1'";
			} else {
				$file_sql = "";
			} 
			

			#### 파일 삭제 체크한 경우 실행 ########
			if($delimg_1=="Y") {				
					######## 이미지 파일들을 삭제 한다 ###################
					if($row[fileadd_name]){ 
						######## 이미지 파일들 삭제 한다 ###################
						if(file_exists($delimg)) {
							if(!unlink($delimg)) {
								$common->error("파일삭제가 실패 되었습니다","previous","");
							}
						}
					}
				$tran_query[0] = "UPDATE $tablename SET  fileadd_name='' WHERE uid='$uid'";
				$tran_result = $db->tran_query( $tran_query );
			} 
			
			$tran_query[0] = "UPDATE $tablename SET mode='$mode',viewtype='$viewtype',title='$title',reg_date='$reg_date',moveurl='$moveurl',actiontype='$actiontype' $file_sql  WHERE uid='$uid'";
			$tran_result = $db->tran_query( $tran_query );


			if ( $tran_result == "1" ) {
				$common->error("수정 되었습니다.  ","goto_no_alert","$_SERVER[PHP_SELF]?bmain=list&conf=$conf");
			} else {
				$common->error("등록 실패 되었습니다","previous","");
			}			

        break;

        

        case 'delete' :  
		########### 삭제하기 하기 처리 ##################		
			if(!$uid) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}

			$query= "SELECT fileadd_name FROM $tablename WHERE uid='$uid' ORDER BY uid DESC LIMIT 1";
			$row = $db->row( $query );
				$delimg = "$ROOT_PATH/$tablefile/$row[fileadd_name]";				

			#### 파일 삭제 체크한 경우 실행 ########
			if($row[fileadd_name]){ 
				######## 이미지 파일들 삭제 한다 ###################
				if(file_exists($delimg)) {
					if(!unlink($delimg)) {
						$common->error("파일삭제가 실패 되었습니다","previous","");
					}
				}
			}


			########## 선택한 글을 삭제 한다 ################
			$tran_query[0] = "DELETE FROM  $tablename WHERE uid='$uid'";
			$tran_result = $db->tran_query( $tran_query );


			$common->error("삭제 되었습니다.","goto_no_alert","$_SERVER[PHP_SELF]?bmain=list&conf=$conf");
			

        break;

        case 'delete_all' :  
		########### 선택 삭제하기 하기 처리 ##################		
			if(!$uid) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}

			$uid_value = explode(",",$uid);	//선택한 메세지를 배열로 저장 해서 순서대로 지운다		

			while(list($key,$uid) = each($uid_value)) {				

				$query= "SELECT fileadd_name FROM $tablename WHERE uid='$uid' ORDER BY uid DESC LIMIT 1";
				$row = $db->row( $query );
					$delimg = "$ROOT_PATH/$tablefile/$row[fileadd_name]";				

				#### 파일 삭제 체크한 경우 실행 ########
				if($row[fileadd_name]){ 
					######## 이미지 파일들 삭제 한다 ###################
					if(file_exists($delimg)) {
						if(!unlink($delimg)) {
							$common->error("파일삭제가 실패 되었습니다","previous","");
						}
					}
				}
				
				########## 선택한 글을 삭제 한다 ################
				$tran_query[0] = "DELETE FROM  $tablename WHERE uid='$uid'";
				$tran_result = $db->tran_query( $tran_query );

			}
			
			$suss_msg = "선택 게시물이 삭제 되었습니다.";	
			
			
        break;

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
			  <td width="275" height="32" bgcolor="50a7e1"><font color="#FFFFFF" class="T3">상태변경처리 </font></td>
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
