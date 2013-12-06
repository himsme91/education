<div class="form form-form clear-block <?php print $form_classes ?>" id="divPer">

<script type="text/javascript">

  $(document).ready(function () {

    $("#edit-field-personalbio-0-value").charCount({
      textMax:1000,
      textMin:250,
      limitAlert:1000
    });

  });

</script>



<?php //if($form){
  //form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
  //$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');
  //print_r($form['form_array']);
  //dsm($form['field_per_orgname'][0]['nid']['#attributes']);
  //dsm($form['field_per_orgname'][0]['#attributes']);
  //}
  //print drupal_render($form);
?>


<div class="padded">
  <h1>Personal Profile</h1>
</div>

<div class="panels">
<?php //$form['field_jobtitle']=array('#value' => '<pre>'.print_r($form['field_jobtitle'],1).'</pre>'); ?>
<!-- Profile Image -->
<div id="per_change_photo" class="panel settings show_link">
  <div class="panel_label">
    <h4 class="left">Photo of you</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php
    if ($node1->field_per_profileimg[0]['filepath'] == '') {
      $img_path = '/sites/all/assets/section/placeholder/person_placeholder.png';
    } else {
      $img_path = $node1->field_per_profileimg[0]['filepath'];
    }
    $attributes = array(
      'class'=> 'left',
      'id'   => 'change_perslogo_val'
    );
    print theme ('imagecache', 'fixed_100-100', $img_path, $alt, $title, $attributes);
    ?>
  </div>
  <div class="panel_content hidden">
    <div class="quick-edit-form">
      <div class="element">
        <?php  $form['field_per_profileimg'][0]['#title'] = t ('');
        print drupal_render ($form['field_per_profileimg']);  ?>
      </div>
      <div class="button-group">
        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>

  </div>

</div>

<!-- Job title -->
<div class="panel settings show_link" id="per_change_jobtitle">
  <div class="panel_label"><h4 class="left">Job title</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php   if ($form['#node']->title == ''): ?>:?>
    <p class="left" id="change_membership_val">You currently have no job title.</p>
    <?php else: ?>
    <p class="left" id="change_membership_val"> <?php  print ($form['#node']->title); ?></p>
    <?php endif; ?>
  </div>
  <div class="panel_content hidden">
    <div class="company-contact-information quick-edit-form sub-form-element">
      <div class="element">
        <?php
        // $form['field_selectalevel']['value']['#title']=t('');
        // print drupal_render($form['field_selectalevel']);

        ?>
      </div>
      <div class="element">
        <?php
        // $form['field_selectafunction']['value']['#title']=t('');
        // print drupal_render($form['field_selectafunction']);

        ?>
      </div>
      <div class="element">
        <?php
        $form['title']['#title'] = t ('Title (this will display in your profile)');
        $form['title']['#attributes'] = array('class'=> 'field');
        print drupal_render ($form['title']);
        ?>
      </div>
      <div class="button-group">
        <?php $form['buttons']['submit_profilejobtitle'] = array(
        '#id'                       => 'edit-submit',
        '#type'                     => 'submit',
        '#access'                   => '1',
        '#value'                    => t ('save'),
        '#submit'                   => array('node_form_submit', 'ajax_submitter'),
        '#access'                   => '1',
        '#attributes'               => Array('class'=> 'small-alt-button update-settings-btn ajax-trigger'),
        '#parents'                  => Array('submit'),
        '#array_parents'            => Array('buttons', 'submit'),
        '#executes_submit_callback' => '1',
        '#process'                  => Array('form_expand_ahah')
      );
        print drupal_render ($form['buttons']['submit_profilejobtitle']);?>

        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>
    <!-- quick edit -->
  </div>
</div>
<!--Company -->
<div class="panel settings show_link" id="per_change_employer">
  <div class="panel_label"><h4 class="left">Company</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php   if ($form['field_related_org'][0]['nid']['#value']['nid'] == ''): ?>
    <p class="left" id="change_membership_val">You currently have no company.</p>
    <?php else: ?>
    <p class="left" id="change_membership_val"><?php
      print_r ($form['field_related_org'][0]['nid']['#value']['nid']); ?></p>
    <?php endif; ?>
  </div>
  <div class="panel_content hidden">
    <div class="quick-edit-form">
      <div class="hidden" id="change-company-form">
        <div class="element">
          <?php $form['field_per_orgname'][0]['value']['#title'] = t ('Name');
          // $form['field_per_orgname'][0]['#attributes']=array('class'=>'field');
          // $form['field_per_orgname'][0]['nid']['#value']['nid']['#attributes']=array('class'=>'field');
          print drupal_render ($form['field_per_orgname']);
          ?>
        </div>
        <div class="button-group">
          <?php $form['buttons']['submit_profilecompany'] = array(
          '#id'                       => 'edit-submit',
          '#type'                     => 'submit',
          '#access'                   => '1',
          '#value'                    => t ('save'),
          '#submit'                   => array('node_form_submit', 'ajax_submitter'),
          '#access'                   => '1',
          '#attributes'               => Array('class'=> 'small-alt-button update-settings-btn ajax-trigger'),
          '#parents'                  => Array('submit'),
          '#array_parents'            => Array('buttons', 'submit'),
          '#executes_submit_callback' => '1',
          '#process'                  => Array('form_expand_ahah')
        );
          print drupal_render ($form['buttons']['submit_profilecompany']);?>

          <a class="small-button cancel-settings-btn" href="#">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!--Bio -->
