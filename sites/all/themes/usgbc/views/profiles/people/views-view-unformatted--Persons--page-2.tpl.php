<?php
// $Id: views-view.tpl.php,v 1.13.2.2 2010/03/25 20:25:28 merlinofchaos Exp $
/**
 *
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

	$args = array();
	$viewname = 'Persons';
	$display_id = 'page_1';
  	$view = views_get_view($viewname);
  	$view->set_display($display_id);
  	$view->get_total_rows = TRUE;
	$view->execute();
	// results are now stored as an array in $view->result
	$count =  $view->total_rows;//count($view->result);
		?>
<div class="block-link"  title="Browse Directory">
<h1>People</h1>
<p>
Search our community of <?php echo '<strong> '.number_format($count).' </strong>';?>
staff, volunteers and professionals who give voice to our commitment to forwarding the green building movement. Our people are contributing a wealth of knowledge to benefit everyone who shares USGBC's vision of green buildings for everyone within this generation.
</p>
<div class="button-group">
<a class="button block-link-src" href="/people">Browse</a>
</div>
</div>
<h5>Connect with the newest individuals</h5>

<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>

<ul class="linelist">
<?php foreach ($rows as $id => $row): ?>
      <?php print $row; ?>
<?php endforeach; ?>
</ul>
