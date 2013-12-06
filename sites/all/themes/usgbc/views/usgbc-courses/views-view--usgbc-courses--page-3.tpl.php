<style>
.lesson-list{
	list-style-type:none;
}

.lesson-list li {
border-top: 2px solid #EEEEEE;
margin-bottom: 0 !important;
padding: 10px 12px 10px 10px !important;
position: relative;
transition: background 0.2s ease 0s;
list-style: none outside none !important;
}

.lesson-list li .frame-container {
float: left;
margin-left: -80px;
}

.frame-container {
position: relative;
z-index: 1;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
background: #ffffff;
}

.session-logo{
	display:inline-block;
	float:left;
	width:15%;
}

.session-details{
	display:inline-block;
	float:left;
	width:80%;
}

.logo-image{
	position:relative;
	top:40px;
}

.session-content{
	border-bottom: 1px solid #EEEEEE;
	display:list-item;
	overflow:hidden;
}

.session-content:first-child{
	border-top: 1px solid #EEEEEE;
}

.clearfix{
	border:none !important;
}

.clearfix-lower{
	border-top: 1px solid #EEEEEE;
	padding:20px 12px 10px 70px !important;
}

.clearfix-upper{
	padding:10px 12px 10px 70px !important;
}

.clearfix-upper span, .clearfix-lower span{
	float:left;
	font-size:16px;
	font-weight:bold;
}

.clearfix-upper .jumbo-button-dark, .clearfix-lower .jumbo-button-dark{
	float:right;
	font-size:12px;
	width:115px;
}

.meta-item strong {
	color: #fff;
	background: #BCBCBC;
	font-weight: 400;
	padding: 2px 5px;
	-moz-border-radius: 4px;
	border-radius: 4px;
}

.reg{
	text-transform: uppercase;
	background: url('/sites/all/themes/usgbc/lib/img/green-check.png') no-repeat left center;
	padding-left: 34px;
	font-size: 12px !important;
	margin-right:15px;
}

.session-content:hover{
	background: none repeat scroll 0 0 #F5F5F5;
	border-radius: 4px 4px 4px 4px;
	box-shadow: none;
}


</style>


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