<div class="panel settings show_link" id="per_change_bio">
  <div class="panel_label"><h4 class="left">Bio</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php   if ($form['body_field']['body']['#default_value'] == ''): ?>
    <p class="left" id="change_bio_val">You currently have no bio.</p>
    <?php else: ?>
    <p class="left" id="change_bio_val"><?php print ($form['body_field']['body']['#default_value']);?></p>
    <?php endif; ?>
  </div>
  <div class="panel_content hidden">
    <div class="quick-edit-form">
      <p>Your description must be between 250 and 1000 characters.</p>

      <?php $form['body_field']['body']['#title'] = t ('');
      $form['body_field']['body']['#resizable'] = false;
      $form['body_field']['body']['#rows'] = 5;
      print drupal_render ($form['body_field']['body']);  ?>

      <div class="button-group">
        <?php $form['buttons']['submit_profilebody'] = array(
        '#id'                       => 'edit-submit',
        '#type'                     => 'submit',
        '#access'                   => '1',
        '#value'                    => t ('save'),
        '#submit'                   => array('node_form_submit', 'ajax_submitter'),
        '#access'                   => '1',
        '#attributes'               => Array('class'=> 'small-alt-button update-settings-btn ajax-trigger'),
        '#parents'                  => Array('submit'),
        '#array_parents'            => Array('buttons', 'submit'),
        '#executes_submit_callback' => '1',
        '#process'                  => Array('form_expand_ahah')
      );
        print drupal_render ($form['buttons']['submit_profilebody']);?>

        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>
  </div>
</div>
<!-- location -->
<div class="panel settings show_link" id="per_change_contactinfo">

  <div class="panel_label"><h4 class="left">Contact</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php   if ($form['locations'][0]['#default_value']['street'] == ''): ?>
    <p class="left" id="change_membership_val"><em>You currently have no contact information.</em></p>
    <?php else: ?>
    <p class="left" id="change_membership_val"><em><?php
      Print($form['locations'][0]['#default_value']['name'] . '<br>' . $form['locations'][0]['#default_value']['street'] . '<br>' . $form['locations'][0]['#default_value']['additional'] . '<br>' . $form['locations'][0]['#default_value']['city'] . ', ' . $form['locations'][0]['#default_value']['province_name'] . ' - ' . $form['locations'][0]['#default_value']['postal_code'] . '<br>' . $form['locations'][0]['#default_value']['country_name'] . '<br>' . $form['locations'][0]['#default_value']['phone']); ?></em>
    </p>
    <?php endif; ?>
  </div>
  <div class="panel_content hidden">
    <div class="company-contact-information quick-edit-form sub-form-element">
      <?php $form['locations'][0]['value']['#title'] = t ('');
      print drupal_render ($form['locations']); ?>
      <div class="button-group">
        <?php $form['buttons']['submit_profilelocation'] = array(
        '#id'                       => 'edit-submit',
        '#type'                     => 'submit',
        '#access'                   => '1',
        '#value'                    => t ('save'),
        '#submit'                   => array('node_form_submit', 'ajax_submitter'),
        '#access'                   => '1',
        '#attributes'               => Array('class'=> 'small-alt-button update-settings-btn ajax-trigger'),
        '#parents'                  => Array('submit'),
        '#array_parents'            => Array('buttons', 'submit'),
        '#executes_submit_callback' => '1',
        '#process'                  => Array('form_expand_ahah')
      );
        print drupal_render ($form['buttons']['submit_profilelocation']);?>

        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>

  </div>
