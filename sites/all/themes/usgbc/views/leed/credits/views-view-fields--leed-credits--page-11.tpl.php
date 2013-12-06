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
<li>
	<div class="views-field-field-category-logo-fid">
	    <img width="40" height="40" alt="" src="<?php print file_create_url($credit_icon_path);?>" class="left">	
	</div>
	<h2>

		<?php 
			$node_title = $fields['title']->content;
			print "<a href='/node/$current_nid?return=$link'>$node_title</a>" ?>
	</h2>
	
	<?php $points = '';
	$low = $fields['field_credit_points_possible_low_value']->content;
	$upp = $fields['field_credit_points_possible_upp_value']->content;
	if($fields['field_credit_required_flag_value']->content == "Required"){
		$points = "Required";
	}else if ($low == $upp){
		if (intval($low) > 1){
			$points = $low.' points';
		}else{
			$points = $low.' point';
		}
	}else{
		if (intval($upp) > 1){
			$points = 'Up to '.$upp.' points';
		}else{
			$points = 'Up to '.$upp.' point';
		}
		
	}
	
	?>
	<p class="credit-id"><?php print $fields['field_credit_short_id_value']->content;?> | <?php echo $points;?></p>
</li>