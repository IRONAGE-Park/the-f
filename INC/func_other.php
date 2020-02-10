<?php

####### 아이디 검수 ##############
function member_check($mid) {
	global $db;
	$mid_1 = $mid;

	//관리자회원
	$query1 = "select mid from tb_master where mid = '$mid_1' " ;
	$mid1 =  $db->select_one( $query1 );


	$row['mid']  = $mid;
	$row['mid1'] = $mid1;

	##### 종복된 아이디 있으면 true 보낸다 ###########
	if($row['mid1']) {
		$row['midok'] = true;
	}
	return $row;
}


//관리자 관련정보 뽑기
function get_tb_master($mid,$field=""){
    global $db;
    $query= "SELECT * FROM tb_master WHERE mid='".$mid."' ORDER BY uid DESC LIMIT 1";
    $result = $db->row( $query );
    if(!empty($field)){
        $result = $result[$field];
    }
    return $result;
}

//관리자 관련정보 뽑기
function get_tb_master1($uid,$field=""){
    global $db;
    $query= "SELECT * FROM tb_master WHERE uid='".$uid."' ORDER BY uid DESC LIMIT 1";
    $result = $db->row( $query );
    if(!empty($field)){
        $result = $result[$field];
    }
    return $result;
}



// 게시판 관련정보 뽑기
function get_tb_board($uid,$tablename,$whe=""){
    global $db;
    $query= "SELECT * FROM $tablename WHERE uid='".$uid."' $whe ORDER BY uid DESC LIMIT 1";
	$result = $db->row( $query );
	return $result;

}

//게시판 조회수 올리기
function get_tb_ref($tablename,$record,$uid) {
    global $db;
	$tran_query[0] = "UPDATE $tablename SET $record=$record+1 WHERE uid='$uid';";
	$tran_result = $db->tran_query( $tran_query );
	return;
}


// 팝업정보 뽑기
function get_tb_popup($uid,$tablename){
    global $db;
    $query= "SELECT * FROM $tablename WHERE uid='".$uid."' ORDER BY uid DESC LIMIT 1";
	$result = $db->row( $query );
    if(!empty($field)){
        $result = $result[$field];
    }
	return $result;
}



##### 문자열 자르기 함수 #######
function strcut($str, $len, $tail="") {
	$str_leng = strlen($str);
	if($str_leng > $len) 	{
		for($i=0; $i<$len; $i++) if(ord($str[$i])>127) $i++;
			$str=substr($str,0,$i);
			$str .= $tail;
	}

		if($str_leng > $len) {
		return $str."..";
		} else {
		return $str;
		}

	return join('', $ret).$tail;
}



