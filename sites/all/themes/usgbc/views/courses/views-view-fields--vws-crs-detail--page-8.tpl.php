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
<div id="<?php print $fields['field_wrksp_id_value']->content;?>">
  <?php
  if ($fields['name']->content != ''):
    print $fields['name']->content . '<br />';
  endif;

  if ($fields['street']->content != ''):
    print $fields['street']->content . '<br />';
  endif;

  if ($fields['city']->content != ''):
    print $fields['city']->content;
  endif;

  if ($fields['province']->content != ''):
    print ', ' . $fields['province']->content;
  endif;

  if ($fields['postal_code']->content != ''):
    print ' ' . $fields['postal_code']->content;
  endif;

  if ($fields['country']->content != ''):
    print '<br />' . $fields['country']->content;
  endif;
  ?>

  <?php if ( $fields['street']->content != '' && $fields['coordinates']->content != ''):?>
    <br/>
    <a class="map-link" target="_blank" href="http://maps.google.com/maps?q=<?php print $fields['coordinates']->content;?>">Map</a>
  <?php endif; ?>
</div>
