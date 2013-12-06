<?php
  // $Id: page-nodetype-application.tpl.php 13434 2012-01-27 16:09:05Z pnewswanger $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */
  $styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/apps.css" />';
?>

<?php
  include('page_inc/page_top.php'); ?>

<div id="content">

  <div id="navCol">
    <img src="/<?php print $node->field_app_image[0]['filepath'];?>">
    <?php global $users;?>
    <?php if (!$user->uid): ?>
    <p class="small"><a href="/user/login?destination=<?php $node->path;?>" class="jqm-form-trigger">Sign in</a> to add to
      favorites.</p>
    <?php else: ?>
    <?php print flag_create_link ('favorites', $node->nid); ?>
    <?php endif;?>

  </div>

  <div class="subcontent-wrapper">
    <div id="mainCol">
      <?php print $content; ?>
    </div>

    <div id="sideCol">
      <?php if ((!empty($node->field_app_file[0]['filepath'])) || (!empty($node->field_app_website[0]['url'])) || (!empty($node->field_app_itunelink[0]['url']))) : ?>

      <div class="purchase-options">

        <?php if ((!empty($node->field_app_file[0]['filepath'])) || (!empty($node->field_app_website[0]['url']))) : ?>
        <div class="section">

          <?php

          if (!empty($node->field_app_file[0]['filepath'])) {
            $downloadlink = "<a target='_blank' href='";
            $downloadlink .= "/";
            $downloadlink .= $node->field_app_file[0]['filepath'];
            $downloadlink .= "' class='jumbo-button-dark'>Download";

            if (!empty($node->field_app_noofdownload[0]['view'])) {
              $downloadlink .= "<span class='downloads'>";
              $downloadlink .= $node->field_app_noofdownload[0]['view'];
              $downloadlink .= " downloads</span>";
            }
            $downloadlink .= "</a>";
            print $downloadlink;
          }
          ?>

          <?php

          if (!empty($node->field_app_website[0]['url'])) {
            $websitelink = "<a target='_blank' href='";
            $websitelink .= $node->field_app_website[0]['url'];
            $websitelink .= "' class='jumbo-button-dark'>Visit website";

            $websitelink .= "</a>";
            print $websitelink;
          }

          ?>
        </div>
        <?php endif;?>


        <?php if (!empty($node->field_app_itunelink[0]['url'])): ?>
        <div class="aside">
          <div class="section">
            <?php
            if (!empty($node->field_app_itunelink[0]['url'])) {
              $itunelink = "<a target='_blank' href='";
              $itunelink .= $node->field_app_itunelink[0]['url'];
              $itunelink .= "' class='jumbo-button-dark'>Get the app";

              $itunelink .= "</a>";
              print $itunelink;
            }
            ?>
            <?php if (!empty($node->field_app_itunelink[0]['url'])) : ?>
            <p>From <strong>iTunes</strong></p>
            <?php endif?>

          </div>

          <?php if (!empty($node->field_app_itunelink[0]['url'])) : ?>
          <div class="itune">
            <a target="_blank" href="<?php echo $node->field_app_itunelink[0]['url']; ?>">
              <img alt="" src="/sites/all/themes/usgbc/lib/img/fpo-prototype/itunes.gif"></a>
          </div>
          <?php endif?>


        </div>
        <?php endif;?>
      </div>
      <?php endif?>

      <div class="sbx">
        <?php


        $viewname = 'servicelinks';
        $args = array();
        $args[0] = $node->nid;
        $display_id = 'page_1';
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?>


      </div>

      <div class="section">
        <?php

        $viewname = 'Apps';
        $args = array();
        $args [0] = (string)$node->field_app_type[0]['view'];
        $args [1] = $node->nid;
        $display_id = 'page_3'; // or any other display
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?>
      </div>
    </div>


  </div>

</div><!--content-->


<?php include('page_inc/page_bottom.php'); ?>
