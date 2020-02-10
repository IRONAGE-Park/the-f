<?php  if ( ! defined('ROOT')) exit('No direct script access allowed.');

class HC_common {

	function loginUser(){

		global $SITE_USER_UID,$SITE_USER_MID;

		############ 로그인 체크 ###########
		if (empty($SITE_USER_MID) OR empty($SITE_USER_UID)) {
			$this->error("로그인해주세요","goto_no_alert","/member/login.html");
		}

	}


	function getUID() {
		if (function_exists('com_create_guid')){
			return com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);
			$charid = strtolower(md5(uniqid(rand(), true)));
			$uuid = substr($charid, 0, 8).substr($charid, 8, 4).substr($charid,12, 4).substr($charid,16, 4).substr($charid,20,12);
			return $uuid;
		}
	}

    ###################################################################
    ## 난수를 발생한다.
    ###################################################################
    function get_random_number($start, $end, $count) {
      $sel_num=array();

      $j=0;
      for($i=$start;$i<=$end;$i++) {
        $num_arr[$j]=$i;
        $j++;
      }

        $k=0;
        while(sizeof($sel_num)!=$count) {
          $num=rand(0,9);
          if(!array_keys($sel_num,$num)) {
            $sel_num[$k]=$num;
            $return_str.=$num;
          }
          $k++;

        }

      return $return_str;
    }

	function formvaluechk($type) {
		$values = '';
		while(list($key,$value) = each($_POST)) {
			if(is_array($value)){
				while(list($key1,$value1)=each($value)){
				$values .= "\$_POST['".$key."'][".$key1."] = \"". $value1."\"<br>\n";
				}
			}else{
				$values .= "\$_POST['".$key."'] = \"". $value."\"<br>\n";
			}
		}
		return $values;
	}

	## 문자셋설정
	function charset($msg) {
			$ctype = mb_detect_encoding($msg);
			if("utf-8" != $ctype ) {
				$string = iconv ( $ctype ,"utf-8", $msg );
			}
			return $string;
	}

    ## 인코딩 변경
	function euckr2utf($msg,$r=""){
        if(!empty($r)){
            //UTF-8을 EUC-KR로 변경
            $string = iconv("UTF-8", "CP949", $msg);
        }else{
            //EUC-KR을 UTF-8로 변경
            $string = iconv("CP949", "UTF-8", $msg);
            //$string = rawurlencode(iconv("CP949", "UTF-8", $msg));
        }
			return $string;
    }

    ## 변환후 넘김
	function rawurl($msg,$r=""){
        if(!empty($r)){
            $string = rawurldecode($msg);
        }else{
            $string = rawurlencode($msg);
        }
			return $string;
    }
    ## 1. 경고창 후 이전페이지 이동
