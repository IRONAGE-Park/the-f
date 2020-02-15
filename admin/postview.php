<?
@extract($_GET); 
@extract($_POST); 
############### DB 정보를 가지고 온다 ####################
if($uid) {	  
	$row_board = get_tb_board($uid,$tablename); //func_other.php 에서 호출 해서 게시판 정보 가지고 온다 

	if(!$row_board['uid']) {
		$common->error("관련된 정보가 없습니다.","previous","");
	}

	##### 게시물 조회수 올림 #########
	get_tb_ref($tablename, "ref", $uid);

	if($MODEUSETYPE=="Y") {
		$row_board_mode = "[".$ARR_BOARD_TYPE[$row_board['mode']]."]";
	}
	$dir = "../".$row_board['fileadd_folder']."/banner";
	// 핸들 획득
	$handle  = opendir($dir);
	
	$files = array();
	
	// 디렉터리에 포함된 파일을 저장한다.
	while (false !== ($filename = readdir($handle))) {
		if($filename == "." || $filename == ".." || $filename == ".DS_Store"){
			continue;
		}
		// 파일인 경우만 목록에 추가한다.
		if(is_file($dir . "/" . $filename)){
			$files[] = $filename;
		}
	}
	// 핸들 해제 
	closedir($handle);
	// 정렬, 역순으로 정렬하려면 rsort 사용
	sort($files);
	// 파일명을 출력한다.
	if($c_name=="post1") {
		$dirProduct = "../".$row_board['fileadd_folder']."/product";
		// 핸들 획득
		$handle  = opendir($dirProduct);
		
		$filesProduct = array();
		
		// 디렉터리에 포함된 파일을 저장한다.
		while (false !== ($filename = readdir($handle))) {
			if($filename == "." || $filename == ".." || $filename == ".DS_Store"){
				continue;
			}
			// 파일인 경우만 목록에 추가한다.
			if(is_file($dirProduct . "/" . $filename)){
				$filesProduct[] = $filename;
			}
		}
		// 핸들 해제 
		closedir($handle);
		// 정렬, 역순으로 정렬하려면 rsort 사용
		sort($filesProduct);
		// 파일명을 출력한다.
	}
}
?>

      <!-- 본문컨텐츠부분 시작 -->
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	  	<tr class="admin-view-title"> 
          <td width="120" height="35"><font class="T4">ㆍ제목</font></td>
          <td ><strong><?=$row_board_mode?> <?=$row_board['title']?></strong></td>
          <td width="10%" height="70"><font class="T4">ㆍ등록일자</font></td>
          <td width="20%"><?=$row_board['reg_date']?></td>
		  <?if($REFUSETYPE=="Y") {?>
          <td width="10%"><font class="T4">ㆍ조회수</font></td>
          <td>
			<?=$row_board['ref']?>
		  </td>
		  <?}?>
        </tr>
      	</table>
	   	<table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr class="admin-view-content"> 
          	<td width="120"><font class="T4">ㆍ배너 이미지</font></td>
          	<td>
				<div class="admin-manage-content-padding">
					<?
					foreach ($files as $f) {
						echo "<img src='$dir/$f'/>";
					}
					?>
				</div>
			</td>
		</tr>
		<? if($c_name=="post1") { ?>
		<tr class="admin-view-content"> 
          	<td width="120"><font class="T4">ㆍ제품 이미지</font></td>
          	<td>
				<div class="admin-manage-content-padding">
					<?
					foreach ($filesProduct as $f) {
						echo "<img src='$dir/$f'/>";
					}
					?>
				</div>
			</td>
		</tr>
		<? } ?>
		<tr class="admin-view-content"> 
          	<td width="120"><font class="T4">ㆍ내용</font></td>
          	<td>
				<div class="admin-manage-content-padding" align="justify">
              		<?=stripslashes($row_board['content'])?>
				</div>
			</td>
        </tr>
      </table>
	  
	  <!-- 각종버튼 -->
	  <table border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td align="right">
			<!-- 목록 --><a class="admin-button" href="<?echo"$_SERVER[PHP_SELF]?c_name=$c_name&bmain=list"?>">목록</a>
            <!-- 등록 --><a class="admin-button" href="<?echo"$_SERVER[PHP_SELF]?c_name=$c_name&bmain=write"?>">등록</a> 
		<?if($SITE_ADMIN_LEVEL=="1") {?>
			<!-- 수정 --><a class="admin-button" href="<?echo"$_SERVER[PHP_SELF]?c_name=$c_name&bmain=write&uid=$uid"?>">수정</a> 
		<?} else {?>	
			<?if($row_board[pass]==$SITE_ADMIN_MID) {?>
            <!-- 수정 --><a class="admin-button" href="<?echo"$_SERVER[PHP_SELF]?c_name=$c_name&bmain=write&uid=$uid"?>">수정</a> 
			<?} else {?>
            <!-- 삭제 --><a class="admin-button" href="javascript: onClick=alert('수정 권한이 없습니다.');">삭제</a>
			<?}?>
		<?}?>	
		<?if($MODEREPLY=="Y") {?>
			<!-- 답변 --><a class="admin-button" href="<?echo"$_SERVER[PHP_SELF]?c_name=$c_name&bmain=reply&uid=$uid"?>">답변</a> 
		<?}?>
		<?if($SITE_ADMIN_LEVEL=="1") {?>
            <!-- 삭제 --><a class="admin-button" href="javascript: onClick=contentDel('<?echo"$_SERVER[PHP_SELF]?c_name=$c_name&bmain=ok&conf=$c_name&uid=$uid&formmode=delete"?>');">삭제</a>
		<?} else {?>	
			<?if($row_board[pass]==$SITE_ADMIN_MID) {?>
            <!-- 삭제 --><a class="admin-button" href="javascript: onClick=contentDel('<?echo"$_SERVER[PHP_SELF]?c_name=$c_name&bmain=ok&conf=$c_name&uid=$uid&formmode=delete"?>');">삭제</a>
			<?} else {?>
            <!-- 삭제 --><a class="admin-button" href="javascript: onClick=alert('삭제 권한이 없습니다.');">삭제</a>
			<?}?>
		<?}?>
			</td>
        </tr>
      </table>