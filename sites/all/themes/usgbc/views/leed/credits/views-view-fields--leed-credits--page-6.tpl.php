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
//dsm($fields);
?>
      <h4 class="sub-compact"><?php print $fields['title']->content;?></h4>
                            <dl class="details">
                                <dt>Format</dt>
                                <dd><?php print $fields['field_crs_fmt_value']->content;?></dd>
                                
                                <dt>Level</dt>
                                <dd><?php print $fields['field_crs_level_value']->content;?></dd>
        
                                <dt>Price</dt>
                                <dd>From $<?php print $fields['field_crs_price1_value']->content;?></dd>
                            </dl> 
