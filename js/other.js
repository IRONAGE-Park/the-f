//달력 관련
$(function() {

	if ( $('#view_sdate').length ){
		//$( "#view_sdate" ).datepicker( );
		$( "#view_sdate" ).datepicker({ 
			defaultDate : '1985-01-01' 
			,showButtonPanel: true //140423 추가
			,closeText: '닫기' //140423 추가
		});
		$( "#view_sdate2" ).datepicker({ 
			defaultDate : '1980-01-01'
			,showButtonPanel: true //140423 추가
			,closeText: '닫기' //140423 추가
		});
		$( "#view_edate" ).datepicker({
			showButtonPanel: true //140423 추가
			,closeText: '닫기' //140423 추가
		} );
	}


	if ( $('#view_sdate1').length ){
		$( "#view_sdate1" ).datepicker({
			showButtonPanel: true //140423 추가
			,closeText: '닫기' //140423 추가
		} );
		$( "#view_edate1" ).datepicker( {
			showButtonPanel: true //140423 추가
			,closeText: '닫기' //140423 추가
		});
	}

/*
 $("#view_sdate").datepicker({
  showOn: "both", // 버튼과 텍스트 필드 모두 캘린더를 보여준다.
  buttonImage: "/application/db/jquery/images/calendar.gif", // 버튼 이미지
  buttonImageOnly: true, // 버튼에 있는 이미지만 표시한다.
  changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
  changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
  minDate: '-100y', // 현재날짜로부터 100년이전까지 년을 표시한다.
  nextText: '다음 달', // next 아이콘의 툴팁.
  prevText: '이전 달', // prev 아이콘의 툴팁.
  numberOfMonths: [1,1], // 한번에 얼마나 많은 월을 표시할것인가. [2,3] 일 경우, 2(행) x 3(열) = 6개의 월을 표시한다.
  //stepMonths: 3, // next, prev 버튼을 클릭했을때 얼마나 많은 월을 이동하여 표시하는가. 
  yearRange: 'c-100:c+10', // 년도 선택 셀렉트박스를 현재 년도에서 이전, 이후로 얼마의 범위를 표시할것인가.
  showButtonPanel: true, // 캘린더 하단에 버튼 패널을 표시한다. 
  currentText: '오늘 날짜' , // 오늘 날짜로 이동하는 버튼 패널
  closeText: '닫기',  // 닫기 버튼 패널
  dateFormat: "yy-mm-dd", // 텍스트 필드에 입력되는 날짜 형식.
  showAnim: "slide", //애니메이션을 적용한다.
  showMonthAfterYear: true , // 월, 년순의 셀렉트 박스를 년,월 순으로 바꿔준다. 
  dayNamesMin: ['월1', '화', '수', '목', '금', '토', '일'], // 요일의 한글 형식.
  monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'] // 월의 한글 형식.
                    
 });

*/



});

// 첨부파일 추가 ============
function add_file(){

	var ord_count = parseInt(signform.file_num.value);
	add = parseInt(ord_count+1);
	document.signform.file_num.value = add;

	if(add<=30) {
		text = "<br><input type='file' name='in_file[]' size='40'>";
		var Tag = document.getElementById("fname_span");
		Tag.innerHTML += text;
	} else {
		alert("30개 까지만 첨부 가능합니다.");
		return;
	}
}
function add_file2(){

	var ord_count = parseInt(signform.file_num.value);
	add = parseInt(ord_count+1);
	document.signform.file_num.value = add;

	if(add<=10) {
		text = "<br><input type='file' name='in_file[]' size='30' style='height:25px;'>";
		var Tag = document.getElementById("fname_span");
		Tag.innerHTML += text;
	} else {
		alert("10개 까지만 첨부 가능합니다.");
		return;
	}
}

