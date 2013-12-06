


<?php

global $user;
  if ($user->uid) {
    drupal_set_message( t('You are already registered as a site user.'), 'status', FALSE);
    header('account');
  }

  //Remove Form Element wrapper
  foreach ($form as $k=> $v) {
    if (!is_array ($v)) continue;
    if (substr ($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
  }

  $form['find-co-by-id']['#wrapper'] = false;
  $form['find-co-by-name']['#wrapper'] = false;

?>

<?php //var_dump($form);
  //dsm($form);
?>
<?php if ($form) {
  //$form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
  //$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');
  //print_r($form['form_array']);
}
?>
<div class="registration-process">

  <h1>Create a USGBC account</h1>


  <div id="mainCol" style="width:725px">
    <div class="form">

      <div class="form-section">

        <h4 class="form-section-head">Account</h4>

        <div class="form-column-set">
          <div class="form-column">
            <div class="element">
              <label title="" for="fname-field">First name</label>
              <?php
              print drupal_render ($form['field_per_fname']); ?>
            </div>
          </div>
          <div class="form-column">
            <div class="element">
              <label title="" for="lname-field">Last name</label>
              <?php
              print drupal_render ($form['field_per_lname']); ?>
            </div>
          </div>
        </div>


        <div class="form-column-set">
          <div class="form-column">
            <div class="element">
              <label title="" for="email-field">Email</label>
              <?php
              print drupal_render ($form['mail']); ?>
            </div>
          </div>
          <div class="form-column">
            <div class="element">
              <label title="" for="email2-field">Email <span class="small">(confirm)</span></label>
              <?php
              print drupal_render ($form['conf_mail']); ?>

            </div>
          </div>
        </div>


        <div class="form-column-set">
          <div class="form-column">
            <div class="element">
              <label title="" for="password-field">Password <span class="small">(7 character minimum)</span></label>
              <?php
              print drupal_render ($form['pass1']); ?>
            </div>
          </div>
          <div class="form-column">
            <div class="element">
              <label title="" for="password2-field">Password <span class="small">(confirm)</span></label>
              <?php
              print drupal_render ($form['pass2']); ?>
            </div>
          </div>
        </div>


        <div class="element">
          <label>Phone</label>
          <?php
          print drupal_render ($form['field_per_phone']); ?>
        </div>
      </div>
      <!-- form section -->

      <div class="form-section">
        <div id="link-to-existing-co" class="aside-dark">
          <h4 class="form-section-head">Connect to member organization <span class="small">(optional)</span>
            <a class="jqm-tip-trigger help-tip" href="#link-member"><img src="/sites/all/themes/usgbc/lib/img/help-hint.gif"></a>
          </h4>

          <div id="link-member" class="modal-tip" style="display:none;">
            <p>If you're a full-time employee of an organization that is a member of USGBC, enter your organization's
              name or Member ID (preferred) to connect your account to your organization's membership account. Once
              linked, you have access the member benefits such as discounts on USGBC purchases, members-only webcasts,
              podcasts and more.</p>
          </div>
          <ul class="inputlist">
            <li>
              <?php
              $form['find-co-by-id']['#help'] = 'The Member ID is the unique identifier for your organization&rsquo;s membership. Providing the Member ID connects your account to your organizations&rsquo;s membership account.';
              print drupal_render ($form['find-co-by-id']);?>
            </li>
            <li>
              <?php
              print drupal_render ($form['find-co-by-name']);?>
            </li>
          </ul>

          <div class="find-by-id hidden">
            <div class="element">
              <label for="memberid-field" title="">Member ID</label>

              <div class="autocomplete-anchor"><input id="memberid-field" class="field" type="text" name="" value=""/>
              </div>

              <div class="element button-group">
                <a class="small-button" id="triggerSearch" href="orgsbymemid">Search</a>
              </div>

            </div>

            <div class="aside hidden" id="company-link-results1">

            </div>

          </div>

          <div class="find-by-name hidden">
            <div class="element">
              <label for="companyname-field" title="">Name</label>

              <div class="autocomplete-anchor"><?php print drupal_render ($form['companyname-field']); ?></div>

              <div class="element button-group">
                <a class="small-button" id="triggerSearchName" href="orgsbymemname">Search</a>
              </div>

            </div>

            <div class="aside hidden" id="company-link-results">

            </div>

          </div>

        </div>

      </div>

      <div class="form-section hidden">
        <h4 class="form-section-head">Newsletters</h4>
        <ul class="inputlist">
          <li>
            <label for="">
              <?php print drupal_render ($form['usgbcupdate']);?>
              <span>USGBC Update (monthly)</span>
            </label>
          </li>
        </ul>
      </div>

      <div class="form-section hidden">
        <h4 class="form-section-head">Notifications</h4>
        <ul class="inputlist">
          <li>
            <label for="">
              <?php print drupal_render ($form['fromusgbc']);?>
              <span>From USGBC</span>
            </label>
          </li>
        </ul>
      </div>
       
<!--  additions for usgbc updates mailchimp list -->   
      <div class="form-section">
        <div class="element">
          <h4 class="form-section-head">Subscribe to our insider emails<span class="small"> (more options available in your account)</span></h4>
          <?php print drupal_render ($form['chkgeneral']);?>
          <?php print drupal_render ($form['chkeducation']);?>
          <?php print drupal_render ($form['chklpcredentials']);?>
          <?php print drupal_render ($form['chkltupdates']);?>
          <?php print drupal_render ($form['chapterupdate']);?>
        </div>
      </div>

      <div class="form-section">
        <div class="element">
          <h4 class="form-section-head">Terms &amp; conditions</h4>
          <?php print drupal_render ($form['field_legal_accept']); ?>
        </div>
      </div>

      <div class="form-controls buttons button-group">
        <?php print drupal_render ($form['register']); ?>
        <a href="/" class="button-note">Cancel</a>
      </div>

      <div id="norender" class="hidden"><?php //$form['og_reg_key']['#required']=false;
        print drupal_render ($form); ?>

      </div>

    </div>
  </div>


  <div id="sideCol">


  </div>


</div>
