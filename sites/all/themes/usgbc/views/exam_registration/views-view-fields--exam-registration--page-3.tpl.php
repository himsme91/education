<?php
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
global $user;

$u_profile_node = content_profile_load('person',$user->uid);
//dsm($fields);
$exam = node_load($fields['field_leed_exam_nid']->raw);
?>
<div class="ag-item" title="Details">
	<div class="order-history-item-details">
		<h2><?php print date("M d, Y", strtotime($fields['field_date_valid_from_value']->raw));?></h2>
		<dl>
			<dt>Total</dt>
			<dd><?php print $fields['field_exam_price_value']->content;?></dd>
			<dt>Id</dt>
			<dd style="text-transform: capitalize;"><?php print $fields['title']->content;?></dd>
			<dt>Status</dt>
			<dd><?php print $fields['field_exam_status_value']->content;?></dd>
		</dl>
	</div><!-- order-history-item-details -->
	<div class="order-history-item-summary" style="width:360px;">
	<h3><?php if($fields['field_exam_name_value']->content!='') {
				print $fields['field_exam_name_value']->content;
			} else {
				print $fields['field_leed_exam_nid']->content;
			} ?></h3>
	<ul class="linelist">
		<li><strong>Registration valid until:</strong> <?php print $fields['field_date_valid_to_value']->content;?></li>
	<?php if(!empty($fields['field_exam_date_value']->content)):?>
		<li><strong>Exam Date:</strong> <?php print $fields['field_exam_date_value']->content; ?></li>
	<?php endif;?>
	</ul>
	<?php if($fields['field_exam_status_value']->content=='Eligibility Submitted'):?>
	<a class="small-alt-button" style="float:left;" href="<?php echo PrometricWebRegistrationURL;?>?prg=<?php echo PROMETRIC_CLIENT_ID;?>&eligid=<?php echo $fields['title']->content; ?>&exam=<?php echo $exam->field_specialty_exam_id[0]['value']; ?>&lname=<?php echo substr($u_profile_node->field_per_lname[0]['value'],0,4); ?>&st=<?php echo $u_profile_node->locations[0]['province']; ?>&path=schd">Schedule exam with Prometric</a>
	<?php endif;?>
	</div><!-- order-history-item-summary -->
</div>