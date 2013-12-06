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
//dsm($fields);
?> 
<style>
.mem-banner .meta p{
	display: block;
	font-family: proxima-nova-1, proxima-nova-2, "Helvetica neue", Arial;
	font-weight: 600;
	color: #777;
	font-size:12px;
	text-shadow: 0 1px 0 white;
}
</style>
<li>
	<div class="mem-banner block-link" style="margin-left: 0;">
		<div class="left" style="width:60%;">
	 		<img class="flag" src="<?php print $fields['field_image_cache_fid']->content;?>" alt="<?php echo $fields['field_specialty_value']->content;?>"/>   
	 		<span class="title block-link-src"><a href="/exam-registration/exam?exam=<?php print $fields['nid']->content;?>"><?php print $fields['field_specialty_value']->content;?></a></span> 
			<span class="meta"><?php print $fields['description']->content;?></span>	
 			<span class="meta">
				<?php 
					if($fields['field_specialty_value']->content=='LEED Green Associate'){
						print "Core exam";
					}else if($fields['field_specialty_value']->content=='Green Rater') {
						print "LEED for Homes Green Rater";
					} else {
						if($fields['field_exam_composite_value']->content == 1){
							print "Combined core & specialty exam";
						} else {
							print "Specialty exam";
						}
					}
					print_r($regular_price);
					$regular_price = usgbc_get_usgbc_price_json($fields['field_usgbc_price_value']->content, 'non-member');
					$user_price    = usgbc_get_usgbc_price_json($fields['field_usgbc_price_value']->content);
				?>
			</span>
		</div>
		<div class="right">
			<?php if($user_price == $regular_price) $user_price = $regular_price; ?>
 				<strong><span>$<?php print $user_price;?></span>
				</strong>
		</div>
	
	</div>
</li>