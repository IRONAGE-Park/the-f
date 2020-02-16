<?php
    $get_field = escape_string($_REQUEST['find_field']);
    $get_word  = escape_string($_REQUEST['query'],'1');
    $get_ordby = escape_string($_REQUEST['ordby']);
    $get_viewtype = escape_string($_REQUEST['find_viewtype']);

    $get_page  = escape_string($_GET['page']);
    $get_plist = escape_string($_REQUEST['plist']);

    $pagePerBlock = "10";
    empty($get_plist) ? $pagesize = "10" :  $pagesize = $get_plist; /// 페이지출력수
    empty($get_page) ? $page = 1 : $page = $get_page;  /// 페이지번호

    $pageurl = $_SERVER['PHP_SELF'];
    $perpage = ($page-1) * $pagesize;
    $search = "plist=".$get_plist."&find_field=".$get_field."&find_word=".$get_word."&find_state=".$find_state."&find_ordby=".$get_ordby."&conf=".$conf;

    ///정렬
    if(empty($get_ordby)){
        $ORDER_BY = "";
    }else{
        $ORDER_BY = str_replace("__"," ",$get_ordby).",";
    }

    ///검색정보
    $where_add ="";

    $get_field = 'title';
    if(!empty($get_field) && !empty($get_word)){
        // $where_add .= " AND ".$get_field." like '%".$get_word."%'";
        $where_add .= " AND title like '%".$get_word."%'"." OR content like '%".$get_word."%'";
    }

    if(!empty($get_viewtype)){	
		//상태정보
        $where_add .= " AND viewtype = '".$find_viewtype."'";
    }
    /// 갯수뽑기용 쿼리
    $query = "SELECT * FROM  $tablename  WHERE topview!='Y'  and viewtype!='N' $w_sql ".$where_add." ORDER BY ".$ORDER_BY." fidnum DESC, thread ASC";
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
	$totalNumOfPage = ceil($total_num/$pagesize);
?>
<div class="search-body-result-count"><?=$total_num?></div>
<form method="POST" action=<?="./more.html?query=".$get_word?>>
    <table class="search-body-contain-wrap">
        <?
            for ( $i=0 ; $i<$rcount ; $i++ ) {			
                $link_page = "/qna/qna.php?bmain=view&uid=".$result[$i]['uid'];
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
            ?>
        <tr class="search-body-contain-element">
            <td class="search-body-contain-image" align="center">
                <a href="<?=$link_page?>">
                    <?echo "<img src=$HOME_PATH/img/logo/logo_1.svg>";?>
                </a>
            </td>
            <td class="search-body-contain-text">
                <div class="search-body-contain-title">
                <a href="<?=$link_page?>">
                    <?=$common->cut_string($result[$i]['title'],43)?>
                </a>
                </div>
                <div class="search-body-contain-content"><?=$result[$i]['content'],43?></div>
                <? if($today==$result[$i]['reg_date']) echo " <img src='../asset/img/main/ico_new.png' alt='new'>"; ?>
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
    <!--
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding:20px 0 100px 0">
                <table border="0" cellspacing="8" cellpadding="0">
                    <tr>
                        <?=$pageNaviHTML;?>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    -->
    <? if (empty($get_plist) &&$total_num > 5) { ?>
		<input type="hidden" name="plist" value="<?=$total_num?>"/>
		<input type="hidden" name="conf_name" value="conf_board"/>
		<input type="hidden" name="page_name" value="boardlist"/>
        <button class="search-body-contain-more">
            더보기 >
        </button>
    <? } ?>
</form>
