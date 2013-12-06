<?php
  // $Id: views-view.tpl.php,v 1.13.2.2 2010/03/25 20:25:28 merlinofchaos Exp $
  /**
   * @file views-view.tpl.php
   * Main view template
   *
   * Variables available:
   * - $classes_array: An array of classes determined in
   *   template_preprocess_views_view(). Default classes are:
   *     .view
   *     .view-[css_name]
   *     .view-id-[view_name]
   *     .view-display-id-[display_name]
   *     .view-dom-id-[dom_id]
   * - $classes: A string version of $classes_array for use in the class attribute
   * - $css_name: A css-safe version of the view name.
   * - $css_class: The user-specified classes names, if any
   * - $header: The view header
   * - $footer: The view footer
   * - $rows: The results of the view query, if any
   * - $empty: The empty text to display if the view is empty
   * - $pager: The pager next/prev links to display, if any
   * - $exposed: Exposed widget form/info to display
   * - $feed_icon: Feed icon to display, if any
   * - $more: A link to view more, if any
   * - $admin_links: A rendered list of administrative links
   * - $admin_links_raw: A list of administrative links suitable for theme('links')
   *
   * @ingroup views_templates
   */
?>

<?php
  drupal_add_js (drupal_get_path ('theme', 'usgbc') . '/lib/js/jquery.submitsearch.js');

?>

<div class="block" title="Browse Courses">
  <h1>Near you</h1>

  <p>Search our catalog of <?php echo '<strong> ' . number_format ($view->total_rows) . ' </strong>';?> instructor-led
    sessions, conferences and tours. Benefit from the insight of the foremost green building leaders as they share their
    knowledge about the latest and most relevant industry trends and practices.</p>

  <div class="button-group">
    <input type="text" class="field left lg padd-right" value="Washington DC" id="searchinput">
    <a class="button block-link-src" id="browseCourse" href="/courses/in-person">Browse Courses</a>
  </div>
</div>
<h5>Upcoming courses</h5>

<?php if (!empty($title)): ?>
<h3><?php print $title; ?></h3>
<?php endif; ?>

<ul class="linelist">
  <?php foreach ($rows as $id => $row): ?>
  <?php print $row; ?>




  <?php endforeach; ?>
</ul>


<!--
<div class="<?php print $classes; ?>">
  <?php if ($admin_links): ?>
    <div class="views-admin-links views-hide">
      <?php print $admin_links; ?>
    </div>
  <?php endif; ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>
<div class="search-report aside">
<span>
    <?php echo '<strong>' . $view->total_rows . ' </strong>';?>
results in
<strong>All</strong>
.
</span>
</div>
  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

<div class="clear-block"></div>

  <?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div>

  -->

<?php /* class view */ ?>

