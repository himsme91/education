<?php include('page_inc/page_top.php'); ?>

<div class="twoColRight" id="content">
<?php  $ratingsystemTerms =  taxonomy_get_tree(TAXID_RATINGSYSTEM);
				/*	$view = views_get_view('menu_projects');
					$view->set_items_per_page(0);
			   		$view->execute('default');

					foreach($view->result as $cat){
						$cat_name = $cat->term_data_node_data_field_prjt_rating_system_name;
						if ($cat_name != ''){
						$unique_categories[$cat_name] = $cat_name;
						}
					} */

				?>
  <div id="navCol"  class='clearfix'>
  		          
        <div class="menu-block-18 menu-name-primary-links parent-mlid-0 menu-level-3">
  			<ul class="menu">
				<li class="first leaf menu-mlid-3005 dhtml-menu ">
				<?php if($path_args[1] == 'list') {?>	
					<a href="/projects/<?php print $path_args[1];?>" id="dhtml_menu-3005" 
				<?php } else { ?>	
					<a href="/projects" id="dhtml_menu-3005" 
				<?php } ?>
						<?php if((!$path_args[1] || $path_args[1]=='list' || $path_args[1]=='grid') && !$path_args[2]):?> class="active" <?php endif;?>>All</a></li>	
			<?php
			//$unique_categories = usort($unique_categories,"sort_array");
			
				foreach($ratingsystemTerms as $category){
					$category_name = $category->name;
					$category_argument = str_replace('&', '%26', usgbc_dashencode($category_name));
			?>
				<li class="leaf menu-mlid-3005 dhtml-menu ">
					<?php if(inStr($pageurl,'list')){?>
						<a href="/projects/list/<?php print $category_argument;?>" id="dhtml_menu-3005" 
						<?php if(strtolower(str_replace('%26', '&', $path_args[2])) == strtolower(usgbc_dashencode($category_name))):?> class="active" <?php endif;?>><?php echo ($category->description != '') ? $category->description : $category->name;?></a></li>
					<?php }else { ?>
						<a href="/projects/<?php print $category_argument;?>" id="dhtml_menu-3005" 
						<?php if(strtolower(str_replace('%26', '&', $path_args[1])) == strtolower(usgbc_dashencode($category_name))):?> class="active" <?php endif;?>><?php echo ($category->description != '') ? $category->description : $category->name;?></a></li>
					<?php } ?>
				<?php }?>
			</ul>
  		</div>
    
    <?php // if (!empty($section_sub_menu)) print $section_sub_menu; ?>
    <?php include('page_inc/saved_search_nav.php');?>
  </div>
  <div class="subcontent-wrapper">
    <div id="mainCol">
      <?php print $content; ?>
    </div>
  </div>
</div>

<?php include('page_inc/page_bottom.php'); ?>
