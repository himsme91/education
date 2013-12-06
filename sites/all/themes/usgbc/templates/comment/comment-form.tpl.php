  <?php global $user;?>
  <?php if($user->uid):?> 
  <script type="text/javascript">
    function cleartext() {
      document.getElementById('edit-comment').value = "";
    }
  </script>
<?php
  $path = drupal_get_path_alias ($_GET['q']);
  $path_args = explode ('/', $path);

  if ($path_args[1] == 'edit'):

    $usertitle = '';
    $user_profile_img = 'sites/default/files/placeholder/person_placeholder.png';

    if ($form['uid']['#value']) {
      $person = content_profile_load ('person', $form['uid']['#value']);
      if ($person->nid) {

        $usertitle = $person->title;
        $usertitle .= ', ' . $person->field_per_orgname[0]['value'];

        if ($person->field_per_profileimg[0]['filepath'] != '') {
          $user_profile_img = $person->field_per_profileimg[0]['filepath'];
        }

      }

    }

    ?>

  <div class="loggedIn_true">
    <h3>Edit comment</h3>

    <div class="lower-comment">
      <?php print theme ('imagecache', 'fixed_060-060', $user_profile_img, $alt, $title, $attributes); ?>
      <h4 class="username"><?php print $usertitle;?></h4>
      <p class="comment-area">

        <!--  <label>Comment</label> -->
        <?php
        $form['comment_filter']['comment']['#required'] = FALSE;
        $form['comment_filter']['comment']['#title'] = t ('');
        $form['comment_filter']['comment']['#attributes'] = Array('class'=> 'field');
        print drupal_render ($form['comment_filter']['comment']); ?>

      </p>
      <?php if ($form['fivestar_rating']): ?>
      <p class="rating-form">
        <?php print drupal_render ($form['fivestar_rating']); ?>
      </p>
      <?php endif;?>
      <div class="button-group">
        <?php
        $form['submit']['#attributes'] = Array('class'=> 'small-alt-button');
        print drupal_render ($form['submit']); ?>
      </div>
    </div>
  </div>

  <div class="hidden">
    <?php  print drupal_render ($form); ?>
  </div>

  <?php else: ?>
  <div class="loggedIn_true">
    <h3>Leave a comment</h3>

    <div class="lower-comment">
      <?php
      $person = content_profile_load ('person', $user->uid);   ?>
      <?php if ($form['_author']['#value'] != ""): ?>
      <p class="small right">
        Not <?php print $person->field_per_fname[0]['value'];?>?
        <a href="/logout#comment-form">Sign out</a></p>
      <?php endif;?>

      <?php
      if ($person->field_per_profileimg[0]['filepath'] == '') {
        $user_profile_img = 'sites/default/files/placeholder/person_placeholder.png';
      } else {
        $user_profile_img = $person->field_per_profileimg[0]['filepath'];
      }
      print theme ('imagecache', 'fixed_060-060', $user_profile_img, $alt, $title, $attributes);
      ?>


      <h4 class="username"><?php print $person->field_per_fname[0]['value'];?> <?php print $person->field_per_lname[0]['value'];?></h4>

      <p class="comment-area">

        <!--  <label>Comment</label> -->
        <?php
        $form['comment_filter']['comment']['#required'] = FALSE;
        $form['comment_filter']['comment']['#title'] = t ('');
        $form['comment_filter']['comment']['#attributes'] = Array('class'=> 'field');
        $form['comment_filter']['comment']['#value'] = t ('Enter your comment');
        $form['comment_filter']['comment']['#wrapper'] = false;
        print drupal_render ($form['comment_filter']['comment']); ?>

      </p>
      <?php if ($form['fivestar_rating']): ?>
      <p class="rating-form">
        <?php print drupal_render ($form['fivestar_rating']); ?>
      </p>
      <?php endif;?>
      <div class="button-group">
        <?php
        //$form['submit']['#value'] = t('Submit');
        $form['submit']['#attributes'] = Array('class'=> 'small-alt-button');
        print drupal_render ($form['submit']); ?>
        <a href="javascript: cleartext();" class="small-button-note reset-form">Reset</a>
      </div>
    </div>
  </div>
  
   <div class="hidden">
    <?php  print drupal_render ($form); ?>
  </div>

  <?php endif; ?>
<?php endif;?>