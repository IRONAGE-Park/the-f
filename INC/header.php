<?php
@extract($_GET); 
@extract($_POST); 

	$doc_root = $_SERVER['DOCUMENT_ROOT'];
    require_once($doc_root."/INC/get_session.php");
    require_once($doc_root."/INC/dbConn.php");
    require_once($doc_root."/INC/Function.php");
	require_once($doc_root."/INC/arr_data.php");

    require_once($doc_root."/INC/func_other.php");
	require_once($doc_root."/INC/down.php");			//파일 다운로드

$url=$_SERVER["PHP_SELF"];
$file_arr=explode("/",$url);
$file_path=$file_arr[sizeof($file_arr)-1];
$file_path_1=$file_arr[sizeof($file_arr)-2];
//echo "$file_path /";
?>
<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The F</title>
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	<link rel='stylesheet' type='text/css' href='../css/header.css'>
	<? if ($mainpage) { ?> 
		<link rel='stylesheet' type='text/css' href='../css/main_header.css'>
	<? } ?>
	<link rel="stylesheet" href="../css/search.css" type="text/css">
	<link rel="stylesheet" href="../css/about.css" type="text/css">
	<link rel="stylesheet" href="../css/material.css" type="text/css">
	<link rel="stylesheet" href="../css/photoview.css" type="text/css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="../js/link.js"></script>
	<script language="JavaScript" type="text/javascript" src="../js/flashWrite.js"></script>
	<!-- <script language="JavaScript" type="text/javascript" src="../js/openlayer.js"></script> -->
	<!-- <script language="JavaScript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> -->
	<script language="JavaScript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="http://code.jquery.com/jquery-3.4.1.min.js"></script>  
	<script language="JavaScript" type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script language="JavaScript" type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
	<script language="JavaScript" type="text/javascript" src="../js/slider3.js"></script>
	<script type="text/javascript" src="<?=$PATH_INFO?>/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?=$PATH_INFO?>/js/head.js"></script>
<script src="../js/search.js"></script>
</head>

<body>

<div id="search-wrap" class="search-wrap invisible">
	<div class="search-wrap-cover"></div>
	<div class="search-content">
		<div class="search-area">
			<div class="search-box">
				<form action="/search/search.php" method="get">
					<input id="search-input" class="search-input" type="text" name="query" placeholder="Search..." required/>
					<button class="search-submit" type="submit">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" fill="#072a40"
							width="25px" height="25px" viewBox="0 0 17 17" enable-background="new 0 0 17 17" xml:space="preserve">
							<g>
								<path d="M15.422,16.707c-0.341,0-0.673-0.141-0.904-0.381l-3.444-3.434c-1.174,0.813-2.58,1.245-4.006,1.245
									C3.163,14.137,0,10.974,0,7.068S3.163,0,7.068,0s7.068,3.163,7.068,7.068c0,1.426-0.432,2.832-1.245,4.006l3.444,3.444
									c0.231,0.231,0.372,0.563,0.372,0.904C16.707,16.125,16.125,16.707,15.422,16.707z M7.068,2.57c-2.48,0-4.498,2.018-4.498,4.498
									s2.018,4.498,4.498,4.498s4.498-2.018,4.498-4.498S9.548,2.57,7.068,2.57z"/>
							</g>
						</svg>
					</button>
				</form>
			</div>
		</div>
	</div>
	<a href="javascript:close_search()" class="search-wrap-close">
		<div class="search-wrap-close-button">
			<div id="nav-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</a>
