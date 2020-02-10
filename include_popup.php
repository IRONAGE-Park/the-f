<script>

var IE5=(document.getElementById && document.all)? true : false;
        var W3C=(document.getElementById)? true: false;
        var currIDb=null, currIDs=null, xoff=0, yoff=0; zctr=0; totz=0;

        function trackmouse(evt){
                if((currIDb!=null) && (currIDs!=null)){
                        var x=(IE5)? event.clientX+document.body.scrollLeft : evt.pageX;
                        var y=(IE5)? event.clientY+document.body.scrollTop : evt.pageY;
                                currIDb.style.left=x+xoff+'px';
                                currIDs.style.left=x+xoff+10+'px';
                                currIDb.style.top=y+yoff+'px';
                                currIDs.style.top=y+yoff+10+'px';
                        return false;
                }
        }

        function stopdrag(){
                currIDb=null;
                currIDs=null;
                NS6bugfix();
        }

        function grab_id(evt){
                xoff=parseInt(this.IDb.style.left)-((IE5)? event.clientX+document.body.scrollLeft : evt.pageX);
                yoff=parseInt(this.IDb.style.top)-((IE5)? event.clientY+document.body.scrollTop : evt.pageY);
                currIDb=this.IDb;
                currIDs=this.IDs;
        }

        function NS6bugfix(){
                if(!IE5){
                        self.resizeBy(0,1);
                        self.resizeBy(0,-1);
                }
        }

        function incrzindex(){
                zctr=zctr+2;
                this.subb.style.zIndex=zctr;
                this.subs.style.zIndex=zctr-1;
        }

        function createPopup(id, title, width, height, x , y , isdraggable, boxcolor, barcolor, shadowcolor, text, textcolor, textptsize, textfamily ,num){
			width = width-9;
                if(W3C){
                        zctr+=2;
                        totz=zctr;
                        var txt='';
                                txt+='<div id="'+id+'_s" style="position:absolute; left:'+(x+7)+'px; top:'+(y+7)+'px; width:'+width+'px; height:'+height+'px; background-color:; filter:alpha(opacity=50); visibility:visible;"></div>';
                                txt+='<div id="'+id+'_b" style="border:outset '+barcolor+' 2px; position:absolute; left:'+x+'px; top:'+y+'px; width:'+width+'px; overflow:hidden; height:'+height+'px; background-color:'+boxcolor+'; visibility:visible;z-index:100000; border:0px solid #000000; ">';
                                //txt+='<div style="width:'+width+'px; height:22px; background-color:'+barcolor+'; padding:0px; border:1px;"></div>';
                                txt+='<div id="'+id+'_ov" width:'+width+'px; style="margin:0px; color:'+textcolor+'; font:'+textptsize+'pt '+textfamily+';z-index:100000;"><table cellpadding="0" cellspacing="0" border="0" width="'+(IE5? width-0 : width)+'" style="border:0px solid #000000;"><tr  bgcolor=cccccc ><td width="100%" align=left><div id="'+id+'_h" style="width:'+(width-70)+'px; height:22px; font: 11px Tahoma; cursor:move; color:'+textcolor+';zindex=9999;z-index:100000;"><INPUT TYPE="checkbox"  onclick="closeWin(\''+id+'_b\',\'Pop'+num+'\');" style="cursor:hand" class=border><font color="000000">오늘하루 이창을 열지않음</font>&nbsp;&nbsp;<a onmousedown="document.getElementById(\''+id+'_s\').style.display=\'none\'; document.getElementById(\''+id+'_b\').style.display=\'none\';return false" style="cursor:hand;"><font color=#000000>[닫기]</a></div> </td></tr></table>'+text+'</div></div>';

                                document.write(txt);
                                this.IDh=document.getElementById(id+'_h');
                                this.IDh.IDb=document.getElementById(id+'_b');
                                this.IDh.IDs=document.getElementById(id+'_s');
                                this.IDh.IDb.subs=this.IDh.IDs;
                                this.IDh.IDb.subb=this.IDh.IDb;
                                this.IDh.IDb.IDov=document.getElementById(id+'_ov');
                                if(IE5){
                                        this.IDh.IDb.IDov.style.width=width-0;
                                        this.IDh.IDb.IDov.style.height=height-0;
                                        this.IDh.IDb.IDov.style.scrollbarBaseColor=boxcolor;
                                        this.IDh.IDb.IDov.style.overflow="auto";
                                }
                                else{
                                        this.IDh.IDs.style.MozOpacity=.5;
                                }
                                this.IDh.IDb.onmousedown=incrzindex;
                                if(isdraggable){
                                        this.IDh.onmousedown=grab_id;
                                        this.IDh.onmouseup=stopdrag;
                                }
                        }
                }

        if(W3C)document.onmousemove=trackmouse;
        if(!IE5 && W3C)window.onload=NS6bugfix;   
		


