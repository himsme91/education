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
?>
<?php $blank_field = '<div class="field-content">empty</div>'?>
<?php

	$author = $fields['name_1']->content;
?>



    <div class="bg-entry">
        <div class="bg-title-header">
            <div class="rating-widget display-rating-widget">
                <div class="top">
                    <?php if ((int)($fields['value_2']->content) >= 0): ?>
                    <?php if ((int)($fields['value_2']->content) == 0): ?>
                        <span class="current-rating positive"><?php print $fields['value_2']->content?></span>
                        <?php else: ?>
                        <span class="current-rating positive">+<?php print $fields['value_2']->content?></span>
                        <?php endif; ?>
                    <?php else: ?>
                    <span class="current-rating negative"><?php print $fields['value_2']->content?></span>
                    <?php endif;?>
                </div>
                <!-- top -->
                <div class="bottom">
                    <span class="likes positive"><?php print $fields['value']->content;?></span>
                    <span class="dislikes negative"><?php print (int)($fields['value_1']->content) * -1;?></span>
                </div>
                <!-- bottom -->
            </div>

            <h2><?php print $fields['title']->content;?></h2>
        </div>
        <!-- bg-title-header -->

        <div class="bg-entry-header">
            <span
                class="bg-entry-header-section">Published on <strong><?php print $fields['created']->content;?></strong></span>
			<?php if($author != Anonymous){?>
            	<span class="bg-entry-header-section">Written by <strong><a href="/<?php print $fields['path']->content;?>"><?php print $author;?></a></strong></span>
			<?php }?>
            <span class="bg-entry-header-section">Posted in <strong><a
                href="/articles/<?php print usgbc_dashencode($fields['name']->content);?>"><?php print $fields['name']->content;?></a></strong></span>
        </div>
        <?php if ($fields['field_art_feature_image_fid']->content != "") { ?>
        <div class="feature-image figure">
            <div class="container">
              <?php print $fields['field_art_feature_image_fid']->content;?>
            </div>
        </div>
        <?php } ?>
        <div class="bg-overlay">
            <p><?php print $fields['body']->content; ?></p>
            <!--<a href="" class="more-link medium-link">Details</a>-->
            <div class="bg-entry-footer">
                <div class="comment-count">
                    <strong>Comments</strong>
                    <span><?php print $fields['comment_count']->content; ?></span>
                </div>
                <div class="right more-link"><?php print $fields['view_node']->content;?></div>
            </div>
        </div>
    </div>

