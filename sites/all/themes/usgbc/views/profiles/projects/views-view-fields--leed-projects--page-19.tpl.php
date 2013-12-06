<h5>Project details</h5>

<dl>
  <?php if (!empty($fields['field_prjt_site_size_value']->content)): ?>
    <dt>Size</dt>
    <dd><?php print $fields['field_prjt_site_size_value']->content;?> sf</dd>
  <?php endif;?>

  <?php if (!empty($fields['field_prjt_type_value']->content)): ?>
    <dt>Use</dt>
    <dd><?php print $fields['field_prjt_type_value']->content;?></dd>
  <?php endif;?>

  <?php if (!empty($fields['field_prjt_setting_value']->content)) : ?>
    <dt>Setting</dt>
    <dd><?php print $fields['field_prjt_setting_value']->content;?></dd>
  <?php endif;?>

  <?php if (!empty($fields['field_prjt_certification_date_value']->content)) : ?>
    <dt>Certified</dt>

    <?php if ($fields['field_prjt_id_value']->content == '10020308'): ?>
      <dd>May 2, 2008 (CS) <br/>April 7, 2008 (CI)</dd>
    <?php else: ?>
      <dd><?php print $fields['field_prjt_certification_date_value']->content;?></dd>
    <?php endif; ?>

  <?php endif;?>

  <?php if (!empty($fields['field_prjt_walkscore_value']->content)) : ?>
  <img src="/sites/all/assets/section/profiles/project_score_icons/walkscore-logo-small.gif" style="float:right;">
    <dt>Walk Score&reg;</dt>
    <dd><?php print $fields['field_prjt_walkscore_value']->content;?></dd>
  <?php endif; ?>

  <!-- <?php if (!empty($fields['field_prjt_setting_value']->content) && false) : ?>
    <dt>Metroscore</dt>
    <dd> <?php print $fields['field_prjt_certification_date_value']->content; ?> </dd>
  <?php endif;?> -->

  <?php if (!empty($fields['field_energy_star_score_value']->content)) : ?>
    <dt>ENERGY STAR&reg; score</dt>
    <dd><?php print $fields['field_energy_star_score_value']->content;?></dd>
  <?php endif;?>
</dl>
