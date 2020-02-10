<?php

    $get_field = escape_string($_REQUEST['find_field']);
    $get_word  = escape_string($_REQUEST['find_word'],'1');
    $get_ordby = escape_string($_REQUEST['ordby']);
    $get_viewtype = escape_string($_REQUEST['find_viewtype']);

    $get_page  = escape_string($_GET['page']);
    $get_plist = escape_string($_REQUEST['plist']);

    $pagePerBlock = "9";
    empty($get_plist) ? $pagesize = "10" :  $pagesize = $get_plist; /// 페이지출력수
    empty($get_page) ? $page = 1 : $page = $get_page;  /// 페이지번호

    $pageurl = $_SERVER['PHP_SELF'];
    $perpage = ($page-1) * $pagesize;
    $search = "plist=".$get_plist."&find_field=".$get_field."&find_word=".$get_word."&find_state=".$find_state."&find_ordby=".$get_ordby."&conf=".$conf;

    ///정렬
    if(empty($get_ordby)){
        $ORDER_BY = "";
    } else {
        $ORDER_BY = str_replace("__"," ",$get_ordby).",";
    }

    ///검색정보
    $where_add ="";

    if(!empty($get_field) && !empty($get_word)){
        $where_add .= " AND ".$get_field." like '%".$get_word."%'";
    }

    if(!empty($get_viewtype)){	
		//상태정보
        $where_add .= " AND viewtype = '".$find_viewtype."'";
    }


     /// 갯수뽑기용 쿼리
    $query = "SELECT * FROM  $tablename  WHERE 1 and viewtype!='N' $w_sql ".$where_add." ORDER BY ".$ORDER_BY." fidnum DESC, thread ASC";
	//echo "$query /<br>";
    $result_cnt = $db->fetch_array( $query );
    $total_num = count($result_cnt) ;

    if(!empty($total_num)){
        //연결 URL, 총번호, 한페이지갯수, 최대페이지번호, 현재페이지, 서치
        $pageNavi = $common->paging( $pageurl, $total_num, $pagesize, $pagePerBlock, $page, $search);
        $pageNaviHTML = '<div class="paging-box"><ul>'.$pageNavi.'</ul></div>'; ///페이징

        //목록 출력 적용
        // $limit = "limit $perpage, $pagesize";
        $numbers = $total_num - $perpage;

    // 전체 쿼리에 제한 걸기
    $query = $query ." ".$limit;
	//echo "$query ///<br>";

        $result = $db->fetch_array( $query );
        $rcount = count($result) ;
    }
	$totalNumOfPage = ceil($total_num/$pagesize);
?>

  <table width="1000px" align="center" border="0" cellspacing="0" cellpadding="0">

	<?
        for ( $i=0 ; $i<$rcount ; $i++ ) {			
		$link_page = "$_SERVER[PHP_SELF]?bmain=view&uid=".$result[$i]['uid'];

		if($MEMOUSETYPE=="Y") {
			#### 댓글 사용하는 경우 갯수 조회 ########
			$query_tot = "SELECT uid FROM  $memo_tablename  WHERE board_uid='".$result[$i]['uid']."'";			
			$result_memo_count = $db->num_rows( $query_tot );
			if($result_memo_count) $result_memo_count = "(".$result_memo_count.")"; else $result_memo_count="";
		}

		if($MODEUSETYPE=="Y"){	//분류사용인경우
			$row_board_mode = "[".$ARR_BOARD_TYPE[$result[$i]['mode']]."] ";
		}

		$today = date("Y-m-d");

		$my_fileadd_name = $result[$i]['fileadd_name'];
	?>
	<? 		
		if(($td%2) == 0) {
			echo("<tr>  ");
		} 		
	?>
		<td>
			<table class="portfolio-wrap" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<a class="portfolio-element" href="<?=$link_page?>">
						<?
						if($my_fileadd_name) {
							echo "<img style='vertical-align: middle;' src='$HOME_PATH/$tablefile/$my_fileadd_name' border=0 height='100%' width='100%'>";
						} else {
							echo "<img src=$HOME_PATH/Bimg/no_image.gif border=0 height='100%' width='100%'>";
						}
						?>
							<div class="portfolio-title"><?=$common->cut_string($result[$i]['title'],43)?></div>
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
	?>

	<?
	$numbers--; //paging에 따른 번호
	}?>

	</table>
<style>
	
	.portfolio-wrap {
		position:relative;
		width: 480px;
		height: 480px;
		border: solid 1px #666;
		margin: 10px;
		opacity: 0.5;
		transition: all 0.4s;
	}
	.portfolio-wrap:hover { opacity: 1; }
	.portfolio-wrap:hover .portfolio-title { transform: translateX(0); }
	.portfolio-element:hover {
		text-decoration: none;
	}
	.portfolio-title {
		position: absolute;
		width: 100%;
		padding: 20px;
		height: 20px;
		top: 0; bottom: 0; left: 20%;
		margin: auto;
		font-size: 20px;
		background-color: #fff;
		transition: all 0.4s ease-in-out;
		transform: translateX(100%);
	}
</style>