//이전,다음 페이지 이동하는 uid값 구하는 함수_3 (답변글이 있는경우 부르는 함수)
function Nummove_title($uid,$table,$type="answer",$whe="") {
global $db,$common;

	# 이전으로 이동 (답변글인경우 이전글에서 제외 된다)
	if($type=="answer") {
		$query = "select max(uid) from $table where uid < '$uid' and thread='A'  and viewtype!='N' and topview!='Y' $whe ";
	} else {
		$query = "select max(uid) from $table where uid < '$uid'  and viewtype!='N'";
	}

	$backuid =  $db->select_one($query);

		if($backuid) {
			$query1 = "SELECT title FROM $table WHERE uid = '$backuid'";
			$result1 = $db->row( $query1 );
			$backtitle=$result1[title];
		}


	# 다음 으로 이동 (답변글인경우 다음글에서 제외 된다)
	if($type=="answer") {
		$query = "select min(uid) from $table where uid > '$uid' and thread='A' and topview!='Y'  and viewtype!='N'";
	} else {
		$query = "select min(uid) from $table where uid > '$uid'  and viewtype!='N'";
	}
	$nextuid = $db->select_one($query);

	if($nextuid){
		$query1 = "SELECT title FROM $table WHERE uid = '$nextuid'";
		$result1 = $db->row( $query1 );
		$nexttitle=$result1[title];
	}

	$row['backtitle']	= stripslashes($backtitle);
	$row['backtitle']	= htmlspecialchars($backtitle);
	$row['nexttitle']	= stripslashes($nexttitle);
	$row['nexttitle']	= htmlspecialchars($nexttitle);

	$row['backtitle']	= $common->cut_string($row['backtitle'],60);
	$row['nexttitle']	= $common->cut_string($row['nexttitle'],60);

	$row['backuid'] = $backuid;
	$row['nextuid'] = $nextuid;


	return $row;
}


	//================ 캐릭터 번호값 구하기 
	function Characterinfo_num($ubirday) {					
	
		############## 캐릭터 구하기 ###########################################
		## 1.생일수 : 1900년 1월 1일부터 사용자의 생년월일까지의 일수를 산출하여 사용자의  생일수로 한다. 
		## 2.기준일 : 1900년 1월 1일부터 기준일(1926년 1월 1일)까지의 일수를 산출하여 기준일수로 한다.  
		## 3.60캐릭터 = (사용자의생일수 - 기준일수 + 26 + 1)을 60으로 나눈 나머지임. 단, 0의 경우는 60으로 한다.
		//$ubirday = "1988-01-01"; //생일박기

		$s_day = "1900-01-01";	//시작일
		$start_day = mktime( 0, 0, 0, substr($s_day, 5, 2), substr($s_day, 8, 2), substr($s_day, 0, 4) );	 //시작일 
		$g_day = "1926-01-01";	//기준일
		$gijun_day = mktime( 0, 0, 0, substr($g_day, 5, 2), substr($g_day, 8, 2), substr($g_day, 0, 4) );	 //기준일

		$m_birday = mktime( 0, 0, 0, substr($ubirday, 5, 2), substr($ubirday, 8, 2), substr($ubirday, 0, 4) );	//회원생일
		$m_date_count =  round(($m_birday - $start_day)/86400,2);		//생일수 (생일수=회원생일-시작일)
		$m_gijun_count = round(($gijun_day - $start_day)/86400,2);	//기준일 (기준일=기준일-시작일) 

		//$m_gijun_count = "9497";	//기준일
		//$m_date_count = "32142";	//생일수

		$m_ca_60_1 = (($m_date_count-$m_gijun_count)+26+1);   //60캐릭터 = (사용자의생일수 - 기준일수 + 26 + 1)을 60으로 나눈 나머지임. 단, 0의 경우는 60
		$m_ca_60 = $m_ca_60_1%60;	//캐리터 값 구함
		############## end 캐릭터 구하기 ###########################################
		if($m_ca_60=="0") $m_ca_60 = "60";

		if($m_ca_60) {
			$s_c =  strlen($m_ca_60);
			if($s_c==1) $m_ca_60 = "0".$m_ca_60; else $m_ca_60 = $m_ca_60;
		}

		$row[m_ca_60] = $m_ca_60;

		return $row;		
	}
