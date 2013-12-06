<?php
// $Id: page.tpl.php 7027 2011-10-18 16:54:26Z pnewswanger $
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */
$styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/css/section/leed.css" />';
//$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/section/leed.js"></script>';

//Turn off page caching
$GLOBALS['conf']['cache'] = FALSE;
unset($_SESSION['pilot-credit']);
unset($_SESSION['rpc']);
unset($_SESSION['return_link']);

include('page_inc/page_top.php'); ?>
	<?php	$ratingsystemTerms =  taxonomy_get_tree(TAXID_RATINGSYSTEM);
			$ratingsystemVersions =  taxonomy_get_tree(TAXID_RATINGSYSTEMVERSION);
	
		/*	$view = views_get_view('leed_rating_systems');
			$view->set_items_per_page(0);
			if (user_access("create credit_definition content")){
				$view->execute('page_3');
			} else {
				$view->execute('page_3');
			}
			foreach($view->result as $cat){
				$rating_sys = $cat->term_data_node_data_field_credit_rating_system_name;
				if ($rating_sys != ''){
					$unique_rating_systems[$rating_sys] = $rating_sys;
				}
			} */ ?>
	<?php /*	$view = views_get_view('leed_rating_systems');
			$view->set_items_per_page(0);
			if (user_access("create credit_definition content")){
				$view->execute('page_4');
			} else {
				$view->execute('page_4');
			}
			foreach($view->result as $cat){
				$rating_sys_version = $cat->term_data_node_data_field_credit_rating_sys_version_name;
				if ($rating_sys_version != ''){
					$unique_rating_sys_version[$rating_sys_version] = $rating_sys_version;
				}
			} */ ?>
<?php $currenturl = explode("?", $_SERVER['REQUEST_URI']);
if($currenturl[0] != '/credits' || (isset($_SESSION['leed_rating_system']) && isset($_SESSION['leed_rating_sys_version']))): ?>
<?php  //print $breadcrumb;

if ($path_args[1]) $_SESSION['leed_rating_system'] = $path_args[1];
if ($path_args[2]) $_SESSION['leed_rating_sys_version'] = $path_args[2];
if ($path_args[3]) {
	$_SESSION['leed_category'] = $path_args[3];
}else{
	if($currenturl[0] != '/credits'){
		$_SESSION['leed_category'] = null;
	}
}

$leed_rating_system_path = $_SESSION['leed_rating_system'];
$leed_rating_sys_version_path = $_SESSION['leed_rating_sys_version'];
$leed_category = $_SESSION['leed_category'];

if(!$leed_rating_system_path) $leed_rating_system_path = '';
if(!$leed_rating_sys_version_path) $leed_rating_sys_version_path = '';	
if(!$leed_category) $leed_category = '';

