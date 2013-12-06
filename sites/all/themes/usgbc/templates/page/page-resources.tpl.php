<?php
// $Id: page.tpl.php 7027 2011-10-18 16:54:26Z pnewswanger $
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */

include('page_inc/page_top.php'); ?>
<?php $pageurl = $_SERVER["REQUEST_URI"]; ?>
<?php $currenturl = explode("?", $_SERVER['REQUEST_URI']);

if($currenturl[0] != '/credits'): ?>

<div id="content" class="twoColRight">

      <div id='navCol' class='clearfix'>
		          <?php 
					$view = views_get_view('menu_resources');
					$view->set_items_per_page(0);
			   		$view->execute('default');
					foreach($view->result as $cat){
						$cat_name = $cat->term_data_node_data_field_res_type_name;
						$unique_categories[$cat_name] = $cat_name;
					}

				?>
        <div class="menu-block-18 menu-name-primary-links parent-mlid-0 menu-level-3">
  			<ul class="menu">
				<li class="first leaf menu-mlid-3005 dhtml-menu ">
				<?php if($path_args[1] == 'list') {?>	
					<a href="/resources/<?php print $path_args[1];?>" id="dhtml_menu-3005" 
				<?php } else if(inStr($pageurl,'favorites')) {?>
					<a href="/resources/grid/favorites" id="dhtml_menu-3005" 
				<?php } else { ?>	
					<a href="/resources" id="dhtml_menu-3005" 
				<?php } ?>
						<?php if((!$path_args[1] || $path_args[1]=='list' || $path_args[1]=='grid') && !$path_args[3]):?> class="active" <?php endif;?>>All</a></li>	
			<?php
				foreach($unique_categories as $category){
					$category_name = $category;
					$category_argument = str_replace('&', '%26', usgbc_dashencode($category_name));
			?>
				<li class="leaf menu-mlid-3005 dhtml-menu ">
					<?php if(inStr($pageurl,'list')){?>
						<a href="/resources/list/<?php print $category_argument;?>" id="dhtml_menu-3005" 
					<?php } else if(inStr($pageurl,'favorites')) {?>
						<a href="/resources/grid/favorites/<?php print $category_argument;?>" id="dhtml_menu-3005" 
							
					<?php } else { ?>
						<a href="/resources/<?php print $category_argument;?>" id="dhtml_menu-3005" 
					<?php } ?>
						<?php if(inStr($pageurl,usgbc_dashencode($category_name))):?> class="active" <?php endif;?>><?php print $category_name;?></a></li>
			<?php }?>
			</ul>
		</div>
		<?php include('page_inc/saved_search_nav.php');?>		
      </div>

      	<div class="subcontent-wrapper">
      			<div id="mainCol">
      				<?php print $content; ?>
      			</div>
      	</div>

</div><!--content-->

<?php else: ?>

<div id="content" class="oneCol">
      <?php print $content; ?>
</div><!--content-->

<?php endif; ?>


<?php include('page_inc/page_bottom.php'); ?>


