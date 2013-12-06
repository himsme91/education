<?php

  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */
  include('page_inc/page_top.php'); 
  
  $sell_price = $node->sell_price ;
  
?>
<div id="content">

  <div id="navCol">
  <?php if ($node->field_res_profileimage[0]['filepath']) {?>
    <img class="resource-img" src="<?php print file_create_url ($node->field_res_profileimage[0]['filepath']);?>">
<?php } else {
	print '<img class="resource-img" src="/sites/all/themes/usgbc/lib/img/resource-icons/placeholder-document.gif"></img>';
}?>
    
    
    <?php print flag_create_link ('favorites', $node->nid); ?>

  </div>

 <div class="subcontent-wrapper">
    <div id="mainCol">
      <?php print $content; ?>
    </div>  
 
   <div id="sideCol">
    
        <div class="purchase-options">
 			<div class="addtocart">
			    <?php  if ($sell_price > 0) :?>
		    	  <a class="jumbo-button-dark" href="" onclick="document.forms.add_to_cart.submit();return false;">Add to cart</a>
		    	<?php endif; ?>
	    	</div>
        </div>
  		
  		<div class="section-library section-apps">
        	<?php print $node->content['vud_node_widget_display']['#value']; ?>
      	</div>
  		
  		<div class="sbx">
	        <?php
	        $viewname = 'servicelinks';
	        $display_id = 'page_2';
	        $args[0] = $node->nid;
	        $view = views_get_view ($viewname);
	        $view->set_display ($display_id);
	        $view->set_arguments ($args);
	        print $view->preview ();
	        ?>
	    </div>
    </div>
 </div>
</div>
  
<?php include('page_inc/page_bottom.php'); 