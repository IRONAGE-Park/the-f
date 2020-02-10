<? 
$down_name = "$tablecode_" . date("Ymd") . ".xlsx";

header("Content-type: application/vnd.ms-excel"); 
header("Cache-Control: no-store, no-cache");  
header("Content-Disposition: attachment; filename=suplus_".date('Ymd').".xls"); 
header("Content-Description: PHP4 Generated Data"); 

@extract($_GET);
@extract($_POST);
@header("Content-Type: text/html;charset=euc-kr");


 require_once("../include/header.php");


?>
<style>
BODY,TD,SELECT,input,div,form,TEXTAREA,tr {font-size:9pt;}
P,blockquote,td,br {font-size:9pt}
td {font-size: 9pt; font-family:"굴림", "굴림체", "돋움", "돋움체";line-height: 12pt; color:#666666;}

.menu {font-size: 9pt; font-family:"굴림", "굴림체", "돋움", "돋움체";; color: #666666}

A:link{ color:#666666; font-family:"굴림", "굴림체", "돋움", "돋움체";font-size:9pt;text-decoration: none;}
A:visited { color:#666666; font-family:"굴림", "굴림체", "돋움", "돋움체"; font-size:9pt; text-decoration:none;}
A:hover { color:#3366FF;font-family:"굴림", "굴림체", "돋움", "돋움체"; font-size:9pt;text-decoration:underline; }
.sub {  font-family: "굴림", "굴림체", "돋움", "돋움체"; font-size: 9pt; color: #666666}
input {border: solid gray 1}
input.border {border : none }
//tr.tr:hover { background-color : #fcf ;} 
</style>

<?
$excel_title = "회원정보 관리";

############ 해당 부분 환경 설정 파일 ######
if($conf) {
	include "./conf/conf_".$conf.".php";
}
?>

	<table width="100%" border="0" cellspacing="1" cellpadding="2">
	  <tr> 
		<td ><b><?=$excel_title?> 정보</b></td>
	  </tr>
	</table>


	<table width="100%" border="1" cellspacing="1" cellpadding="2">
	  <tr align="center" bgcolor="#E7E7E7"> 
		<td height="25">번호</td>
		<td>아이디</td>
		<td>성명</td>
		<td>상태</td>
		<td>회원구분</td>
		<td>전화번호</td>
		<td>휴대전화</td>
		<td>이메일</td>

		<td>소속</td>
		<td>성별</td>
		<td>생년월일</td>
		<td>등록일</td>

		<td>결혼여부</td>
		<td>페이스북아이디</td>
		<td>트위터 아이디</td>
		<td>보유고객 수</td>
		<td>추천인 연락처</td>
		<td>기타내용</td>

	  </tr>
	<?	

    $get_field = escape_string($_REQUEST['find_field']);
    $get_word  = escape_string($_REQUEST['find_word'],'1');
    $get_ordby = escape_string($_REQUEST['ordby']);
    $get_state = escape_string($_REQUEST['find_state']);



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

    if(!empty($get_state)){	
		//상태정보
        $where_add .= " AND state = '".$find_state."'";
    }

	if($membertype=="out") {	//탈퇴회원 보기 이면실행
		$where_add .= " AND state='Y' OR  state='N' ";
	}

    // 전체 쿼리에 제한 걸기
    $query = $query = "SELECT * FROM $tablecode  WHERE 1 ".$where_add." ORDER BY ".$ORDER_BY." reg_date DESC";
	//echo "$query ///<br>";
        $result = $db->fetch_array( $query );
        $rcount = count($result) ;

	   $c=1;
       for ( $i=0 ; $i<$rcount ; $i++ ) {

		if($result[$i][state]=="N"){  $result_state = "불량";
		}else if($result[$i][state]=="Y"){  $result_state = "정상";
		}else if($result[$i][state]=="O"){  $result_state = "탈퇴";
		}else if($result[$i][state]=="D"){  $result_state = "삭제";
        }else { $result_state = "";
        }
		$row_member = get_tb_member($result[$i][tcode]);	//회원 구함

		## 소속회사 정보 ###
		$row_cname = get_tb_cname($result[$i][tb_cname_uid]);
	?>
	  <tr align="center"> 
		<td height="25"><?=$c?></td>
		<td><?=$result[$i][mid]?></td>
		<td><?=$result[$i][uname]?></td>
		<td><?=$result_state?></td>
		<td><?=$ARR_MEMBER_LEVEL[$result[$i][ulevel]]?></td>
		<td><?=$result[$i][utel]?></td>
		<td><?=$result[$i][uptel]?></td>
		<td><?=$result[$i][uemail]?></td>


		<td><?=$row_cname[cname]?></td>
		<td><?=$result[$i][usex]?></td>
		<td><?=$result[$i][ubir]?></td>
		<td><?=$result[$i][reg_date]?>&nbsp;</td>

		<td><?=$result[$i][marrytype]?></td>
		<td><?=$result[$i][facebookid]?></td>
		<td><?=$result[$i][twitterid]?></td>
		<td><?=$ARR_COUSCOUNT_INFO[$result[$i][couscount]]?></td>
		<td><?=$result[$i][recom_utel]?></td>
		<td><?=$result[$i][content]?></td>

	  </tr>	

	<?	 
		$c++;
	   }  //end 
	?>

	</table>
