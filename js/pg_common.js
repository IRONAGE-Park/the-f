
function stripslashes (str) {
  // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   improved by: Ates Goral (http://magnetiq.com)
  // +      fixed by: Mick@el
  // +   improved by: marrtins
  // +   bugfixed by: Onno Marsman
  // +   improved by: rezna
  // +   input by: Rick Waldron
  // +   reimplemented by: Brett Zamir (http://brett-zamir.me)
  // +   input by: Brant Messenger (http://www.brantmessenger.com/)
  // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
  // *     example 1: stripslashes('Kevin\'s code');
  // *     returns 1: "Kevin's code"
  // *     example 2: stripslashes('Kevin\\\'s code');
  // *     returns 2: "Kevin\'s code"
  return (str + '').replace(/\\(.?)/g, function (s, n1) {
    switch (n1) {
    case '\\':
      return '\\';
    case '0':
      return '\u0000';
    case '':
      return '';
    default:
      return n1;
    }
  });
}

//이미지 확장자 체크
function checkImgFile(obj,tg_name) {
	var filename = $(obj).val().substring($(obj).val().lastIndexOf('\\')+1);
	var ext = filename.substring(filename.lastIndexOf('.')+1).toLowerCase();
	if (ext == "jpg"  || ext == "png"  || ext == "gif"  ||
		ext == "ppt"  || ext == "xls"  || ext == "doc"  ||
		ext == "pptx" || ext == "xlsx" || ext == "docx" ||
		ext == "zip"  || ext == "txt"  || ext == "pdf"
	) {
		$(tg_name).val( filename );
		return true;
	} else {
		alert("업로드가능한 파일이 아닙니다. 다시 선택해 주세요.");
		return false;
	}
}

