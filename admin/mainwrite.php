<?
@extract($_GET); 
@extract($_POST); 

############### DB 정보를 가지고 온다 ####################
  if($uid) {		 
	 $row_board = get_tb_popup($uid,$tablename); //func_other.php 에서 호출 해서 게시판 정보 가지고 온다 
	 if(!$row_board['uid']) {
		 $common->error("관련된 정보가 없습니다.","previous","");
	 }
  }
  ?>
<?if(!$row_board['uid']) {?>
<!-- 등록인경우 -->
<form name="signform" method="post" action="<?echo" $_SERVER[PHP_SELF]?c_name=main"?>" onsubmit="return frmCheck('title,mode');"
  ENCTYPE="multipart/form-data">
  <input type="hidden" name="formmode" value="save">
  <input type="hidden" name="conf" value="<?=$conf?>"><!-- 환경설정파일  -->
  <input type="hidden" name="bmain" value="ok">
  <?} else {?>
  <!-- 수정인경우 -->
  <form name="signform" method="post" action="<?echo" $_SERVER[PHP_SELF]?c_name=main"?>" onsubmit="return frmCheck('title,mode');"
    ENCTYPE="multipart/form-data">
    <input type="hidden" name="formmode" value="modify">
    <input type="hidden" name="uid" value="<?=$uid?>">
    <input type="hidden" name="conf" value="<?=$conf?>"><!-- 환경설정파일  -->
    <input type="hidden" name="bmain" value="ok">
    <?}?>

    <table border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="50" width="150">
          <font class="T4">ㆍ제목</font>
        </td>
        <td width="730"><input type="text" name="title" size="80" id="title" title="제목" maxlength="250" class="FORM1"
            value="<?=$row_board['title']?>"></td>
      </tr>

      <?if($MODEUSETYPE=="Y"){?>
      <tr>
        <td width="150" height="50">
          <font class="T4">ㆍ사이트 지정 분류</font>
        </td>
        <td>
          <div class="select">
            <select name="mode" class="FORM1" title="분류">
              <option selected disabled>- 분류 -</option>
              <? for($j=1;$j<=count($ARR_BOARD_TYPE);$i++,$j++) { ?>
              <option value="<?=$j?>" <?if($row_board['mode']=="$j" ) echo"selected";?>><?=$ARR_BOARD_TYPE[$j]?></option>
              <?}?>
            </select>
          </div>
        </td>
      </tr>
      <?}?>

      <tr>
        <td width="150" height="50">
          <font class="T4">ㆍ출력여부</font>
        </td>
        <td><input type="radio" name="viewtype" value="Y" <?if($row_board['viewtype']=="Y" ) echo"checked";
            else if(!$row_board['viewtype']) echo "checked" ;?> />
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
          <?
            if($row_board['fileadd_name']) {
              $row_board['fileadd_size'] = filesize("$ROOT_PATH/$tablefile/$row_board[fileadd_name]");	
              echo "<a class='fancybox-effects-d' href='$HOME_PATH/$tablefile/$row_board[fileadd_name]' title='$row_board[title]'><img src='$HOME_PATH/$tablefile/$row_board[fileadd_name]' width=80 border=0></a>";
            }
          ?>
          <input type="file" name="fileadd" size=50 id="fileadd" title="첨부이미지">
          <?if($row_board['fileadd_name']) { ?>
          삭제 <input type="checkbox" name="delimg_1" value="Y" class="border">
          <?echo"<a href='$PHP_SELF?down=$row_board[fileadd_name]&file_name=$row_board[fileadd_name]&size=$row_board[fileadd_size]&board_name=$tablefile'>"?><?=$row_board['fileadd_name']?></a>
          <?}?>
        </td>
      </tr>
      <tr>
        <td height="50">
          <font class="T4">ㆍ등록일자</font>
        </td>
        <td><input type="text" name="reg_date" size="20" maxlength="70"
            <?if($row_board['reg_date']){?>value="<?=$row_board['reg_date']?>"
          <?} else {?>value="<?=date("Y-m-d H:i:s");?>"
          <?}?> class="FORM1" readonly></td>
      </tr>
    </table>
    <table width="880" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="55" align="right">
          <button class="admin-button submit">제출</button>
          <a class="admin-button" href="<?echo" $_SERVER[PHP_SELF]?c_name=main&bmain=list"?>">
            취소
          </a>
        </td>
      </tr>
    </table>
  </form>