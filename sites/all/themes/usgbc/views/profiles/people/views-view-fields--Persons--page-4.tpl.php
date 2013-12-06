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
<?php //dsm($row);?>
<div class="ag-item ag-item-with-visual block-link"  title="<?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?>">
  <?php print $fields['field_per_profileimg_fid']->content;?>
	<div class="ag-data left">
<ul class="ag-item-credentials">
<!-- 	<li class="documents hoverTip">
	<span>
	<span>4</span>
	</span>
	<div class="tip">Tim Adkinson wrote 4 articles in the last 12 months</div>
	</li>
	<li class="cert-ap hoverTip">
	certification
	<div class="tip">Tim Adkinson is a LEED Accredited Professional with Building Design &amp; Construction Specialty (LEED AP BD+C)</div>
</li>-->
</ul>
<h3 class="ag-item-title">
<a class="block-link-src" href="<?php print $fields['path']->content;?> "><?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?></a>
</h3>
<span class="ag-item-detail">
<strong><?php print $fields['field_per_job_title_value']->content;?></strong>
</span>
<span class="ag-item-detail"><?php print $fields['field_related_org_nid']->content;?></span>
</div>
<div class="ag-item-footer"><?php
	print preg_replace('/<\/div><div[^>]+>/i', ', ', $fields['field_per_associations_value']->content);
?>
</div>
</div>