//이미지 확장자 체크
function checkFile(obj,tg_name) {
	var filename = $(obj).val().substring($(obj).val().lastIndexOf('\\')+1);
	var ext = filename.substring(filename.lastIndexOf('.')+1).toLowerCase();
	if (ext == "jpg"  || ext == "png"  || ext == "gif" ) {
		$(tg_name).val( filename );
		return true;
	} else {
		alert("이미지 파일이 아닙니다. 다시 선택해 주세요.");
		return false;
	}
}

	/// onFocus="clearText(this)" onBlur="clearTextOut(this)"
	function clearText(y){
		if (y.defaultValue==y.value){
			y.value = "";
		}
	}
	function clearTextOut(y){
		if (y.value==""){
			y.value = y.defaultValue;
		}
	}

	function clearImg(y){
		y.style.backgroundImage='url(none)';
	}

	function popup(url,id,w,h,sc){
		if(sc!="") sc = "yes";
		var window_left = (screen.width-640)/2;
		var window_top = (screen.height-480)/2;
	   //showModalDialog
		window.open(url,id,'width=' + w + ',height=' + h + ',status=no,scrollbars='+ sc +',menubar=no,top=' + window_top + ',left=' + window_left + '');
	}
	function popup2(url,id,w,h,sc){
		if(sc!="") sc = "yes";
		var window_left = (screen.width-640)/2;
		var window_top = (screen.height-480)/2;
		showModalDialog(url,id,'width=' + w + ',height=' + h + ',status=no,scrollbars='+ sc +',menubar=no,top=' + window_top + ',left=' + window_left + '');
	}

     function frmIdCheck(nv){

        var nameVal = nv.split(",")
        var inputName = new Array();
        var inputText,thislimit,inputValu;
        var n_cnt = nameVal.length;
        for(n=0;n<n_cnt;n++){
		   inputName[n] = $("#"+nameVal[n]);
		}

        var x_cnt = inputName.length;
        for(x=0;x<x_cnt;x++){

            inputText = inputName[x].attr('title');
            thislimit = inputName[x].attr('txtlimit');
            inputChks = inputName[x].attr('chk');

                    inputValu = inputName[x].val();
                    if(!inputValu ){
                            alert(inputText+"를(을) 입력해주세요");
                            inputName[x].focus();
                           return false;
                    }else{
                        if(thislimit){ ///txtlimit='n'
                            var valcnt = inputValu.length;
                            if(thislimit > valcnt){
                                    alert(inputText+"의 글자 수가 작습니다.");
                                    inputName[x].focus();
                                    return false;
                            }
                        }
                    }

					if(inputChks){
						if(inputChks=="email"){
						    var EmailChkExp = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
							if(!EmailChkExp.test(inputName[x].val())) {
								alert('이메일 주소가 유효하지 않습니다');
									inputName[x].focus();
								return false;
							}
						}
						if(inputChks=="number"){
						    var NumberChkExp = /[^0-9.]/gi;
							if(NumberChkExp.test(inputName[x].val())== true ) {
								alert('숫자만 입력해주세요');
									inputName[x].focus();
								return false;
							}
						}
						if(inputChks=="eng"){
						    var NumberChkExp = /[^a-zA-Z]/g;;
							if(NumberChkExp.test(inputName[x].val())== true ) {
								alert('영문만 입력해주세요');
									inputName[x].focus();
								return false;
							}
						}
					} ///CHK

         }
        return true;
    }

	/// onsubmit="return frmCheck('name,name2');"
    function frmCheck(nv){

        var nameVal = nv.split(",")
        var inputName = new Array();
        var inputText,thislimit,inputValu;
        var n_cnt = nameVal.length;
        for(n=0;n<n_cnt;n++){

			var sVal = $("input[name="+nameVal[n]+"]").val();
			if(sVal==undefined){
				inputName[n] = $("select[name="+nameVal[n]+"]");
			}else{
				inputName[n] = $("input[name="+nameVal[n]+"]");
			}
		}

        var x_cnt = inputName.length;
        for(x=0;x<x_cnt;x++){

            inputText = inputName[x].attr('title');
            inputRead = inputName[x].attr('readonly');
            inputType = inputName[x].attr('type');
            inputChks = inputName[x].attr('chk');      //입력타입 email number eng
            thislimit = inputName[x].attr('txtlimit'); //글자수 txtlimit='n'
                if(inputType=="radio"){
                     if(!$(":radio[name="+nameVal[x]+"]:checked").val()){
                        alert(inputText+"를(을) 체크해주세요");
                        return false;
                     }

                }else if(inputType=="checkbox"){
                    if($("input:checkbox[name="+nameVal[x]+"]").is(":checked") != true ){
                        alert(inputText+"를(을) 체크해주세요");
                        return false;
                    }
                    /// 값가져오기 $('input:checkbox [ id="checkbox_id" ]').val();

                }else if(inputType=="text"){

                    inputValu = inputName[x].val();
                    if(!inputValu ){
						if (inputRead=="readonly"){
                            alert(inputText+"이(가) 입력 되지 않았습니다.");
                            inputName[x].focus();
                           return false;
						}else{
                            alert(inputText+"를(을) 입력해주세요");
                            inputName[x].focus();
                           return false;
						}
					}else{
                        if(thislimit){ ///txtlimit='n'
                            var valcnt = inputValu.length;
                            if(thislimit > valcnt){
                                    alert(inputText+"의 글자 수가 작습니다.");
                                    inputName[x].focus();
                                    return false;
                            }
                        }
                    }

					if(inputChks){

						if(inputChks=="idcheck"){
							  if(inputValu < 5 || inputValu > 15) {
								 alert("아이디는 5 ~ 15자의 영문 소문자나 숫자 또는 조합된 문자열이어야 합니다!");
								 return false;
							  }
							  for(var i = 0; i < inputValu.length; i++) {
								 var chr = inputValu.substr(i,1);
								 if((chr < '0' || chr > '9') && (chr < 'a' || chr > 'z')) {
									alert("아이디는 5 ~ 15자의 영문 소문자나 숫자 또는 조합된 문자열이어야 합니다!");
									return false;
								 }

							  }
						}
						if(inputChks=="email"){
						    var EmailChkExp = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
							if(!EmailChkExp.test(inputName[x].val())) {
								alert('이메일 주소가 유효하지 않습니다');
									inputName[x].focus();
								return false;
							}
						}
						if(inputChks=="number"){
						    var NumberChkExp = /[^0-9.]/gi;
							if(NumberChkExp.test(inputName[x].val())== true ) {
								alert('숫자만 입력해주세요');
									inputName[x].focus();
								return false;
							}
						}
						if(inputChks=="eng"){
						    var NumberChkExp = /[^a-zA-Z]/g;;
							if(NumberChkExp.test(inputName[x].val())== true ) {
								alert('영문만 입력해주세요');
									inputName[x].focus();
								return false;
							}
						}
					} ///CHK
                }else if(inputType=="hidden"){
                    inputValu = inputName[x].val();
                    if(!inputValu ){
                        alert(inputText+"의 값이 없습니다.");
                        return false;
                    }
                }else if(inputType=="password"){
                    inputValu = inputName[x].val();
			
					//비밀번호 확인 검사 
					if(inputChks=="pwcheck"){							
						  if (signform.upasswd.value != signform.upasswd1.value) {
							 alert("입력하신 비밀번호가 일치하지 않습니다.\n다시 확인하시고 입력하여 주십시오.");
							 signform.upasswd1.focus();
							 signform.upasswd1.select();
							  return false;
						  }
					}


                    if(!inputValu ){
                            alert(inputText+"를(을) 입력해주세요");
                            inputName[x].focus();
                           return false;
                    }else{
                        if(thislimit){
                            var valcnt = inputValu.length;
                            if(thislimit > valcnt){
                                    alert(inputText+"의 글자 수가 작습니다.");
                                    inputName[x].focus();
                                    return false;
                            }
                        }
                    }
                }else{ ///select
                    inputValu = inputName[x].val();
                    if(!inputValu ){
                        alert(inputText+"를 선택해 주세요.");
						inputName[x].focus();
                        return false;
                    }
                } //inputType



         }
        return true;
    }