</div>
<div class="shade"></div>
<div class="sidebar">
	<table class="sidebar-wrap">
		<tbody class="sidebar-content">
			<tr class="sidebar-header">
				<td class="sidebar-button">
					<div class="hamburger" id="hamburger-11">
						<span class="line"></span>
						<span class="line"></span>
						<span class="line"></span>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<table width="100%">
						<tbody>
							<tr class="sidebar-intro">
								<td class="sidebar-content">
									<h1>Introduce.</h1>
									<img src="../img/logo/logo_8.svg"/>
								</td>
							</tr>
							<tr class="sidebar-nav">
								<td class="sidebar-nav-wrap">
									<ul class="sidebar-nav-content">
										<li class="sidebar-nav-element">
											<div class="sidebar-nav-cover"></div>
											<a href="javascript:go_09();">About</a>
										</li>
										<li class="sidebar-nav-element">
											<div class="sidebar-nav-cover"></div>
											<a href="javascript:go_09_01();">Portfolio</a>
										</li>
										<li class="sidebar-nav-element">
											<div class="sidebar-nav-cover"></div>
											<a href="javascript:go_10();">Product</a>
										</li>
										<li class="sidebar-nav-element">
											<div class="sidebar-nav-cover"></div>
											<a target="_blank" href="https://www.vittz.co.kr/shop/page.html?id=48">Shop</a>
										</li>
										<li class="sidebar-nav-element">
											<div class="sidebar-nav-cover"></div>
											<a href="javascript:go_09_02();">Q & A</a>
										</li>
										<li class="sidebar-nav-element">
											<form class="sidebar-nav-search" action="/search/search.php" method="get">
												<input id="sidebar-search-input" class="sidebar-search-input" type="text" name="query" placeholder="Search..." required/>
												<button class="sidebar-search-submit" type="submit">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" fill="#ffffff"
														width="20px" height="20px" viewBox="0 0 17 17" enable-background="new 0 0 17 17" xml:space="preserve">
														<g>
															<path d="M15.422,16.707c-0.341,0-0.673-0.141-0.904-0.381l-3.444-3.434c-1.174,0.813-2.58,1.245-4.006,1.245
																C3.163,14.137,0,10.974,0,7.068S3.163,0,7.068,0s7.068,3.163,7.068,7.068c0,1.426-0.432,2.832-1.245,4.006l3.444,3.444
																c0.231,0.231,0.372,0.563,0.372,0.904C16.707,16.125,16.125,16.707,15.422,16.707z M7.068,2.57c-2.48,0-4.498,2.018-4.498,4.498
																s2.018,4.498,4.498,4.498s4.498-2.018,4.498-4.498S9.548,2.57,7.068,2.57z"/>
														</g>
													</svg>
												</button>
											</form>
										</li>
									</ul>
								</td>
							</tr>
							<tr class="sidebar-contact">
								<td class="sidebar-content">
									<h1>Contact.</h1>
									<div class="sidebar-contact-address">경기도 남양주시 식송1로 33-1, 1층 101호(별내동)</div>
									<div class="sidebar-contact-tel">TEL. 070-7844-1701~2</div>
									<div class="sidebar-contact-fax">FAX. 031-527-1703</div>
									<div class="sidebar-contact-email">E-mail. the_f10@naver.com</div>
								</td>
							</tr>
						</tbody>
					</table> 
				</td>
			</tr>
		</tbody>
	</table>
</div>

<table class="header" width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td align="center">
	<table class="header-wrap" width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="middle" class="gnb-bg01">
				<a href="javascript:go_main()">					
					<img class="header-logo" src="../img/header/logo.svg" alt="logo">
				</a>
			</td>
		  	<td align="right" valign="middle" class="gnb-bg01">
				<table class="header-nav" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td style="padding:0 50px 0 0"><a class="header-nav-element" href="javascript:go_09();">About</a></td>
						<td style="padding:0 50px 0 0"><a class="header-nav-element" href="javascript:go_09_01();">Portfolio</a></td>
						<td style="padding:0 50px 0 0"><a class="header-nav-element" href="javascript:go_10();">Product</a></td>
						<td style="padding:0 50px 0 0"><a class="header-nav-element" target="_blank" href="https://www.vittz.co.kr/shop/page.html?id=48">Shop</a></td>
						<td style="padding:0 50px 0 0"><a class="header-nav-element" href="javascript:go_09_02();">Q & A</a></td>
						<td style="padding:0 130px 0 0">
							<a class="header-nav-element" href="javascript:open_search()">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" fill="#072a40"
								width="17px" height="17px" viewBox="0 0 17 17" enable-background="new 0 0 17 17" xml:space="preserve">
								<g>
									<path d="M15.422,16.707c-0.341,0-0.673-0.141-0.904-0.381l-3.444-3.434c-1.174,0.813-2.58,1.245-4.006,1.245
										C3.163,14.137,0,10.974,0,7.068S3.163,0,7.068,0s7.068,3.163,7.068,7.068c0,1.426-0.432,2.832-1.245,4.006l3.444,3.444
										c0.231,0.231,0.372,0.563,0.372,0.904C16.707,16.125,16.125,16.707,15.422,16.707z M7.068,2.57c-2.48,0-4.498,2.018-4.498,4.498
										s2.018,4.498,4.498,4.498s4.498-2.018,4.498-4.498S9.548,2.57,7.068,2.57z"/>
								</g>
							</svg>
							</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
  </td>
 </tr>
</table>
<div class="header-area"></div>