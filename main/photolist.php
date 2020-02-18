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
<table width="80%" align="center" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<? if ($tablename == "tb_post") {?>
		<td align="center" class="border-n">
			<span class="list_tit">
				Portfolio
			</span>
		</td>
		<? } else if ($tablename == "tb_post1") { ?>
		<td align="center" class="border-n">
			<span class="list_tit">
				Product
			</span>
		</td>
		<td align="center" class="border-n">
			<span class="list_tit">
				<a class="product_menu" href="./material.php">Material</a>
			</span>
		</td>
		<? } else {?>
		<td align="center" class="border-n">
			<span class="list_tit">
				Product
			</span>
		</td>
		<td align="center" class="border-n">
			<span class="list_tit">
				<a class="product_menu" href="./material.php">Material</a>
			</span>
		</td>
		<? } ?>
	</tr>
</table>
<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
	<tbody>
	<?
		if ($rcount == 0) { echo "<div class='not-found'>Sorry, no posts matched your criteria.</div>"; }
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
	</tbody>
</table>