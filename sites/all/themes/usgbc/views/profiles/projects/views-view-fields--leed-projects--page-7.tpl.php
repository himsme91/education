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
?>

<?php if ($fields['field_prjt_certification_level_value']->content == "Platinum"): ?>
<p class="cert-flag plat-cert-flag">&nbsp;</p>
<?php endif; ?>
<?php if ($fields['field_prjt_certification_level_value']->content == "Gold"): ?>
<p class="cert-flag gold-cert-flag">&nbsp;</p>
<?php endif; ?>
<?php if ($fields['field_prjt_certification_level_value']->content == "Silver"): ?>
<p class="cert-flag sil-cert-flag">&nbsp;</p>
<?php endif; ?>
<?php if ($fields['field_prjt_certification_level_value']->content == "Certified"): ?>
<p class="cert-flag cert-cert-flag">&nbsp;</p>
<?php endif; ?>

<?php print $fields['field_prjt_profile_image_fid']->content; ?>

<span class="system-version"><?php print $fields['field_prjt_rating_system_value']->content; ?> 
	<?php print $fields['field_prjt_rating_system_version_value']->content; ?></span>
<h4><?php print $fields['title']->content;?></h4>

<h5><em><?php print $fields['city']->content;?>, <?php print $fields['province']->content;?></em></h5>
