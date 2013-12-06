<?php global $user;?>
<div class="form form-form clear-block <?php print $form_classes ?>" id="divPer">
			
				<h1>LEED project profiles</h1>
				<div id="permission-granted" class="">
				<p>You are an admin to the following LEED certified projects. As admin, you can create project profiles and identify who played a role in each project team.</p>
			
			<div class="tabs tabbed-box">
     	
	                	                    
	            <ul class="tabNavigation">
	            	<li class="selected"><a href="#tab-compDrafts">Drafts</a></li>
	                <li><a href="#tab-compLive">Live</a></li>
	            </ul>
	                	
	            <div class="aside padded displayed" id="tab-compDrafts">
                	<?php
         			    $viewname = 'leed_projects';
      					$args = array();
      					$args[0]=$user->uid;
      					$display_id = 'page_2';
      					$view = views_get_view($viewname);
					    $view->set_display($display_id);
      					$view->set_arguments($args);
      					print $view->preview();
      				?>	                		
	            </div>
				<div class="aside padded hidethis" id="tab-compLive">
                	<?php
         			    $viewname = 'leed_projects';
      					$args = array();
      					$args[0]=$user->uid;
      					$display_id = 'page_1';
      					$view = views_get_view($viewname);
					    $view->set_display($display_id);
      					$view->set_arguments($args);
      					print $view->preview();
      				?>							
				</div>
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
  'vid' => 'leed_projects',
  'display' => 'page_2',
  'args' => $user->uid,
);
$tabs['LIVE'] = array(
  'title' => t('LIVE'),
  'type' => 'view',
  'vid' => 'leed_projects',
  'display' => 'page_1',
  'args' => $user->uid,
); 

$quicktabs['qtid'] = 'qtleedprojects';
$quicktabs['tabs'] = $tabs;
$quicktabs['style'] = 'Basic';
$quicktabs['ajax'] = TRUE; 
print theme('quicktabs', $quicktabs);
*/
?>      