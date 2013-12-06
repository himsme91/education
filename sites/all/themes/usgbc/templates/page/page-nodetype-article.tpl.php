<?php
  // $Id: page-nodetype-article.tpl.php 6900 2011-10-17 22:43:44Z pnewswanger $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */

  $channel = $node->field_art_channel[0]['view'];
	
  $styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/directory.css" />';
  $styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/blog.css" />';
  $scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/channelswitch.js"></script>';


  include('page_inc/page_top.php'); ?>
  
<style type="text/css">
.key-image[rel="image-gallery"]:hover:before, .key-image[rel="image-gallery"]:active:before {
    height: 173px;
    width: 658px;
}
.key-image img {
    width: 658px;
}
</style>

<div id="content">
  <div id="blog" class="oneCol">
    <?php //print views_embed_view('ArticleView', 'page_10', $channel); ?>
    <div class="bg-agsort">
      <h3><?php echo $channel;?></h3>

      <ul class="sort-layout">
        <li>
          <a href="/articles/archive<?php if ($channel != NULL) echo '/' . usgbc_dashencode(strtolower ($channel)); ?>" title="archive">
            <strong class="archive">Archive</strong>
          </a>
        </li>

        <li>
          <a href="/articles/grid<?php if ($channel != NULL) echo '/' . usgbc_dashencode(strtolower ($channel)); ?>" title="grid view">
            <strong class="grid">Grid</strong>
          </a>
        </li>
        <li>
          <a href="/articles<?php if ($channel != NULL) echo '/' . usgbc_dashencode(strtolower ($channel)); ?>" title="list view">


            <strong class="list">List</strong>
          </a>
        </li>
      </ul>


    </div>

    <div class="entry-column">
      <?php print $content; ?>
    </div>

    <div class="secondary-column">
      <div class="sbx">
        <?php
        $viewname = 'servicelinks';
        $args = array();
        $args[0] = $node->nid;
        $display_id = 'page_1'; // or any other display
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?>
      </div>


      <div class="bg-column bg-grid">
        <?php

        $viewname = 'ArticleView';
        $args = array($channel);

        $args [0] = 'all';
        $args [1] = $node->nid;
        $args [2] = $node->nid;
        $display_id = 'page_8'; // or any other display
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?>
        <?php

        $viewname = 'ArticleView';
        $args = array($channel);

        $args [0] = (string)$node->field_art_channel[0]['view'];
        $args [1] = $node->nid;
        $display_id = 'page_8'; // or any other display
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
