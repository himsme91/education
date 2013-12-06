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
<link rel="stylesheet" type="text/css" media="screen" href="/sites/all/themes/usgbc/lib/css/section/usgbc-courses.css">

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

  <!-- Show the content even if no result returned -->
  <div class="courses-container">
  <?php global $user;
	if(!$user->uid || $user->uid==0 ) {
		$destination =  $_SERVER['REQUEST_URI'];
		header("Location: /user/login?destination=$destination");
	}else{ ?>
  	<h1>My Courses</h1>
  	<div class="courses-block">
  		<div class="list-courses">
  			<?php if($rows){
  				print $rows; 
  			}?>
  			<div class="course-holder">
        		<div class="course-portlet add-new">
        			<form name="add_course" action="/node/add/usgbc-course" method="post">
						<input type="hidden" value="Parent" name="course_type"/>
					</form>
					<img alt="" src="/sites/all/themes/usgbc/lib/img/create.png" onclick="document.forms.add_course.submit();return false;" />
	        		<a onclick="document.forms.add_course.submit();return false;">Create New Course</a>
	        	</div>
        	</div>
        </div>  
     </div>
     <?php } ?>
  </div>
 
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