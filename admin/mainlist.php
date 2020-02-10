<?php
  @extract($_GET);
  @extract($_POST);

    $get_sdate = escape_string($_REQUEST['sdate']);
    $get_city  = escape_string($_REQUEST['city_1']);
    $get_county= escape_string($_REQUEST['county_1']);
    $get_field = escape_string($_REQUEST['find_field']);
    $get_word  = escape_string($_REQUEST['find_word'],'1');
    $get_ordby = escape_string($_REQUEST['ordby']);
    if(empty($get_ordby)){ $get_ordby = escape_string($_REQUEST['find_ordby']); }
	$get_viewtype = escape_string($_REQUEST['find_viewtype']);

    $get_page  = escape_string($_GET['page']);
    $get_plist = escape_string($_REQUEST['plist']);

	$pagePerBlock = "10";
    empty($get_plist) ? $pagesize = "10" :  $pagesize = $get_plist; /// 페이지출력수
    empty($get_page) ? $page = 1 : $page = $get_page;  /// 페이지번호

    $pageurl = $_SERVER['PHP_SELF'];
    $perpage = ($page-1) * $pagesize;
    $search = "c_name=main&plist=".$get_plist."&find_field=".$get_field."&find_word=".$get_word."&find_state=".$find_state."&find_ordby=".$get_ordby."&conf=".$conf."&get_viewtype=".$viewtype;

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

    if(!empty($get_sdate) && !empty($get_edate)){
		//날자검색
        $where_add .= " AND substring(reg_date,1,10) between '".$get_sdate."' AND '".$get_edate."'";
    }

    if(!empty($get_viewtype)){
		//상태정보
        $where_add .= " AND viewtype = '".$get_viewtype."'";
    }

     /// 갯수뽑기용 쿼리
    $query = "SELECT * FROM  $tablename  WHERE 1 ".$where_add." ORDER BY ".$ORDER_BY." reg_date DESC";
	//echo "$query /<br>";
    $result_cnt = $db->fetch_array( $query );
    $total_num = count($result_cnt) ;

    if(!empty($total_num)){
        //연결 URL, 총번호, 한페이지갯수, 최대페이지번호, 현재페이지, 서치
        $pageNavi = $common->paging( $pageurl, $total_num, $pagesize, $pagePerBlock, $page, $search);
        $pageNaviHTML = '<div class="paging-box"><ul>'.$pageNavi.'</ul></div>'; ///페이징

        //목록 출력 적용
        $limit = "limit $perpage, $pagesize";
        $numbers = $total_num - $perpage;

    // 전체 쿼리에 제한 걸기
    $query = $query ." ".$limit;
	//echo "$query ///<br>";

        $result = $db->fetch_array( $query );
        $rcount = count($result) ;
    }
?>
<form name="listform" method="post">
  <table class="admin-manage-view-content" border="0" cellspacing="0" cellpadding="0">
    <tr class="admin-manage-view-header">
      <td width="33" align="center"><input type="checkbox" name="allCheck" value="all" onclick="checkall(this.form)">
      </td>
      <td width="66" align="center">
        <font class="T4">번호</font>
      </td>
      <td width="100" align="center">
        <font class="T4">이미지</font>
      </td>
      <td align="center">
        <font class="T4">제목</font>
      </td>
      <td width="105" align="center">
        <font class="T4">등록일</font>
      </td>
      <td width="80" align="center">
        <font class="T4">상태</font>
      </td>
    </tr>
    <?
        for ( $i=0 ; $i<$rcount ; $i++ ) {
		$link_page = "$_SERVER[PHP_SELF]?c_name=main&bmain=write&uid=".$result[$i]['uid'];

		if($MODEUSETYPE=="Y"){	//분류사용인경우
			$row_board_mode = "[".$ARR_BOARD_TYPE[$result[$i]['mode']]."] ";
		}
	?>

  <tr class="admin-manage-view-list">
      <td align="center"><input type="checkbox" name="chklist" class=border value="<?=$result[$i]['uid']?>"></td>
      <td align="center"><?=$numbers?></td>
      <td align="center">
        <table width="100" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td height="70" align="center"><a href="<?=$link_page?>">
                <? 
				if($result[$i]['fileadd_name']) {
					echo "<img src='$HOME_PATH/$tablefile/".$result[$i]['fileadd_name']."' border=0 width=100 height=80></a></td>";
					} else {
					echo "<img src=$HOME_PATH/Bimg/no_image.gif border=0 width=100 height=80></a></td>";
					}
				?>
            </td>
          </tr>
        </table>
      </td>
      <td><a href="<?=$link_page?>" class="L4"><?=$row_board_mode?><?=$result[$i]['title']?></a></td>
      <td align="center"><a href="<?=$link_page?>"><?=substr($result[$i]['reg_date'],0,10)?></a></td>
      <td align="center"><a href="<?=$link_page?>"><?=$result[$i]['viewtype']?></a></td>
    </tr>
    <?
		$numbers--; //paging에 따른 번호
		} //end for ?>
  </table>
</form>
<table width="100%" height="70" border="0" cellpadding="0" cellspacing="0">
<tr valign="bottom">
    <td align="left" width="100"><a class="admin-button"
        href="javascript:select_member_change('board_delete','boardok.php?conf=<?=$conf?>&formmode=delete_all');">선택
        삭제</a></td>
    <td align="center"><?=$pageNaviHTML;?></td>
    <td align="right" width="100"><a class="admin-button" href="<?echo" $_SERVER[PHP_SELF]?c_name=main&bmain=write"?>">글쓰기</a></td>
  </tr>
</table>
<!--
<form method="POST" action="?c_name=<?=$c_name?>" id="searchForm">
  <table width="100%" height="50" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="100%" valign="top">
        <table border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="67" height="42">
              <select name="find_field" class="FORM3">
                <option value="title" <?=($get_field=="title"  )?"selected":"";?>>제목</option>
              </select>
            </td>
            <td width="203"><input name="find_word" type="text" size="30" class="FORM1" value="<?=$get_word;?>" />
            </td>
            <td align="right" width="80"><button class="FORM1" type="submit" border="0">검색</button></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <input type="hidden" name="plist">
  <input type="hidden" name="ordby">
  <input type="hidden" name="conf" value="<?=$conf?>">
</form>
-->


<SCRIPT type="text/javascript">
  $(document).ready(function () {
    //한페이지에 커서
    $('select[name="selectRow"]').val("<?=$pagesize;?>").attr("selected", "selected");

    //한페이지에 검색폼으로 값보내기
    $('select[name="selectRow"]').change(function () {
      var selectRowVal = $(this).val();
      $('input[name="plist"]').val(selectRowVal);
      $("#searchForm").submit();
    });

  });
</SCRIPT>