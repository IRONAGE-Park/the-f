<?php include "../INC/header.php"; ?>
<?
########## �Խ��Ǽ������� #########
if (!$bmain) $bmain="list";
include "../admin/conf/conf_post1.php";

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td align="center" valign="top">
			<table style="max-width: 1300px;" width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<!--contents-->
					<td valign="top" class="content">
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