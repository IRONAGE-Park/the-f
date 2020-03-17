<?php include "../INC/header.php"; ?>
<?
	#### 레이어 팝업 창 ##########
	//$pop_wsql = " and mode='1'";
	include "../include_popup.php";

	$query = "SELECT * FROM tb_banner ORDER BY reg_date DESC";
    $result = $db->fetch_array( $query );
    $rcount = count($result);

    $m_query = "SELECT * FROM tb_mbanner ORDER BY reg_date DESC";
    $m_result = $db->fetch_array( $m_query );
    $m_rcount = count($m_result);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td>
	<div class="visual-wrap">
		<? for($i = 1; $i <= $rcount; $i++) { 
			$board_img = "../upload/banner/".$result[$i - 1]['fileadd_name'];
		?>
		<div class=<?="visual-posi"?>>
			<img src=<?=$board_img?> alt="">
		</div>
		<? } ?>
	</div>
	<div class="mvisual-wrap">
		<? for($i = 1; $i <= $m_rcount; $i++) { 
			$board_img = "../upload/mbanner/".$m_result[$i - 1]['fileadd_name'];
		?>
		<div class=<?="mvisual-posi"?>>
			<img src=<?=$board_img?> alt="">
		</div>
		<? } ?>
	</div>
  </td>
 </tr>

</table>
<?php include "../INC/footer.php"; ?>
