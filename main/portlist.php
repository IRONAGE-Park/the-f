<?php
    $get_field = escape_string($_REQUEST['find_field']);
    $get_word  = escape_string($_REQUEST['find_word'],'1');

    ///정렬
    if(empty($get_ordby)){
        $ORDER_BY = "reg_date DESC";
    } else {
        $ORDER_BY = str_replace("__"," ",$get_ordby).",";
    }

    ///검색정보
    $where_add ="";

     /// 갯수뽑기용 쿼리
    $query = "SELECT * FROM  $tablename  WHERE 1 ".$where_add." ORDER BY ".$ORDER_BY;
	// echo "$query /<br>";
	$result = $db->fetch_array( $query );
	$rcount = count($result) ;
?>
<div class="portfolio-name">주요 설비 현황</div>
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
	<tbody>
	<?
		// if ($rcount == 0) { echo "<div class='not-found'>Sorry, no posts matched your criteria.</div>"; }
        for ( $i=0 ; $i<$rcount ; $i++ ) {			
			$link_page = "$_SERVER[PHP_SELF]?bmain=view&uid=".$result[$i]['uid'];
			$my_fileadd_folder = $result[$i]['fileadd_folder'];
			$dir = '../'.$result[$i]['fileadd_folder']."/banner";
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
			if(($td%2) == 0) {
				echo("<tr>  ");
			} 		
	?>
	<td class="portfolio-area">
		<table align="center" class="portfolio-wrap" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<a class="portfolio-link" href="<?=$link_page?>">
						<?
							if($files[0]) {
										echo "<div class='portfolio-element' style='background-image: url($dir/$files[0]);'>";
							} else {
										echo "<div class='portfolio-element' style='background-image: url($HOME_PATH/Bimg/no_image.gif);'>";
							}
						?>
							<div class="portfolio-title"><?=$common->cut_string($result[$i]['title'],43)?></div>
							<div class="portfolio-content"><?=$common->cut_string($result[$i]['content'],43)?></div>
						</div>
					</a>
				</td>
			</tr>
		</table>
	</td>
		<?
			$td += 1;
			if(($td%2) == 0) {
				echo("</tr>");
			}
		}?>
		<tr>
			<td class="portfolio-area">
				<table align="center" class="portfolio-wrap" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<!--<a class="portfolio-link" href="<?=$link_page?>">-->
								<div class='portfolio-element'>
									<img class="portfolio-element-image" src="../upload/post/1.png">
									<div class="portfolio-title">
										공업용 오븐
									</div>
									<div class="portfolio-content">
										2500 x 2300 x 4000<br>크기의 대형 오븐 2개 보유<br><br>1200 x 1200 x 1000<br>크기의 중형 오븐 2개 보유
									</div>
								</div>
							<!--</a>-->
						</td>
					</tr>
				</table>
			</td>
			<td class="portfolio-area">
				<table align="center" class="portfolio-wrap" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<!--<a class="portfolio-link" href="<?=$link_page?>">-->
								<div class='portfolio-element'>
									<img class="portfolio-element-image" src="../upload/post/2.png">
									<div class="portfolio-title">
										컨베이어
									</div>
									<div class="portfolio-content">
										1200 x 500 x 23000<br>크기의 컨베이어 2개 및<br>자동화 시스템 보유
									</div>
								</div>
							<!--</a>-->
						</td>
					</tr>
				</table>
			</td>
			<td class="portfolio-area">
				<table align="center" class="portfolio-wrap" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>
							<!--<a class="portfolio-link" href="<?=$link_page?>">-->
								<div class='portfolio-element'>
									<img class="portfolio-element-image" src="../upload/post/3.png">
									<div class="portfolio-title">
										자동화 스프레이 기계
									</div>
									<div class="portfolio-content">
										자동화 코팅 설비 보유
									</div>
								</div>
							<!--</a>-->
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>