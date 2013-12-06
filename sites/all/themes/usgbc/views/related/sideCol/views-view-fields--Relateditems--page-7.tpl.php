<div class="section">
	<?php if($fields['field_res_profileimage_fid']->content){ ?>
		<img class="left resimg" src="/<?php print $fields['field_res_profileimage_fid']->content;?>" alt="">
	<?php } else {
		$res_type = strtolower($fields['field_res_type_value']->content);
		print "<img width='70' class='left' src='/sites/all/themes/usgbc/lib/img/resource-icons/placeholder-$res_type.gif'></img>";
	}?>
	<h4 class="sub-compact"><?php print $fields['title']->content;?></h4>
	<p class="small" style="clear: both;"><?php print $fields['field_all_description_short_value']->content;?></p>
</div>