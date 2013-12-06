<?php
  // $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
  /**
   * @file views-view-fields.tpl.php
   * Default simple view template to all the fields as a row.
   *
   * - $view: The view in use.
   * - $fields: an array of $field objects. Each one contains:
   *   - $field->content: The output of the field.
   *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
   *   - $field->class: The safe class id to use.
   *   - $field->handler: The Views field handler object controlling this field. Do not use
   *     var_export to dump this object, as it can't handle the recursion.
   *   - $field->inline: Whether or not the field should be inline.
   *   - $field->inline_html: either div or span based on the above flag.
   *   - $field->separator: an optional separator that may appear before a field.
   * - $row: The raw result object from the query, with all data it fetched.
   *
   * @ingroup views_templates
   */

  foreach ($fields['field_art_slideshow_image_fid']->handler->field_values as $imagearray)
    $image_count = count ($imagearray);
?>
<?php //print_r($fields) ?>
<?php //dsm($fields);?>
<?php if ($fields['field_org_foundation_statement_value']->content):
  $stmt = $fields['field_org_foundation_statement_value']->content;
elseif ($fields['field_chp_foundation_stmt_value']->content):
  $stmt = $fields['field_chp_foundation_stmt_value']->content;
endif; ?>

<div id="mainCol">
  <div class="contributed-content">
    <?php if ($fields['field_art_feature_image_fid']->content != ""): ?>

    <?php if ($fields['field_art_slideshow_image_fid']->content == ""): ?>
      <div class="feature-image" itemprop="image">
        <span class="key-image">
        <?php print $fields['field_art_feature_image_fid']->content;?>
        </span>

        <p class="copyright"></p>
      </div>
      <?php else: ?>
      <?php $img_count = count ($fields['field_art_slideshow_image_fid']->content);
      $img_url = '/gallery/img/' . $fields['nid']->content . '/0';
      ?>
      <div class="feature-image">
        <a class="key-image" href="<?php print $img_url;?>" rel="image-gallery" title="View <?php print $image_count;?> more images">
          <?php print $fields['field_art_feature_image_fid']->content;?>
          <span><?php print $image_count;?></span>
        </a>

        <p class="copyright"></p>
      </div>
      <?php endif; ?>

    <?php endif;?>
  <div class="contributed-content" itemprop="description">
    <h2 class="kicker"><?php print $stmt;?></h2>
  	<!--  
	<?php if ($fields['field_art_videos_embed']->content != ""):
      $video_count = count ($fields['field_art_videos_embed']->content);
      $video_url = '/gallery/video/' . $fields['nid']->content . '/0/video';
      ?>
      <div class="galleries">
        <div class="gallery-box">
          <a href="<?php print $video_url; ?>" rel="video-gallery"><?php print $fields['field_art_videos_embed']->content;?>
            <span><?php print $video_count; ?></span></a>
        </div>
      </div>

      <?php endif;?>
      -->
	<?php if ($fields['body']->content != ''):?>
	    <p><?php print $fields['body']->raw; ?></p>
	<?php else:?>
		<p><em>This organization has not provided an overview.</em></p>
	<?php endif;?>
  </div>
  </div>
</div>

