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
      $criteria_class .= 'criteria ss';
      $icon_img = '<img alt="Sustainable Sites" src="/sites/all/themes/usgbc/lib/img/leed-icons/ss-border.png">';
      break;
    case 'Water efficiency':
      $criteria_class .= 'criteria we';
      $icon_img = '<img alt="Water Efficiency" src="/sites/all/themes/usgbc/lib/img/leed-icons/we-border.png">';
      break;
    case 'Energy AND atmosphere':
      $criteria_class .= 'criteria ea';
      $icon_img = '<img alt="Energy and Atmosphere" src="/sites/all/themes/usgbc/lib/img/leed-icons/ea-border.png">';
      break;
    case 'Material AND resources':
      $criteria_class .= 'criteria mr';
      $icon_img = '<img alt="Materials and Resources" src="/sites/all/themes/usgbc/lib/img/leed-icons/mr-border.png">';
      break;
    case 'Indoor environmental quality':
      $criteria_class .= 'criteria iq';
      $icon_img = '<img alt="Indoor Environmental Quality" src="/sites/all/themes/usgbc/lib/img/leed-icons/iq-border.png">';
      break;
    case 'Innovation AND design process':
      $criteria_class .= 'criteria id';
      $icon_img = '<img alt="Innovation and Design Process" src="/sites/all/themes/usgbc/lib/img/leed-icons/id-border.png">';
      break;
    case 'Regional Priority':
      $criteria_class .= 'criteria rp';
      $icon_img = '<img alt="Regional Priority" src="/sites/all/themes/usgbc/lib/img/leed-icons/rp-border.png">';
      break;
    case 'Location AND linkages':
      $criteria_class .= 'criteria ll';
      $icon_img = '<img src="/sites/all/themes/usgbc/lib/img/leed-icons/ll-border.png" alt="Locations & Linkages"/>';
      break;
    case 'Awareness AND education':
      $criteria_class .= 'criteria ae';
      $icon_img = '<img src="/sites/all/themes/usgbc/lib/img/leed-icons/ae-border.png" alt="Awareness & Education"/>';
      break;
    default:
      $criteria_class = "criteria";
      $icon_img = '';
      break;
  }
?>
<div class="<?php print $criteria_class; ?>">
  <div class="criteria-head">
    <a class="sh-trigger" href="">
      <?php print str_replace ('&amp;', 'AND', $fields['field_pc_credit_category_value']->content); ?>
      <span class="criteria-score">
		<?php print $fields['field_pc_points_achieved_value']->content;?> of
        <?php
        $viewname = 'leed_projects';
        $args = array();
        $args [0] = str_replace ('&amp;', '&', $fields['field_pc_rating_system_value']->content);
        $args [1] = $fields['field_pc_rating_sys_version_value']->content;
        $args [2] = str_replace ('&amp;', '&', $fields['field_pc_credit_category_value']->content);
        $display_id = 'page_13'; // or any other display
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?> </span></a>

    <?php print $icon_img; ?>

  </div>
  <ul class="sh-content plainlist">
    <?php
    $viewname = 'leed_projects';
    $args = array();
    $args [0] = $fields['field_pc_leed_project_id_value']->content;
    $args [1] = str_replace ('&amp;', '&', $fields['field_pc_credit_category_value']->content);
    $display_id = 'page_11'; // or any other display
    $view = views_get_view ($viewname);
    $view->set_display ($display_id);
    $view->set_arguments ($args);
    print $view->preview ();
    ?>


  </ul>
</div>
