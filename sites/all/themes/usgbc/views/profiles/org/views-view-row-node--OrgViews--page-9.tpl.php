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
<?php //print_r($fields) ?>
<?php //dsm($fields);?>
<div class="ag-item ag-item-with-visual ag-item-no-footer block-link"  >

<?php if ($fields['field_org_profileimg_fid']->content):
    $imgSrc = $fields['field_org_profileimg_fid']->content;
   elseif ($fields['field_chp_profileimg_fid']->content):
    $imgSrc = $fields['field_chp_profileimg_fid']->content;
   endif; ?>
<?php //print $imgSrc;?>
	<img class="ag-item-visual" width="60" height="60" border="0" src="<?php print $imgSrc;?>">
	<div class="ag-data">
		<h3 class="ag-item-title">
		<a class="block-link-src" href="<?php print $fields['path']->content;?>"><?php print $fields['title']->content;?></a>
		</h3>
		<span class="ag-item-detail">
		<?php //print $fields['type']->content;?>
		<strong><?php print $fields['city']->content;?>, <?php print $fields['province']->content;?></strong>
		</span>
	</div>
	<div class="ag-item-footer empty"></div>
</div>	
