<?php

    $get_field = escape_string($_REQUEST['find_field']);
    $get_word  = escape_string($_REQUEST['find_word'],'1');
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

    if(!empty($get_field) && !empty($get_word)){
        $where_add .= " AND ".$get_field." like '%".$get_word."%'";
    }

    if(!empty($get_viewtype)){	
		//상태정보
        $where_add .= " AND viewtype = '".$find_viewtype."'";
    }


     /// 갯수뽑기용 쿼리
    $query = "SELECT * FROM  $tablename  WHERE topview!='Y'  and viewtype!='N' $w_sql ".$where_add." ORDER BY ".$ORDER_BY." fidnum DESC, thread ASC";
	//echo "$query /<br>";
    $result_cnt = $db->fetch_array( $query );
    $total_num = count($result_cnt) ;

    if(!empty($total_num)){
        //연결 URL, 총번호, 한페이지갯수, 최대페이지번호, 현재페이지, 서치
        $pageNavi = $common->paging_new( $pageurl, $total_num, $pagesize, $pagePerBlock, $page, $search);
        $pageNaviHTML = ''.$pageNavi.''; ///페이징

        //목록 출력 적용
        $limit = "limit $perpage, $pagesize";
        $numbers = $total_num - $perpage;

    // 전체 쿼리에 제한 걸기
    $query = $query ." ".$limit;
	//echo "$query ///<br>";

        $result = $db->fetch_array( $query );
        $rcount = count($result) ;
    }
	$totalNumOfPage = ceil($total_num/$pagesize);
?>
<form method="POST" action="?" id="searchForm">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="right">
                <table border="0" cellspacing="5" cellpadding="0">
                    <tr>
                        <td>
                            <select name="find_field" class="styled">
                                <option value="title" <?=($get_field=="title"  )?"selected":"";?>>제목</option>
                                <option value="content" <?=($get_field=="uname")?"selected":"";?>>내용</option>
                            </select>
                        </td>
                        <td>
                            <div class="qna-search-box">
                                <input name="find_word" value="<?=$get_word;?>" type="text" class="search-input">
                                <button class="search-submit" type="submit"><img src="../img/search.svg"></button>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <tr>
        <td valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="60" align="center" class="qna_list01">번호</td>
                    <td align="center" class="qna_list01">제목</td>
                    <td width="65" align="center" class="qna_list01 m_dis">작성자</td>
                    <td width="65" align="center" class="qna_list01 m_dis">작성일</td>
                    <td width="60" align="center" class="qna_list01 m_dis">조회</td>
                </tr>

                <!-- 상단 출력인 경우 사용  -->
                <?
     /// 갯수뽑기용 쿼리
    $query1 = "SELECT * FROM  $tablename  WHERE topview='Y' ".$where_add." ORDER BY ".$ORDER_BY." fidnum DESC, thread ASC";
	//echo "$query /<br>";
       $result1 = $db->fetch_array( $query1);
       $rcount1 = count($result1) ;

        for ( $t=0 ; $t<$rcount1 ; $t++ ) {			
		$link_page = "$_SERVER[PHP_SELF]?bmain=view&uid=".$result1[$t]['uid'];
	?>
                <tr>
                    <td>[공지]</td>
                    <td class="subject">
                        <a href="<?=$link_page?>"><?=$common->cut_string($result1[$t]['title'],43)?></a><img
                            src="../asset/img/main/ico_new.png" alt="new">
                    </td>
                    <td><?=$result1[$t]['uname']?></td>
                    <td><?=$common->dateStyle(substr($result1[$t]['reg_date'],0,10),".")?></td>
                    <td><?=$result1[$t]['ref']?></td>
                </tr>
                <?}?>
                <!-- end 상단 출력인 경우 사용  -->


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
	?>

                <tr>
                    <td align="center" class="qna_list02"><?=$numbers?></td>
                    <td class="qna_list02">
                        <a href="<?=$link_page?>"><?=$common->cut_string($result[$i]['title'],43)?></a>
                        <? if($today==$result[$i]['reg_date']) echo " <img src='../asset/img/main/ico_new.png' alt='new'>"; ?>
                    </td>
                    <td align="center" class="m_dis qna_list02"><?=$result[$i]['uname']?></td>
                    <td align="center" class="m_dis qna_list02">
                        <?=$common->dateStyle(substr($result[$i]['reg_date'],0,10),".")?></td>
                    <td align="center" class="m_dis qna_list02"><?=$result[$i]['ref']?></td>
                </tr>


                <?
	$numbers--; //paging에 따른 번호
	}?>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center">
            <!--pagenum-->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="right" style="padding:20px 0 100px 0" width=100></td>
                    <td align="center" style="padding:20px 0 100px 0">
                        <table border="0" cellspacing="8" cellpadding="0">
                            <tr>
                                <?=$pageNaviHTML;?>
                            </tr>
                        </table>

                    </td>
                    <td align="right" style="padding:20px 0 100px 0" width=100>
                        <?if($MEMBER_WRITE=="Y") {?>
                        <a href="<?echo" $_SERVER[PHP_SELF]?bmain=write"?>" class="thef-button">
                        글쓰기</a>
                        <?}?>
                    </td>
                </tr>
            </table>
            <!--//pagenum-->


        </td>
    </tr>
</form>