//
//    // mini jQuery plugin that formats to two decimal places
//    (function($) {
//        $.fn.currencyFormat = function() {
//            this.each( function( i ) {
//                $(this).change( function( e ){
//                    if( isNaN( parseFloat( this.value ) ) ) return;
//                    this.value = parseFloat(this.value).toFixed(2);
//                });
//            });
//            return this; //for chaining
//        }
//    })( jQuery );
//
//    // apply the currencyFormat behaviour to elements with 'currency' as their class
//    $( function() {
//        $('.currency').currencyFormat();
//     });

function fillzero(obj, len) {
  obj= '000000000000000'+obj;
  return obj.substring(obj.length-len);
}
//사용법 fillzero(33, 5);
//결과 00033

function numberFormat(val){
    var number = val.toString();
    var minus = false;

    if (number.length > 3) {
        if (number.charAt(0) == '-') {
            number = number.substr(1);
            minus = true;
        }
        var mod = number.length % 3;
        var div = number.length / 3;
        var output = (mod > 0 ? (number.substring(0, mod)) : "");
        for (var i = 0; i < Math.floor(div); i++) {
            if ((mod == 0) && (i == 0)) {
                output += number.substring(mod + 3 * i, mod + 3 * i + 3);
            } else {
                output += "," + number.substring(mod + 3 * i, mod + 3 * i + 3);
            }
        }
        if (minus) {
            return "-"+ output;
        } else {
            return output;
        }
    } else {
        return number;
    }
}

/*  modal_name  띄우려는 내용에 해당하는 레이어 */
function modal_pop ( modal_id ,title, width) {
	$(function() {
		$( modal_id ).dialog({
			'autoOpen': true,
			'title' : title,
			'modal': true,
			'draggable': false,
			'resizable': false,
			'width': width,
				'buttons': {
					"닫기": function() {
						$( this ).dialog( "close" );
						history.back();
					}
				}

			});
	});
}

