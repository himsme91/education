<?php global $user;?>
<div class="form form-form clear-block <?php print $form_classes ?>" id="divPer">
	
				<h1>Resource contributions</h1>
					<p>We encourage you to share your green building resources with our community! Whether it's a book, website, or podcast, sharing resources in our library is a great way to participate in the global dialog and spread the green insight. Our editors are here to help make your submission a high value to our readers.</p>
					<div class="button-group">
						<a class="button" href="/node/add/resource">Create new resource</a>
					</div>
					<div class="tabs tabbed-box">
	                	
	                	                    
	                	<ul class="tabNavigation">
	                		<li class="selected"><a href="#tab-compDrafts">Drafts</a></li>
	                		<li class=""><a href="#tab-compPending">Pending</a></li>
	                		<li class=""><a href="#tab-compLive">Live</a></li>
	                	</ul>
	                	
	                	<div class="aside padded displayed" id="tab-compDrafts">
		                	<?php
		         			    $viewname = 'Resources';
		      					$args = array();
		      					$args[0]=$user->uid;
		      					$display_id = 'page_9';
		      					$view = views_get_view($viewname);
							    $view->set_display($display_id);
		      					$view->set_arguments($args);
		      					print $view->preview();
		      				?>		                			                		

	                	</div>
	                	<div class="aside padded hidethis hidden" id="tab-compPending">
	                			<?php
		         			    $viewname = 'Resources';
		      					$args = array();
		      					$args[0]=$user->uid;
		      					$display_id = 'page_8';
		      					$view = views_get_view($viewname);
							    $view->set_display($display_id);
		      					$view->set_arguments($args);
		      					print $view->preview();
		      				?>		                			                		
	                		
	                	</div>
						<div class="aside padded hidethis hidden" id="tab-compLive">
		                	<?php
		         			    $viewname = 'Resources';
		      					$args = array();
		      					$args[0]=$user->uid;
		      					$display_id = 'page_7';
		      					$view = views_get_view($viewname);
							    $view->set_display($display_id);
		      					$view->set_arguments($args);
		      					print $view->preview();
		      				?>															
						</div>
					</div>
	    
			
    </div>      
    
      <?php
      /*   
  global $user;
  //dsm($user);
    $tabs['DRAFTS'] = array(
  'title' => t('DRAFTS'),
  'type' => 'view',
  'vid' => 'Resources',
  'display' => 'page_9',
  'args' => $user->uid,
);
$tabs['LIVE'] = array(
  'title' => t('LIVE'),
  'type' => 'view',
  'vid' => 'Resources',
  'display' => 'page_7',
  'args' => $user->uid,
); 

$quicktabs['qtid'] = 'qtresourcetab';
$quicktabs['tabs'] = $tabs;
$quicktabs['style'] = 'Basic';
$quicktabs['ajax'] = TRUE; 
print theme('quicktabs', $quicktabs);

*/
?>  