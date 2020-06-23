<?php
    
	@extract($_GET); 
	@extract($_POST); 

		$doc_root = $_SERVER['DOCUMENT_ROOT'];
		require_once($doc_root."/INC/get_session.php");
		require_once($doc_root."/INC/dbConn.php");
		require_once($doc_root."/INC/Function.php");
		require_once($doc_root."/INC/arr_data.php");

		require_once($doc_root."/INC/func_other.php");
		require_once($doc_root."/INC/down.php");			//파일 다운로드

	$url=$_SERVER["PHP_SELF"];
	$file_arr=explode("/",$url);
	$file_path=$file_arr[sizeof($file_arr)-1];
	$file_path_1=$file_arr[sizeof($file_arr)-2];
	include "../admin/conf/conf_post1.php";
    $get_word  = escape_string($_REQUEST['find_word'],'1');

    ///정렬
    if(empty($get_ordby)){
        $ORDER_BY = "reg_date DESC";
    } else {
        $ORDER_BY = str_replace("__"," ",$get_ordby).",";
    }

    ///검색정보
	$where_add ="";
	if(!empty($get_word)){
        $where_add .= " AND title like '%".$get_word."%'";
    }

     /// 갯수뽑기용 쿼리
    $query = "SELECT * FROM  $tablename  WHERE 1 ".$where_add." ORDER BY ".$ORDER_BY;
	// echo "$query /<br>";
	$result = $db->fetch_array( $query );
	$rcount = count($result) ;
?>

<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
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
			if(($td%4) == 0) {
				echo("<tr>  ");
			} 		
	?>
	<td class="product-area">
		<table align="center" class="product-wrap" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>
					<!--<a class="product-link" href="<?=$link_page?>">-->
						<div class='product-element' style="background-image:url(<?="'$dir/$files[0]'"?>)">
						<?
							if($files[0]) {
								// echo "<img class='product-image' src='$dir/$files[0]'>";
							} else {
								// echo "<img class='product-image' src='$HOME_PATH/Bimg/no_image.gif'>";
							}
						?>
						</div>
						<div class="product-title"><?=$common->cut_string($result[$i]['title'],43)?></div>
					<!--</a>-->
				</td>
			</tr>
		</table>
	</td>
		<?
			$td += 1;
			if(($td%4) == 0) {
				echo("</tr>");
			}
		}?>
		<tr class="product-paging">

		</tr>
	</tbody>
</table>