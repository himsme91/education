<?php 
global $user;
//dsm($user);
$admin = FALSE;
foreach($user->roles as $role){
	if($role == 'LI Admin') $admin = TRUE;
}
?>
<?php 
$searchterm = $_GET['keys'];
$currenturl = explode("?", $_SERVER['REQUEST_URI']);
$node = node_load($fields['nid']->content);
//dsm($node->field_li_rating_system);
//dsm($fields);
/*
$default_credit = node_load($node->field_applicable_credits[0]['nid']);
$str = '';
$str = '<a class="credit-link" href="#" data-url="/'.$default_credit->path.'">'.$default_credit->field_credit_short_id[0]['value'].' - '.$default_credit->title.'</a><br/>';
$ratsys = '';
foreach($default_credit->field_credit_rating_system as $rat){
	$term = taxonomy_get_term($rat['value']);
	if($ratsys == ''):
		$ratsys = '<small>'.$term->name;
	else:
		$ratsys .= ', '.$term->name;
	endif;
}
$str .= $ratsys;
if ($ratsys != '') $str .= '</small>';
$ratver = taxonomy_get_term($default_credit->field_credit_rating_sys_version[0]['value']);
if($ratver->name != '') $str .= '<br/><small>'.$ratver->name.'</small>';
*/
?>
	<div class="criteria">
		<div class="criteria-head">
			
			<p class="date">
				<span class="right"><?php print $fields['field_entry_type_value']->content;?></span>
				<span class="id"><a class="block-link-src sh-trigger" href="#">ID#<?php print $fields['field_li_id_value']->content;?>
				</a> </span> made on
				<?php print $fields['field_li_date_value']->content;?><br/><br/>
			<!-- <span class="first-credit"><?php echo $str;?></span>  -->
			<span class="first-credit">
				<?php if($node->field_applicable_credits[0]['nid'] != ''):  ?>
					Prerequisite/Credit: 
					<?php $credit = node_load($node->field_applicable_credits[0]['nid']); 
					//echo '<a class="credit-link" href="#" data-url="/'.$credit->path.'">'.$credit->field_credit_short_id[0]['value'].' - '.$credit->title.'</a><br/>';
					echo $credit->field_credit_short_id[0]['value'].' - '.$credit->title;
					?><br/>
				<?php elseif($node->field_primary_credit[0]['value'] != ''):?>
					Prerequisite/Credit: <?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',$node->field_primary_credit[0]['value']);?><br/>
				<?php endif;?>
				<?php if($node->field_rating_system_family[0]['value'] != ''){?>
						Rating System Family: 
						<?php
							$ratings = array();
							foreach($node->field_rating_system_family as $rat){
										if(!in_array($rat['value'],$ratings)){
											array_push($ratings, $rat['value']);
											$term = taxonomy_get_term($rat['value']);
											if($term->name != ""){
												if($ratsys == ''):
												$ratsys = '<small>'.$term->name;
												else:
												$ratsys .= ', '.$term->name;
												endif;
											}
										}
									}
								echo $ratsys;
								if ($ratsys != '') echo '</small>';	
							?>
						
					<?php 
					}
					elseif(!empty($node->field_li_rating_system)){?>
						Rating System: 
						<?php 
					$ratings = array();
					foreach($node->field_li_rating_system as $rat){
								if(!in_array($rat['value'],$ratings)){
									array_push($ratings, $rat['value']);
									$term = taxonomy_get_term($rat['value']);
									if($term->name != ""){
										$ratDescription = ($term->description != '') ? $term->description : $term->name;
										if($ratsys == ''):
										$ratsys = '<small>'.$ratDescription;
										else:
										$ratsys .= ', '.$ratDescription;
										endif;
									}
								}
							}
						echo $ratsys;
						if ($ratsys != '') echo '</small>';
					 ?>
					 <?php }?>
			</span> 
			</p>
			<br/>
			<p class="summary">
			<?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',trim(substr(str_replace('\n','<br>',str_replace("\&#039;","'",str_replace("&lt;br &gt;"," ",$fields['field_li_inquiry_value']->content))),0,200)));
			if(strlen(str_replace('\n','<br>',str_replace("\&#039;","'",str_replace("&lt;br &gt;"," ",$fields['field_li_inquiry_value']->content))))>200){
				print '...';
			}
	
			?>
		<!-- 	<a href="#"><img class="img-exp" src="/sites/all/themes/usgbc/lib/img/expand_alt-new.png" alt="expand" title="click here to expand" /></a>  --> 
			</p>
		</div>
	
		<div class="sh-content" style="padding-top: 20px">
			
			<h3>Inquiry</h3>
			<p>
			<?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',str_replace('\n','<br>',str_replace("\'","'",str_replace("&lt;br &gt;"," ",$fields['field_li_inquiry_value']->raw))));?>
			</p>
			<br />
			<h3>Ruling</h3>
			<p>
			<?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',str_replace('\n','<br>',str_replace("\'","'",str_replace("&lt;br &gt;"," ",$fields['field_li_ruling_value']->raw))));?>
			<?php
			
			if ($fields['field_international_applicable_value']->raw == 1){
				echo '<br/><br/><em>Internationally applicable'; 
				if($fields['field_inter_appl_cntry_value']){
					$int_cnty = '';
					foreach($node->field_inter_appl_cntry as $int_country){
						if(!is_null($int_country['value'])){
							$term_int_cnty = taxonomy_get_term($int_country['value']);
							
							if ($int_cnty == '')
								$int_cnty = $term_int_cnty->name;
							else 
								$int_cnty .= ', '.$term_int_cnty->name;
						}
					}
					
					if($int_cnty != '')	echo ' - ' .$int_cnty;
				}
				echo '</em>';
				}?>
			<?php if ($fields['field_campus_applicable_value']->raw == 1):?>
				<br/><br/><em>Campus applicable</em>
			<?php endif;?>
			</p>
			<br />
			<h3>Related Addenda (Corrections & Interpretations)</h3>
			<ul>
			<?php 
			if($node->field_related_li[0]['nid'] != ''){
				foreach($node->field_related_li as $li){
					$li = node_load($li['nid']);
					echo '<li>';
					echo '<a class="credit-link" href="#" data-url="/leed-interpretations?clearsmartf=true&keys='.$li->field_li_id[0]['value'].'">'.str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',$li->title).'</a>';
					echo '</li>';
				}
			}else{
				echo 'None';
			}
			?>
			</ul>
			<br />
			<h3>Related resources</h3>
			<ul>
			<?php 
			if($node->field_related_resources[0]['nid'] != ''){
				foreach($node->field_related_resources as $resource){
					$resource = node_load($resource['nid']);
					echo '<li>';
					echo '<a class="credit-link" href="#" data-url="/'.$resource->path.'">'.str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',$resource->title).'</a>';
					echo '</li>';
				}
			}else{
				echo 'None';
			}
			?>
			</ul>
			<br/>
		 	<h3>Applicable credits</h3>
			<ul>
			<?php 
			foreach($node->field_applicable_credits as $credit){
			$credit = node_load($credit['nid']);
			echo '<li>';
			echo '<a class="credit-link" href="#" data-url="/'.$credit->path.'">'.$credit->field_credit_short_id[0]['value'].' - '.$credit->title.'</a><br/>';
			$ratsys = '';
			if($credit->field_credit_rating_system){
				foreach($credit->field_credit_rating_system as $rat){
					$term = taxonomy_get_term($rat['value']);
					$ratDescription = ($term->description != '') ? $term->description : $term->name;
					if($ratsys == ''):
						$ratsys = '<small>'.$ratDescription;
					else:
						$ratsys .= ', '.$ratDescription;
					endif;
				}
			}
			echo $ratsys;
			if ($ratsys != '') echo '</small>';
			$ratver = taxonomy_get_term($credit->field_credit_rating_sys_version[0]['value']);
			if($ratver->name != '' && $ratsys != '') echo '<br/><small>'.$ratver->name.'</small>';
			echo '</li>';
			
			}
			?>
			</ul>
			<br/>
		 				<span><a data-id="<?php print $fields['field_li_id_value']->content;?>" href="#" data-entry-type="<?php echo $fields['field_entry_type_value']->content;?>" data-credit="<?php echo $node->field_primary_credit[0]['value'];?>" data-rating-sys="<?php echo $node->field_primary_rating_system[0]['value'];?>" data-date="<?php echo strip_tags($fields['field_li_date_value']->content); ?>" data-url="<?php echo USGBCHOST.'/leed-interpretations?keys='.$fields['field_li_id_value']->content;?>" class="share">Share Email</a></span>
			<?php if($admin):?>
				<br />
				<h3>Admin notes</h3>
				<?php if($node->body != ''):?>
					<p><?php echo str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',$node->body);?></p>
				<?php else:?>
					<p><?php echo 'None';?></p>
				<?php endif;?>
			<?php endif;?>
			<br/>
		</div>
	    
	</div>
