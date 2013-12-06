<?php
// $Id: views-view-unformatted.tpl.php,v 1.6 2008/10/01 20:52:11 merlinofchaos Exp $
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>

<ul class="simple-feedback-box">
<li class="blank"><a href="/myaccount/downloadmemberslist">Download</a> a list of all employees currently linked to your membership account.</li>
</ul>

<ul class="manage-user-list plainlist">
                                                      
<?php foreach ($rows as $id => $row): ?>
  
 <?php print $row;?>

<?php endforeach; ?>
  </ul>