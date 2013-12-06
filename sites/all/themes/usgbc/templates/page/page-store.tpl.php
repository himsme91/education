<?php
  // $Id: page-course.tpl.php 6782 2011-10-17 14:09:44Z jmehta $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */

  $styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/store.css" />';


  include('page_inc/page_top.php'); ?>

<div class="twoColRight" id="content">

  <div id="navCol">
    <?php 
					$view = views_get_view('menu_store');
					$view->set_items_per_page(100);
			   		$view->execute('default');
					foreach($view->result as $cat){
						$cat_name = $cat->term_data_node_data_field_res_type_name;
						$unique_categories[$cat_name] = $cat_name;
					}

				?>
        <div class="menu-block-18 menu-name-primary-links parent-mlid-0 menu-level-3">
  			<ul class="menu">
				<li class="first leaf menu-mlid-3005 dhtml-menu ">
					<a href="/store" id="dhtml_menu-3005" 
					<?php if(!$path_args[1]):?> class="active" <?php endif;?>>All</a>
				</li>	
			<?php
				foreach($unique_categories as $category){
					$category_name = $category;
					$category_argument = str_replace('&', '%26', usgbc_dashencode($category_name));
			?>
				<li class="leaf menu-mlid-3005 dhtml-menu ">
					<a href="/store/resource/<?php print $category_argument;?>" id="dhtml_menu-3005" 
					<?php if(inStr($pageurl,usgbc_dashencode($category_name))):?> class="active" <?php endif;?>><?php print $category_name;?></a></li>
			<?php }?>
			
				
				<li class="leaf menu-mlid-3005 dhtml-menu" >
				<a href="/store/merchandise" <?php if(inStr($pageurl, 'merchandise')):?> class="active" <?php endif;?> >Merchandise</a>
				</li>
				
				<li class="leaf menu-mlid-3005 dhtml-menu" >
				<a href="/store/all/all/kindle" <?php if(inStr($pageurl, 'kindle')):?> class="active" <?php endif;?> >Kindle version</a>
				</li>
			</ul>
		</div>




  </div>
  <div class="subcontent-wrapper">
    <div id="mainCol">
      <?php print $content; ?>
    </div>
  </div>
</div>

<?php include('page_inc/page_bottom.php'); ?>
