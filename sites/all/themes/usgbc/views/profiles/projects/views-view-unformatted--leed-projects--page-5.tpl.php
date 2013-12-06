<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<div class="block-link"  title="Browse Directory">
                                <h1>Projects</h1>
                                <p>Search our directory of <strong><?php print number_format($view->total_rows) ?></strong> LEED-certified project profiles. See how each project achieved LEED certification and glean best practices to guide the success of your project.</p>

                                <div class="button-group">
                                    <a href="/projects" class="button block-link-src">Browse</a>
                                </div>
</div>
<h5>View the newest LEED certified projects</h5>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>

<ul class="linelist">
<?php foreach ($rows as $id => $row): ?>
      <?php print $row; ?>
<?php endforeach; ?>
</ul>
