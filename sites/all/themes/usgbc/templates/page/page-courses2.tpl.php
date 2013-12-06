<?php
  // $Id: page-courses.tpl.php 29945 2012-08-06 17:10:38Z pkhanna $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */
  $path = drupal_get_path_alias($_GET['q']);

  $menu_block = module_invoke ('menu_block', 'block', 'view', 21);
  $section_sub_menu = $menu_block['content'];

  $styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/courses.css" />';

  include('page_inc/page_top.php'); ?>
		
  <div id="content" class="twoColRight">

     <div id='navCol' class='clearfix'>
		          <?php 
					$view = views_get_view('menu_coursetypes');
					$view->set_items_per_page(0);
			   		$view->execute('default');
					foreach($view->result as $cat){
						$cat_name = $cat->term_data_node_data_field_crs_fmt_name;
						$unique_categories[$cat_name] = $cat_name;
					}

				?>
        <div class="menu-block-18 menu-name-primary-links parent-mlid-0 menu-level-3">
  			<ul class="menu">
				<li class="first leaf menu-mlid-3005 dhtml-menu ">
				<?php if($path_args[1] == 'list') {?>	
					<a href="/courses/<?php print $path_args[1];?>" id="dhtml_menu-3005" 
				<?php } else if(inStr($pageurl,'favorites')) {?>
					<a href="/coursesfavorites" id="dhtml_menu-3005" 
				<?php } else { ?>	
					<a href="/courses" id="dhtml_menu-3005" 
				<?php } ?>
						<?php if((!$path_args[1] || $path_args[1]=='list' || $path_args[1]=='grid') && !$path_args[3]):?> class="active" <?php endif;?>>All</a></li>	
			<?php
				foreach($unique_categories as $category){
					$category_name = $category;
					$category_argument = str_replace('&', '%26', usgbc_dashencode($category_name));
			?>
				<li class="leaf menu-mlid-3005 dhtml-menu ">
					<?php if(inStr($pageurl,'list')){?>
						<a href="/courses/<?php print $category_argument;?>" id="dhtml_menu-3005" 
					<?php } else if(inStr($pageurl,'favorites')) {?>
						<a href="/courses/<?php print $category_argument;?>" id="dhtml_menu-3005" 

					<?php } else { ?>
						<a href="/courses/<?php print $category_argument;?>" id="dhtml_menu-3005" 
					<?php } ?>
						<?php if(inStr($pageurl,usgbc_dashencode($category_name))):?> class="active" <?php endif;?>><?php print $category_name;?></a></li>
			<?php }?>
			</ul>
		</div>
		<?php include('page_inc/saved_search_nav.php');?>
		<div class="emphasized-box">
			<h5>Full course list</h5>
			<p>Go to GBCI's course catalog for the full list of courses approved for LEED credential maintenance.<p>
			<a target="_blank" class="button" href="http://www.gbci.org/erp/coursecatalog/index.aspx">View</a>
		</div>				
      </div>

    <div class="subcontent-wrapper">
      <div id="mainCol">
        <?php print $content; ?>
      </div>
    </div>

  </div><!--content-->
<?php include('page_inc/page_bottom.php'); ?>
