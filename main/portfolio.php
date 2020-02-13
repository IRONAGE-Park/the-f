<?php include "../INC/header.php"; ?>
<?
########## �Խ��Ǽ������� #########
if (!$bmain) $bmain="list";
include "../admin/conf/conf_post.php";

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<!--contents-->
					<td valign="top" class="content">
						<table width="80%" align="center" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" class="border-n">
									<span class="list_tit">
										<a class="product_menu" href="./portfolio.php">Portfolio</a>
									</span>
								</td>
							</tr>
						</table>
						<?
						include "./photo${bmain}.php";
						?>
					</td>
					<!--//contents-->
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php include "../INC/footer.php"; ?>