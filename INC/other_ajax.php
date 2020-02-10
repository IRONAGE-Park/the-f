<?php
require_once($_SERVER[DOCUMENT_ROOT]."/INC/get_session.php");
require_once($_SERVER[DOCUMENT_ROOT]."/INC/dbConn.php");
require_once($_SERVER[DOCUMENT_ROOT]."/INC/Function.php");
require_once($_SERVER[DOCUMENT_ROOT]."/INC/func_other.php");


//// 게시판, 회원 기타 처리 부분

    $mode = $_POST["mode"];

    switch( $mode ){

		//아이디 중복 검사 
        case 'duplicate' :
            $id_val = $_POST['v'];
            $code = "0";
            $data = "";		

			// /INC/func_other.php 에서 호출 
			$mem_row = member_check($id_val);
			##### 종복된 아이디 있으면 true 보낸다 ###########
			if($mem_row[midok]) {
				$row[midok] = true;
			}
            if(!$row[midok]) {
                exit(json_encode(array('code' => $code, 'msg' => $data)));
            }else{
                exit(json_encode(array('code' => '1', 'msg' => 'duplicate')));
            }
        break;       

		//소속사 중복 검사 
        case 'cnamcheck' :
            $cnam_val = $_POST['v'];
            $code = "0";
            $data = "";		

			// /INC/func_other.php 에서 호출 
			$mem_row = cname_check($cnam_val);
			##### 종복된 아이디 있으면 true 보낸다 ###########
			if($mem_row[midok]) {
				$row[midok] = true;
			}
            if(!$row[midok]) {
                exit(json_encode(array('code' => $code, 'msg' => $data)));
            }else{
                exit(json_encode(array('code' => '1', 'msg' => 'duplicate')));
            }
        break;       


    } //switch end

	exit;
?>
