<?php //dsm($fields); ?>

<?php $workship_id=$_GET['workshop_nid'];?>

<?php //print $fields['field_wrksp_id_value']->content;?>

<option value="<?php print $fields['nid']->content;?>" 
<?php if($workship_id==$fields['nid']->content){
    print ' selected ';
}?>
>    

<?php print $fields['field_wrksp_startdate_value']->content;?>    
</option>  