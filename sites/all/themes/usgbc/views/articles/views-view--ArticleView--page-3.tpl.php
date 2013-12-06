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
<?php if ($admin_links): ?>
<div class="<?php print $classes; ?>">
<?php endif; ?>

  <?php if ($admin_links): ?>
    <div class="views-admin-links views-hide">
      <?php print $admin_links; ?>
    </div>
  <?php endif; ?>
  
  <?php if ($header) print $header; ?>

  <?php if ($exposed): ?>
   <div class="mini-search">
  	<div class="mini-search-container">
  			<form action="/articles/searchlist">
  				<input type="text" value="Search the blog" name="keys" defaultvalue="Search the blog" class="mini-search-field default"> 
  				<input type="submit" value="Search" src="/themes/usgbc/lib/img/search-icon-button.gif" name="" class="mini-search-button">&nbsp;</form>
  		</div>
  	</div>
   
      <?php // print $exposed; ?>
  <?php endif; ?> 

  <?php if ($attachment_before) print $attachment_before; ?>
   <?php 

$page_title = $view->build_info['title'];
$date = $view->args[0];
$arg = explode('/', $_GET['q']);

?>
<?php $i = substr($date,4,5);?>
 
  <?php //print $page_title; ?>
  <div class="archive-header">
  	<h1><?php print date( "F" , mktime( 0 , 0 , 0 , $i ) ) ;?> <?php print substr($date,0,4)?></h1>
  	<a class="back-link" href="/articles/archive<?php if ($arg[2] != NULL) echo '/'.drupal_urlencode(usgbc_dashencode($arg[3])); ?>"> Archive</a>
  </div>
 <div id="article-list-view">
<div class="bg-list">

  <?php
  if ($rows){
    print $rows;
  } else {
    print $empty;
  }
  ?>
</div>
  <?php if ($pager) print $pager; ?>
</div> <!-- end article-list-view-->
  
  <?php if ($attachment_after) print $attachment_after; ?>
  <?php if ($more) print $more; ?>
  <?php if ($footer) print $footer; ?>
  <?php if ($feed_icon) print $feed_icon; ?>

<?php if ($admin_links): ?>
</div> <?php /* class view */ ?>
<?php endif; ?>
