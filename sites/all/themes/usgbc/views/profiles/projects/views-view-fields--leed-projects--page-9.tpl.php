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
?>
<script type="text/javascript">
  $(document).ready(function () {
    $(".sh-content").hide();
    $('.sh-trigger').click(function (e) {
      e.preventDefault();
      var parentDiv = $(this).parents('.criteria').find('.sh-content');
      parentDiv.css("height", parentDiv.height() + "px");
      parentDiv.slideToggle(600);
      $(this).parents('.criteria-head').toggleClass("expanded")
    });
  });
</script>



<div id="mainCol">
  <div id="scorecard">
    <div class="sc-header">
      <h2>LEED Scorecard</h2>

      <p class="total">** Total Possible Points <span class="total-num"><?php
        $viewname = 'leed_projects';
        $args = array();
        $args [0] = str_replace ('&amp;', '&', $fields['field_prjt_rating_system_value']->content);
        $args [1] = $fields['field_prjt_rating_sys_version_value']->content;

        $display_id = 'page_15'; // or any other display
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?></span></p>
    </div>

    <?php
    $viewname = 'leed_projects';
    $args = array();
    //$args[0]='Announcements';
    $args[0] = $fields['field_prjt_id_value']->content;
    $display_id = 'page_10'; // or any other display
    $view = views_get_view ($viewname);
    $view->set_display ($display_id);
    $view->set_arguments ($args);
    print $view->preview ();
    ?>

  </div>
</div>

<div id="sideCol">
  <div class="sbx">
    <?php
    $viewname = 'servicelinks';
    $display_id = 'page_2';
    $view = views_get_view ($viewname);
    $view->set_display ($display_id);
    print $view->preview ();
    ?>
  </div>
  <div class="button-group">
    <a class="jumbo-button-dark" href="#">Download Scorecard</a>
  </div>

  <div id="mini-scorecard">
    <h2>LEED Facts</h2>

    <p class="cert"><?php print $fields['field_prjt_rating_system_value']->content; ?></p>

    <p class="recert">Recertification
      awarded <?php print $fields['field_prjt_certification_date_value']->content; ?></p>
    <dl class="points total">
      <dt><?php print $fields['field_prjt_certification_level_value']->content; ?></dt>
      <dd><?php
        $viewname = 'leed_projects';
        $args = array();
        //$args[0]='Announcements';
        $args [0] = $fields['nid']->content;
        $display_id = 'page_14'; // or any other display
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?></dd>
    </dl>

    <?php
    $viewname = 'leed_projects';
    $args = array();
    //$args[0]='Announcements';
    $args [0] = $fields['nid']->content;
    $display_id = 'page_12'; // or any other display
    $view = views_get_view ($viewname);
    $view->set_display ($display_id);
    $view->set_arguments ($args);
    print $view->preview ();
    ?>
    <p class="footnote">Points possible = <?php
      $viewname = 'leed_projects';
      $args = array();
      $args [0] = str_replace ('&amp;', '&', $fields['field_prjt_rating_system_value']->content);
      $args [1] = $fields['field_prjt_rating_sys_version_value']->content;

      $display_id = 'page_15'; // or any other display
      $view = views_get_view ($viewname);
      $view->set_display ($display_id);
      $view->set_arguments ($args);
      print $view->preview ();
      ?> points</p>
  </div>
</div>
