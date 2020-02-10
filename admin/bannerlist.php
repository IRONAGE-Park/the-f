<?php
    $query = "SELECT * FROM tb_banner ORDER BY reg_date DESC";
    $result = $db->fetch_array( $query );
    $rcount = count($result);

    $m_query = "SELECT * FROM tb_mbanner ORDER BY reg_date DESC";
    $m_result = $db->fetch_array( $m_query );
    $m_rcount = count($m_result);
?>

<!-- 본문컨텐츠부분 시작 -->

<div id="admin-upload-shade">
  <div class="admin-upload-box">
    <form class="admin-upload-form" name="signform" method="post" action="<?echo" $_SERVER[PHP_SELF]?c_name=banner"?>" onsubmit="return frmCheck('title');" ENCTYPE="multipart/form-data">
      <input type="hidden" name="formmode" value="save">
      <input type="hidden" name="conf" value="<?=$conf?>"><!-- 환경설정파일  -->
      <input type="hidden" name="bmain" value="ok">
      <table border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td height="50" width="150">
              <font class="T4">ㆍ제목</font>
            </td>
            <td width="730"><input type="text" name="title" size="30" id="title" title="제목" maxlength="250"
                class="FORM1" value="<?=$row_board['title']?>">
            </td>
          </tr>
          <tr>
            <td height="50" width="150">
              <font class="T4">ㆍ연결주소</font>
            </td>
            <td width="730"><input type="text" name="moveurl" size="30" id="moveurl" title="연결주소" maxlength="250"
                class="FORM1" value="<?=$row_board['moveurl']?>">
            </td>
          </tr>
          <tr>
            <td width="20%" height="50">
              <font class="T4">ㆍ출력여부</font>
            </td>
            <td width="80%"><input type="radio" name="viewtype" value="Y" <?if($row_board['viewtype']=="Y" )
                echo"checked"; else if(!$row_board['viewtype']) echo "checked" ;?> />
              출력
              <input type="radio" name="viewtype" value="N" <?if($row_board['viewtype']=="N" ) echo"checked"; ?> />
              숨기기</td>
          </tr>
          <tr>
            <td height="120">
              <font class="T4">ㆍ첨부이미지</font>
            </td>
            <td>
              <script type="text/javascript">
                $(document).ready(function () {
                  //이미지 팝업
                  $(".fancybox-effects-d").fancybox({
                    closeClick: true,
                    openEffect: 'none',
                    closeEffect: 'none',
                    helpers: {
                      title: {
                        type: 'over'
                      }
                    }
                  });
                });
              </script>
              <input type="file" name="fileadd" size=50 id="fileadd" title="첨부이미지">
            </td>
          </tr>
          <tr>
            <td height="50">
              <font class="T4">ㆍ등록일자</font>
            </td>
            <td>
              <input type="text" name="reg_date" size="20" maxlength="70" value="<?=date("Y-m-d H:i:s");?>" class="FORM1" readonly>
            </td>
          </tr>
      </table>
      <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="55" align="right"><button class="admin-button submit">제출</button>
              <a class="admin-button" href="javascript:uploadToogleSwitch();">
                취소
              </a>
            </td>
          </tr>
      </table>
    </form>
  </div>
</div>

<div class="admin-image-title">Desktop Banner</div>
<table style="border:none;" cellpadding="0" cellspacing="0">
    <?
      for ( $i=0 ; $i<$rcount ; $i++ ) {
		  $link_page = "";
			if(($td%4) == 0) {
				echo("<tr>  ");
			}
			$board_img = "$HOME_PATH/$tablefile/".$result[$i]['fileadd_name'];
		?>

  <td>
    <table style="border:none;" width="200" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="160" align="center">
          <a href="javascript:swal('삭제하시겠습니까?', { dangerMode: true, buttons: true });">
            <div class="admin-image-box">
              <img width="200" height="160" src=<?=$board_img?> />
              <div class="admin-image-overlay">
                <span class="admin-image-plus">X</span>
              </div>
            </div>
          </a>
        </td>
      </tr>
    </table>
  </td>
  <?
		$td += 1;
		if(($td%4) == 0) {
			echo("</tr> <tr><td height=20></td></tr> ");
		}
	}//end for
  ?>
  <td>
    <table style="border:none;" width="200" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="160" align="center">
          <a href="javascript:uploadToogleSwitch();">
            <div class="admin-image-box">
              <div class="admin-image-overlay" style="opacity: 0.5">
                <span class="admin-image-plus">+</span>
              </div>
            </div>
          </a>
        </td>
      </tr>
    </table>
  </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
</table>


<!-- 모바일 배너 -->
<div class="admin-image-title">Mobile Banner</div>
<table style="border:none;" cellpadding="0" cellspacing="0">
  <?
  $td = 0;
  for ( $i=0 ; $i<$m_rcount ; $i++ ) {
		$link_page = "$_SERVER[PHP_SELF]?c_name=${c_name}&bmain=view&uid=".$m_result[$i]['uid'];
    if(($td%5) == 0) {
      echo("<tr>");
    }
    $board_img = "$HOME_PATH/$tablefile/".$m_result[$i]['fileadd_name'];
	?>
  <td>
    <table style="border:none;" width="160" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="200" align="center">
          <a href="<?=$link_page?>">
            <div class="admin-image-box mobile">
              <img width="160" height="200" src=<?=$board_img?> />
              <div class="admin-image-overlay mobile">
                <span class="admin-image-plus">X</span>
              </div>
            </div>
          </a>
        </td>
      </tr>
    </table>
  </td>
  <?
		$td += 1;
		if(($td%5) == 0) {
			echo("</tr> <tr><td height=20></td></tr> ");
		}
	}//end for
  ?>
  <td>
    <table style="border:none;" width="160" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="200" align="center">
          <a href="javascript:uploadToogleSwitch();">
            <div class="admin-image-box mobile">
              <div class="admin-image-overlay mobile" style="opacity: 0.5">
                <span class="admin-image-plus">+</span>
              </div>
            </div>
          </a>
        </td>
      </tr>
    </table>
  </td>
  </tr>
  <tr>
    <td height="20"></td>
  </tr>
</table>