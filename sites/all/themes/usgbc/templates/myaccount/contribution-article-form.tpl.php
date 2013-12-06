<?php global $user;?>
<div class="form form-form clear-block <?php print $form_classes ?>" id="divPer">
				<h1>Article contributions</h1>
				<p>We encourage you to share your green building experiences and expertise with our community! Authoring articles in our blog is a great way to participate in the global dialog. Our editors are here to help make your submission a high value to our readers.</p>
				<div class="button-group">
					<a class="button" href="/node/add/article">Create new article</a>
				</div>
			<div class="tabs tabbed-box ">
                
                                
              	<ul class="tabNavigation">
              		<li class="selected"><a href="#tab-compDrafts">Drafts</a></li>
              		<li><a href="#tab-compPending">Pending</a></li>
              		<li><a href="#tab-compLive">Live</a></li>
              	</ul>
                
                
              	<div class="aside padded displayed" id="tab-compDrafts">
                	<?php
         			    $viewname = 'ArticleView';
      					$args = array();
      					$args[0]=$user->uid;
      					$display_id = 'page_4';
      					$view = views_get_view($viewname);
					    $view->set_display($display_id);
      					$view->set_arguments($args);
      					print $view->preview();
      				?>
                </div>
                		
                <div class="aside padded hidethis" id="tab-compPending">
      				<?php
         			    $viewname = 'ArticleView';
      					$args = array();
      					$args[0]=$user->uid;
      					$display_id = 'page_13';
      					$view = views_get_view($viewname);
					    $view->set_display($display_id);
      					$view->set_arguments($args);
      					print $view->preview();
      				?>		   						
      			</div>
					
				<div class="aside padded hidethis" id="tab-compLive">
                	<?php
         			    $viewname = 'ArticleView';
      					$args = array();
      					$args[0]=$user->uid;
      					$display_id = 'page_5';
      					$view = views_get_view($viewname);
					    $view->set_display($display_id);
      					$view->set_arguments($args);
      					print $view->preview();
      				?>
				
				</div>
            </div>
    </div>   
  <br>
  <br>  
         
  <?php 
  /*  
  global $user;
  //dsm($user);
    $tabs['DRAFTS'] = array(
  'title' => t('DRAFTS'),
  'type' => 'view',
  'vid' => 'ArticleView',
  'display' => 'page_4',
  'args' => $user->uid,
);
$tabs['LIVE'] = array(
  'title' => t('LIVE'),
  'type' => 'view',
  'vid' => 'ArticleView',
  'display' => 'page_5',
  'args' => $user->uid,
); 

$quicktabs['qtid'] = 'qtarticlequicktab';
$quicktabs['tabs'] = $tabs;
$quicktabs['style'] = 'Basic';
$quicktabs['ajax'] = TRUE; 
print theme('quicktabs', $quicktabs);

*/
?>