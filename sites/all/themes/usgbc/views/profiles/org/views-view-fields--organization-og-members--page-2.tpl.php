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
<?php //echo '<pre>'; print_r($fields); echo '</pre>';?>
<li class="user odd pending-user">
  <h4>
    <?php print $fields['field_per_fname_value']->content?>  <?php print $fields['field_per_lname_value']->content?>
  </h4>

  <div class="pending-user-menu">

    <span class="small"><a><?php print $fields['mail']->content;?></a></span>

    <div class="button-group mini-button-group right">

      <?php $acceptuid = "acceptuid" . $fields['uid']->content; ?>
      <a class="acceptdeny" id=<?php print $acceptuid;?> href="#" action="accept"
      user-value="<?php print $fields['uid']->content;?>" nid=<?php print $_SESSION['orgnid'];?>>Accept</a>
      <?php $denyuid = "denyuid" . $fields['uid']->content; ?>
      <a class="acceptdeny" id=<?php print $denyuid;?> href="#" action="deny"
      user-value="<?php print $fields['uid']->content;?>" nid=<?php print $_SESSION['orgnid'];?>>Deny</a>

    </div>

  </div>

  <div class="hidden">

    <span class="small">This person has been successfully added to this account.</span>

  </div>

</li>