//아이디 확인
$(document).ready(function(){
	$(document).on("keyup","input[name='mid']", function(){
		var idVal = $('input[name="mid"]').val();

			var IdChkExp =  /^[a-z0-9_-]{3,16}$/; // 아이디 검사식
			if(!IdChkExp.test(idVal)) {
				$("#loginId").html('<b style="color:#ff0000">영문,숫자만 가능</b>');
				return false;
			}


			if(idVal.length >= 5){

				$.ajax({
					type : "POST"
					, url : "/INC/other_ajax.php"
					, dataType : "json"
					, data : "mode=duplicate&v="+idVal
					, beforeSend: function(){  $("#curtainTop").show(); }
					, success : function(res){ $("#curtainTop").hide();
					 if(res.code=='1'){
						$("#loginId").html('<b style="color:#ff0000">중복</b>');
						//$('input[name="id"]').val('');
					 }else{
						$("#loginId").html('사용가능');
					 }
					}
				});
			}else{
					$("#loginId").html('<b style="color:#ff0000">5자 이상 입력</b>');
			}
	});

	//비밀번호 확인
	$(document).on("keyup","input[name='upasswd']", function(){
		var idVal = $('input[name="upasswd"]').val();
		var idVal_1 = $('input[name="upasswd1"]').val();
	
			if(idVal.length < 4){
				$("#passId").html('<b style="color:#ff0000"> 4자 이상 입력</b>');
			} else {
				$("#passId").html(' 사용가능');
			}

	});

	$(document).on("keyup","input[name='upasswd1']", function(){
		var idVal = $('input[name="upasswd"]').val();
		var idVal_1 = $('input[name="upasswd1"]').val();
	
			if(idVal!=idVal_1) {
				$("#passId_1").html('<b style="color:#ff0000"> 비밀번호가 일치하지 않습니다.</b>');
			} else {
				$("#passId_1").html(' 사용가능');
			}
	});




}); //end $(document).ready(function(){


//주소상동
function addr_copy() {

 if(signform.par_zip1){
	signform.par_zip1.value=signform.uzip1.value;
	signform.par_zip2.value=signform.uzip2.value;
	signform.par_addr1.value=signform.uaddr1.value;
	signform.par_addr2.value=signform.uaddr2.value;
 }
}

//선택한 회원 처리
function select_member_change(type,link) {

	var j = 0;
	var length = 0;
	var arrItemList = new Array();
	var Itemlist = new Array();


	/* uid 배열로 구한다.  */
	for(var i = 0; i<document.listform.length; i++) {
		if(document.listform.elements[i].checked == true) {
			if(document.listform.elements[i].value != 0) {
				arrItemList[j] = document.listform.elements[i].value;
				j += 1 ;
			}
		}
	}

	Itemlist = arrItemList.join(",");

	if(type=="member_out"){		//선택한거 변경
		if( j == 0 ){
			alert("선택한 항목이 없습니다");
			return;
			}
		selectMemberout(Itemlist,link);
	}

	if(type=="member_state"){		//선택한거 변경
		if( j == 0 ){
			alert("선택한 항목이 없습니다");
			return;
			}
		selectMemberstate(Itemlist,link);
	}

	if(type=="member_in"){		//회원복원
		if( j == 0 ){
			alert("선택한 항목이 없습니다");
			return;
			}
		selectMemberin(Itemlist,link);
	}
	if(type=="member_del"){		//회원삭제
		if( j == 0 ){
			alert("선택한 항목이 없습니다");
			return;
			}
		selectMemberdel(Itemlist,link);
	}
	if(type=="board_view"){		//게시물 숨기기
		if( j == 0 ){
			alert("선택한 항목이 없습니다");
			return;
			}
		selectBoardview(Itemlist,link);
	}

	if(type=="board_delete"){		//게시물 숨기기
		if( j == 0 ){
			alert("선택한 항목이 없습니다");
			return;
			}
		selectBoarddelete(Itemlist,link);
	}

	if(type=="user_board_delete"){		//게시물 숨기기
		if( j == 0 ){
			alert("선택한 항목이 없습니다");
			return;
			}
		user_selectBoarddelete(Itemlist,link);
	}

}

//선택한 회원 탈퇴 시키기
function selectMemberout(Itemlist,link){
	temp1 = confirm("선택한 회원을 탈퇴 시키겠습니까?");
	if(temp1 == true) {
		var ref = link + "&uid=" + Itemlist;
		//window.open = ref;
		fancyboxOpen_w(ref,'300');
	} else {
		return;
	}

}  //end function

//선택한 회원 복원 시키기
function selectMemberin(Itemlist,link){
	temp1 = confirm("선택한 회원을 복원 시키겠습니까?");
	if(temp1 == true) {
		var ref = link + "&uid=" + Itemlist;
		//window.open = ref;
		fancyboxOpen_w(ref,'300');
	} else {
		return;
	}

}  //end function

