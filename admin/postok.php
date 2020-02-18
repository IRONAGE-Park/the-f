<?
function rmdir_all($dir) {
  if (!file_exists($dir)) {
    return;
  }
  $dhandle = opendir($dir);
  if ($dhandle) {
    while (false !== ($fname = readdir($dhandle))) {
       if (is_dir( "{$dir}/{$fname}" )) {
          if (($fname != '.') && ($fname != '..')) {
            rmdir_all("$dir/$fname");
          }
       } else {
          unlink("{$dir}/{$fname}");
       }
    }
    closedir($dhandle);
  }
  rmdir($dir);
}

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
	if($c_name) {
		include "./conf/conf_".$c_name.".php";
	}
	//인젝션
	$tcode		= escape_string($_REQUEST['tcode'],1);	
	$title		= escape_string($_REQUEST['title'],1);	
	$uname		= escape_string($_REQUEST['uname'],1);	
	$content	= escape_string($_REQUEST['content'],1);		
	$ref		= escape_string($_REQUEST['ref'],1);	
	$fileadd_name = escape_string($_REQUEST['fileadd_name'],1);
	$fileadd_product_name = escape_string($_REQUEST['fileadd_name'],1);

	$fileadd_name	= $_FILES['fileadd']['name'];		//등록파일명
	$fileadd		= $_FILES['fileadd']['tmp_name'];	//파일임지저장소 
	$fileadd_size	= $_FILES['fileadd']['size'];		//파일크기
	

	$fileadd_product_name	= $_FILES['fileadd_product']['name'];		//등록파일명
	$fileadd_product		= $_FILES['fileadd_product']['tmp_name'];	//파일임지저장소 
	$fileadd_product_size	= $_FILES['fileadd_product']['size'];		//파일크기
	$filename		= $_POST['filename'];
	$filelink		= $_POST['filelink'];

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
			$query1= "SELECT max(uid) FROM $tablename";
			$row1 =  $db->fetch_row($query1);
			if ($row1[0]) $new_uid = $row1[0] + 1; else $new_uid = 1;
			
			if (!is_dir($ROOT_PATH."/$tablefile/$new_uid")){ // 폴더를 만듬
				mkdir($ROOT_PATH."/$tablefile/$new_uid",0707);
			}
			$directory = $tablefile."/".$new_uid; // 디렉토리의 주소(새로운 id로 갱신)
			for ($fi = 0; $fi < count($fileadd); $fi++) {
				// list($fileadd_name_1,$fileadd_size,$fileadd_org) = $common->Fileadd($new_uid, $directory, $fileadd[$fi], $fileadd_name[$fi]);
				$common->Fileadd($fi, $directory."/banner", $fileadd[$fi], $fileadd_name[$fi]);
			}
			for ($fpi = 0; $fpi < count($fileadd_product); $fpi++) {
				// list($fileadd_name_1,$fileadd_size,$fileadd_org) = $common->Fileadd($new_uid, $directory, $fileadd[$fpi], $fileadd_name[$fpi]);
				$set_file_name = $filename[$fpi].'_'.$filelink[$fpi].'_'.$fpi;
				$common->Fileadd($set_file_name, $directory."/product", $fileadd_product[$fpi], $fileadd_product_name[$fpi]);

				// 하이퍼 링크 저장 데이터
				$txtfile = fopen($ROOT_PATH.'/'.$directory."/product/".$set_file_name.".txt", 'w');
				fwrite($txtfile, $filelink[$fpi]);
				fclose($txtfile);
			}
			// 파일 저장
			 
			$tran_query[0] = "INSERT INTO $tablename (uid,title,content,ref,fileadd_folder,reg_date) VALUES ('$new_uid','$title','$content','$ref','$directory','$reg_date')";
			$tran_result = $db->tran_query( $tran_query );
			if ($tran_result == "1" ) {
				$common->error("처리 되었습니다.","goto_no_alert","$_SERVER[PHP_SELF]?c_name=$c_name&bmain=list&conf=$conf");
			} else {
				$common->error("등록 실패 되었습니다","previous","");
			}
		break;
		case 'modify' :  
			########### 수정 하기 처리 ##################		
			if(!$uid) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}
			$query= "SELECT fileadd_folder FROM $tablename WHERE uid='$uid' ORDER BY uid DESC LIMIT 1";
			$row = $db->row( $query );
			
			if ($fileadd[0] != "") {
				if(is_dir("../".$row['fileadd_folder']."/banner")) {
					if(rmdir_all("../".$row['fileadd_folder']."/banner")) {
						$common->error("폴더삭제가 실패 되었습니다","previous","");
					}
				}
			}
			if ($fileadd_product[0] != "") {
				if(is_dir("../".$row['fileadd_folder']."/product")) {
					if(rmdir_all("../".$row['fileadd_folder']."/product")) {
						$common->error("폴더삭제가 실패 되었습니다","previous","");
					}
				}
			}

			// #### 파일 삭제 체크한 경우 실행 ########
			// if($delimg_1=="Y") {				
			// 		######## 이미지 파일들을 삭제 한다 ###################
			// 		if($row['fileadd_folder']){ 
			// 			######## 이미지 파일들 삭제 한다 ###################
			// 			if(file_exists($delimg)) {
			// 				if(!unlink($delimg)) {
			// 					$common->error("파일삭제가 실패 되었습니다","previous","");
			// 				}
			// 			}
			// 		}
			// }
			$directory = $tablefile."/".$uid; // 디렉토리의 주소
			for ($fi = 0; $fi < count($fileadd); $fi++) {
				// list($fileadd_name_1,$fileadd_size,$fileadd_org) = $common->Fileadd($new_uid, $directory, $fileadd[$fi], $fileadd_name[$fi]);
				$common->Fileadd($fi, $directory."/banner", $fileadd[$fi], $fileadd_name[$fi]);
			}
			for ($fpi = 0; $fpi < count($fileadd_product); $fpi++) {
				// list($fileadd_name_1,$fileadd_size,$fileadd_org) = $common->Fileadd($new_uid, $directory, $fileadd[$fpi], $fileadd_name[$fpi]);
				$set_file_name = $filename[$fpi].'_'.$fpi;
				$common->Fileadd($set_file_name, $directory."/product", $fileadd_product[$fpi], $fileadd_product_name[$fpi]);
				
				// 하이퍼 링크 저장 데이터
				$txtfile = fopen($ROOT_PATH.'/'.$directory."/product/".$set_file_name.".txt", 'w');
				fwrite($txtfile, $filelink[$fpi]);
				fclose($txtfile);
			}
			// 파일 저장
			 
			$tran_query[0] = "UPDATE $tablename SET title='$title',content='$content',ref='$ref',reg_date='$reg_date' WHERE uid='$uid'";
			$tran_result = $db->tran_query( $tran_query );

			if ( $tran_result == "1" ) {
				$common->error("수정 되었습니다.  ","goto_no_alert","$_SERVER[PHP_SELF]?c_name=$c_name&bmain=list&conf=$conf");
			} else {
				$common->error("등록 실패 되었습니다","previous","");
			}			
        break;
        case 'delete' :  
			########### 삭제하기 하기 처리 ##################		
			if(!$uid) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}
			$query= "SELECT fileadd_folder FROM $tablename WHERE uid='$uid' ORDER BY uid DESC LIMIT 1";
				$row = $db->row( $query );

				#### 파일 삭제 체크한 경우 실행 ########
				if($row['fileadd_folder']){ 
					######## 이미지 파일들 삭제 한다 ###################
					if(is_dir("../".$row['fileadd_folder'])) {
						if(rmdir_all("../".$row['fileadd_folder'])) {
							$common->error("폴더삭제가 실패 되었습니다","previous","");
						}
					}
				}
				$tran_query[0] = "DELETE FROM  $tablename WHERE uid='$uid'";
				$tran_result = $db->tran_query( $tran_query );
			$common->error("삭제 되었습니다.","goto_no_alert","$_SERVER[PHP_SELF]?c_name=$c_name&bmain=list&conf=$conf");
        break;

        case 'delete_all' :  
		########### 선택 삭제하기 하기 처리 ##################		
			if(!$uid) {
				$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
			}
			$uid_value = explode(",",$uid);	//선택한 메세지를 배열로 저장 해서 순서대로 지운다		
			while(list($key,$uid) = each($uid_value)) {				
				$query= "SELECT fileadd_folder FROM $tablename WHERE uid='$uid' ORDER BY uid DESC LIMIT 1";
				$row = $db->row( $query );

				#### 파일 삭제 체크한 경우 실행 ########
				if($row['fileadd_folder']){ 
					######## 이미지 파일들 삭제 한다 ###################
					if(is_dir("../".$row['fileadd_folder'])) {
						if(rmdir_all("../".$row['fileadd_folder'])) {
							$common->error("폴더삭제가 실패 되었습니다","previous","");
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