</script>
<SCRIPT LANGUAGE="JavaScript">
<!--
		function setCookie( name, value, expiredays ,val)
{
        var todayDate = new Date();
        todayDate.setDate( todayDate.getDate() + expiredays );
        document.cookie = val + '=' + escape( val ) + '; path=/; expires=' + todayDate.toGMTString() + ';'
		//alert(document.cookie);
 return;
}


function closeWin(lay,val) { 

	setCookie( lay, "done" , 1,val); 
   // alert(val);
	document.getElementById(lay).style.display='none';
}


function getCookie( name ){
  var nameOfCookie = name + "=";
  var x = 0;
  while ( x <= document.cookie.length )
  {
    var y = (x+nameOfCookie.length);
    if ( document.cookie.substring( x, y ) == nameOfCookie ) {
      if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
        endOfCookie = document.cookie.length;
      return unescape( document.cookie.substring( y, endOfCookie ) );
    }
    x = document.cookie.indexOf( " ", x ) + 1;
    if ( x == 0 )
      break;
  }
  return "";
}
//-->
</SCRIPT>




<SCRIPT LANGUAGE="JavaScript">
     <!--
   

   
<?
	//팝업 창 검색하여 보여주기
	$i=0;
	$date = date("Y-m-d");
	$query = "select * from tb_popup  where sdate <= '$date' and edate >= '$date' and viewtype = 'Y' $pop_wsql";
	$result = $db->fetch_array( $query );
	$rcount = count($result) ; 

	if($rcount){
		$left_value = 50;

		for ( $i=0 ; $i<$rcount ; $i++ ) {
			$Coval = "Pop".$result[$i]["uid"];
			$val = "Pop".$num;
			
			$moveurl = $result[$i][moveurl];
			$action_type = $result[$i][actiontype];
			$fileadd_name = $result[$i][fileadd_name];
?>

	<?
			$img_url = "$HOME_PATH/upload/popup/$fileadd_name";
		
			$file_size=GetImageSize("$ROOT_PATH/upload/popup/$fileadd_name");
			
			$result[$i][w_size] = "$file_size[0]";
			$result[$i][h_size] = "$file_size[1]";



			$w_size = $result[$i][w_size]+8;
			$h_size = $result[$i][h_size]+28;

			$h_size_1 = $result[$i][h_size]+10;
			$left_value_1 = $left_value."_b";
			
			if($action_type=="move") { 
				//화면닫고이동
				$move_link = "<a href=\"#\" onClick=\"document.getElementById(\'$left_value_1\').style.display=\'none\';location.href=\'$moveurl\'\">";
			} else {
				//$move_link = "<a onClick=\"document.getElementById(\'$left_value_1\').style.display=\'none\';location.href=\'$moveurl\';\">";
				$move_link = "<a href=\"#\" onClick=\"document.getElementById(\'$left_value_1\').style.display=\'none\';\">";
			}
			if($Coval){
?>

			if ( getCookie( "<?=$Coval?>" ) != "<?=$Coval?>" ){
				//function createPopup(id, title, width, height, x , y , isdraggable, boxcolor, barcolor, shadowcolor, text, textcolor, textptsize, textfamily ){
				createPopup( '<?=$left_value?>', '58' , <?=$w_size?>, <?=$h_size?>, <?=$result[$i][left_v]?>, <?=$result[$i][top_v]?>, true, 'ffffff' , '3B6BA9' , 'ffffff' ,  '<?=$move_link?><IMG src="<?=$img_url?>" width=<?=$result[$i][w_size]?> height=<?=$result[$i][h_size]?> align=left border=0 name="imgphoto"></a><br>' , 'ffffff' , 10 , 'Arial','<?=$result[$i][uid]?>'); 		

			} 
<?
				$left_value += 420;

			}
		}
	}

?>


      
     //-->
</SCRIPT>  
