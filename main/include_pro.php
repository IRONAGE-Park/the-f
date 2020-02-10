<?php
$query = "SELECT * FROM  $tablename  WHERE 1 and viewtype!='N' $w_sql and mode='$mode' ".$where_add." ORDER BY ".$ORDER_BY." reg_date DESC";
$result = $db->fetch_array( $query );
$rcount = count($result) ;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
        <?
        for ( $i=0 ; $i<$rcount ; $i++ ) {		
        $my_fileadd_name = $result[$i]['fileadd_name'];
        ?>
            <div style="display:inline-block" align="center">
                <div>
                    <a href="<?=$link_page?>">
                    <? 
                    if($my_fileadd_name) {
                        echo "<img src='$HOME_PATH/$tablefile/$my_fileadd_name' border=0 height=120 width='120'>";
                    }
                    ?>
                    </a>
                </div>
                <div style="padding:5px 0 20px 0" align="center">
                    <a href="<?=$link_page?>"><?=$common->cut_string($result[$i]['title'],43)?></a>
                </div> 
            </div>
        <?
        }
        ?>
        </td>
    </tr>
</table>
</td>
</tr>