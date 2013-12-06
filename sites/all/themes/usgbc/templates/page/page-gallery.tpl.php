<?php
  // $Id: page-gallery.tpl.php 11388 2011-12-23 13:10:50Z pnewswanger $
  /**
   * @file
   * USGBC theme
   * Displays a gallery page.
   */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><!--[if lt IE 7 ]>
<html class="ie ie6" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]--><!--[if IE 7 ]>
<html class="ie ie7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]--><!--[if IE 8 ]>
<html class="ie ie8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]--><!--[if IE 9 ]>
<html class="ie ie9" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]--><!--[if (gt IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<!--<![endif]-->

<head>

  <title><?php print $head_title; ?></title>
  <?php print $head; ?>

  <?php print $styles; ?>
  <?php print $scripts; ?>
  <?php if ($conditional_scripts) {
  print $conditional_scripts;
} ?>

</head>
<body id="gallery-page" class="<?php print $body_classes; ?>">

<?php if (!empty($messages) || !empty($help)): ?>
<div id='console'>
  <div class='limiter clearfix'>
    <?php if (!empty($messages)): print $messages; endif; ?>
    <?php if (!empty($help)): print $help; endif; ?>
  </div>
</div>
  <?php endif; ?>

<div id="body-container">

  <div id="gallery">
    <?php print $content; ?>
  </div>
  <a href="/" class="gallery-logo"></a>
</div>
<!--body-container-->
<?php print $closure; ?>
</body>
</html>
