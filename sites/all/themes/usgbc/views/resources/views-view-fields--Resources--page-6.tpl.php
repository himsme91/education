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


<p><?php print $fields['field_res_profileimage_fid']->content;?></p>
 <h4><?php print $fields['title']->content;?></h4>
 <?php 
  if(($fields['field_res_type_value']->content) == "Book")
 {
 	if(!empty($fields['field_res_type_value']->content))
 	{
 		$filesize = " | " . $fields['field_res_noofpage_value']->content . " pgs";
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
 
<h5><em><?php print $fields['field_res_format_value']->content;?><?php print $filesize;?></em></h5> 
<?php if (($fields['field_res_memberonly_value']->content) == "Yes" ) :?> 
<span class="member-only">Members Only</span>  
<?php endif?> 
