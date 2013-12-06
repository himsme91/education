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
<?php if($fields['field_entry_type_value']->content == 'LEED Interpretations'):?>
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
			
			<div class="inquiry"><h3>Inquiry</h3><div class="allow-copy" title="copy text to clipboard"></div></div>
			<p class="content-copy">
			<?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',str_replace('\n','<br>',str_replace("\'","'",str_replace("&lt;br &gt;"," ",$fields['field_li_inquiry_value']->raw))));?>
			</p>
			<br />
			<div class="ruling"><h3>Ruling</h3><div class="allow-copy" title="copy text to clipboard"></div></div>
			<p class="content-copy">
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
			<div class="related-addenda"><h3>Related Addenda (Corrections & Interpretations)</h3><div class="allow-copy" title="copy text to clipboard"></div></div>
			<ul class="content-copy">
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
		 	<em>If a credit that a project is attempting is listed as applicable, the team must review the interpretation and apply it if it makes sense to do so. LEED project teams can choose to reference LEED Interpretations that do not list their credit as applicable if the project team believes it is appropriate. A final determination will be made during the certification review. <a href="/help-topic/addenda-%26-interpretations">Learn more</a></em>
			<br/><br/>
			<ul>
			<?php 
			$applicable_credits = array();
			foreach($node->field_applicable_credits as $credit){
				if(!in_array($credit['nid'],$applicable_credits)){
					array_push($applicable_credits, $credit['nid']);
					$credit_node = node_load($credit['nid']);
					echo '<li>';
					echo '<a class="credit-link" href="#" data-url="/'.$credit_node->path.'">'.$credit_node->field_credit_short_id[0]['value'].' - '.$credit_node->title.'</a><br/>';
					$ratsys = '';
					if($credit_node->field_credit_rating_system){
						foreach($credit_node->field_credit_rating_system as $rat){
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
					$ratver = taxonomy_get_term($credit_node->field_credit_rating_sys_version[0]['value']);
					if($ratver->name != '' && $ratsys != '') echo '<br/><small>'.$ratver->name.'</small>';
					echo '</li>';
				}
			}
			?>
			</ul>
		<!-- 	<br/>
		 	<h3>Applicable Rating Systems & References</h3>
			<p>
			<?php $query = "SELECT 
							CASE rsmap.map_rating_system
							WHEN '1226' THEN 'New Construction'
							WHEN '76' THEN 'Schools'
							WHEN '68' THEN 'Commercial Interiors'
							WHEN '69' THEN 'Core & Shell'
							WHEN '1227' THEN 'Existing Buildings'
							WHEN '1306' THEN 'Retail CI'
							WHEN '75' THEN 'Retail NC'
							WHEN '73' THEN 'Neighborhood Development'
							WHEN '72' THEN 'Homes'
							WHEN '71' THEN 'Healthcare'
							END AS 'RS'
							,
							MAX(IF(rsmap.map_version = 84 , rs.value, NULL)) AS '1',
							MAX(IF(rsmap.map_version = 83 , rs.value, NULL)) AS '2',
							MAX(IF(rsmap.map_version = 82 , rs.value, NULL)) AS '3',
							MAX(IF(rsmap.map_version = 491 , rs.value, NULL)) AS '4',
							MAX(IF(rsmap.map_version = 490 , rs.value, NULL)) AS '5',
							MAX(IF(rsmap.map_version = 81 , rs.value, NULL)) AS '6'
							from extracts.LItoRatingSystem rs
							inner join extracts.LIRatingSystemMap rsmap
							on rs.rating_system = rsmap.rating_system
							WHERE rs.Inquiry_Number = %d and rsmap.map_rating_system in (68,69,71,72,73,75,76,1226,1227,1306)
							GROUP BY rsmap.map_rating_system
							ORDER BY
							CASE rsmap.map_rating_system
							WHEN 1226 THEN 1
							WHEN 1226 THEN 2
							WHEN 1226 THEN 3
							WHEN 1226 THEN 4
							WHEN 76 THEN 5
							WHEN 76 THEN 6
							WHEN 68 THEN 7
							WHEN 68 THEN 8
							WHEN 69 THEN 9
							WHEN 69 THEN 10
							WHEN 1227 THEN 11
							WHEN 1227 THEN 12
							WHEN 1227 THEN 13
							WHEN 75 THEN 14
							WHEN 1306 THEN 15
							WHEN 73 THEN 16
							WHEN 72 THEN 17
							WHEN 71 THEN 18
							END";
				//  $result = db_query($query,$fields['field_li_id_value']->content);
				 
			      ?>
			      	  <table cellspacing="0" border="1" style="border-collapse:collapse;" id="dg_RatingSystem" rules="all" class="Appbox">
					  	<tbody>
					  		<tr>
								<td class="firstcolumn"> </td>
								<td class="headerrows">v2.0</td>
								<td class="headerrows">v2.1</td>
								<td class="headerrows">v2.2</td>
								<td class="headerrows">v2007</td>
								<td class="headerrows">v2008</td>
								<td class="headerrows">v2009</td>
							</tr>
							
						  <?php while ($row = db_fetch_array($result)) { ?>
						  <?php //dsm($row);?>
							<tr>
								<td class="firstcolumn"><?php echo $row['RS']; ?></td>
							 	<td class="<?php echo 'rowli'.$row['1'];?>"><?php if(is_null($row['1'])) echo '&nbsp;';?></td>
								<td class="<?php echo 'rowli'.$row['2'];?>"><?php if(is_null($row['2'])) echo '&nbsp;';?></td>
								<td class="<?php echo 'rowli'.$row['3'];?>"><?php if(is_null($row['3'])) echo '&nbsp;';?></td>
								<td class="<?php echo 'rowli'.$row['4'];?>"><?php if(is_null($row['4'])) echo '&nbsp;';?></td>
								<td class="<?php echo 'rowli'.$row['5'];?>"><?php if(is_null($row['5'])) echo '&nbsp;';?></td>
								<td class="<?php echo 'rowli'.$row['6'];?>"><?php if(is_null($row['6'])) echo '&nbsp;';?></td>
							</tr>
						  <?php } ?>
						</tbody>
					</table>
					<table class="" style="background-color: #EFEFEF; font-size :14px; font-family: Helvetica, Arial, sans-serif; letter-spacing: .02em; width: 588px;">
					  <tbody>
					  	<tr>
					      	<td class="style27">KEY</td>
					    	<td class="style21"></td>
						</tr>
						<tr>
					    	<td class="style24">
					        	<img style="border-width:0px;" src="/sites/all/themes/usgbc/lib/img/li/appBoxdoubleTick.gif" id="LISearchNew221_rptResults_ctl00_Image14">
					    	</td>
					    	<td class="style19"> 
					        	The ruling was written for projects using this rating system and must be applied
					        	based on the project's registration date
					    	</td>
						</tr>
						<tr>
					    	<td class="style25">
					        	<img style="border-width:0px;" src="/sites/all/themes/usgbc/lib/img/li/appBoxtick.gif" id="LISearchNew221_rptResults_ctl00_Image15">
					    	</td>
					    	<td class="style14">
					        	Project teams and reviewers may refer to the ruling for projects using this rating system, if reasonable and appropriate
					    	</td>
						</tr>
						<tr>
					    	<td class="style26">
					        	<img style="border-width:0px;" src="/sites/all/themes/usgbc/lib/img/li/appBoxcircle.gif" id="LISearchNew221_rptResults_ctl00_Image13">
					    	</td>
					   		<td class="style20">
					        	The ruling was not yet considered for projects using this rating system
					    	</td>
						</tr>
						<tr>
					    	<td class="style27">
					        	<img style="border-width:0px;" src="/sites/all/themes/usgbc/lib/img/li/appBoxcross.gif" id="LISearchNew221_rptResults_ctl00_Image21">
					    	</td>
					    	<td class="style21">
					        	The ruling does NOT apply to projects using this rating system
					    	</td>
						</tr>
						<tr>
					    	<td class="style28">
					        	<img style="border-width:0px;" src="/sites/all/themes/usgbc/lib/img/li/Grey_blank.GIF" id="LISearchNew221_rptResults_ctl00_ImgDoesntExist">
					    	</td>
					   		<td class="style22">
					       		The rating system for this version does not exist
					    	</td>
						</tr>
					</tbody>
				</table>
			</p> -->
			<br/>
			<span><a data-id="<?php print $fields['field_li_id_value']->content;?>" href="#" data-entry-type="<?php echo $fields['field_entry_type_value']->content;?>" data-credit="<?php echo $node->field_primary_credit[0]['value'];?>" data-rating-sys="<?php echo $node->field_primary_rating_system[0]['value'];?>" data-date="<?php echo strip_tags($fields['field_li_date_value']->content); ?>" data-url="<?php echo USGBCHOST.$currenturl[0].'?keys='.$fields['field_li_id_value']->content;?>" class="share">Share Email</a></span>
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
<?php else:?>
	<div class="criteria">
		<div class="criteria-head-std">
	
			<p class="date">
				<span class="right">
				<?php if(strlen($fields['field_entry_type_value']->content) > 50):?>
					Addendum Rating System and Reference Guide
				<?php else:?>
					<?php print $fields['field_entry_type_value']->content;?> 
				<?php endif;?>
				</span>
				<span class="id"><a class="block-link-src sh-trigger" href="#">ID#<?php print $fields['field_li_id_value']->content;?> 
				</a> </span> made on
				<?php print $fields['field_li_date_value']->content;?><br/><br/>
			<!-- <span class="first-credit"><?php echo $str;?></span>  -->
				<span class="first-credit">
				<?php if($node->field_applicable_credits[0]['nid'] != ''):  ?>
					Prerequisite/Credit: 
					<?php $credit = node_load($node->field_applicable_credits[0]['nid']); 
					echo '<a class="credit-link" href="#" data-url="/'.$credit->path.'">'.$credit->field_credit_short_id[0]['value'].' - '.$credit->title.'</a><br/>';
					?>
				<?php elseif($node->field_primary_credit[0]['value'] != ''):?>
					Prerequisite/Credit: <?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',$node->field_primary_credit[0]['value']);?><br/>
				<?php endif;?>
				<?php if($node->field_primary_rating_system[0]['value'] != ''):?>
					Rating System: <?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',$node->field_primary_rating_system[0]['value']);?><br/>
				<?php endif;?>
				</span>	
			</p>
			<br/>
			<p class="summary addenda">
				<?php if($node->field_ref_guide_name_and_edition[0]['value'] != ''):?>
				<span class="bold">Reference Guide:</span>
				<span><?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',str_replace("$","and",$node->field_ref_guide_name_and_edition[0]['value']));?></span>
				<br/>
				<?php endif;?>
				<?php if($node->field_page[0]['value'] != ''):?>
				<span class="bold">Page:</span>
				<span><?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',str_replace(" $",",",$node->field_page[0]['value']));?></span>
				<br/>
				<?php endif;?>
				<?php if($node->field_li_location[0]['value'] != ''):?>
				<span class="bold">Location:</span>
				<span><?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',$node->field_li_location[0]['value']);?></span>
				<br/>
				<?php endif;?>
				<!-- 	<a href="#"><img class="img-exp" src="/sites/all/themes/usgbc/lib/img/expand_alt-new.png" alt="expand" title="click here to expand" /></a> --> 
			</p>

		</div>
	
		<div class="sh-content" style="padding-top: 20px">
			<h3>Description of change</h3>
			<p>
			<?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',str_replace('\n','<br>',str_replace("\&#039;","'",$node->field_issue[0]['value'])));?>
			</p>
			<br />
			<h3>Related Addenda and LIs</h3>
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
			<?php $entry_type_addenda = '';?>
			<?php if(strlen($fields['field_entry_type_value']->content) > 50):?>
				<?php $entry_type_addenda = 'Addendum Rating System and Reference Guide';?>
			<?php else:?>
				<?php $entry_type_addenda = $fields['field_entry_type_value']->content;?> 
			<?php endif;?>
			<span> <a href="#" data-id="<?php print $fields['field_li_id_value']->content;?>" data-credit="<?php echo $node->field_primary_credit[0]['value'];?>" data-rating-sys="<?php echo $node->field_primary_rating_system[0]['value'];?>" data-entry-type="<?php echo $entry_type_addenda;?>" data-date="<?php echo strip_tags($fields['field_li_date_value']->content); ?>" data-url="<?php echo USGBCHOST.$currenturl[0].'?keys='.$fields['field_li_id_value']->content;?>" class="share">Share Email</a></span>
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
<?php endif;?>
