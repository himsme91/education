<?php //dsm($fields);?>
<?php if($fields['nothing']->content == 'taxonomy'):
		$taxonomy = true;
		else :
		$taxonomy = false;
		endif;
?>

<?php if ($taxonomy):?>
<div class="search-result">
	<h4><a href="/help-topic/<?php print str_replace('&','%26',usgbc_dashencode($fields['name_1']->raw));?>"><?php print $fields['name_1']->raw;?></a></h4>
    <p><?php print $fields['description']->raw?></p>
</div>
<?php else:?>
<div class="search-result">
	<h4><?php print $fields['name_1']->raw;?></h4>
    <p><?php print $fields['description']->raw?></p>
</div>
<?php endif;?>