<?php
// $Id: views-view.tpl.php 14065 2012-02-10 22:20:23Z pkhanna $
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
//dsm($more);

?>


<?php if ($admin_links): 

?>

<div class="<?php print $classes; ?>">
<?php endif; ?>

  <?php if ($admin_links): ?>
    <div class="views-admin-links views-hide">
      <?php print $admin_links; ?>
    </div>
  <?php endif; ?>
  
  <?php if ($header) print $header; ?>

  <?php if ($exposed) print $exposed; ?>
  <?php if ($attachment_before) print $attachment_before; ?>
 
      <?php
      if ($rows){
        print $rows;
      } else {
        print $empty;
      }
      ?>

  <?php if ($pager) print $pager; ?>
  <?php if ($attachment_after) print $attachment_after; ?>
  <?php if ($more)  print $more; ?>
  <?php if ($footer) print $footer; ?>
  <?php if ($feed_icon)  print $feed_icon; ?>

<?php if ($admin_links): ?>
</div> <?php /* class view */ ?>
<?php endif; ?>


