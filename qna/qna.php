<?php include "../INC/header.php"; ?>
<?
########## 게시판설정파일 #########
if (!$bmain) $bmain="list";
include "../admin/conf/conf_board.php";
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td align="center" valign="top">
	<table width="80%" border="0" cellspacing="0" cellpadding="0">
   <tr>
		<!--contents-->
    <td valign="top" class="content"><table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
      <td align="center"><img class="qna-image" src="../img/visual/visual11.jpg"></td>
     </tr>
     <tr>
      <td class="border-n">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td><span class="list_tit">Q&amp;A</span></td>
		</tr>
	  </table>
			<br>
			<? 
			if(($bmain=="view") or ($bmain=="modify")){

			 $row_board = get_tb_board($uid,$tablename); //func_other.php 에서 호출 해서 게시판 정보 가지고 온다 
		
				if(($row_board['keytype']=="Y") and (($S_USER_ID!=$row_board['pass']) or ($S_USER_NUM!=$uid) or ($S_USER_TABLE!=$tablename) ) AND  ($SITE_ADMIN_UID!=$row_board['pass']) ) { 
					include "../Bboard/boardlogin.php";
				} else { 
					include "../Bboard/board${bmain}.php";
				}
			} else {
				include "../Bboard/board${bmain}.php";

			}
			?>

	
	</td>
		<!--//contents-->
   </tr>
  </table>
	</td>
 </tr>
</table>
<?php include "../INC/footer.php"; ?>