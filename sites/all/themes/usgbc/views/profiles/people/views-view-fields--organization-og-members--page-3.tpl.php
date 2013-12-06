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
<?php
  $type = "chapter";
  $getchp = db_result (db_query ("SELECT n.title FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s')", $fields['uid']->content, 1, $type));
  $otype = "organization";
  $getorg = db_result (db_query ("SELECT n.title FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s')", $fields['uid']->content, 1, $otype));
?>
<?php //print_r($fields) ?>
<?php //dsm($row);?>
<div class="ag-item ag-item-with-visual block-link" title="<?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?>">
  <img class="ag-item-visual" width="60" height="60" border="0" src="<?php print $fields['field_per_profileimg_fid']->content;?>">

  <div class="ag-data left">
    <ul class="ag-item-credentials">
      <?php

      $viewname = 'PersonActivity';

      // set arguments (if needed, otherwise omit this line)
      $args [0] = $fields['uid']->content;
      $display_id = 'page_1'; // or any other display
      $view = views_get_view ($viewname);
      $view->set_display ($display_id);
      $view->set_arguments ($args);
      $view->get_total_rows = TRUE;
      $view->execute ();
      //	dsm($view);
      // results are now stored as an array in $view->result
      $count = count ($view->result);
      ?>
      <?php if ($count > 0) { ?>
      <li class="documents hoverTip">
			<span>
			<span><?php print $count;?></span>
			</span>

        <div class="tip"><?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?>
          made <?php print $count;?><?php echo ($count == 1) ? ' contribution' : ' contributions'?> in the last 6 months
        </div>
      </li>
      <?php }?>
      <?php $associations = $fields['field_per_associations_value']->content;?>
      <?php $pos = strpos ($associations, 'Chapter members'); ?>
      <?php if ($pos != false) {
      ?>
      <li class='usgbc hoverTip'>USGBC
        <div class="tip" style="display: none;"><?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?>
          is a member of <?php print $getchp;?></div>
      </li>
      <?php }?>
      <?php $creds = $fields['field_per_leedcred_value']->content;?>
      <?php $pos1 = strpos ($creds, 'LEED Fellow');?>
      <?php if ($pos1 != false) {
      ?>
      <li class="cert-lf hoverTip">
        certification
        <div class="tip" style="display: none;"><?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?>
          is a LEED Accredited Professional
        </div>
      </li>
      <?php }?>
      <?php $pos2 = strpos ($creds, 'LEED AP Homes');?>
      <?php if ($pos2 != false) {
      ?>
      <li class="cert-ap hoverTip">
        certification
        <div class="tip" style="display: none;"><?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?>
          is a LEED Accredited Professional with Homes speciality (LEED AP Homes)
        </div>
      </li>
      <?php }?>
      <?php $pos3 = strpos ($creds, 'LEED AP ID+C');?>
      <?php if ($pos3 != false) {
      ?>
      <li class="cert-ap hoverTip">
        certification
        <div class="tip" style="display: none;"><?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?>
          is a LEED Accredited Professional with Interior Design &amp; Construction specialty (LEED AP ID&amp;C)
        </div>
      </li>
      <?php }?>
      <?php $pos4 = strpos ($creds, 'LEED AP ND');?>
      <?php if ($pos4 != false) {
      ?>
      <li class="cert-ap hoverTip">
        certification
        <div class="tip" style="display: none;"><?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?>
          is a LEED Accredited Professional with Neighborhood Development specialty (LEED AP ND)
        </div>
      </li>
      <?php }?>
      <?php $pos5 = strpos ($creds, 'LEED AP O+M');?>
      <?php if ($pos5 != false) {
      ?>
      <li class="cert-ap hoverTip">
        certification
        <div class="tip" style="display: none;"><?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?>
          is a LEED Accredited Professional with Operations &amp; Maintenance specialty (LEED AP O&amp;M)
        </div>
      </li>
      <?php }?>
      <?php $pos6 = strpos ($creds, 'Green Associate');?>
      <?php if ($pos6 != false) {
      ?>
      <li class="cert-ga hoverTip">
        certification
        <div class="tip" style="display: none;"><?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?>
          is a LEED Green Associate
        </div>
      </li>
      <?php }?>
    </ul>
    <h3 class="ag-item-title">
      <a class="block-link-src" href="<?php print $fields['path']->content;?> "><?php print $fields['field_per_fname_value']->content;?> <?php print $fields['field_per_lname_value']->content;?></a>
    </h3>
<span class="ag-item-detail">
<strong><?php print $fields['field_per_job_title_value']->content;?></strong>
</span>
    <span class="ag-item-detail"><?php print $fields['title']->content;?></span>
  </div>
  <div class="ag-item-footer" style="border:none;"><?php
    //print preg_replace ('/<\/div><div[^>]+>/i', ', ', $fields['field_per_associations_value']->content);
    ?>
  </div>
</div>