?>
<?php	$view = views_get_view('leed_rating_systems');
		$view->set_arguments(array($leed_rating_sys_version_path));
			$view->set_items_per_page(0);
			if (user_access("create credit_definition content")){
				$view->execute('page_3');
			} else {
				$view->execute('page_3');
			}
			foreach($view->result as $cat){
				$rating_sys = $cat->term_data_node_data_field_credit_rating_system_name;
				if ($rating_sys != ''){
					$available_rating_systems[$rating_sys] = $rating_sys;
				}
			}  ?>
	<?php	$view = views_get_view('leed_rating_systems');
			$view->set_arguments(array($leed_rating_system_path));
			$view->set_items_per_page(0);
			if (user_access("create credit_definition content")){
				$view->execute('page_4');
			} else {
				$view->execute('page_4');
			}
			foreach($view->result as $cat){
				$rating_sys_version = $cat->term_data_node_data_field_credit_rating_sys_version_name;
				if ($rating_sys_version != ''){
					$available_rating_sys_version[$rating_sys_version] = $rating_sys_version;
				}
			} ?>
	<div class="credit-lib-nav ">
		<h4>Filter credits</h4>
		<?php foreach($ratingsystemTerms as $rating_system){
				$rating_sys_name = $rating_system->name;
 				if( strtolower(str_replace('-',' ',$rating_sys_name)) == strtolower(str_replace('-',' ',str_replace('%26','&', $leed_rating_system_path)))){
 					$rating_system_selection = 	$rating_sys_name;
 					$rating_system_selection_description = $rating_system->description;
 				}
			  }
		?>
		
	    <div class="cred-system drop-menu">
			<a data-url="<?php echo  str_replace('&', '%26', usgbc_dashencode($rating_system_selection));?>" href="#" class="placeholder"><?php print $rating_system_selection_description;?></a>
			<ul class="drop-panel">
				<?php foreach($ratingsystemTerms as $rating_system){
					$rating_sys_name = $rating_system->name;
					$rating_sys_name_argument = str_replace('&', '%26', usgbc_dashencode($rating_sys_name));
				?>
				<?php if (in_array($rating_sys_name, $available_rating_systems)):?>
				<li <?php if( strtolower(str_replace('-',' ',$rating_sys_name)) == strtolower(str_replace('-',' ',str_replace('%26','&', $leed_rating_system_path)))):?> class="active" <?php endif;?>><a data-url="<?php echo $rating_sys_name_argument;?>" href="#"><?php echo ($rating_system->description != '') ? $rating_system->description : $rating_system->name;?></a></li>
				<?php else: ?>
				<li <?php if( strtolower(str_replace('-',' ',$rating_sys_name)) == strtolower(str_replace('-',' ',str_replace('%26','&', $leed_rating_system_path)))):?> class="active" <?php endif;?>><a data-url="<?php echo $rating_sys_name_argument;?>" class="not-available" href="#"><?php echo ($rating_system->description != '') ? $rating_system->description : $rating_system->name;?></a></li>
				<?php endif;?>
				
				<?php }?>

			</ul>
		</div>
	    		
	    <div class="cred-version drop-menu">		    		
	    	<a href="#" class="placeholder"><?php print str_replace('-',' ',$leed_rating_sys_version_path);?></a>
			<ul class="drop-panel">
				<?php foreach($ratingsystemVersions as $rating_sys_version){
					$rating_sys_version_name = $rating_sys_version->name;
					$rating_sys_version_name_argument = str_replace('&', '%26', usgbc_dashencode($rating_sys_version_name));
				?>
				<?php if (in_array($rating_sys_version_name, $available_rating_sys_version)):?>
				<li <?php if(strtolower(str_replace('-',' ',$leed_rating_sys_version_path)) == strtolower(str_replace('-',' ',$rating_sys_version_name))):?> class="active" <?php endif;?>><a href="#"><?php echo str_replace('-',' ',$rating_sys_version_name);?></a></li>
				<?php else:?>
				<li <?php if(strtolower(str_replace('-',' ',$leed_rating_sys_version_path)) == strtolower(str_replace('-',' ',$rating_sys_version_name))):?> class="active" <?php endif;?>><a class="not-available" href="#"><?php echo str_replace('-',' ',$rating_sys_version_name);?></a></li>
				<?php endif;?>
				
				<?php }?>
		 
		 <li class="hidden"><?php print str_replace('-',' ',str_replace('leed','LEED',$leed_rating_sys_version_path));?></li>
			</ul>
	    </div>
    </div>