</div>
<!--Website -->
<div class="panel settings show_link" id="per_change_website">

  <div class="panel_label"><h4 class="left">Website</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php   if ($form['#node']->field_per_website[0]['url'] == ''): ?>
    <p class="left" id="change_membership_val">You currently have no website.</p>
    <?php else: ?>
    <p class="left" id="change_membership_val"><a><?php print ($form['#node']->field_per_website[0]['url']); ?></a></p>
    <?php endif; ?>
  </div>
  <div class="panel_content hidden">
    <div class="quick-edit-form">
      <div class="element">
        <?php $form['field_per_website'][0]['url']['#title'] = t ('URL');
        $form['field_per_website'][0]['url']['#attributes'] = array('class'=> 'field');
        print drupal_render ($form['field_per_website'][0]['url']);     ?>
      </div>
      <div class="button-group">
        <?php $form['buttons']['submit_profilewebsite'] = array(
        '#id'                       => 'edit-submit',
        '#type'                     => 'submit',
        '#access'                   => '1',
        '#value'                    => t ('save'),
        '#submit'                   => array('node_form_submit', 'ajax_submitter'),
        '#access'                   => '1',
        '#attributes'               => Array('class'=> 'small-alt-button update-settings-btn ajax-trigger'),
        '#parents'                  => Array('submit'),
        '#array_parents'            => Array('buttons', 'submit'),
        '#executes_submit_callback' => '1',
        '#process'                  => Array('form_expand_ahah')
      );
        print drupal_render ($form['buttons']['submit_profilewebsite']);?>

        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>
  </div>
</div>

<!-- Social Nw -->
<div class="panel settings show_link" id="per_change_social">

  <div class="panel_label"><h4 class="left">Social networks</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php   if ($form['#node']->field_per_facebook[0]['url'] == '' && $form['#node']->field_per_linkedin[0]['url'] == '' && $form['#node']->field_per_twitter[0]['url'] == ''): ?>
    <p class="left" id="change_membership_val">You currently have no social networks.</p>
    <?php else: ?>
    <ul class="social-network-list">
      <?php if ($form['#node']->field_per_facebook[0]['url'] != '') : ?>

      <li class="facebook"><a><?php print $form['#node']->field_per_facebook[0]['url'] ?></a></li>
      <?php endif;?>
      <?php if ($form['#node']->field_per_twitter[0]['url'] != ''): ?>

      <li class="twitter"><a><?php print $form['#node']->field_per_twitter[0]['url'] ?></a></li>
      <?php endif;?>
      <?php if ($form['#node']->field_per_linkedin[0]['url'] != ''): ?>

      <li class="linkedin"><a><?php print $form['#node']->field_per_linkedin[0]['url'] ?></a></li>
      <?php endif;?>
    </ul>
    <?php endif; ?>
  </div>
  <div class="panel_content hidden">
    <div class="quick-edit-form" id="social-network-edit-form">
      <p>Paste in URL of social network page to include in profile.</p>

      <div class="element">
        <label class="left social">
          <img alt="Facebook" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/facebook_16.png'?>">
        </label>
        <?php $form['field_per_facebook'][0]['url']['#title'] = t ('');
        $form['field_per_facebook'][0]['url']['#attributes'] = array('class'=> 'field xlg');
        print drupal_render ($form['field_per_facebook'][0]['url']);     ?>
      </div>
      <div class="element">
        <label class="left social">
          <img alt="Twitter" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/twitter_16.png'?>">
        </label>
        <?php $form['field_per_twitter'][0]['url']['#title'] = t ('');
        $form['field_per_twitter'][0]['url']['#attributes'] = array('class'=> 'field xlg');
        print drupal_render ($form['field_per_twitter'][0]['url']);     ?>
      </div>
      <div class="element">
        <label class="left social">
          <img alt="LinkedIn" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/linkedin_16.png'?>">
        </label>
        <?php $form['field_per_linkedin'][0]['url']['#title'] = t ('');
        $form['field_per_linkedin'][0]['url']['#attributes'] = array('class'=> 'field xlg');
        print drupal_render ($form['field_per_linkedin'][0]['url']);     ?>
      </div>

      <div class="button-group">
        <?php $form['buttons']['submit_profilesocialnetwork'] = array(
        '#id'                       => 'edit-submit',
        '#type'                     => 'submit',
        '#access'                   => '1',
        '#value'                    => t ('save'),
        '#submit'                   => array('node_form_submit', 'ajax_submitter'),
        '#access'                   => '1',
        '#attributes'               => Array('class'=> 'small-alt-button update-settings-btn ajax-trigger'),
        '#parents'                  => Array('submit'),
        '#array_parents'            => Array('buttons', 'submit'),
        '#executes_submit_callback' => '1',
        '#process'                  => Array('form_expand_ahah')
      );
        print drupal_render ($form['buttons']['submit_profilesocialnetwork']);?>

        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>
  </div>
</div>


<div class="panel settings show_link" id="per_change_admin">
  <div class="panel_label"><h4 class="left">Admin</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_content hidethis">
    <div class="quick-edit-form">
      <div class="element">
        <?php
        //	print drupal_render($left_sidebar);
        //	print drupal_render($right_sidebar);
        print drupal_render ($form); ?>
      </div>
      <div class="button-group">
        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>
  </div>
</div>

</div>


</div>

