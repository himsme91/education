<?php $currenturl = explode("?", $_SERVER['REQUEST_URI']);?>
<?php if( strstr($currenturl[1], 'clearsmartf') ):?>
	<?php echo "<form id='smartform' action='".$currenturl[0]."' method='post'>" ?>
<?php else:?>
	<?php echo "<form id='smartform' action='".$_SERVER['REQUEST_URI']."' method='post'>" ?>
<?php endif;?>
<div id="smartfilters" class="uniform-mini">
 	
		<!--<fieldset class="match left">
		<div class="rule"><label><div class="radio active" id="uniform-undefined"><span <?php echo ($field_separator == '' || trim($field_separator) == "AND") ? 'class="checked"' : '';?>><input type="radio" <?php echo ($field_separator == '' || trim($field_separator) == "AND") ? 'checked="checked"' : '';?> name="match" value="all" style="opacity: 0; "></span></div> Match <strong>all</strong> results</label></div>
		<div class="rule"><label><div class="radio" id="uniform-undefined"><span <?php echo (trim($field_separator) == "OR") ? 'class="checked"' : '';?>><input type="radio" <?php echo (trim($field_separator) == "OR") ? 'checked="checked"' : '';?> name="match" value="any" style="opacity: 0; "></span></div> Match <strong>any</strong> results</label></div>
	</fieldset>-->
	<div id="filter-set">
	</div>
	<input type="hidden" id="smartf" name="smartf"></input>
	<input type="hidden" id="smartfiltername" name="smartfiltername"></input>
	<input type="hidden" id="smartfid" name="smartfid"></input>
	<div class="button-group">
		<a href="#" id="smartsubmit" class="small-alt-button right apply" onclick="smart_submit();">Apply</a>
		<?php global $user;
			if($user->uid): ?>
		<a class="small-button right save" href="">Save</a>
		<?php endif;?>
		<?php if ($smartf_name && $user->uid):?>
			<a class="small-warning-button left delete" onclick="saved_search_delete();" href="">Delete</a>
			<span class="small-button-note danger-text left">This will remove '<?php echo $smartf_name;?>' from your saved searches.</span>
		<?php endif;?> 
		<?php global $user;
			if($user->uid): ?>
				<span class="helper" id="savesearch-helper">You can save your search, so that you don&#146;t have to add filters each time you visit. The saved filter will show up in the left side navigation under "Saved searches."<br><a class="hide-trigger" href="#helper">Hide</a><span class="helper-flag right"></span></span>
			<?php endif;?>
		<a class="right" style="margin-right: 5px;padding-top: 4px;" onclick="clear_submit();" href="#">Clear filters</a>
	</div>
</div>