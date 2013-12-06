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
<h3><a href="#"><?php print $fields['title']->content;?></a></h3>
<div class="small-rating-ratio single-rating-ratio">
<?php if((int)($fields['value']->content) >= 0): ?>
	<div class="like-count">
    	<strong>Likes</strong>
        <span><?php print $fields['value']->content;?></span>
    </div>
    <?php else: ?>
    <div class="dislike-count" >
            <strong >Dislikes</strong>
            <span ><?php print $fields['value']->content;?></span>
        </div>
  <?php endif;?>
</div><!-- rating-ratio -->
<div class="bg-entry-footer">
	<div class="comment-count">
		<strong >Comments</strong>
		<span> <?php print $fields['comment_count']->content;?></span>
    </div>
    
</div>