//================ end 캐릭터 번호값 구하기 

	//------------------------------------ 60 캐릭터 구하기 
	function Characterinfo($val) {		
		global $db;
			
		$val_len = strlen($val);
		if($val_len=="1") $val = "0".$val;
		$query_ch = "SELECT *  FROM Ch_Character_an WHERE an_no='$val' limit 1";
		//echo "$query_ch";
		$row_ch = $db->row($query_ch);

			//$row_ch[an_namejp]		= trim(substr($row_ch[an_namejp],3));
			$row_ch[an_namejp]		=  trim(str_replace("$val","", "$row_ch[an_namejp]"));
			$row_ch[an_namejp]		= trim(substr($row_ch[an_namejp],3));
			$row_ch[an_img]			= "$HOME_PATH/img/c_$row_ch[an_no].jpg";		//캐릭터 사진
			$row_ch[an_img_s_3]		= "$HOME_PATH/img/1200$row_ch[an_12_no]_3.gif";	//캐릭터 제일 작은것 30*24
			$row_ch[an_img_s_1]		= "$HOME_PATH/img/1200$row_ch[an_12_no]_1.gif";	//캐릭터 제일 작은것 50*40

			if($row_ch[an_sunjp]=="태양") {
				$group_img = "img_group3.jpg";
			} else if($row_ch[an_sunjp]=="지구") {
				$group_img = "img_group2.jpg";
			} else if($row_ch[an_sunjp]=="초승달") {
				$group_img = "img_group4.jpg";
			} else if($row_ch[an_sunjp]=="보름달") {
				$group_img = "img_group1.jpg";
			}
			$row_ch[an_img_group]	= "$HOME_PATH/img/$group_img";	//그룹사진
			
			//$row_ch[an_namejp] = substr($row_ch[an_namejp],1,100);

		return $row_ch;		
	}
	//------------------------------------ 60 캐릭터 구하기  끝
	
	//------------------------------------ 60 캐릭터 본질
	function Charactertext($val_num,$val_sex) {		
		global $db;
		$query_ch = "SELECT *  FROM Ch_Character  WHERE ch_no='$val_num' and ch_sex='$val_sex' limit 1";
		$row_ch = $db->row($query_ch);
		return $row_ch;		
	}
	//------------------------------------ 60 캐릭터 구하기  끝

	//------------------------------------ 궁합구하기 
	function Compatibility($val_my,$val_you) {		
		global $db;
		//애정점수: point_love,친구점수:point_friend,사업점수: point_business
		
		$val_my_1	= substr($val_my,0,1);
		$val_you_1  = substr($val_you,0,1);

		if($val_my_1=="0") $val_my = substr($val_my,1,1);
		if($val_you_1=="0") $val_you = substr($val_you,1,1);
		
		$query_co = "SELECT *  FROM Ch_Compatibility  WHERE co_my60='$val_my' and co_your60='$val_you' limit 1";
		$row_co = $db->row($query_co);

		########### 궁합 텍스트 구하기 #################
		//친구궁합 텍스트 구함 
		$query_fr = "SELECT score,content FROM Ch_Compatibility_friend  WHERE score='$row_co[co_point_friend]' limit 1";
			$row_fr = $db->row($query_fr);
			$row_co[fr_content] = $row_fr[content];

		//친구궁합 텍스트 구함 
		$query_lo = "SELECT score,content FROM Ch_Compatibility_love  WHERE score='$row_co[co_point_love]' limit 1";
		$row_lo = $db->row($query_lo);
			$row_co[lo_content] = $row_lo[content];
		
		return $row_co;		

	}
	//------------------------------------ 60 캐릭터 구하기  끝
	
	//------------------------------------ 오늘의 운기 $val_num:캐릭터의 리듬넘버,$val_m_ca_60:캐릭터번호,$val_an_cycle:캐릭터 cycle
	function Characterday($val_num,$val_m_ca_60,$val_an_cycle) {		
		global $db;

		if($val_num) {
			//앞에 0이 붙은 경우 0 제거 해준다 
			if(strlen($val_num)=="2") {
				$str_t = substr($val_num,0,1);
				if($str_t=="0") $val_num = substr($val_num,1,1); else $val_num = $val_num;
			}
		}

		$query_ch = "SELECT *  FROM Ch_Condition_day  WHERE co_rhythmno='$val_num' limit 1";
		//echo "$query_ch";
		$row_ch = $db->row($query_ch);
			## $row_ch[co_tokino];	//기준 운기 넘버

		####### 기준년원일 #######
		$s_day = $row_ch[co_year]."-".$row_ch[co_month]."-".$row_ch[co_day];	//기준일일
		$start_day = mktime( 0, 0, 0, substr($s_day, 5, 2), substr($s_day, 8, 2), substr($s_day, 0, 4) );	 //기준일 
		
		#### 진단하는날(오늘) ############
		$g_day = date("Y-m-d");	//기준일 ex : $g_day = "2011-12-28";	//기준일		
		$gijun_day = mktime( 0, 0, 0, substr($g_day, 5, 2), substr($g_day, 8, 2), substr($g_day, 0, 4) );	 //기준일

		## 일차수 구함 $result_day : 기준일 ###		
		$result_day =  round(($gijun_day  - $start_day)/86400,2);	//기준 연월일(2002년 11월 7일) 부터 진단하는 날까지의 일수를 산출하고 그 값을 일수차로 한다.
		//echo "$result_day";
		##### 운기 no 구함 : $tokino ##########
		$tokino = (($result_day+$row_ch[co_tokino])%10);		//운기No= ( 일수차 + 기준운기no)를 10으로 나눈 나머지
		if($tokino=="0") $tokino = "10";						//(만일 운기no값이 0이 나올경우 운기no는 10으로 한다.)

		/*Cycle 이 +인가? 			
		chinese(60chara attribute)_new.xls 에서 cycle가 +인지 -인지 확인하면 되는데, 리듬넘버가 홀수인 경우에는  +이고 짝수인 경우에는 -이다.
		Cycle가 + 인경우 CNaviTokiNameSei.csv목록을 운기NO로 검색하고, TextKey를 운기ID로 한다.			
		위의 예에서는 + 였으므로 4번 낭비를 선택하고 정보를 얻어온다.

		Cycle 이 -인가? 			
		Cycle 이 -의 경우 CNaviTokiNameInn.csv 목록을 운기NO로 검색하고, TextKey를 운기ID로 한다. 			
		*/
		
		//echo "$val_an_cycle //";
		if($val_an_cycle=="+") {
			$query_sei = "SELECT *  FROM Ch_Condition_sei  WHERE co_no='$tokino'";
			$row_i = $db->row($query_sei);
		}
		if($val_an_cycle=="-") {
			$query_inn = "SELECT *  FROM Ch_Condition_inn  WHERE co_no='$tokino'";
			$row_i = $db->row($query_inn);
		}
			$textkey = $row_i[co_textkey];		//운기NO로 검색하고, TextKey를 운기ID로 한다. 
			$new_tokino = $textkey+10;			//운기ID = 운기ID + 10
			//echo "$textkey ////$new_tokino";

		/*운기ID = 절대치(운기ID-2)를 10으로 나눈 나머지			
		운기ID = (14-2)/ 10으로 나눈 나머지 = 12/10 =1.2   나머지는 2가 된다.*/
			$new_tokino = (abs($new_tokino-2)%10);										//운기ID = 절대치(운기ID-2)를 10으로 나눈 나머지			
			if($new_tokino=="0") $last_tokino = 10; else $last_tokino = $new_tokino;		//최종으로 구한 운기ID

		//echo "최종 운기넙버 $last_tokino <br>";	

		/*이제 리듬NO를 계산한다.
		리듬NO = 일수차를 100으로 나눈 나머지	
		위의 예시에서 리듬 NO = 3338/100 = 33.38   나머지는 38	*/
		$new_rhythm =  round($result_day%100);	//리듬NO = 일수차를 100으로 나눈 나머지	

		/* 리듬 NO < 10  (10보다 작은 경우)		
		리듬 NO가 0일때는 10으로 하고 그 이외의 경우는 1로 한다.*/
		if($new_rhythm<10) {
			//if($new_rhythm=="0") $new_rhythm = 10; else $new_rhythm = "1";
			if($new_rhythm=="0") $last_rhythm = 10; else $last_rhythm = "1";
		}
		/*리듬 NO > 10  (10보다 큰경우)
		리듬 NO의 값이 10으로 나머지 없이 나누어 지는가?*/
		if($new_rhythm>10) {
			$new_rhythm_1  = $new_rhythm%10;
			if(!$new_rhythm_1) {				
				$last_rhythm = substr($new_rhythm,0,1);	////나머지 없이 나누어 지는 경우는 리듬 NO의 10단위 값을 리듬 NO로 한다.
			} else {
				$last_rhythm = (substr($new_rhythm,0,1)+1);	//나머지가 생기면서 나눠지는 경우는  리듬NO 의 10단위 값 + 1을 리듬 NO로 한다.
			}
		}

		//echo "<br>최종리듬넘버 :$last_rhythm";

		/*  ---> 여기 시작하기 
		fortune(daily toki).xls 에서 위 예시대로 오늘의 운세를 검색해보면	
		운기 ID 는 2번 낭비, 리듬NO는 4번의 결과 값이  전체 운이 된다.	
		나머지 <fortune(daily biz).xls> <fortune(daily love).xls> <fortune (daily money).xls>가 비즈니스운, 애정운, 금전운의 값을 찾으면 된다.	
		*/
		########## 오늘의 전체운 구하기 ##########
		$query_toki = "SELECT *  FROM Ch_Daily_toki  WHERE to_toki_id='$last_tokino' and to_rhythm_10day='$last_rhythm'";
		$row_toki = $db->row($query_toki);
		$row_ch[to_toki_txt] = $row_toki[to_toki_txt];

		########### 오늘이 연애 운 ############
		$query_lo = "SELECT *  FROM Ch_Daily_love WHERE lo_toki_id='$last_tokino' and lo_rhythm_10day='$last_rhythm'";
		$row_lo = $db->row($query_lo);
		$row_ch[lo_toki_txt] = $row_lo[lo_toki_txt];

		########### 오늘이 금전 운 ############
		$query_mo = "SELECT *  FROM Ch_Daily_money WHERE mo_toki_id='$last_tokino' and mo_rhythm_10day='$last_rhythm'";
		$row_mo = $db->row($query_mo);
		$row_ch[mo_toki_txt] = $row_mo[mo_toki_txt];

		########### 오늘이 비지니스 운 ############
		$query_bi = "SELECT *  FROM Ch_Daily_biz  WHERE bi_toki_id='$last_tokino' and bi_rhythm_10day='$last_rhythm'";
		$row_bi = $db->row($query_bi);
		$row_ch[bi_toki_txt] = $row_bi[bi_toki_txt];

		########### 오늘의 행운의 컬러 ##############
		$query_sei = "SELECT *  FROM Ch_Condition_sei  WHERE co_no='$last_tokino'";
		$row_s = $db->row($query_sei);
		$row_ch[co_color] = $row_s[co_color];

		########### 그날의 컨디션과 제목 ##############
		$query_gu = "SELECT *  FROM Ch_Daily_toki_guide  WHERE gu_toki_id='$row_toki[to_toki_id]'";
		$row_gu = $db->row($query_gu);
		$row_ch[gu_tit] = $row_gu[gu_tit]; //제목
		$row_ch[gu_toki_txt] = $row_gu[gu_toki_txt]; //내용
		$row_ch[gu_toki_count] = $row_gu[gu_toki_count]; //스마일갯수		
		
		return $row_ch;		
	}
	//------------------------------------ 오늘의 운기  끝


