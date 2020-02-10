  <?
function session_register($name) {
	if(isset($GLOBALS[$name])) $_SESSION[$name] = $GLOBALS[$name];
	$GLOBALS[$name] = &$_SESSION[$name];
}

############### DB 정보를 가지고 온다 ####################
  if($uid) {		 
	 $row_board = get_tb_board($uid,$tablename); //func_other.php 에서 호출 해서 게시판 정보 가지고 온다 
	 if(!$row_board['uid']) {
		 $common->error("관련된 정보가 없습니다.","previous","");
	 }

  }


	########## 게시물의 암호와 사용자가 입력한 암호가 같은지 확인 ##########
	  if (($row_board['pass'] != $pass) and ($S_ADMIN_ID!=$row_board['pass']) and ($S_USER_NUM!=$uid)){      
		$common->error("비밀번호가 일치하지 않습니다.","previous","");
	   } else if (($row_board['pass'] == $pass) or (($S_ADMIN_ID == $row_board['pass']) and ($S_USER_NUM == $uid))) {    
		$my_userid1 = $row_board['pass'];
		$my_usernum = $uid;
		$my_usertable = $tablename;
		session_register("my_userid1");
		session_register("my_usernum");
		session_register("my_usertable");

		echo (" <meta http-equiv='Refresh' content='0; URL=$_SERVER[PHP_SELF]?bmain=view&uid=$uid'> ");
		}

  ?>
 