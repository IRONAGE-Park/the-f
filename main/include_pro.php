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
                    <? 
                    if($my_fileadd_name) {
                        echo "<img class='material-image' src='$HOME_PATH/$tablefile/$my_fileadd_name' border=0>";
                    }
                    ?>
                </div>
                <div style="padding:5px 0 20px 0" align="center">
                    <?=$common->cut_string($result[$i]['title'],43)?>
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