//선택한 회원 삭제 시키기
function selectMemberdel(Itemlist,link){
	temp1 = confirm("선택한 회원을 삭제 시키겠습니까? 회원정보가 완전 삭제 됩니다.!");
	if(temp1 == true) {
		var ref = link + "&uid=" + Itemlist;
		//window.open = ref;
		fancyboxOpen_w(ref,'300');
	} else {
		return;
	}
}  //end function




//선택한 게시물 상태 변경
function selectBoardview(Itemlist,link){
	temp1 = confirm("선택한 게시물을 숨기기 처리 하겠습니까?");
	if(temp1 == true) {
		var ref = link + "&uid=" + Itemlist;
		//window.open = ref;
		fancyboxOpen_w(ref,'300');
	} else {
		return;
	}

}  //end function

//선택한 게시물 삭제
function selectBoarddelete(Itemlist,link){
	temp1 = confirm("선택한 게시물을 삭제 하겠습니까?");
	if(temp1 == true) {
		var ref = link + "&uid=" + Itemlist;
		//window.open = ref;
		fancyboxOpen_w(ref,'300');
	} else {
		return;
	}

}  //end function

//선택한 게시물 삭제
function user_selectBoarddelete(Itemlist,link){
	temp1 = confirm("선택한 게시물을 삭제 하겠습니까?");
	if(temp1 == true) {
		var ref = link + "&uid=" + Itemlist;
		window.location= ref;		
	} else {
		return;
	}

}  //end function


//게시판 글 등록 체크
function boardWritecheck(){
	if(signform.mode){
		if(!signform.mode.value){
			// alert("분류를 선택해 주세요.");
			swal("분류를 선택해주세요.", '', 'error');
			signform.mode.focus();
			return false;
		}
	}

	if(isBlank(signform.title.value)) {
		// alert("제목을 입력해 주세요.");
		swal("제목을 입력해주세요.", '', 'error');
		signform.title.focus();
		return false;
	}


	if(signform.pass){
		if(isBlank(signform.pass.value)) {
			// alert("비밀번호를 입력해 주세요.");
			swal("비밀번호를 입력해주세요.", '', 'error');
			signform.pass.focus();
			return false;
		}
	}

	if(signform.uname){
		if(isBlank(signform.uname.value)) {
			// alert("이름을 입력해 주세요.");
			swal("이름을 입력해주세요.", '', 'error');
			signform.uname.focus();
			return false;
		}
	}



	//파일 체크 한다.
	if(signform.fileadd) {
		if(signform.fileadd.value) {

			var obj = signform.fileadd;
			var no  = obj.value.lastIndexOf(".");
			var file_name = obj.value.substr(no+1, 3);
			//이미지/ PDF/ 오피스/ 한글
			if ((file_name.toUpperCase() != "JPG") && (file_name.toUpperCase() != "GIF") && (file_name.toUpperCase() != "PNG") && (file_name.toUpperCase() != "XLS") && (file_name.toUpperCase() != "XLSX")  && (file_name.toUpperCase() != "PDF") && (file_name.toUpperCase() != "HWP") && (file_name.toUpperCase() != "TXT") ) {
				// alert("jpg,gif,png,pdf,hwp,xls 파일만 업로드 가능합니다.");
				swal("jpg, gif, png, pdf, hwp, xls 파일만 업로드 가능합니다.", '', 'error');
				signform.fileadd.focus();
				return false;
			}

		}
	}
	//파일 체크 한다.
	if(signform.fileadd1) {
		if(signform.fileadd1.value) {

			var obj = signform.fileadd1;
			var no  = obj.value.lastIndexOf(".");
			var file_name = obj.value.substr(no+1, 3);

			if ((file_name.toUpperCase() != "JPG") && (file_name.toUpperCase() != "GIF") && (file_name.toUpperCase() != "PNG") && (file_name.toUpperCase() != "XLS") && (file_name.toUpperCase() != "XLSX")  && (file_name.toUpperCase() != "PDF") && (file_name.toUpperCase() != "HWP") && (file_name.toUpperCase() != "TXT") ) {
				// alert("jpg,gif,png,pdf,hwp,xls 파일만 업로드 가능합니다.");
				swal("jpg, gif, png, pdf, hwp, xls 파일만 업로드 가능합니다.", '', 'error');
				signform.fileadd1.focus();
				return false;
			}

		}
	}

	//return true;	
	signform.submit();

} //function boardWritecheck(){



