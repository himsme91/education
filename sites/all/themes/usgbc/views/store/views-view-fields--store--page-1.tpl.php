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
<?php 

$currenturl = explode("/", strtolower($_SERVER['REQUEST_URI']));

/*
if ($fields['field_pubs_new_flag_value']->content == 'Yes'): ?>
  <img class="new-item" alt="New Item!" src="/sites/all/themes/usgbc/lib/img/new-store-item.png">
<?php endif; 
*/ ?>


<?php print $fields['field_res_profileimage_fid']->content; ?>
<h2><?php print $fields['title']->content;?></h2>
<?php if($fields['field_res_edition_value']->content){ ?>
	<h5><strong><?php print ($fields['field_res_edition_value']->content)?></strong></h5>
<?php }?>


<p class="price">
<?php 

if(in_array('kindle', $currenturl) && $fields['field_kindle_price_value']->content > 0){
	print uc_currency_format($fields['field_kindle_price_value']->content);
}else{
	if($fields['list_price']->content > $fields['sell_price']->content){
?>
		<span  style="text-decoration:line-through ;">
<?php 	print uc_currency_format($fields['list_price']->content);?><br />
		</span>
<?php 
	}?>

<?php print uc_currency_format ($fields['sell_price']->content); //print $fields['field_pubs_bulk_100_plus_price_value']->content;
	
}?>
</p>