//
	function error($msg, $condition, $uri="")  {
//		$msg = $this->charset($msg);
		if($msg) {
                    echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">';

			switch($condition) {
				case "alert":
					echo "<script type=\"text/javascript\">window.alert('$msg');</script>";
				break;
				case "previous":
					echo "<script type=\"text/javascript\">window.alert('$msg');history.go(-1);</script>";
					exit;
				break;
				case "reload":
					echo "<script type=\"text/javascript\">window.alert('$msg');location.reload();</script>";
					exit;
				break;
				case "close":
					echo "<script type=\"text/javascript\">window.alert('$msg');window.close();</script>";
					exit;
				break;
				case "goto":
					echo "<script type=\"text/javascript\">window.alert('$msg');location.replace('$uri');</script>";
					exit;
				break;
				case "goto_no_alert":
					echo "<script type=\"text/javascript\">location.replace('$uri');</script>";
					exit;
				break;

				case "fancy_parent_close":
					echo "<script type=\"text/javascript\">window.alert('$msg');parent.fancyboxClose();</script>";
					exit;
				break;
            }
		}
	}

	## 2. 경고창
    // $common->alert($msg, "previous"); //history.back
	function alert($msg, $condition='previous', $uri="")  {
		$this->error($msg, $condition, $uri);
	}

	## 3. 페이지이동
	function replace($url) {
		echo "<meta http-equiv='Refresh' content='0; URL=$url'>";
		exit;
	}
    ## 4. 타겟 지정하여 페이지이동
    function goto_target($url,$target='self') {
      echo"<script language=\"javascript\">";
     // echo $target.".location.href='".$url."';";
      echo $target.".location.replace( '" . $url . "');";
      echo "</script>";
    }


	## 5. 년, 월, 일 구하기 (셀렉트박스용)
	function YmD_SEL($data,$type='',$start='') {
		$list ="";
		if($type=="year") {
			$nowyear = date("Y");
			for($i=$nowyear-5; $i<$nowyear+20; $i++ ) {
				if($data == $i) $list .= "<option value='$i' selected> $i </option>";
				else  $list .= "<option value='$i'> $i </option>";
			}

		} else if($type=="year_s") {
			$nowyear = date("Y");
            if(empty($start)) $start = $nowyear;
			for($i=$start; $i<$nowyear+2; $i++ ) {
				if($data == $i) $list .= "<option value='$i' selected> $i </option>";
				else  $list .= "<option value='$i'> $i </option>";
			}
		} else if($type=="year_d") {
			$nowyear = date("Y");
            if(empty($start)) $start = $nowyear;
			for($i=$nowyear+1; $i>=$start; $i-- ) {
				if($data == $i) $list .= "<option value='$i' selected> $i </option>";
				else  $list .= "<option value='$i'> $i </option>";
			}

		} else if($type=="month") {
			for($i=1; $i<=12; $i++ ) {
				$i>=10 ? $i=$i : $i = sprintf('%02x',$i);
				if($data == $i) $list .= "<option value='$i' selected> $i </option>";
				else  $list .= "<option value='$i'> $i </option>";
			}
		} else {

			for($i=1; $i<=31; $i++ ) {
				$i>=10 ? $i=$i : $i = sprintf('%02x',$i);
				if($data == $i) $list .= "<option value='$i' selected> $i </option>";
				else  $list .= "<option value='$i'> $i </option>";
			}
		}
		return $list;
	}

	##  이메일휴효성검사(DNS까지검사)
	function checkEmail($email) {
		if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)){
			$domain = explode("@",$email);
			if(!checkdnsrr($domain['1'],'MX')) {
				return false;
			}
			return $email;
		}
		return false;
	}

    ## 두자리로 만들기
    function get_2num($value) {
        $return_str = sprintf("%02d",$value);
        return $return_str;
    }
    ## 4자리로 만들기
    function get_4num($value) {
        $return_str = sprintf("%04d",$value);
        return $return_str;
    }
    ## 6자리로 만들기
    function get_6num($value) {
        $return_str = sprintf("%06d",$value);
        return $return_str;
    }


    ## 4자리로 만들기
    function get_4num2($value){
        $value = $value."0000";
        $return_str = substr($value,0,4);
        return $return_str;
    }

    ## 문자열자르기
	function cut_string($str, $len, $addStr="...")  {
		/*
		if(mb_strlen($str, "CP949") > $len) {
			return mb_substr($str, 0, $len, "CP949").$addStr;
		} else return $str;
		*/

		preg_match_all('/[\xE0-\xFF][\x80-\xFF]{2}|./', $str, $match); // target for BMP

		$m = $match[0];
		$slen = strlen($str); // length of source string
		$tlen = strlen($tail); // length of tail string
		$mlen = count($m); // length of matched characters

		if ($slen <= $len) return $str;
		if (!$checkmb && $mlen <= $len) return $str;

		$ret = array();
		$count = 0;

		for ($i=0; $i < $len; $i++) {
			$count += ($checkmb && strlen($m[$i]) > 1)?2:1;
			if ($count + $tlen > $len) break;
			$ret[] = $m[$i];
		}

		return join('', $ret).$addStr;
	}


    ## 문자 변환하기
    function str_injection($value){
        $changes = array("<",">",null,NULL,'null',"%27","syscolumns","convert","CHAR","style","script");
        $results = array("&lt;","&gt;");
        $value = str_replace($changes, $results, $value);
        return $value;
    }

    ## 썸네일만들기
	function thumb($input, $output, $x, $y, $imgsharpen='1', $imgcrop='') {

		$LB[Amount]=60;
		$LB[Radius]=0.5;
		$LB[Threshold]=3;

		$params['file']=$input;
		$_DST['file']=$output;
		$_DST['width']=$x;
		$_DST['height']=$y;

		if($imgcrop) $params['crop'] = 1;
		if($imgsharpen)$params['sharpen'] = 1;

        if(file_exists($params['file']) == false)   return "";

		$temp = getimagesize($params['file']);
		$_SRC['file']		= $params['file'];
		$_SRC['width']		= $temp[0];
		$_SRC['height']		= $temp[1];
		$_SRC['type']		= $temp[2]; // 1=GIF, 2=JPG, 3=PNG, SWF=4
		$_SRC['string']		= $temp[3];
		$_SRC['filename'] 	= basename($params['file']);
		$_SRC['modified'] 	= filemtime($params['file']);

        if($_SRC['type']>3){
              return "";
        }

		if($params['crop'] and $x and $y){
		$width_ratio = $_SRC['width']/$_DST['width'];
		$height_ratio = $_SRC['height']/$_DST['height'];


		if ($width_ratio > $height_ratio)
			{
			$_DST['offset_w'] = round(($_SRC['width']-$_DST['width']*$height_ratio)/1);
			$_SRC['width'] = round($_DST['width']*$height_ratio);
			}

		elseif ($width_ratio < $height_ratio)
			{
//			$_DST['offset_h'] = round(($_SRC['height']-$_DST['height']*$width_ratio)/1);
			$_DST['offset_h'] = round((($_SRC['height']-$_SRC['height']+30)*$width_ratio)/1);
			$_SRC['height'] = round($_DST['height']*$width_ratio);
			}
		}

		else {

		$params['longside'] = $_DST['width'];
		$params['shortside'] = $_DST['height'];

		$temp_large=$temp[0]>$temp[1] ? $temp[0] : $temp[1];

			//// 큰 쪽을 수정
			if($x and $y){
				if($temp_large>$x){
					$temp_sel = $temp_large==$temp[0] ? "width" : "height" ;
					if($temp_sel=="width"){
						$_DST['width']=$temp[0]>=$x ? $x : $temp[0];
						$_DST['height']=ceil($_DST['width'] * $temp[1] / $temp[0]);
					} else {
						$_DST['height']=$temp[1]>=$x ? $x : $temp[1];
						$_DST['width']=ceil($_DST['height'] * $temp[0] / $temp[1]);
					}
				}
			}

			//// 한쪽이 안정해졌을경우 ( 한쪽에만 맞춤 )
			elseif(!$x || !$y)
			{
				if($x){ // width 를 수치로 고정
					$_DST['width']=$x;
					$_DST['height']=ceil($_DST['width'] * $temp[1] / $temp[0]);
				}
				else{
					$_DST['height']=$y;
					$_DST['width']=ceil($_DST['height'] * $temp[0] / $temp[1]);
				}
			}

			//// 양쪽 다 정해졌을 경우
			else{ $_DST['width']=$x; $_DST['height']=$y; }

		}

		if (!empty($params['frame']))
			{
			// schauen obs g?tig ist
			$imagesize = getimagesize($params['frame']);
			// Blockgr秤e brauche ich schon hier, falls ein gecachtes Bild wiedergegeben werden soll
			$frame_blocksize = $imagesize[0]/3;

			$_DST['string'] = 'width="'.($_DST['width']+2*$frame_blocksize).'" height="'.($_DST['height']+2*$frame_blocksize).'"';
			}

		if ($_SRC['type'] == 1)	$_SRC['image'] = imagecreatefromgif($_SRC['file']);
		if ($_SRC['type'] == 2)	$_SRC['image'] = imagecreatefromjpeg($_SRC['file']);
		if ($_SRC['type'] == 3)	$_SRC['image'] = imagecreatefrompng($_SRC['file']);

		if (!empty($params['type'])) $_DST['type']	= $params['type'];
		else $_DST['type']	= $_SRC['type'];

		$_DST['image'] = imagecreatetruecolor($_DST['width'], $_DST['height']);
		imagecopyresampled($_DST['image'], $_SRC['image'], 0, 0, $_DST['offset_w'], $_DST['offset_h'], $_DST['width'], $_DST['height'], $_SRC['width'], $_SRC['height']);

		//	if ($params['sharpen']) $_DST['image'] =	common::UnsharpMask($_DST['image'],$LB[Amount],$LB[Radius],$LB[Threshold]);

		if (!empty($params['frame']))
			{
		// "frame"-Bild laden und initialisieren
		$frame = imagecreatefrompng($params['frame']);
		$frame_blocksize = $imagesize[0]/3;

		// Neues Bild erstellen und bisher erzeugtes Bild hereinkopieren
		$_FRAME['image'] = imagecreatetruecolor($_DST['width']+2*$frame_blocksize, $_DST['height']+2*$frame_blocksize);
		imagecopy($_FRAME['image'], $_DST['image'], $frame_blocksize, $frame_blocksize, 0, 0, $_DST['width'], $_DST['height']);

		// Jetzt die ganzen anderen Rahmen herum zeichnen
		// die Ecken
		imagecopy($_FRAME['image'], $frame, 0, 0, 0, 0, $frame_blocksize, $frame_blocksize); // ecke links oben
		imagecopy($_FRAME['image'], $frame, $_DST['width']+$frame_blocksize, 0, 2*$frame_blocksize, 0, $frame_blocksize, $frame_blocksize); // ecke rechts oben
		imagecopy($_FRAME['image'], $frame, $_DST['width']+$frame_blocksize, $_DST['height']+$frame_blocksize, 2*$frame_blocksize, 2*$frame_blocksize, $frame_blocksize, $frame_blocksize); // ecke rechts unten
		imagecopy($_FRAME['image'], $frame, 0, $_DST['height']+$frame_blocksize, 0, 2*$frame_blocksize, $frame_blocksize, $frame_blocksize); // ecke links unten
		// jetzt die Seiten
		imagecopyresized($_FRAME['image'], $frame, $frame_blocksize, 0, $frame_blocksize, 0, $_DST['width'], $frame_blocksize, $frame_blocksize, $frame_blocksize); // oben
		imagecopyresized($_FRAME['image'], $frame, $_DST['width']+$frame_blocksize, $frame_blocksize, 2*$frame_blocksize, $frame_blocksize, $frame_blocksize, $_DST['height'], $frame_blocksize, $frame_blocksize); // rechts
		imagecopyresized($_FRAME['image'], $frame, $frame_blocksize, $_DST['height']+$frame_blocksize, $frame_blocksize, 2*$frame_blocksize, $_DST['width'], $frame_blocksize, $frame_blocksize, $frame_blocksize); // unten
		imagecopyresized($_FRAME['image'], $frame, 0, $frame_blocksize, 0, $frame_blocksize, $frame_blocksize, $_DST['height'], $frame_blocksize, $frame_blocksize); // links

		$_DST['image']	= $_FRAME['image'];
		$_DST['width']	= $_DST['width']+2*$frame_blocksize;
		$_DST['height']	= $_DST['height']+2*$frame_blocksize;
		$_DST['string2']	= 'width="'.$_DST['width'].'" height="'.$_DST['height'].'"';

		$returner = str_replace($_DST['string'], $_DST['string2'], $returner);
		}

            //		if(@imagetypes() & IMG_PNG) @ImagePNG($_DST['image'],$output);
            //							else @ImageJPEG($_DST['image'],$output);
            //                               @chmod($output,0606);
            ImageJPEG($_DST['image'],$output);
            @chmod($output,0606);

		imagedestroy($_DST['image']);
		imagedestroy($_SRC['image']);
		return file_exists($output);
	}

    ////// 목록 페이지별 페이지 NUM 붙이기
