<?
@extract($_GET); 
@extract($_POST); 

    $get_page  = escape_string($_GET['page']);
    $get_plist = escape_string($_REQUEST['plist']);

    $pagePerBlock = "10";
    empty($get_plist) ? $pagesize = "10" :  $pagesize = $get_plist; /// 페이지출력수
    empty($get_page) ? $page = 1 : $page = $get_page;  /// 페이지번호

    $pageurl = $_SERVER['PHP_SELF'];
    $perpage = ($page-1) * $pagesize;

	$search = "plist=".$get_plist."&conf=".$conf."&board_uid=".$board_uid;


    $where_add .= " AND board_uid='".$board_uid."'";
     /// 갯수뽑기용 쿼리
    $query = "SELECT * FROM  $memo_tablename  WHERE 1 ".$where_add." ORDER BY fidnum ASC, thread ASC";
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
	  <table width="880" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="30"><img src="./img/bbs1_32.gif" width="17" height="11" /><font class="T5">댓글 
            (<?=$total_num;?>) </font></td>
        </tr>
      </table>
      <table width="880" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td height="1" colspan="4" background="./img/bbs1_3.gif"></td>
        </tr>

	<?
		$g=1;
        for ( $i=0 ; $i<$rcount ; $i++ ) {			
	?>
        <tr onmouseover="this.style.background='#FAFAFB'" onmouseout="this.style.background='#FFFFFF'"> 
          <td width="100" height="30"><?//=$numbers?> <?=$result[$i][uname]?></td>
          <td>
			<?
				$reply_space=5;
				########## 답변 단계에 따라서 안으로 한칸씩 밀어서 출력 ##########
				 $space = strlen($result[$i][thread])-1;
				 if($space > $reply_space)   
					 $space = $reply_space;  //답변글이 $reply_space 값 이상이 되면  출력 간격을 고정
				 if($space>0){
					 for($j = 0; $j < $space; $j++) {
						echo("&nbsp;");
					 }
					 echo("&nbsp;&nbsp;<img src=./img/bbs1_50.gif>");
				 }
			
				 $memo_uid = $result[$i][uid];
			?>
		  <?=$result[$i][content]?> </td>
          <td width="110"><div align="center"><?=$result[$i][reg_date]?></div></td>
          <td width="80"><div align="center"><!-- 삭제 --><a href="javascript: onClick=contentDel('<?echo"$_SERVER[PHP_SELF]?bmain=ok&conf=$conf&uid=$memo_uid&formmode=delete&board_uid=$board_uid"?>');"><img src="./img/bbs1_44.gif"  border="0" /></a>
				<?if($result[$i][thread]=="A") {?>
				<a onclick="javascript:showhide(menu_reply_<?echo"$g"?>,'');init2();" style="cursor:hand" alt='댓글답변달기'><img src="./img/bbs1_44_1.gif" border="0" alt="답변"  ></a>
				<?}?>
		  </div></td>
        </tr>
        <tr> 
          <td height="1" colspan="4" background="./img/bbs1_3.gif"></td>
		</tr>
		<tr>
			<td colspan=4>
				<div  id='menu_reply_<?echo"$g"?>' style='display:none;'>
				<table width="880"  border="0" align="center" cellpadding="0" cellspacing="0">
				<!-- 답변달기 부분 -->
			<?if($result[$i][thread]=="A") {?>
				<form name=recommform_<?echo"$g"?> action="<?=$_SERVER["PHP_SELF"]?>" method="post"  ENCTYPE="multipart/form-data">

				<input type="hidden" name="bmain" value="ok">
				<input type="hidden" name="conf" value="<?=$conf?>">
				<input type="hidden" name="board_uid" value="<?=$board_uid?>">
				<input type="hidden" name="formmode" value="reply">
				<input type="hidden" name="fidnum" value="<?=$result[$i][fidnum]?>">
				<input type="hidden" name="thread" value="<?=$result[$i][thread]?>">
				<input type="hidden" name="g" value="<?=$g?>">


				<tr onmouseover="this.style.background='#FAFAFB'" onmouseout="this.style.background='#FFFFFF'"> 
				  <td width="158" height="35">&nbsp;</td>
				  <td width="621"> <strong>답변</strong> 
					<input name="reply_content_<?echo"$g"?>" type="text" class="FORM1" id="textfield22222" size="95" /> 
				  </td>
				  <td width="84"><div align="center"><a href="javascript:onClick=recommform_<?echo"$g"?>.submit();"><img src="./img/btn_161.gif" width="46" height="19" border="0" /></a></div></td>
				  <td width="17"><div align="center"></div></td>
				</tr>
				<tr> 
				  <td height="1" colspan="4" background="./img/bbs1_3.gif"></td>
				</tr>
				</form>
			<?}?>
				<!-- end 답변달기 부분 -->
				</table>
				</div>
			</td>
		</tr>
	<?
	$numbers--; //paging에 따른 번호
	$g++;
	}?>       
      </table>
     
      <table width="315" height="23" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td align=center><br><?=$pageNaviHTML;?></td>
        </tr>
      </table>
      <br />

	<!-- 댓글 입력 폼 ================== -->
	<form name="memoform" action="<?=$_SERVER["PHP_SELF"]?>" method="post" onSubmit="return memoCheck()" ENCTYPE="multipart/form-data">
	<input type="hidden" name="bmain" value="ok">
	<input type="hidden" name="conf" value="<?=$conf?>">
	<input type="hidden" name="board_uid" value="<?=$board_uid?>">
	<input type="hidden" name="formmode" value="save">
      <table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td><img src="./img/bbs1_33_2.gif" width="880" height="13" /></td>
        </tr>
        <tr> 
          <td background="./img/bbs1_34.gif"><table width="840" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="785" height="42"><textarea name="content" cols="105" rows="2" class="FORM1"></textarea>
                </td>
                <td width="55"><a href="javascript:onClick=memoCheck();" ><img src="./img/btn_93.gif" width="55" height="34" border="0" /></a></td>
              </tr>
              <!-- <tr>
                <td height="22" valign="bottom">0/600 bytes </td>
                <td valign="top">&nbsp;</td>
              </tr> -->
            </table></td>
        </tr>
        <tr> 
          <td><img src="./img/bbs1_35_2.gif" width="880" height="15" /></td>
        </tr>
      </table>
	  </form>