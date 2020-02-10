<?php
 include_once ($_SERVER['DOCUMENT_ROOT']."/INC/get_session.php");
 include_once ($_SERVER['DOCUMENT_ROOT']."/INC/Function.php");
 include_once ($_SERVER['DOCUMENT_ROOT']."/INC/dbConn.php");

    $code = 0;
    $data = "";
    $dbname = "";
	$today_time = time();
	$ip_addrs = getenv("REMOTE_ADDR");

    $mode = $_POST["mode"];

    switch( $mode ){

        case 'logout' :

             $_SESSION["user_time"]="";
            // session_unregister('SITE_USER_MID');

			 $_SESSION["SITE_ADMIN_MID"]	= "";
			 $_SESSION["SITE_ADMIN_NAME"]	= "";
			 $_SESSION["SITE_ADMIN_LEVEL"]	= "";
			 $_SESSION["SITE_ADMIN_UID"]	= "";


			 $_SESSION["Session_ID"] = "";


             session_destroy();
             if(empty($_SESSION["SITE_USER_MID"])){
                 $code = 1;
                 $data = "logout";
             }
             exit(json_encode(array('code' => $code, 'msg' => $data)));
        break;


        case 'login' :

			/*
            if(!empty($_SESSION["Session_ID"])){
                if($_POST["session_id"]!=$_SESSION["Session_ID"]){
                    exit(json_encode(array('code' => $code, 'msg' => "No_Session_ID")));
                } //session_id
            }*/

            $val01 = trim($_POST['v1']);        #문자 4자리
            $val02 = trim($_POST['v2']);        #앞코드

				$query1 = "select mid,ulevel,uname,uid  from tb_master where state='Y' and ulevel='1' and mid='$val01'" ;
				$result1 = $db->row( $query1 );
				$memberMid = $result1['mid'];

                if(empty($memberMid)){
                    $code = 0;
                    $data = $query1;
                }else{

                  
                    # 로그인 정보 업데이트
                    $todays = date('Y-m-d H:i:s');
                    $que[0] = "UPDATE tb_master SET lastdate ='".$todays."', num_login = num_login +1 WHERE member_mid ='".$memberMid."'";
					$result = $db->tran_query( $que);


						########### 관리자 세션생성 ###########
						 $_SESSION["SITE_ADMIN_MID"]		= $result1['mid'];			//회원아이디
						 $_SESSION["SITE_ADMIN_NAME"]		= $result1['uname'];			//회원이름
						 $_SESSION["SITE_ADMIN_UID"]		= $result1['uid'];   			//회원일련번호
						 $_SESSION["SITE_ADMIN_LEVEL"]		= $result1['ulevel'];			//(회원등급 1 관리자)


				
                        $_SESSION["user_time"] = time();
                        $data = "loging";
                        $code = $result1['ulevel'];

                    if(empty($result1['ulevel'])){
                        $code = 0;
                        $data = "levelNotUser";
                    }


                }

             exit(json_encode(array('code' => $code, 'msg' => $data)));
        break;
       

    } //switch end
exit;

?>
