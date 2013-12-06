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
//$node = node_load($row->nid);
//dsm($fields);       
                                                                                                                                                                                                                      
?>
<div class="contribute-info">
	<div class="left live rating-widget display-rating-widget">
          <div class="top">
          <?php if ((int)($fields['value']->content) >= (int)($fields['value_1']->content)): ?>
              <span class="current-rating positive"><?php print $fields['value_2']->content;?></span>
          <?php else:?>
          	  <span class="current-rating negative"><?php print $fields['value_2']->content;?></span>
          <?php endif;?>
         </div><!-- top -->
                   <div class="bottom">
                      <span class="likes positive"><?php print $fields['value']->content;?></span>
                      <span class="dislikes negative"><?php print $fields['value_1']->content;?></span>
                   </div><!-- bottom -->
    </div>
    <h2 class="sub-compact"><?php print $fields['title']->content;?></h2>
 </div>
 <div class="live-blog contribute-options button-group">
      <div class="bg-entry-footer right">
          <div class="comment-count">
             <strong>Comments</strong>
                <span><?php print $fields['comment_count']->raw;?></span>
           </div>
       </div>
  <p class="sub-text">Published <?php print $fields['stamp']->content;?> - <a href="mailto:<?php print $fields['mail']->raw;?>">Email editor</a></p>
</div>


