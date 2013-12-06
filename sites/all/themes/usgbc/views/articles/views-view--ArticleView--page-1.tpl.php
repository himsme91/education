<?php
// $Id: views-view--ArticleView--page-1.tpl.php 15134 2012-03-05 18:00:13Z jmehta $
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

<?php if ($admin_links): ?>
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

  <div id="article-list-view">

       <?php
      if ($rows){
        print $rows;
      } else {
        print $empty;
      }
?>
  <?php if ($pager) print $pager; ?>
  </div> <!-- end article-list-view-->
	<?php if (user_access("create article content")):?>
  <div class="search-report aside">
	<a target="_blank" href="/node/add/article/">New</a>
</div>
<?php endif; ?>

  <?php if ($attachment_after) print $attachment_after; ?>
  <?php if ($more)  print $more; ?>
  <?php if ($footer) print $footer; ?>
  <?php if ($feed_icon)  print $feed_icon; ?>

<?php if ($admin_links): ?>
</div> <?php /* class view */ ?>
<?php endif; ?>


