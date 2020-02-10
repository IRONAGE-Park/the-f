<?
include_once "func_image_resize.php";

$funcNum = $_GET['CKEditorFuncNum'] ;
$CKEditor = $_GET['CKEditor'] ;
$langCode = $_GET['langCode'] ;

if (!stristr($_FILES['upload']['type'], 'image/')) {
	alertBack('이미지 파일만 업로드할 수 있습니다.');
	exit;
}

$up_url		= $_SERVER['DOCUMENT_ROOT'] . '/ckeditor/upload/' . date('Y');		// server path
$up_path	= '/ckeditor/upload/' . date('Y');			// for web
$src_file = $_FILES['upload']['tmp_name'];
$path_parts = pathinfo($_FILES['upload']['name']);
$n_name = array_sum(explode( ' ' , microtime()));
$exname = $path_parts['extension'];
$filename = $n_name . '.' . $exname;

if (!is_dir($up_url)) {
	mkdir($up_url, 0777, true);
}

if (move_uploaded_file($src_file, $up_url . '/' . $filename)) {
	$msg = '';
} else {
	$url = '';
	$msg = '파일이 업로드되지 않았습니다.';
}
/*
$saverdir_1 = $up_url;	
if(!copy($src_file,$saverdir_1)){
	$url = '';
	$msg = '파일이 업로드되지 않았습니다.'.$saverdir_1;
} else {
	$msg = '';
}

*/
$view_img = @getimagesize("../upload/".date(Y)."/".$filename);
if(  $view_img[0] > 830 ) {

	$upload_defaultpath="../upload/".date(Y)."/";
	$db_table_small_image_size="830";

	TG_Image_Resize($upload_defaultpath, $filename, $filename, (int)($db_table_small_image_size), 100 , "small_","N");

	$url = $up_path . '/small_'.$filename;

} else {
	$url = $up_path . '/' . $filename;
}

echo "
	<script>
		window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$msg');
	</script>
";
?>



