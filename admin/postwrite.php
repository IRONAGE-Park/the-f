<?
@extract($_GET); 
@extract($_POST); 

############### DB 정보를 가지고 온다 ####################
  if($uid) {		 
	$row_board = get_tb_board($uid,$tablename); //func_other.php 에서 호출 해서 게시판 정보 가지고 온다 
	if(!$row_board['uid']) {
		$common->error("관련된 정보가 없습니다.","previous","");
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
<link rel="stylesheet" href="../admin/css/drop.css" type="text/css" />
<script src="../admin/js/drop.js" type="text/javascript"></script>
<?if(!$row_board['uid']) {?>
<!-- 등록인경우 -->
<form name="signform" method="post" action="<?echo" $_SERVER[PHP_SELF]?c_name=$c_name"?>" onSubmit="return boardWritecheck()"
	ENCTYPE="multipart/form-data">
	<input type="hidden" name="formmode" value="save">
	<input type="hidden" name="conf" value="<?=$conf?>"><!-- 환경설정파일  -->
	<input type="hidden" name="bmain" value="ok">
	<?} else {?>
	<!-- 수정인경우 -->
	<form name="signform" method="post" action="<?echo" $_SERVER[PHP_SELF]?c_name=$c_name"?>" onSubmit="return boardWritecheck()"
		ENCTYPE="multipart/form-data">
		<input type="hidden" name="formmode" value="modify">
		<input type="hidden" name="uid" value="<?=$uid?>">
		<input type="hidden" name="conf" value="<?=$conf?>"><!-- 환경설정파일  -->
		<input type="hidden" name="bmain" value="ok">
		<?}?>

		<table align="center" cellpadding="0" cellspacing="0">
			<!-- 비밀번호 --><input type="hidden" name="pass" size="30" maxlength="20" class="FORM1"
				value="<?=$SITE_ADMIN_MID?>">
			<tr>
				<td height="50" width="150">
					<font class="T4">ㆍ제목</font>
				</td>
				<td colspan="2" width="730"><input type="text" name="title" size="50" maxlength="250" class="FORM1"
						value="<?=$row_board['title']?>"></td>
			</tr>
			<?if($CONTENT2TYPE=="Y") { ?>
			<tr>
				<td height="140" width="150">
					<font class="T4">ㆍ요약글</font>
				</td>
				<td colspan="2" width="730"><textarea name="content1" rows=8
						cols=60><?=stripslashes($row_board['content1'])?></textarea></td>
			</tr>
			<?}?>
			<tr>
				<td height="50" width="150">
					<font class="T4">ㆍ내용</font>
				</td>
				<td colspan="2"><input type="text" name="content" size="80" maxlength="70"
						<?if($row_board['content']){?>value="<?=$row_board['content']?>"
					<?} ?>></td>
			</tr>
			<?if($REFUSETYPE=="Y") {?>
			<tr>
				<td height="50">
					<font class="T4">ㆍ조회수</font>
				</td>
				<td colspan="2"><input type="text" name="ref" size="15" maxlength="10" class="FORM1"
						value="<?if(!$row_board['ref'])echo" 0"; else echo"$row_board[ref]";?>"></td>
			</tr>
			<?} else {?>
			<input type="hidden" name="ref" size="15" maxlength="10" class="FORM1" value="<?if(!$row_board['ref'])echo"
				0"; else echo"$row_board[ref]";?>">
			<?}?>
			<tr>
				<td height="50">
					<font class="T4">ㆍ등록일자</font>
				</td>
				<td colspan="2"><input type="text" name="reg_date" size="20" maxlength="70"
						<?if($row_board['reg_date']){?>value="<?=$row_board['reg_date']?>"
					<?} else {?>value="<?=date("Y-m-d H:i:s");?>"
					<?}?> class="FORM1" readonly></td>
			</tr>
			<tr>
				<td width="150" height="50">
					<font class="T4">ㆍ배너 이미지</font>
				</td>
				<td width="300">
					<? if($row_board['fileadd_folder']) { ?>
					기존 이미지
					<div id="tableExist">
						<table align="left" style="width:auto; border: none;">
							<thead>
								<th>Image</th><!--<th>Size</th>-->
							</thead>
							<tbody align="center">
								<?php
									foreach ($files as $f) {
										if ($f !== "." && $f !== ".." && $f !== ".DS_Store" && substr($f, -4) !== ".txt") {
											echo "<tr><td><img height='60' src='$dir/$f'/></td>";
										}
									}
								?>
							</tbody>
						</table>
					</div>
					<? } ?>
				</td>
				<td width="600">
					업로드 할 이미지
					<?if($row_board['fileadd_name']) {
					$row_board['fileadd_size'] = filesize("$ROOT_PATH/$tablefile/$row_board[fileadd_name]");	
					?>
					삭제 <input type="checkbox" name="delimg_1" value="Y" class="border">
					<?echo"<a href='$PHP_SELF?down=$row_board[fileadd_name]&file_name=$row_board[fileadd_name]&size=$row_board[fileadd_size]&board_name=$tablefile'>"?><?=$row_board['fileadd_org']?></a>
					<?}?>
					<?if($tablename=="tb_board1") echo "내용보기";?>
					<input type="file" name="fileadd[]" id="input" multiple accept="image/*"/>
					<div id="table"></div>
				</td>
			</tr>
			<? if($c_name=="post1") { ?>
			<tr>
				<td width="150" height="50">
					<font class="T4">ㆍ제품 이미지</font>
				</td>
				<td width="300">
					<? if($row_board['fileadd_folder']) { ?>
					기존 이미지
					<div id="tableExist">
						<table align="left" style="width:auto; border: none;">
							<thead>
								<th>Image</th><!--<th>Size</th>-->
							</thead>
							<tbody align="center">
								<?php
									foreach ($filesProduct as $f) {
										if ($f !== "." && $f !== ".." && $f !== ".DS_Store" && substr($f, -4) !== ".txt") {
											echo "<tr><td><img height='60' src='$dirProduct/$f'/></td>";
										}
									}
								?>
							</tbody>
						</table>
					</div>
					<? } ?>
				</td>
				<td width="600">
					업로드 할 이미지
					<input type="file" name="fileadd_product[]" id="input_product" multiple accept="image/*"/>
					<div id="tableProduct"></div>
			</tr>
			<? } ?>
		</table>
		<table border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td align="right">
					<button class="admin-button submit">제출</button>
					<a class="admin-button" href="<?echo" $_SERVER[PHP_SELF]?c_name=$c_name&bmain=list"?>">취소</a>
				</td>
			</tr>
		</table>
	</form>