
<style>
.content-view-box::after {
    content:"";  position:absolute;  left:0; top:0;
    display:block; width:100%; height:100%;
    background-color: #000;
<?
############### DB 정보를 가지고 온다 ####################
  if($uid) {		 
	$row_board = get_tb_board($uid,$tablename); //func_other.php 에서 호출 해서 게시판 정보 가지고 온다 
	if(!$row_board['uid']) {
		$common->error("관련된 정보가 없습니다.","previous","");
	}

	##### 게시물 조회수 올림 #########
	get_tb_ref($tablename,"ref",$uid);

	if($MODEUSETYPE=="Y") {
		$row_board_mode = "[".$ARR_BOARD_TYPE[$row_board['mode']]."]";
	}
	 	$dir = '../'.$row_board['fileadd_folder']."/banner";
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
		if($files[0]) {
			echo "background:url(".$dir."/".$files[0].");";
		}
  }
?>
    background-repeat: no-repeat;
    background-position:center;
    background-origin:content-box;
    background-size: cover;
    background-attachment: fixed;
    filter: blur(10px);
    opacity: 0.8;
    z-index: -1;
}
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<table align="center" class="content-view-box">
				<tbody class="content-view-wrap">
					<tr class="content-view-area">
						<td></td>
						<td class="content-view-image">
							<div class="content-view-image-box">
								<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
									<!-- Indicators -->
									<ol class="carousel-indicators">
										<? for($i = 0; $i < count($files); $i++) { ?>
											<li data-target='#carousel-example-generic' data-slide-to=<?=$i?> <?=$i != 0 ? "" : "class='active'"?>></li>
										<? } ?>
									</ol>
									<!-- Wrapper for slides -->
									<div class="carousel-inner" role="listbox">
										<? for($i = 0; $i < count($files); $i++) { ?>
										<div class="item <?=$i != 0 ? "" : "active"?>">
											<img class="content-view-image-element" src="<?=$dir.'/'.$files[$i]?>">
										</div>
										<? } ?>
									</div>
									<!-- Controls -->
									<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
										<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
										<span class="sr-only">Previous</span>
									</a>
									<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
										<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
										<span class="sr-only">Next</span>
									</a>
								</div>
							</div>
						</td>
						<td class="content-view-text">
							<div class="content-view-text-wrap">
								<div class="content-view-text-title"><?=$row_board['title']?></div>
								<div class="content-view-text-content"><?=$row_board['content']?></div>
							</div>
						</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</td>
	</tr>
	<?

		if($tablename == "tb_post1") {
			$dir = '../'.$row_board['fileadd_folder']."/product";
			// 핸들 획득
			$handle  = opendir($dir);
			$files = array();
			if($handle) {
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
	?>
	<tr align="center" class="content-view-product">
		<td class="content-view-product-wrap">
			<div class="content-view-product-box">
			<? for($i = 0; $i < count($files); $i++) { ?>
				<a href="#">
					<div class="content-view-product-element">
						<img class="content-view-product-image" src="<?=$dir.'/'.$files[$i]?>">
						<div class="content-view-product-name"><?=$files[$i]?></div>
					</div>
				</a>
			<? } ?>
			</div>
		</td>
	</tr>
		<? }
		} ?>
	<tr>
		<td align="center" class="last_border"><a class="thef-button" href="javascript:history.back();">뒤로가기</a></td>
	</tr>
</table>