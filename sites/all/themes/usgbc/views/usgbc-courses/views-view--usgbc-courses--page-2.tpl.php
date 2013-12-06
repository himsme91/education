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
<link rel="stylesheet" type="text/css" media="screen" href="/sites/all/themes/usgbc/lib/css/section/usgbc-courses.css">
<link rel="stylesheet" type="text/css" media="screen" href="/sites/all/themes/usgbc/lib/css/section/usgbc-courses.css">
<style>
#header{ display: block !important;}
#education-subscribe-button .box h4 .reg{
	text-transform: uppercase;
	background: url('/sites/all/themes/usgbc/lib/img/green-check.png') no-repeat left center;
	padding-left: 34px;
}

#education-subscribe-button .box {
	background: #EEEEEE;
	margin-bottom: 15px;
	-moz-border-radius: 6px;
	border-radius: 6px;
}

</style>
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

  <div id="education-subscribe-button" style="text-align:center;">
  		<div class="box" id="sub-here" style="display: inline-block;">
	  		<?php 
	  		$es_node_id = variable_get('education_subscription',"");
			$es_node = node_load($es_node_id);
			$education_subscription = og_subscriber_count_link($es_node);
			if($education_subscription[1] != "active"):
				$price = $es_node->list_price;
				?>
				<h4><?php print uc_currency_format ($price);?> per year
				</h4>
				<form name="add_to_cart" action="/education-subscription/payment" method="post" >
					<a href="" class="jumbo-button-dark" id="btn_register" onclick="document.forms.add_to_cart.submit();return false;">
					Education Subscription
					</a>
					<input type="hidden" name="workshopSKU" value="<?php print $es_node_id;?>"/>
				</form>
			<?php else:?>
				<h4><span class="reg">Subscribed</span></h4>
			<?php endif;?>
		</div>
	</div>
  
  <div id="article-grid-view">

       <?php
      if ($rows){
        print $rows;
      } else {
        print $empty;
      }
      ?>

  <?php if ($pager) print $pager; ?>
  </div>  <!-- end article-grid-view-->

  <?php if ($attachment_after) print $attachment_after; ?>
  <?php if ($more)  print $more; ?>
  <?php if ($footer) print $footer; ?>
  <?php if ($feed_icon)  print $feed_icon; ?>

<?php if ($admin_links): ?>
</div> <?php /* class view */ ?>
<?php endif; ?>


