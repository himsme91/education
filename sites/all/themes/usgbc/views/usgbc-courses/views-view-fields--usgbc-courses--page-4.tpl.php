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
<?php $blank_field = '<div class="field-content">empty</div>';?>

    
    <div class="course-holder">
		<div class="course-portlet">
			<div class="course-image">
				<?php //if($fields['field_usgbc_course_feature_image_fid']->content != ""){
    				//print $fields['field_usgbc_course_feature_image_fid']->content;
    			//}else{?>
    				<img src="/misc/webinar.jpg" height="175" width="250"/>
    			<?php // } ?>
			</div>
			<div class="course-link">
				<form name="add_course" action="/node/add/usgbc-course" method="post">
				<input type="hidden" value="Parent" name="course_type"/>
				</form>
				<a class="small-alt-button" href="<?php print $fields['path']->content?>/edit">Manage This Course</a>
			</div>
			<div class="course-title">
				<?php print $fields['title']->content; ?>
			</div>
		</div>
	</div>
