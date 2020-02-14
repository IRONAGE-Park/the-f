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

	//인젝션
	$mid = escape_string($_REQUEST['mid'],1);	
	$master_mid = escape_string($_REQUEST['master_mid'],1);	

	$uname = escape_string($_REQUEST['uname'],1);	
	$upasswd = escape_string($_REQUEST['upasswd'],1);	
	$utel = escape_string($_REQUEST['utel'],1);	
	$uptel = escape_string($_REQUEST['uptel'],1);	
	$uemail = escape_string($_REQUEST['uemail'],1);	

	if($uzip1)	 $uzip = $uzip1."-".$uzip2;
	if($utel1)	 $utel  = $utel1."-".$utel2."-".$utel3;
	if($uptel1)  $uptel	= $uptel1."-".$uptel2."-".$uptel3;

	$mento = $master_mid;
	//$content = addslashes($content);

	$reg_date = date("Y-m-d H:i:s");
	$ip_addrs = getenv("REMOTE_ADDR");

	if(!$mid OR !$uname) {
		$common->error("데이터가 없습니다. 정상적으로 접근해 주세요.","previous","");	
	}

    switch( $formmode ){        
        case 'save' :  
		########### 저장하기 처리 ##################


			 //회원 테이블 모두 에서 아이디 중복확인 
			 $Membercheck = member_check($mid);
			 if($Membercheck[midok]) $common->error("$mid 는 중복된 아이디 입니다. 확인 후 가입해 주세요.","previous","");

			
			$tran_query[0] = "INSERT INTO tb_master (uid,mid,state,ulevel,uname,upasswd,utel,uptel,uemail,ip_addrs,reg_date) VALUES ('','$mid','Y','1','$uname',password('$upasswd'),'$utel','$uptel','$uemail','$ip_addrs','$reg_date')";
			$tran_result = $db->tran_query( $tran_query );

			if ( $tran_result == "1" ) {
				$common->error("처리 되었습니다.","goto","admin1_1.html?conf=$conf");
			} else {
				$common->error("등록 실패 되었습니다","previous","");
			}
			
        break;
        case 'modify' :  
		########### 수정 하기 처리 ##################				


			if($upasswd)	$sql_pass	= " ,upasswd=password('$upasswd')";
			
			$tran_query[0] = "UPDATE tb_master SET uname='$uname',utel='$utel',uptel='$uptel',uemail='$uemail' $sql_pass WHERE uid='$uid'";
			$tran_result = $db->tran_query( $tran_query );
			//echo "<br><Br> $tran_query[0] <br>";

			if ( $tran_result == "1" ) {
				$common->error("수정 되었습니다.  ","goto","/admin");
			} else {
				$common->error("등록 실패 되었습니다","previous","");
			}			

        break;
    } //switch end

?>
