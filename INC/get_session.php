<?php  session_start();
	if(!$_SESSION['Session_ID']){
		$Session_ID = md5(rand());
        $_SESSION['Session_ID'] = $Session_ID;
    }
  define('ROOT', $_SERVER['DOCUMENT_ROOT']);

############## 관리자툴 세션 #############
/*
$SITE_ADMIN_UID			= "1";		//회원일련번호
$SITE_ADMIN_MID			= "admin";	//회원아이디
$SITE_ADMIN_NAME		= "관리자";	//회원이름
$SITE_ADMIN_LEVEL		= "1";	//회원등급 (회원등급 1:수퍼관리자,2:일반관리자)
*/

$SITE_ADMIN_UID			= $_SESSION['SITE_ADMIN_UID'];	//회원일련번호
$SITE_ADMIN_MID			= $_SESSION['SITE_ADMIN_MID'];	//회원아이디
$SITE_ADMIN_NAME		= $_SESSION['SITE_ADMIN_NAME'];	//회원이름
$SITE_ADMIN_LEVEL		= $_SESSION['SITE_ADMIN_LEVEL'];	//회원등급 (회원등급 1:수퍼관리자,2:일반관리자)

$S_USER_ID			= $_SESSION['my_userid1'];  //사이트 일반사용자에게 임시로 발급
$S_USER_NUM			= $_SESSION['my_usernum'];  //사이트 일반사용자에게 임시로 발급
$S_USER_TABLE		= $_SESSION['my_usertable']; //사이트 일반사용자에게 임시로 발급

?>
