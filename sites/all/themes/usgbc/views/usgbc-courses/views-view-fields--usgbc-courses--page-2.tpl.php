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
<?php $es_node_id = variable_get('education_subscription',"");
	if($es_node_id != $fields['nid']->raw){
		$blank_field = '<div class="field-content">empty</div>'?>
	
	    <div style="text-align:center">
			<?php if($fields['field_usgbc_course_feature_image_fid']->content != ""){?>
	    		<?php print $fields['field_usgbc_course_feature_image_fid']->content;?>
		</div>
	    <h2 class="condensed-type">
	      <?php print $fields['field_usgbc_course_name_value']->content;?>
	    </h2><p class="small"><?php print $fields['field_usgbc_course_summary_value']->content;?></p>
	          <?php }else{?>
	    <h2 class="large condensed-type" >
	      <?php print $fields['field_usgbc_course_name_value']->content;?>
	    </h2>
	    <?php }?>
		<div class="bg-entry-footer">
			<div class="small-rating-ratio">
		        <div class="dislike-count">
		            <strong>Dislikes</strong>
		            <span><?php print (int)($fields['value_1']->content)*-1; ?></span>
		        </div>
		        <div class="like-count">
		            <strong>Likes</strong>
		            <span><?php print ($fields['value']->content); ?></span>
		        </div>
		    </div>
		</div>
		<?php if($fields['field_usgbc_course_unavailable_value']->content != ""){?>
			<div class="unavailable">
				<p><?php print $fields['field_usgbc_course_unavailable_value']->content; ?></p>
				<span class="go">&rarr;</span>
			</div>
		<?}?>	
		
		<div class="bg-overlay">
			<p><?php print $fields['field_usgbc_course_description_value']->content; ?></p>
			<span class="go">&rarr;</span>
		</div>
<?php } ?>