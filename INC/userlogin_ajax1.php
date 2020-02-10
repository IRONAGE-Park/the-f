<?php
 include_once ($_SERVER[DOCUMENT_ROOT]."/INC/get_session.php");
 include_once ($_SERVER[DOCUMENT_ROOT]."/INC/Function.php");
 include_once ($_SERVER[DOCUMENT_ROOT]."/INC/dbConn.php");
 require_once($_SERVER[DOCUMENT_ROOT]."/INC/func_other.php");




    $code = 0;
    $data = "";
    $dbname = "";
	$today_time = time();
	$ip_addrs = getenv("REMOTE_ADDR");

    $mode = $_POST["mode"];

    switch( $mode ){

        case 'logout' :
             $que_o[0] = "Delete From tb_login_session where member_mid = '$_SESSION[SITE_USER_MID]'";
			 $res_o = $db->tran_query($que_o);

             $_SESSION["user_time"]="";
            // session_unregister('SITE_USER_MID');
			########### 사용자 세션 ###########
			 $_SESSION["SITE_USER_MID"]		= "";
			 $_SESSION["SITE_USER_NAME"]		= "";
			 $_SESSION["SITE_USER_UID"]		= "";
			 $_SESSION["SITE_USER_LEVEL"]		= "";


             //session_destroy();

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
			$dsave = trim($_POST['v4']);


			//로그인
				$query1 = "select uid,mid,ulevel,uname from tb_member where state='Y' and   mid='$val01' and upasswd=password('$val02') " ;
				$result1 = $db->row( $query1 );
				$memberMid	= $result1[mid];
				$uname		= $result1[uname];
				$uid		= $result1[uid];
				$ulevel		= $result1[ulevel];

			

                if(empty($memberMid)){
                    $code = 0;
                    $data = "NotUser";
                }else{

                 

                    # 로그인 정보 업데이트
					/*
                    $todays = date('Y-m-d H:i:s');
                    $que[0] = "UPDATE tb_member SET lastdate ='".$todays."', num_login = num_login +1 WHERE member_mid ='".$memberMid."'";
					$result = $db->tran_query( $que);
					*/


                    # 로그인 히스토리 저장
                    $que_h[0] = "INSERT INTO tb_login_history (ip_addrs, reg_date, member_mid) VALUES ('$ip_addrs','$today_time','$memberMid')";
					$res_h = $db->tran_query($que_h);


                    # 이전로그인 세션 삭제
                    # $que_d = "Delete From tb_login_session where member_mid = '%s' AND session_id != '%s'";
                    # $res_d = $mysql->query($que_d,$memberMid, $_SESSION['Session_ID']);
                    $que_d[0] = "Delete From tb_login_session where member_mid = '$memberMid'";
					$res_d = $db->tran_query($que_d);

                    $que_l[0] = "INSERT INTO tb_login_session (ip_addrs, reg_date, session_id, member_mid) VALUES ('$ip_addrs','$today_time','$_SESSION[Session_ID]','$memberMid')";
					$res_1 = $db->tran_query($que_l);


						########### 사용자 세션생성 ###########
						 $_SESSION["SITE_USER_MID"]		= $memberMid;			//회원아이디
						 $_SESSION["SITE_USER_NAME"]	= $uname;				//회원이름
						 $_SESSION["SITE_USER_UID"]		= $uid;					//회원일련번호
						 $_SESSION["SITE_USER_LEVEL"]	= $ulevel;				//회원등급 (회원등급 1:무료회원,2:일반회원,3:프리미엄회원,4:플러스회원)


						################### 로그인시 기간 검색 해서 회원등급조정, 문자나, 매거진, 인사말 등등 기간 조정 #############		
						if($uid) {
							##### 이용기간 지난 회원 회원등급 조정 ####
							@get_tb_member_level($uid);
							###### 각종 종료된 상품 상태 변경 ####
							@get_tb_product_usetype_modify($uid);
						}
						################### end 로그인시 기간 검색 해서 회원등급조정, 문자나, 매거진, 인사말 등등 기간 조정 #############


						if($dsave=="Y") {
							$_SESSION["IDSAVE"]	= $result1[mid];//아이디저장
						} else {
							$_SESSION["IDSAVE"]	= "";	//아이디저장
						}

                        $_SESSION["user_time"] = time();
                        $data = "loging";
                        $code = $result1[ulevel];

                    if(empty($result1[ulevel])){
                        $code = 0;
                        $data = "levelNotUser";
                    }


                }

             exit(json_encode(array('code' => $code, 'msg' => $data)));
        break;


        case 'keeping' :
            if(!empty($_SESSION['user_time'])){
                # 5분이 지났으면...
                if(empty($sessionTimeSet)) $sessionTimeSet ="5";
                if(date('YmdHi')-date("YmdHi",$_SESSION['user_time']) > $sessionTimeSet){

                        if(!empty($_SESSION['SITE_USER_MID'])){

                                $que = " SELECT * FROM tb_login_session WHERE where session_id='%s' AND member_mid ='%s' ORDER BY uid DESC LIMIT 1";
                                $res_row = $mysql->row($que,$_SESSION['Session_ID'],$_SESSION['SITE_USER_MID']);

                            if($res_row["reg_date"]>0){
								//$ip_addrs,$today_time,$_SESSION['Session_ID'],$_SESSION['SITE_USER_MID']
                                $que[0] = "UPDATE tb_login_session SET ip_addrs ='$ip_addrs', reg_date='$today_time' WHERE session_id='$_SESSION[Session_ID]' AND member_mid ='%s' ORDER BY uid DESC LIMIT 1";
								$result = $db->tran_query( $que);
                                $_SESSION['user_time'] = $today_time; // 세션시간 갱신
                                $data = date('Y/m/d H:i:s');
                            }else{
                                # 로그인 세션이 존재하지 않는 경우
                              session_destroy();
                              $code = 2;
                              $data = "topPage";
				             exit(json_encode(array('code' => $code, 'msg' => $data)));
                            }
                        }
                }
            }

            exit(json_encode(array('code' => $code, 'msg' => $data)));
        break;

        //        case 'keepings' :
        //                        if(!empty($_SESSION['SITE_USER_MID'])){
        //                                $_SESSION['user_time'] = $today_time; // 세션시간 갱신
        //                                $data = date('Y/m/d H:i:s');
        //                            }else{
        //                                # 로그인 세션이 존재하지 않는 경우
        //                              session_destroy();
        //                              $code = 2;
        //                              $data = "topPage";
        //                            }
        //            exit(json_encode(array('code' => $code, 'msg' => $data)));
        //        break;


    } //switch end
