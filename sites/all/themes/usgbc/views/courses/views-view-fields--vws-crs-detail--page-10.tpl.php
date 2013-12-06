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
<?php
	if($_REQUEST['workshop_nid']){
		$workshop_id = $_REQUEST['workshop_nid'];
		$workshop_node = node_load($workshop_id);
		$parent_course = node_load($workshop_node->field_all_reference_courses[0][nid]);
		$info_url = $parent_course->field_all_url_website[0][url];
		if($workshop_node->field_wrksp_reg_url[0][value]){
			$info_url = $workshop_node->field_wrksp_reg_url[0][value];
		}
	}else {
		$parent_course = node_load($fields['nid']->content);
		$info_url = $parent_course->field_all_url_website[0][url];
		$view = views_get_view('vws_crs_detail');
	    $view->set_arguments(array($fields['nid']->content));
	    $view->set_display('page_6');
	    $view->execute();
	    $workshop_id = $view->result[0]->nid;
	    $workshop_node = node_load($workshop_id);
		if($workshop_node->field_wrksp_reg_url[0][value]){
			$info_url = $workshop_node->field_wrksp_reg_url[0][value];
		}
	}
?>


<?php if($info_url && strstr($info_url, 'usgbc.org') == false && strstr($info_url, 'usgbc.name') == false){ ?>
	<a href="<?php print $info_url;?>" target="_blank" class="jumbo-button-dark">Purchase info</a>
<?php } elseif(strstr($info_url, 'usgbc.org') || strstr($info_url, 'usgbc.name')) {?>
<form name="add_to_cart" action="/course-registration/contact" method="post" >
<a href="" class="jumbo-button-dark" id="btn_register" onclick="document.forms.add_to_cart.submit();return false;">
<?php if(strtolower(taxonomy_get_term($parent_course->field_crs_type[0]['value'])->name) == 'webinar'):?>
Subscribe now
<?php else:?>
Purchase now 
<?php endif;?>
</a>
<input type="hidden" name="workshopSKU" value="<?php print $workshop_id;?>"/>

</form>
<?php }?>
<div class="hidden">
<?php foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

  <<?php print $field->inline_html;?> class="views-field-<?php print $field->class; ?>">
    <?php if ($field->label): ?>
      <label class="views-label-<?php print $field->class; ?>">
        <?php print $field->label; ?>:
      </label>
    <?php endif; ?>
      <?php
      // $field->element_type is either SPAN or DIV depending upon whether or not
      // the field is a 'block' element type or 'inline' element type.
      ?>
      <<?php print $field->element_type; ?> class="field-content"><?php print $field->content; ?></<?php print $field->element_type; ?>>
  </<?php print $field->inline_html;?>>
<?php endforeach; ?>

</div>	