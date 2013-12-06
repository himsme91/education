<?php
  // $Id: page-nodetype-publication.tpl.php 7043 2011-10-18 17:47:46Z jmehta $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */
dsm($node);
  $styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/store.css" />';

  include('page_inc/page_top.php'); ?>

<div id="content">

  <div class="store-item-images" id="navCol">
    <img alt="" src="<?php print file_create_url ($node->field_pubs_feature_image[0]['filepath']);?>" class="main-img">
    <!-- 	<div class="additional-img">

        			<?php //print $node->field_pubs_slideshow_image[0]['view']?>
        		</div>  -->
  </div>

  <div id="mainCol">
    <?php print $content; ?>
  </div>

  <div id="sideCol">
    <div class="purchase-options">

    
    <?php 
 //   dsm($node);
    //if ($node->sell_price > 0) :?>
    
      <a class="jumbo-button-dark" href="" onclick="document.forms.add_to_cart.submit();return false;">Add to cart</a>
      
    <?php // endif; ?>

      <?php print $node->content['vud_node_widget_display']['#value']; ?>

      <div class="sbx">
        <?php
        $viewname = 'servicelinks';
        $args = array();
        $args[0] = $node->nid;
        $display_id = 'page_2';
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
