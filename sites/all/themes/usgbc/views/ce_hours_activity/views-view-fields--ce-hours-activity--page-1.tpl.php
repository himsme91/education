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
<?php if($fields['field_ce_approval_status_value']->content == 'Approved'):?>
<td class="col-source" style="color:#11859B;"><strong class="name">
<?php if($fields['field_ce_act_type_value']->content == 'Project experience'):?>
	<?php print $fields['field_all_reference_projects_nid']->content;?>
<?php else:?>
	<?php print $fields['field_ce_course_title_value']->content;?>
<?php endif;?>
</strong> <br><small class="course-id"><?php print $fields['field_ce_act_type_value']->content;?></small>
</td>

<td><?php print $fields['field_ce_hours_reported_value']->content;?></td>

<td>
<?php if(strstr($fields['field_ce_specialty_value']->content,'BD+C')):?>
<span class="leed-certificate-bdc">BD+C</span>
<?php endif;?>
<?php if(strstr($fields['field_ce_specialty_value']->content,'Homes')):?>
<span class="leed-certificate-homes">Homes</span>
<?php endif;?>
<?php if(strstr($fields['field_ce_specialty_value']->content,'ID+C')):?>
<span class="leed-certificate-idc">ID+C</span>
<?php endif;?>
<?php if(strstr($fields['field_ce_specialty_value']->content,'ND')):?>
<span class="leed-certificate-nd">ND</span>
<?php endif;?>
<?php if(strstr($fields['field_ce_specialty_value']->content,'O+M')):?>
<span class="leed-certificate-om">O+M</span>
<?php endif;?>
<?php if(strstr($fields['field_ce_specialty_value']->content,'Green Associate')):?>
<span class="leed-certificate-ga">Green Associate</span>
<?php endif;?>
</td>
<?php endif;?>
