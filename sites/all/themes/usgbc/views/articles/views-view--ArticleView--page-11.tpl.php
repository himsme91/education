<?php
// $Id: views-view--ArticleView--page-2.tpl.php 10692 2011-12-15 17:04:45Z pnewswanger $
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
<?php 
//dsm($rows[0]);
//$month_list=array("January","February","March","April","May","June","July","August","September","October","November","December");
//dsm(count($month_list));
//dsm($rows[0]);
//dsm($month);
 
//dsm($view);
$channel = $view->args[0];
if (!empty($channel)){
	if ($channel == 'leed'){
		$page_title = "LEED archive";
	}else{
		$page_title = str_replace('-',' ',ucfirst($channel))." archive";
	}
}else{
	$page_title = "Archive";
}
//$page_title = $view->build_info['title'];
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

  <div id="article-grid-view">
<div class="bg-list">

  	<div class="archive-header"><h1><?php print $page_title; ?></h1></div>
  	
       <?php
      if ($rows){
        print $rows;
      } else {
        print $empty;
      }
      ?>
   	
</div>
  <?php if ($pager) print $pager; ?>
  </div>  <!-- end article-grid-view-->

  <?php if ($attachment_after) print $attachment_after; ?>
  <?php if ($more)  print $more; ?>
  <?php if ($footer) print $footer; ?>
  <?php if ($feed_icon)  print $feed_icon; ?>

<?php if ($admin_links): ?>
</div> <?php /* class view */ ?>
<?php endif; ?>


