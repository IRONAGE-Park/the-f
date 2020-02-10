<?php
@extract($_GET);
@extract($_POST);
    $get_field = escape_string($_REQUEST['find_field']);
    $get_word  = escape_string($_REQUEST['query'],'1');
    $get_ordby = escape_string($_REQUEST['ordby']);
	$get_viewtype = escape_string($_REQUEST['find_viewtype']);
	$get_mode = escape_string($_REQUEST['find_mode']);

    if(empty($get_ordby)){ $get_ordby = escape_string($_REQUEST['find_ordby']); }

    $get_page  = escape_string($_GET['page']);
    $get_plist = escape_string($_REQUEST['plist']);

    $pagePerBlock = "10";
	if($BOARD_TYPE=="PHOTO") {
	    empty($get_plist) ? $pagesize = "12" :  $pagesize = $get_plist; /// 페이지출력수
	} else {
	    empty($get_plist) ? $pagesize = "5" :  $pagesize = $get_plist; /// 페이지출력수
	}
    empty($get_page) ? $page = 1 : $page = $get_page;  /// 페이지번호

    $pageurl = $_SERVER['PHP_SELF'];
    $perpage = ($page-1) * $pagesize;
    $search = "plist=".$get_plist."&find_field=".$get_field."&find_word=".$get_word."&find_state=".$find_state."&find_ordby=".$get_ordby."&find_viewtype=".$find_viewtype."&find_mode=".$find_mode."&conf=".$conf;

    ///검색정보
    $where_add ="";

    ///정렬
    if(empty($get_ordby)){
        $ORDER_BY = "";
    }else{
        $ORDER_BY = str_replace("__"," ",$get_ordby).",";
    }

    $get_field = 'title';
    if(!empty($get_field) && !empty($get_word)){
        $where_add .= " AND ".$get_field." like '%".$get_word."%'";
    }
	$query = "SELECT * FROM  $tablename  WHERE 1 ".$where_add;
	
	for($i = 1; $i < 10; $i++)
		$query .= " UNION SELECT * FROM tb_pro${i} WHERE 1 ".$where_add;

	$query .= " ORDER BY ".$ORDER_BY." reg_date DESC";
    $result_cnt = $db->fetch_array( $query );
    $total_num = count($result_cnt) ;

	// if(!empty($total_num))
	{
        //연결 URL, 총번호, 한페이지갯수, 최대페이지번호, 현재페이지, 서치
        $pageNavi = $common->paging( $pageurl, $total_num, $pagesize, $pagePerBlock, $page, $search);
        $pageNaviHTML = '<div class="paging-box"><ul>'.$pageNavi.'</ul></div>'; ///페이징
        //목록 출력 적용
        $limit = "limit $perpage, $pagesize";
    	$query = $query ." ".$limit;
        $result = $db->fetch_array($query);
        $rcount = count($result) ;
    }
?>
<div class="search-body-result-count"><?=$total_num?></div>
<form method="POST" action=<?="./more.html?query=".$get_word?>>
	<table class="search-body-contain-wrap">
		<?
    	/// 갯수뽑기용 쿼리
    	$query1 = "SELECT * FROM  $tablename  WHERE topview='Y' ".$where_add." ORDER BY ".$ORDER_BY." fidnum DESC, thread ASC";
        $result1 = $db->fetch_array($query1);
        $rcount1 = count($result1) ;

        for ( $t=0 ; $t<$rcount1 ; $t++ ) {
		$link_page = "$_SERVER[PHP_SELF]?bmain=view&uid=".$result1[$t]['uid'];

		?>
		<tr height="33">
			<td></td>
			<td align="center"><b>[공지]</b></td>
			<td><a href="<?=$link_page?>"><?=$result1[$t]['title']?></a> <?=$result_memo_count?></td>
			<td align="center"><a href="<?=$link_page?>"><?=substr($result1[$t]['reg_date'],0,10)?></a></td>
			<?if($REFUSETYPE=="Y") {?>
			<td align="center"><?=$result1[$t]['ref']?></td>
			<?}?>
			<td align="center"><?=$result1[$t]['viewtype']?></td>
		</tr>
		<?}?>
		<!-- end 상단 출력인 경우 사용  -->

		<?
        for ( $i=0 ; $i<$rcount ; $i++ ) {
		$link_page = "/product/view.php?bmain=view&uid=".$result[$i]['uid'];

		?>
		<tr class="search-body-contain-element">
			<td class="search-body-contain-image" align="center">
				<a href="<?=$link_page?>">
				<? 
				if ($result[$i]['fileadd_name']) {
					echo "<img src='$HOME_PATH/$tablefile/".$result[$i]['fileadd_name']."'>";
				} else {
					echo "<img src=$HOME_PATH/Bimg/loading.gif>";
				}
				?>
				</a>
			</td>
        	<td class="search-body-contain-text">
            	<div class="search-body-contain-title">
					<a href="<?=$link_page?>"><?=$row_board_mode?><?=$result[$i]['title']?></a>
					<?=$row_reply?> <?=$result_memo_count?>
				</div>
				<div class="search-body-contain-content">임시 내용</div>
			</td>
			<td>
				<?=$common->dateStyle(substr($result[$i]['reg_date'],0,10),".")?>
			</td>
			<td>
				조회수 <?=$result[$i]['ref']?>
			</td>
		</tr>
		<? } ?>
	</table>
	<? if (empty($get_plist) && $total_num > 5) { ?>
		<input type="hidden" name="plist" value="<?=$total_num?>"/>
		<input type="hidden" name="conf_name" value="conf_pro"/>
		<input type="hidden" name="page_name" value="prolist"/>
		<button class="search-body-contain-more">
            더보기 >
        </button>
	<? } ?>
</form>