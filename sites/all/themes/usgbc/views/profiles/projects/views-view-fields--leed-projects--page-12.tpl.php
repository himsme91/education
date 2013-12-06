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

  switch (str_replace ('&amp;', 'AND', $fields['field_pc_credit_category_value']->content)) {
    case 'Sustainable sites':
      $class .= 'points ss';
      break;
    case 'Water efficiency':
      $class .= 'points we';
      break;
    case 'Energy AND atmosphere':
      $class .= 'points ea';
      break;
    case 'Material AND resources':
      $class .= 'points mr';
      break;
    case 'Indoor environmental quality':
      $class .= 'points iq';
      break;
    case 'Innovation AND design process':
      $class .= 'points id';
      break;
    case 'Regional Priority':
      $class .= 'points rp';
      break;
    case 'Location AND linkages':
      $class .= 'points ll';
      break;
    case 'Awareness AND education':
      $class .= 'points ae';
      break;
    default:
      $class = "points";
  }
?>
<dl class="<?php print $class; ?>">
  <dt><?php print $fields['field_pc_credit_category_value']->content;?></dt>
  <dd><?php print $fields['field_pc_points_achieved_value']->content;?>/<?php $viewname = 'leed_projects';
    $args = array();
    //$args[0]='Announcements';
    $args [0] = str_replace ('&amp;', '&', $fields['field_pc_rating_system_value']->content);
    $args [1] = $fields['field_pc_rating_sys_version_value']->content;
    $args [2] = str_replace ('&amp;', '&', $fields['field_pc_credit_category_value']->content);
    $display_id = 'page_13'; // or any other display
    $view = views_get_view ($viewname);
    $view->set_display ($display_id);
    $view->set_arguments ($args);
    print $view->preview ();?></dd>
</dl>
