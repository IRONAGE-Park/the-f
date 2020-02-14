<?
@extract($_GET); 
@extract($_POST);
require_once("../INC/get_session.php");
require_once("../INC/dbConn.php");
require_once("../INC/Function.php");
require_once("../INC/arr_data.php");
require_once("../INC/func_other.php");
require_once("../INC/down.php");			//파일 다운로드
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

		########### 저장하기 처리 ##################		

			$query1= "SELECT max(uid) FROM $tablename";
			$row1 =  $db->fetch_row($query1);
				if($row1[0])	$new_uid = $row1[0] + 1; else $new_uid = 1;

			list($fileadd_name_1,$fileadd_size,$fileadd_org)=$common->Fileadd($new_uid,$tablefile, $fileadd, $fileadd_name);
			 
			$tran_query[0] = "INSERT INTO $tablename (uid,mode,viewtype,title,fileadd_name,reg_date,moveurl,actiontype) VALUES ('$new_uid','$mode','$viewtype','$title','$fileadd_name_1','$reg_date','$moveurl','$actiontype')";
			$tran_result = $db->tran_query( $tran_query );

			if ( $tran_result == "1" ) {
				$common->error("처리 되었습니다.","goto_no_alert","$_SERVER[PHP_SELF]?c_name=$c_name&bmain=list&conf=$conf");
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


			$common->error("삭제 되었습니다.","goto_no_alert","$_SERVER[PHP_SELF]?c_name=$c_name&bmain=list&conf=$conf");

        break;
    } //switch end

?>