//게시판 글 등록 체크
function boardDelcheck(){

	if(isBlank(signform.pass.value)) {
		alert("비밀번호를 입력해주세요.");
		swal("비밀번호를 입력해주세요.", '', 'error');
		signform.pass.focus();
		return false;
	}

	signform.submit();

} //function boardWritecheck(){




//게시판 글 등록 체크
function jumpoWritecheck(){

	if(isBlank(signform.title.value)) {
		alert("제목을 입력해 주세요.");
		signform.title.focus();
		return false;
	}


	//파일 체크 한다.
	if(signform.fileadd) {
		if(signform.fileadd.value) {

			var obj = signform.fileadd;
			var no  = obj.value.lastIndexOf(".");
			var file_name = obj.value.substr(no+1, 3);
			//이미지/ PDF/ 오피스/ 한글
			if ((file_name.toUpperCase() != "JPG") && (file_name.toUpperCase() != "GIF") && (file_name.toUpperCase() != "PNG") && (file_name.toUpperCase() != "XLS") && (file_name.toUpperCase() != "XLSX")  && (file_name.toUpperCase() != "PDF") && (file_name.toUpperCase() != "HWP") ) {
				alert("jpg,gif,png,pdf,hwp,xls 파일만 업로드 가능합니다.");
				signform.fileadd.focus();
				return false;
			}

		}
	}
	//파일 체크 한다.
	if(signform.fileadd1) {
		if(signform.fileadd1.value) {

			var obj = signform.fileadd1;
			var no  = obj.value.lastIndexOf(".");
			var file_name = obj.value.substr(no+1, 3);

			if ((file_name.toUpperCase() != "JPG") && (file_name.toUpperCase() != "GIF") && (file_name.toUpperCase() != "PNG") && (file_name.toUpperCase() != "XLS") && (file_name.toUpperCase() != "XLSX")  && (file_name.toUpperCase() != "PDF") && (file_name.toUpperCase() != "HWP") ) {
				alert("jpg,gif,png,pdf,hwp,xls 파일만 업로드 가능합니다.");
				signform.fileadd1.focus();
				return false;
			}

		}
	}

	return true;	
	//signform.submit();

} //function jumpoWritecheck(){


//게시판 글 등록 체크
function onlineWritecheck(){

	if(signform.mode){
		if(!signform.mode.value){
			alert("분류를 선택해 주세요.");
			signform.mode.focus();
			return false;
		}
	}

	return true;	
	//signform.submit();
}


function isBlank(str) {
    str = str.replace(/\s/g, '');
    return (str.length==0);
}

//이미지 포맷 체크 함수
function Check_Img(obj) {

	var no = obj.value.lastIndexOf(".");
	var file_name = obj.value.substr(no+1, 3);

	if (!((file_name.toUpperCase() == "JPG") || (file_name.toUpperCase() == "GIF")))	{
		return false;
	}

	return true;
}

// 게시판 글 삭제 한다 (페이지수,게시물번호)
function contentDel(val){
	temp = confirm("글을 삭제 하겠습니까?");
	if(temp == true) {
		window.location = val;
	} else {
		return;
	}
}


// 게시판 글 삭제 한다 (페이지수,게시물번호)
function contentModify(val,cont){
	temp = confirm(cont);
	if(temp == true) {
		window.location = val;
	} else {
		return;
	}
}


//댓글 게시판 글 등록
function memoCheck(){

	if(isBlank(memoform.content.value)) {
		alert("내용을 입력해 주세요.");
		memoform.content.focus();
		return;
	}

	memoform.submit();
} //function boardWritecheck(){



function showhide(what,num) {

	if (what.style.display=='') {
		closewhide(what);
	return ;
	}

	for(j=1;j>=30;j++) {
		if(j<=num)
			menu_cont_+j+'.style.display=none';
	}
	if (what.style.display=='none') {
		what.style.display='';
	}
}

//이용후기 내용 감추기
function closewhide(what) {
	what.style.display='none';
}

