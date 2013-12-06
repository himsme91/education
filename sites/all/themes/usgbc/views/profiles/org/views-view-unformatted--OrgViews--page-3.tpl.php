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
<?php $count_query = 
"SELECT count(DISTINCT node.nid) AS the_total from node 
LEFT JOIN content_field_org_validto validto
ON node.vid = validto.vid 
WHERE (node.type in ('chapter', 'organization')) and node.status <> 0 
and DATE(validto.field_org_validto_value) >= CURDATE()";
?>
<?php $count = db_result(db_query($count_query)) ?>

<div class="block-link"  title="Browse Directory">
<h1>Organizations</h1>
<p>
Search our membership community of
<?php echo '<strong> '.number_format($count).' </strong>';?>
companies, nonprofits, education institutions, state &amp; local governments, professional societies and trade organizations that provide direction, leverage policy and advance the understanding of the most important issues affecting building today.
</p>
<div class="button-group">
<a class="button block-link-src" href="/organizations">Browse</a>
</div>
</div>
<h5>Learn more about the newest organizations</h5>
 
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>

<ul class="linelist">
<?php foreach ($rows as $id => $row): ?>
      <?php print $row; ?>
<?php endforeach; ?>
</ul>

