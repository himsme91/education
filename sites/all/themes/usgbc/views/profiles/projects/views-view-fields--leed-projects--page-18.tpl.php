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
<script type="text/javascript">
  $('#sticky').scrollNav();
</script>

<div id="mainCol">
  <?php if (user_access("create project content")): ?>
  <div class="search-report aside">
    <a target="_blank" href="/node/<?php print $fields['nid']->content; ?>/edit">Edit Stories</a>
  </div>
  <?php endif;?>

  <?php print $fields['field_prjt_int_description_value']->content; ?>
</div>

<div id="sideCol">

  <div class="sbx">
    <?php
    $viewname = 'servicelinks';
    $display_id = 'page_2';
    $args[0] = $fields['nid_1']->content;
    $view = views_get_view ($viewname);
    $view->set_display ($display_id);
    $view->set_arguments ($args);
    print $view->preview ();
    ?>
  </div>

  <div id="project-details" class="aside padded project-details">
    <?php
    $viewname = 'leed_projects';
    $display_id = 'page_19';
    $args = array();
    $args[0] = $fields['nid_1']->content;
    $view = views_get_view ($viewname);
    $view->set_display ($display_id);
    $view->set_arguments ($args);
    print $view->preview ();
    ?>
  </div>

  <div id="sticky">
    <a class="top" href="#body-container">Back to top</a>
  </div>

</div>