/*
            $pageurl = $_SERVER['PHP_SELF'];

            // 각종변수는 알아서 정의하셔서  name=변수값&name2=변수값2
            // $search = "findword=".$findword;
            $search = "";

            $pagesize = "20";
            $pagePerBlock = "10";

            isset($_GET['page']) ? $page = $_GET['page'] : $page = 1;
            $perpage = ($page-1) * $pagesize;

            //목록 출력 적용
            //$limit = "limit $perpage, $pagesize";
            //$numbers = $totalUser - $perpage; 	$numbers--; 목록숫자
            //연결 URL, 총번호, 한페이지갯수, 최대페이지번호, 현재페이지, 서치
    */


    function paging( $pageurl, $total_num, $pagesize, $pagePerBlock, $page, $search){

            $totalNumOfPage = ceil($total_num/$pagesize);
            $totalNumOfBlock = ceil($totalNumOfPage/$pagePerBlock);
            $currentBlock = ceil($page/$pagePerBlock);

            $startPage = ($currentBlock-1)*$pagePerBlock+1;
            $endPage = $startPage+$pagePerBlock -1;
            if($endPage > $totalNumOfPage) $endPage = $totalNumOfPage;

            $isNext = false;
            $isPrev = false;

            if($currentBlock < $totalNumOfBlock)	$isNext = true;
            if($currentBlock > 1)					$isPrev = true;

            if($totalNumOfBlock == 1){
                $isNext = false;
                $isPrev = false;
            }

            if($search) $search = "&".$search;
            else $search = '';

            $nav = '<li><a href="'.$pageurl.'?page=1' . $search.'" class="btn-start" ><<</a></li>';

            if($isPrev){
                $goPrevPage = $startPage-$pagePerBlock; // 11page
                $nav .= '<li><a href="'.$pageurl.'?page=' . $goPrevPage .  $search . '" class="btn-prev"><</a></li>';
            }

            for($i=$startPage;$i<=$endPage;$i++){

                if($i==$page) {

                        $nav .=  '<li><a class="btn-num current">'.$i.'</a></li>';

                } else {
                        $nav .=  '<li><a href="' . $pageurl . '?page=' . $i . $search . '" class="btn-num">'.$i.'</a></li>';
                }
            }

            if($isNext){
                $goNextPage = $startPage+$pagePerBlock; // 11page
                $nav .= '<li><a href="' . $pageurl . '?page=' . $goNextPage . $search . '" class="btn-next">></a></li>';
            }
            $nav .= '<li><a href="' . $pageurl . '?page=' . $totalNumOfPage . $search . '" class="btn-end">>></a></li>';
            return $nav;
    }


    function paging_new( $pageurl, $total_num, $pagesize, $pagePerBlock, $page, $search){

            $totalNumOfPage = ceil($total_num/$pagesize);
            $totalNumOfBlock = ceil($totalNumOfPage/$pagePerBlock);
            $currentBlock = ceil($page/$pagePerBlock);

            $startPage = ($currentBlock-1)*$pagePerBlock+1;
            $endPage = $startPage+$pagePerBlock -1;
            if($endPage > $totalNumOfPage) $endPage = $totalNumOfPage;

            $isNext = false;
            $isPrev = false;

            if($currentBlock < $totalNumOfBlock)	$isNext = true;
            if($currentBlock > 1)					$isPrev = true;

            if($totalNumOfBlock == 1){
                $isNext = false;
                $isPrev = false;
            }

            if($search) $search = "&".$search;
            else $search = '';

            $nav = '<td><div class="sub02_numbox"><a href="'.$pageurl.'?page=1' . $search.'" class="thef-button"><<</a></div></td>';

            if($isPrev){
                $goPrevPage = $endPage-1; // 11page
                $nav .= '<td><div class="sub02_numbox"><a href="'.$pageurl.'?page=' . $goPrevPage .  $search . '" class="thef-button"><</a></div></td>';
            }

            for($i=$startPage;$i<=$endPage;$i++){

                if($i==$page) {

                        $nav .=  '<td><div class="sub03_numbox"><a href="javascript:;" class="thef-button">'.$i.'</a></div></td>';

                } else {
                        $nav .=  '<td><div class="sub02_numbox"><a href="' . $pageurl . '?page=' . $i . $search . '" class="thef-button">'.$i.'</a></div></td>';
                }
            }

            if($isNext){
                $goNextPage = $startPage+$page; // 11page
                $nav .= '<td><div class="sub02_numbox"><a href="' . $pageurl . '?page=' . $goNextPage . $search . '" class="thef-button">></a></div></td>';
            }
            $nav .= '<td><div class="sub02_numbox"><a href="' . $pageurl . '?page=' . $totalNumOfPage . $search . '" class="thef-button">>></a></div></td>';
            return $nav;
    }
    
    
    ###################################################################
    ## 메일보내기
    ###################################################################
    /*
        $args["receiver_name"]  //수신자 이름
        $args["receiver"]  //수신자 메일 주소
        $args["fromMail"]  //보내는사람메일
        $args["usernm"]    //보내는사람이름
        $args["subject"]   //제목
        $args["body"]      //내용

    emailSend($args);
    */
    function emailSend($args) {

        if (ereg("@",$args["receiver"])) {

            ///iconv('EUC-KR', 'UTF-8//IGNORE', $args["subject"]) //IGNORE 무시
            /*
                     if(!$args["fromMail"]) $args["fromMail"] = "NoReply@".$_SERVER['SERVER_NAME'];
                         $args["usernm" ] ='=?euc-kr?B?'.base64_encode( $args["usernm"]).'?=';
                         $args["subject"] ='=?euc-kr?B?'.base64_encode( $args["subject"]).'?=';
                      if($args["receiver_name"]){
                         $args["receiver_name"] ='=?euc-kr?B?'.base64_encode($args["receiver_name"]).'?=';
                         $args["receiver"] = $args["receiver_name"]."<".$args["receiver"].">";
                      }
            */
             if(!$args["fromMail"]) $args["fromMail"] = "NoReply@".$_SERVER['SERVER_NAME'];
                 $args["usernm" ] ='=?UTF-8?B?'.base64_encode( $args["usernm"]).'?=';
                 $args["subject"] ='=?UTF-8?B?'.base64_encode( $args["subject"]).'?=';
              if($args["receiver_name"]){
                 $args["receiver_name"] ='=?UTF-8?B?'.base64_encode($args["receiver_name"]).'?=';
                 $args["receiver"] = $args["receiver_name"]."<".$args["receiver"].">";
              }

            /* recipients */
             $header = "MIME-Version: 1.0;\n";
             $header .= "Content-type:text/html;charset=\"UTF-8\"\n";  //euc-kr
             $header .= "Content-Transfer-Encoding: 8bit\n";

            /* additional header */
             $header .= "From:".$args["usernm"]."<".$args["fromMail"].">\n";
            /// $header .= "CC: " . $args["CCMail"] . "\n";

           $result = mail($args["receiver"],$args["subject"],$args["body"],$header);

          if (!$result) {
              return "error";
            }else{
              return 1;
            }
        }
    }
    ##########################################################################################

    function getReadableTime($ut) {
        $passed = time() - $ut;

        $units = array(
                '31536000' => '년',
                '2628000' => '개월',
                '87600' => '일',
                '3600' => '시간',
                '60' => '분'
        );

        if ($passed < 60) {
            return $passed . " 초";
        }

        foreach ($units as $base => $title) {
            if (floor($passed / $base) != 0) {
                return number_format($passed / $base) . $title;
            }
        }
    }
    ################################################################################
    # 문자채크
    #chkParamRule($idx,"int");
    #chkParamRule($tmpl,"en");
    #chkParamRule($linkid,"int, kr, en");
    /********** 파라미터값 규칙 설정 함수 *****************/
    function chkParamRule($obj,$rule){

     $chk = 1;

     $obj = trim($obj);

     if($obj){

      //한글체크
      if(!eregi("kr",trim($rule))){
       if(preg_match("/[\xA1-\xFE\xA1-\xFE]/",$obj)) $chk = 0;
      }

      //영문체크
      if(!eregi("en",trim($rule))){
       if(preg_match("/[a-zA-Z]/",$obj)) $chk = 0;
      }

      //숫자체크
      if(!eregi("int",trim($rule))){
       if(preg_match("/[0-9]/",$obj)) $chk = 0;
      }

      //특수문자체크
      if(!eregi("special",trim($rule))){
       if(preg_match("/[!#$%^&*()?+=\/]/",$obj)) $chk = 0;
      }

      //echo $obj.":".$rule.":".$chk." // ";

      if($chk != 1) {
    //     $result = "'".$obj."' 값에 금지된 문자가 포함되어 있습니다.";
      }
     }

    return $chk;
    }


	###### 파일 첨부 ########
    //	$new_code = ""; // 코드
    //  $new_file ="photo_imgfile"; //파일 NAME
    //   ## 파일업로드 처리부분
    //         $fileadd_name	= $_FILES[$new_file]['name'];		//등록파일명
    //         $fileadd		= $_FILES[$new_file]['tmp_name'];	//파일임지저장소
    //         $fileadd_size	= $_FILES[$new_file]['size'];		//파일크기
    //     // 파일명, 파일크기, 원래 파일명
    //	   list($fileadd_name_1,$fileadd_size,$fileadd_org)=$common->Fileadd($new_code,"upload/student", $fileadd, $fileadd_name);
    //   ## 파일업로드 처리부분
	function Fileadd($new_num, $tablefile, $fileadd, $fileadd_name,$limitSize="20",$imgType='N') {
    // global ROOT;
	global  $ROOT_PATH;

        if($imgType=='Y'){
            $temp = getimagesize($fileadd); // 1=GIF, 2=JPG, 3=PNG
             if($temp[2]!='1' && $temp[2]!='2' && $temp[2]!='3'){
				$this->error( "GIF,JPG,PNG형식이 아닌것은 업로드가 불가능 합니다.","previous");
                exit;
            }
        }

		if ($fileadd != ""){
			## 이미지 크기를 구한다  ##
			$file_size_1 = filesize($fileadd);

			#### 이미지 파일 크기가 20M 가 넘으면 등록 할 수 없다. ###
			if( (1024000 * $limitSize) < $file_size_1 ) {
				$this->error( $limitSize."M 가 넘으면 등록 할 수 없습니다.","previous","");
			}

			#### 파일의 확장자를 그대로 사용 하기 위해서 확장자를 잘라서 변수에 넣는다 ####
			$fileadd_name_last = substr($fileadd_name,-4);
			## 대문자는 소문자로 변환 ###
			$fileadd_name_1 = "$new_num"."$fileadd_name_last";
			$fileadd_org = $fileadd_name;
            ## 폴더 자동생성
           if (!is_dir( $ROOT_PATH."/$tablefile" )){  mkdir($ROOT_PATH."/$tablefile",0707);      }

			#### 큰 이미지 저장한다. ####
			$saverdir_1 = $ROOT_PATH."/$tablefile/$fileadd_name_1";
			//echo "$fileadd_name_last / $fileadd <br> $saverdir_1<br>";

			if(!copy($fileadd,"$saverdir_1")){
				$this->error("첨부화일 등록에 실패하였습니다. 다시 등록해 주세요","previous","");
			}

		return array("$fileadd_name_1","$file_size_1","$fileadd_org");

		}
	}

