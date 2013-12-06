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
	<div class="left rating-widget pending display-rating-widget">
                                  							    <div class="top">
                                  							        <span class="current-rating positive">0</span>
                                  							    </div><!-- top -->
                                  							    <div class="bottom">
                                  							        <span class="likes positive">0</span>
                                  							        <span class="dislikes negative">0</span>
                                  							    </div><!-- bottom -->
                                  							</div>
    <h2 class="sub-compact"><?php print $fields['title']->content;?></h2>
 </div>
 <div class="live-blog contribute-options button-group">
  <p class="sub-text">Submitted <?php print $fields['stamp']->content;?> - <a href="mailto:<?php print $fields['mail']->raw;?>">Email editor</a></p>
</div>


