<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php //print_r($rows);?>


<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>


    <p class="small">These articles have been submitted for review and are awaiting your approval.</p>
		<?php foreach ($rows as $id => $row): ?>
			<?php print $row; ?>
		<?php endforeach; ?>  