<div id="content" class="twoColRight">

      <div id='navCol' class='clearfix'>

		          <?php
					$view = views_get_view('menu_credit_categories');
			   		$view->set_arguments(array($leed_rating_system_path,$leed_rating_sys_version_path));
					$view->set_items_per_page(100);
			   		$view->execute('default');
					foreach($view->result as $cat){
						$cat_name = $cat->term_data_node_data_field_credit_category_name;
						$unique_categories[$cat_name] = $cat_name;
					}

				?>
        <div class="menu-block-18 menu-name-primary-links parent-mlid-0 menu-level-3">
  			<ul class="menu">
				<li class="leaf menu-mlid-3005 dhtml-menu ">
					<a href="/credits/<?php print str_replace('&','%26',$leed_rating_system_path);?>/<?php print $leed_rating_sys_version_path;?>" id="dhtml_menu-3005"
						<?php if(!$leed_category):?> class="active" <?php endif;?>>All</a></li>

			<?php foreach($unique_categories as $category){
					$category_name = $category;
					$category_argument = str_replace('&', '%26', usgbc_dashencode($category_name));
			?>
				<li class="leaf menu-mlid-3005 dhtml-menu ">
					<a href="/credits/<?php print str_replace('&','%26',$leed_rating_system_path);?>/<?php print $leed_rating_sys_version_path;?>/<?php print $category_argument;?>" id="dhtml_menu-3005"
						<?php if($leed_category == usgbc_dashencode($category_name)):?> class="active" <?php endif;?>><?php print $category_name;?></a></li>
			<?php }?>
			</ul>
		</div>
    	<?php include('page_inc/saved_search_nav.php');?>
		<?php
		$rating_system_full_name = str_replace('-',' ',$leed_rating_system_path);
		$rating_system_full_name = str_replace('   ','-',$rating_system_full_name);		
		$search_string = $rating_system_full_name . ' ' . $leed_rating_sys_version_path;
		$search_url = "/resources?show_in_library=0&title=".$search_string;
		?>
		
		<?php if(!inStr($leed_rating_system_path, 'homes') && !inStr($leed_rating_system_path, 'mid-rise')){?>
			<div class="button-group">
				<a class="jumbo-button-dark" href="/dopdf.php?q=scorecard/<?php print $leed_rating_system_path?>/<?php print $_SESSION['leed_rating_sys_version'];?>">Download scorecard</a>
			</div>
		<?php }?>
		<?php if(inStr($_SESSION['leed_rating_sys_version'], '2009')){?>
			<div class="button-group">
				<a target="_blank" class="jumbo-button-dark" href="<?php print $search_url?>">Addenda</a>
			</div>
			
		<?php }?>
      </div>



      	<div class="subcontent-wrapper">
      			<div id="mainCol">
      				<?php print $content; ?>
      			</div>
      	</div>

</div><!--content-->

<?php else: ?>

<div id="content" class="oneCol">
		
	<div class="credit-lib-intro">
    	<h2>The LEED Credit Library</h2>
	    <h3>Access all LEED credit information &mdash; including language, addenda, resources, discussion threads and more.</h3>
	    <p>To get started, just choose a System and Version below. <br><a href="/leed/rating-systems">Not sure what Version?</a></p>
    </div>
	<div class="credit-lib-nav ">
		<h4>Filter credits</h4>
	    <div class="cred-system drop-menu">
			<a href="#" class="placeholder">Select a System</a>
			<ul class="drop-panel">
				<?php foreach($ratingsystemTerms as $rating_system){
					$rating_sys_name = $rating_system->name;
					$rating_sys_name_argument = str_replace('&', '%26', usgbc_dashencode($rating_sys_name));
				?>
				<li><a data-url="<?php echo $rating_sys_name_argument;?>" href="#"><?php echo ($rating_system->description != '') ? $rating_system->description : $rating_system->name;?></a></li>
				<?php }?>
			</ul>
		</div>
	    		
	    <div class="cred-version drop-menu">		    		
	    	<a href="#" class="placeholder">Select a Version</a>
			<ul class="drop-panel">
				<?php foreach($ratingsystemVersions as $rating_sys_version){
					$rating_sys_version_name = $rating_sys_version->name;
					$rating_sys_version_name_argument = str_replace('&', '%26', usgbc_dashencode($rating_sys_version_name));
				?>
				<li><a href="#"><?php echo $rating_sys_version_name;?></a></li>
				<?php }?>
			 
			</ul>
	    </div>
    </div>
	<div class="dotted-box ">
	    <p class="centered-text">Select a Version and System to view credits.</p>
    </div>

</div><!--content-->

<?php endif; ?>

<?php include('page_inc/page_bottom.php'); ?>

<script type="text/javascript">
	$(document).ready(function() {
		<?php if($currenturl[0] != '/credits'):?>	
			//This is the id for the "credit library" blue arrow button - JM
			$("#dhtml_menu-10981").removeClass("button active-trail").addClass("button active-trail active");
		<?php endif;?>
	});
</script>
