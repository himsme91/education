<?php
// $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
/**
 * @file views-view-fields.tpl.php
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->separator: an optional separator that may appear before a field.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php $blank_field = '<div class="field-content">empty</div>'?>
<?php 
//$node = node_load($row->nid);
//dsm($fields); 

if ($fields['field_res_memberonly_value']->content == 'No'){
	$print = 'Public';
}else{
	$print = 'Member only';
}

                                                                                                                                                                                                                   
?>


<div class="contribute-info">

	<div class="<?php print strtolower(rtrim($fields['field_res_type_value']->content,"s"));?> resource-thumb"></div>
	<h2 class="sub-compact"><?php print $fields['title']->content;?></h2>
	<p class="padded-left sub-compact note"><em><?php print $print;?></em></p>
</div>
<div class="contribute-options button-group">
	<p class="sub-text left">Published <?php print $fields['stamp']->content;?> - <a href="mailto:<?php print $fields['mail']->raw;?>">Email editor</a></p>
		
</div>							