################################
##  $Pass = "Passwort";
##  $Clear = "Klartext";
##
##  $crypted = fnEncrypt($Clear, $Pass);
##  echo "Encrypred: ".$crypted."</br>";
##
##  $newClear = fnDecrypt($crypted, $Pass);
##  echo "Decrypred: ".$newClear."</br>";
##
##  HEX(AES_ENCRYPT(:rcv_number, 'YBMSMC')) (//mysql Use)
##
function fnEncrypt($sValue, $sSecretKey="mylovey"){
    return rtrim(
        base64_encode(
            mcrypt_encrypt(
                MCRYPT_RIJNDAEL_256,
                $sSecretKey, $sValue,
                MCRYPT_MODE_ECB,
                mcrypt_create_iv(
                    mcrypt_get_iv_size(
                        MCRYPT_RIJNDAEL_256,
                        MCRYPT_MODE_ECB
                    ),
                    MCRYPT_RAND)
                )
            ), "\0"
        );
}

function fnDecrypt($sValue, $sSecretKey="mylovey"){
    return rtrim(
        mcrypt_decrypt(
            MCRYPT_RIJNDAEL_256,
            $sSecretKey,
            base64_decode($sValue),
            MCRYPT_MODE_ECB,
            mcrypt_create_iv(
                mcrypt_get_iv_size(
                    MCRYPT_RIJNDAEL_256,
                    MCRYPT_MODE_ECB
                ),
                MCRYPT_RAND
            )
        ), "\0"
    );
}

function url_encode( $string ){ ///보낼때
    $str = base64_encode(rawurlencode(base64_encode(rawurlencode(base64_encode(utf8_encode($string))))));
    return $str;
}

function url_decode( $string ){/// 받을떄
    $str = utf8_decode(base64_decode(rawurldecode(base64_decode(rawurldecode(base64_decode($string))))));
    return $str;
}

function url_sim_encode2( $string ){///보낼때
    $str = utf8_encode(rawurlencode(base64_encode($string)));
    return $str;
}

function url_sim_decode2( $string ){/// 받을떄
    $str = base64_decode(rawurldecode(utf8_decode($string)));
    return $str;
}

function url_sim_encode( $string ){///보낼때
    $str = utf8_encode(base64_encode($string));
    return $str;
}

function url_sim_decode( $string ){/// 받을떄
    $str = base64_decode(utf8_decode($string));
    return $str;
}
// $value -> 날짜 정보 $type 바꾸려는 타입 기본 "."
//$common->dateStyle($value);
function dateStyle($value,$type="."){
    $result = str_replace("-",$type,$value);
    return $result;
}




/////////-> end
}
    $common = new HC_common();
?>
