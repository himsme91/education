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
//dsm($fields);

if (arg(0) == 'node' && is_numeric(arg(1))) $nodeid = arg(1);
//dsm($nodeid);
dsm($fields);

?>

<?php if($fields['field_res_profileimage_fid']->content){ ?>
	<p><?php print $fields['field_res_profileimage_fid']->content;?></p>
<?php } else {
	$res_type = strtolower($fields['field_res_type_value']->content);
	print "<p><img src='/sites/all/themes/usgbc/lib/img/resource-icons/placeholder-document.gif'></img></p>";
}?>


<?php
	if(!$fields['field_all_custom_title_value']->content
	|| empty($fields['field_all_custom_title_value']->raw) 
	|| $fields['field_all_custom_title_value']->content==""){
		$fields['field_all_custom_title_value']->content = $fields['title']->content;
	}
?>
 <h4><a class="block-link-src" href="<?php print $fields['path']->content;?>"><?php print $fields['field_all_custom_title_value']->content;?></a></h4>
 <?php 
  if(($fields['field_res_type_value']->content) == "Book")
 {
 	if(!empty($fields['field_res_type_value']->content))
 	{
 		$filesize = " | " . $fields['field_res_pages_value']->content . " pgs";
 	}
 }
 elseif($fields['field_res_type_value']->content != "Website" || $fields['field_res_type_value']->content != "Video" )
 {
 	
 if (!empty($fields['field_res_file_fid']->content))
 {
 	//dsm($fields['field_res_file_fid']->content);
 	//$filesize = " | " . filesize($fields['field_res_file_fid']->content);

 }
 }
 ?>
 
 <?php 
 $prefix = '';
 if (!empty($fields['field_res_id_value']->content)){
 	$prefix =  $fields['field_res_id_value']->content . " | " ;
 }elseif (!empty($fields['field_res_edition_value']->content)){
 	$prefix =  $fields['field_res_edition_value']->content . " | " ;
 }
  ?>
 
 
<h5><em><?php print $prefix; ?><?php print $fields['field_res_type_value']->content;?><?php print $filesize;?></em></h5>


<?php if($fields['sell_price']->content):?>
<p class="price"><?php print uc_currency_format($fields['sell_price']->content);?></p>
<?php endif;?>

<?php if (($fields['field_res_memberonly_value']->content) == "Yes" ) :?> 
<span class="member-only">Members Only</span>  
<?php endif?>                   

                      