//메일 직업입력 부분 
function changeEmail ( email ) { 

	if(email == "1") { 
		//document.getElementById("email2").style.display = "block"; 
		document.signform.uemail2.value = ""; 
	} else { 
		//document.getElementById("email2").style.display = "none"; 
		document.signform.uemail2.value = email; 
	} 
} 

function changeEmail_1 ( email ) { 
	if(email == "1") { 
		document.signform_1.uemail2_1.value = ""; 
	} else { 
		document.signform_1.uemail2_1.value = email; 
	} 
} 


//파일 업로드 체크
function file_upload() {
	obj = document.getElementById('fileupload');
	var filename = $(obj).val().substring($(obj).val().lastIndexOf('\\')+1);

	var ext = filename.substring(filename.lastIndexOf('.')+1).toLowerCase();


	if(!ext) {
		alert("파일을 선택해 주세요.");
		return;
	}

	if(ext == "xls") {
		//alert("업로드 가능");
		frm_up.submit();
	} else {
		alert("업로드가능한 파일이 아닙니다. 다시 선택해 주세요.");
		frm_up.fileupload.focus();
		return;
	}

}

//문자열 길이 체크 (글자수길이,변수명)
function CheckMsg(lenval,nameval) {
	var str,msg;
	var len = 0;
	var temp;
	var count = 0;

	var msg = $('#'+nameval).val();
	str = new String(msg);
	len = str.length;

	for (k=0 ; k<len ; k++){
		temp = str.charAt(k);
		if (escape(temp).length > 4) {
			count += 2;
		}
		else if (temp == '\r' && str.charAt(k+1) == '\n') { // \r\n일 경우
			count += 2;
		}
		else if (temp != '\n') {
			count++;
		}
	}

	allSend.innerText = count;
	/*
	if(count > lenval) {
		//$('#'+nameval).blur();
		//$('#'+nameval).focus();
		CutChar(lenval,nameval);
	}*/
}

function CutChar(endval,nameval) {
	var str,msg;
	var len=0;
	var temp;
	var count;
	count = 0;

	msg = $('#'+nameval).val();
	str = new String(msg);
	len = str.length;

	for(k=0 ; k<len ; k++) {
		temp = str.charAt(k);

		if(escape(temp).length > 4) {
			count += 2;
		}
		else if (temp == '\r' && str.charAt(k+1) == '\n') { // \r\n일 경우
			count += 2;
		}
		else if(temp != '\n') {
			count++;
		}
		if(count > endval) {
			str = str.substring(0,k);
			break;
		}
	}

	$('#'+nameval).value = str;
	alert("내용은 "+endval+"byte 까지만 가능합니다.");
	//CheckMsg();
} //end function CutChar() {




//로그아웃 처리
	$(document).ready(function(){
		$("#logout").css("cursor","pointer");
		$("#logout").click(function(){
				$.ajax({
					type : "POST"
					, url : "/INC/userlogin_ajax1.php"
					, dataType : "JSON"
					, data : "mode=logout"
					, success : function(res){
						if(res.code=="1"){
							location.replace("/");
						}
					}
				});
		});
	});

//메인 로그아웃 처리
	$(document).ready(function(){
		$("#main_logout").css("cursor","pointer");
		$("#main_logout").click(function(){
				$.ajax({
					type : "POST"
					, url : "/INC/userlogin_ajax1.php"
					, dataType : "JSON"
					, data : "mode=logout"
					, success : function(res){
						if(res.code=="1"){
							location.replace("/");
						}
					}
				});
		});
	});




/**
 * 메인 퀵 이동
 */

 var m_quick = {
    init: function() {
        this.qucik_m();
    },
    qucik_m: function() {
        
        // var currentTop = parseInt($('.m-quick-box').css('top'));
        // $(window).scroll(function() {
        //     $('.m-quick-box').stop().animate({'top': $(window).scrollTop()+currentTop+'px'}, 500);
        // });
        
        $(function() {

            $('.quick-top-go a').on('click',function(event){
                var $anchor = $(this);
                
                $('html, body').clearQueue().stop().animate({scrollTop: $($anchor.attr('href')).offset().top}, 700,'easeInOutCubic');

                event.preventDefault();
            });
        });

        
    }
};

m_quick.init(); // 메인퀵 실행
