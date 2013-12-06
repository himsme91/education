<?php 
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */
include('page_inc/page_top.php');
$pageurl = $_SERVER["REQUEST_URI"];
$currenturl = explode("/", $_SERVER['REQUEST_URI']);

?>

<div id="content" class="twoColRight">
    <div id='navCol' class='clearfix'>
    	<div class="menu-block-18 menu-name-primary-links parent-mlid-0 menu-level-3">
  			<ul class="menu">
				<li class="first leaf menu-mlid-3005 dhtml-menu ">
					<a href="/sampleforms" id="dhtml_menu-3005" <?php if(!$currenturl[2]):?> class="active" <?php endif;?> style="font-family: 'helvetica neue', arial; ">LEED v3 and v4</a>
				</li>
				<li class="first leaf menu-mlid-3005 dhtml-menu ">
					<a href="/sampleforms/v2" id="dhtml_menu-3005" <?php if($currenturl[2]=='v2'):?> class="active" <?php endif;?> style="font-family: 'helvetica neue', arial; ">LEED v2</a>
				</li>
			</ul>
		</div>
    </div>

	<div class="subcontent-wrapper">
      	<div id="mainCol">
   
		<?php 
		if($currenturl[2] == 'v2'){ 
			
			$v2_node = node_load(2361472);
			print $v2_node->body;
	
		}else{ 
			print $content; 
		}	?>
      	
      	</div>
   	</div>
</div>

<?php include('page_inc/page_bottom.php');