//메일 발송
function Mailsend($uemail,$uname,$title,$send) {

	global $HOME_PATH;
	global $admin_email;

	################### 메일 발송

	$body="

		<!doctype html>
		<html lang='ko'>
		<head>
			<meta charset='UTF-8'>
			<title>$title</title>
		</head>
		<body style='-webkit-text-size-adjust: none;-ms-text-size-adjust: none;text-size-adjust: none;margin: 0;padding: 0;width: 100%; font-family:'Malgun Gothic';'>
			<table cellspacing='0' cellpadding='0' align='left' border='0' width='700' bgcolor='#ffffff' style='mso-table-lspace: 0pt;mso-table-rspace: 0pt;'>
				<tr>
					<td valign='top' align='left' width='700'>
						<table cellspacing='0' cellpadding='0' align='left' border='0' width='700'>
							<tr>
								<td valign='top' align='left' width='80'>
									<a href='$HOME_PATH' target='_blank' title='새창:WitU' style='display: block; text-decoration: none; outline: none; border: none;'><img src='$HOME_PATH/images/email/logo.gif' alt='WitU' style='display: block;outline: none;height: auto;line-height: 100%;text-decoration: none;-ms-interpolation-mode: bicubic;' border='0'></a>
								</td>
								<td valign='top' align='right' width='620'>
									<img src='$HOME_PATH/images/email/witu-title.gif' alt='Always be with you' style='display: block;outline: none;height: auto;line-height: 100%;text-decoration: none;-ms-interpolation-mode: bicubic;' border='0'>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				$send
				<tr>
					<td valign='top' align='left' width='700' style='border-top:1px solid #e2e2e2;'>
						<img src='$HOME_PATH/images/email/footer.gif' alt='' style='display: block;outline: none;height: auto;line-height: 100%;text-decoration: none;-ms-interpolation-mode: bicubic;' border='0'>
					</td>
				</tr>
			</table>
		</body>
		</html>

	";

	//echo "$body";
	$title = '=?UTF-8?B?'.base64_encode($title).'?=';
	$uname = '=?UTF-8?B?'.base64_encode($uname).'?=';
	$uname1 = '=?UTF-8?B?'.base64_encode("WitU").'?=';


	$to_email=$uemail;
	$from_email=$admin_email;
	$subject="$title";
	$mailheaders .= "Return-Path: $from_email\r\n";
	$mailheaders .= "From: $uname1 <$from_email>\r\n";
	$mailheaders .= "Content-Type:text/html; charset=utf-8\r\n";


	mail($to_email,$subject,$body,$mailheaders);

	//return $body;
}
?>
