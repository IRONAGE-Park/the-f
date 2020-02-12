<?php include "../INC/header.php"; ?>
<?
if (!$bmain) $bmain="list";
$code = 8;
include "../admin/conf/conf_main.php";
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td align="center" valign="top">
	<table width="80%" border="0" cellspacing="0" cellpadding="0">
   		<tr>
   			<!--contents-->
			<td valign="top" class="content">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center"><img class="qna-image" src="../img/visual/visual0<?=$code?>.jpg"></td>
					</tr>
					<script>
						function plSelect(index) {
							var plNavElements = document.getElementsByClassName('product-list-nav-element');
							for (let i = 0; i < plNavElements.length; i++) {
								plNavElements[i].classList.remove('selected');
							}
							plNavElements[index].classList.add('selected');

							var plElements = document.getElementsByClassName('PL');
							var setStyle = 'none';
							if (!index) setStyle = 'table-row';
							for (let i = 0; i < plElements.length; i++) {
								plElements[i].style.display = setStyle;
							}
							if (index) {
								var plElement = document.getElementsByClassName('product-list-'+index);
								for (let i = 0; i < plElement.length; i++) {
									plElement[i].style.display = 'table-row';
								}
							}
						}
					</script>
					<tr>
						<td align="center">
							<table border="0" cellspacing="0" cellpadding="0" class="product-list-nav">
								<tr id="productListNav">
									<td width="25%" class="product-list-nav-element selected"><a href="javascript:plSelect(0);">전체</a></td>
									<td width="25%" class="product-list-nav-element"><a href="javascript:plSelect(1);"><?=$ARR_BOARD_TYPE[1]?></a></td>
									<td width="25%" class="product-list-nav-element"><a href="javascript:plSelect(2);"><?=$ARR_BOARD_TYPE[2]?></a></td>
									<td width="25%" class="product-list-nav-element"><a href="javascript:plSelect(3);"><?=$ARR_BOARD_TYPE[3]?></a></td>	
								</tr>
							</table>
						</td>
					</tr>
					<?
						$td = 0;
						$mode = 1;
					?>
					<tr class="PL product-list-<?=$mode?>">
						<td class="border-n"><span class="material-title"><?=$ARR_BOARD_TYPE[$mode]?></span></td>
					</tr>
					<tr class="PL product-list-<?=$mode?>">
						<td class="border-n">
						<?include "include_pro.php";?>	
						</td>
					</tr>
					<?
						$td = 0;
						$mode = 2;
					?>
					<tr class="PL product-list-<?=$mode?>">
						<td class="border-n"><span class="material-title"><?=$ARR_BOARD_TYPE[$mode]?></span></td>
					</tr>
					<tr class="PL product-list-<?=$mode?>">
						<td class="border-n">
						<?include "include_pro.php";?>	
						</td>
					</tr>
					<?
						$td = 0;
						$mode = 3;
					?>
					<tr class="PL product-list-<?=$mode?>">
						<td class="border-n"><span class="material-title"><?=$ARR_BOARD_TYPE[$mode]?></span></td>
					</tr>
					<tr class="PL product-list-<?=$mode?>">
						<td class="border-n">
						<?include "include_pro.php";?>	
						</td>
					</tr>
				</table>
			</td>
 		</tr>
	</table>
    </tr>
</table>
<?php include "../INC/footer.php"; ?>