<?php if (!empty($fields['uid'])):?>

<div class="section">

<?php if($fields['field_per_profileimg_fid']):?>
	<?php print $fields['field_per_profileimg_fid']->content;?>
<?php else:?> 
    <img width="40" class="left" src="<?php print '/sites/all/themes/usgbc/lib/img/usgbc-seal.gif';?>" alt>
<?php endif;?>

     <h6 class="sub-compact">
   <a href="<?php print $fields['path']->content;?>">
          <?php print $fields['field_per_fname_value']->raw;?>
          <?php print $fields['field_per_lname_value']->raw;?>
          </a> 
    </h6>

    <h6>Instructor</h6>


</div>
<?php endif;?>
