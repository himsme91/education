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
<?php // print_r($fields['body']->content); ?>
<?php  //dsm($fields);?>

<?php if($fields['homepage']->raw == 'post'):
		$post = true;
		else :
		$post = false;
		endif;
?>

<?php if($post){?>
<li class="write">
<strong>
Published 
<a href=""><?php  print $fields['title']->content; ?></a>
</strong>
<?php  print $fields['body']->content; ?>
<small><?php  print $fields['created']->content; ?></small>
</li>
<?php } else {?>
<li class="small">
Commented on
<?php  print $fields['title']->content; ?>&nbsp;
<?php $author = content_profile_load('person',$fields['hostname']->content);?>
<?php if($author->field_per_fname[0]['value']) {?>
by <a href="/<?php print $author->path;?>">
<?php 
$authorname = $author->field_per_fname[0]['value'] . ' ' . $author->field_per_lname[0]['value'];
print $authorname;
}?></a>

</li>
<?php }?>