exit;

?>
<?php
// 사용자단 공통에 넣어서 채크해야 됨니다.
//
//  $sessionTimeSet = "500"; //5분
//  $dailyTime = 1000 * 60 * ($sessionTimeSet-2); //3분
//
////echo $dailyTime;
//$keepingScript =
//'<SCRIPT language="javascript">
//    $(document).ready(function(){
//
//        login_keeping = function(){
//            $.ajax({
//                type : "POST"
//                , url : "../_INC/func_ajax.php"
//                , dataType : "JSON"
//                , data : "mode=keeping"
//                , success : function(res){
//                    if(res.code=="2"){
//                        alert ("'.$sessionTimeSet.'분 동안 작업이 없어 자동로그아웃 됩니다.");
//                        location.replace("./login.php");
//                          return false;
//                    }else{
//                        $("#timeview").html(res.msg);
//                    }
//                }
//            });
//        }
//         setInterval(login_keeping, "'.$dailyTime.'");
//
//   $("body").keydown(function() {
//            $.ajax({
//                type : "POST"
//                , url : "../_INC/func_ajax.php"
//                , dataType : "JSON"
//                , data : "mode=keeping"
//                , success : function(res){
//                    if(res.code=="2"){
//                        alert ("'.$sessionTimeSet.'분 동안 작업이 없어 자동로그아웃 됩니다.");
//                        location.replace("./login.php");
//                        return false;
//
//                    }else{
//                        $("#timeview").html(res.msg);
//                    }
//                }
//            });
//    });
//    $("body").mousedown(function() {
//            $.ajax({
//                type : "POST"
//                , url : "../_INC/func_ajax.php"
//                , dataType : "JSON"
//                , data : "mode=keeping"
//                , success : function(res){
//                    if(res.code=="2"){
//                        alert ("'.$sessionTimeSet.'분 동안 작업이 없어 자동로그아웃 됩니다.");
//                        location.replace("./login.php");
//                        return false;
//                    }else{
//                        $("#timeview").html(res.msg);
//                    }
//                }
//            });
//    });
//
//    });
//</script>';
//
//<?=$keepingScript ;?>
?>
