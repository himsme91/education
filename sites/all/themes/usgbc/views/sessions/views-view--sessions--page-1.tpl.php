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
<style type="text/css">
.course-leaders .head {
    margin-bottom: 0px;
    padding: 0 0 10px;
}
.course-leaders .head .frame-container {
    margin-left: 0;
}
</style>
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

  <?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php else: ?>
  <?php 
  global $user;
  $workshop_node = node_load($view->args[0]);
  $subscription = og_subscriber_count_link($workshop_node);
  $user_access = false;
  if($subscription[1] == "active") $user_access = true;
  ?>
  <div>
  <?php if(!$user_access):?>
  <h2 style="padding:20px">You do not have access to this module
	<br><span style="font-weight:300;color: rgb(110, 160, 53);" class="small">Please sign up for the webinar to get access</span>
  </h2>
  <br>
  <?php endif;?>
  <?php if($user_access):?>
	  	<?php 
	  	$viewname = 'sessions';
		$args = array();
		$args [0] = $view->args[0];
		$display_id = 'page_2'; // or any other display
		$view = views_get_view ($viewname);
		$view->set_display ($display_id);
		$view->set_arguments ($args);
		print $view->preview ();
		?>
  <?php else:?>
  	  	<?php 
	  	$viewname = 'sessions';
		$args = array();
		$args [0] = $view->args[0];
		$display_id = 'page_3'; // or any other display
		$view = views_get_view ($viewname);
		$view->set_display ($display_id);
		$view->set_arguments ($args);
		print $view->preview ();
		?>
  <?php endif;?>
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

</div> <?php /* class view */ ?>