//modal_open ( 'modal_id', 'modal_title', modal_width, true, false, 'calendar1_id', 'calendar2_id' )
function modal_open ( modal_id, modal_title, modal_width, modal_resizable, modal_button, calendar1_id, calendar2_id ) {
	$(function() {
		$( modal_id ).dialog({
			'autoOpen': false,
			'title': modal_title,
			'resizable': modal_resizable,
			'closeOnEscape': true ,
			'buttons': [],
			'modal': true
		});
		if (modal_width > 0 ) {
			$( modal_id ).dialog({
				'width': modal_width
			});
		}
		if (modal_button) {
			$( modal_id ).dialog({
				'buttons': {
					"닫기": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		}
	});

	if ( calendar1_id.length > 0 )
	{
		$(function() {
			$( "#"+calendar1_id ).datepicker( );
		});
	}
	if ( calendar2_id.length > 0 )
	{
		$(function() {
			$( "#"+calendar2_id ).datepicker( );
		});
	}

	$( modal_id ).dialog( "open" );
	return false;
}

//모달창으로 메시지를 보여줌.
function view_msg ( modal_id, modal_title, msg ) {
	$( "#"+modal_id ).html( msg );
	modal_open ( "#"+modal_id, modal_title, 0, false, false, "", "" );
}

 /*  //사용법
     javascript:parent.fancyboxClose();
     javascript:fancyboxOpen('../blank.html');
 */
// fancybox팝업창열기
function fancyboxOpen(u,w){
	if(w==''){
	    $.fancybox.open({'type': 'iframe','padding' : 0,'href' : u });
	}else{
	    $.fancybox.open({'type': 'iframe','padding' : 0,'href' : u, 'width' : w });
	}
}
// fancybox팝업창닫기
function fancyboxClose(){
    $.fancybox.close();
}
// fancybox팝업창열기 사이즈 지정
function fancyboxOpen_w(u,w){
    $.fancybox.open({'type': 'iframe','padding' : 0,'href' : u, 'width' : w });
}

//달력 관련
//$(function() {
//	$( "#view_sdate" ).datepicker( );
//	$( "#view_edate" ).datepicker( );
//});
//end 달력 관련



//체크박스 전체선택
function checkall(frm){
   var i=0;
   if(frm.chklist.length){

   }else{
      if(frm.allCheck.checked){
         frm.chklist.checked=true;
      }else{
         frm.chklist.checked=false;
      }
   }

   if(frm.chklist.length > 1){
      for(i=0; i<frm.chklist.length; i++){
         if(frm.allCheck.checked){
            frm.chklist[i].checked=true;
         }else{
            frm.chklist[i].checked=false;
      }
    }
  }
} //end checkall(frm)


function rawurlencode (str) {
  // From: http://phpjs.org/functions
  // +   original by: Brett Zamir (http://brett-zamir.me)
  // +      input by: travc
  // +      input by: Brett Zamir (http://brett-zamir.me)
  // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +      input by: Michael Grier
  // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
  // +      input by: Ratheous
  // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
  // +   bugfixed by: Joris
  // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
  // %          note 1: This reflects PHP 5.3/6.0+ behavior
  // %        note 2: Please be aware that this function expects to encode into UTF-8 encoded strings, as found on
  // %        note 2: pages served as UTF-8
  // *     example 1: rawurlencode('Kevin van Zonneveld!');
  // *     returns 1: 'Kevin%20van%20Zonneveld%21'
  // *     example 2: rawurlencode('http://kevin.vanzonneveld.net/');
  // *     returns 2: 'http%3A%2F%2Fkevin.vanzonneveld.net%2F'
  // *     example 3: rawurlencode('http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a');
  // *     returns 3: 'http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a'
  str = (str + '').toString();

  // Tilde should be allowed unescaped in future versions of PHP (as reflected below), but if you want to reflect current
  // PHP behavior, you would need to add ".replace(/~/g, '%7E');" to the following.
  return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
  replace(/\)/g, '%29').replace(/\*/g, '%2A');
}
/**
 * 스트링의 바이트 수를 센다(length를 하면 한글도 길이1로 나오는데 바이트 수는 2가 된다)
 * @param obj   : textfield ,textarea objec
 * @return 바이트 수
 */
function FFGetByteLength( obj ){
	var msg = obj;
	var str = new String(msg);
	var len = str.length;
	var count = 0;

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
	return count;
}
/**
 * 스트링을 바이트 수만큼 자른다. 물론 한글을 깨지지 않게 잘라준다(한글이 짤릴경우 버림을 취한다)
 * maxlength만큼 자른 후 obj의 값을 자른 결과로 setting한다
 * @param obj       : textfield ,textarea objec
 * @param mexlength : 최대길이
 */

function FFCutByteString( obj, maxlength) {
	var str,msg;
	var len=0;
	var temp;
	var count;
	count = 0;

	msg = obj;
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
		if(count > maxlength) {
			str = str.substring(0,k);
			break;
		}
	}
	obj.value = str;
}
// Trim
function Trim(obj1){
	obj1 = obj1.replace(/^(\s+)|(\s+)$/g, "")
	return obj1;
}


//===== 오른쪽 마우스 막는 스크립트시작 ======= //
/*
document.oncontextmenu = function(){return false}
if(document.layers) {
	window.captureEvents(Event.MOUSEDOWN);
	window.onmousedown = function(e){
		if(e.target==document)return false;
	}
}
else {
	document.onmousedown = function(){return false}
}*/
//===== 오른쪽 마우스 막는 스크립트 끝 ======= //