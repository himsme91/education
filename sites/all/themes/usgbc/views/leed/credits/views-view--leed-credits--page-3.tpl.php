<?php
include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters-small.php';
drupal_add_css(drupal_get_path('theme', 'usgbc') .'/lib/css/liapplicabilitybox.css');

// $Id: views-view.tpl.php,v 1.13.2.2 2010/03/25 20:25:28 merlinofchaos Exp $
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
?>
<?php 
//dsm($exposed);
$credit_nid = $view->args[0];
$current_node = node_load($credit_nid);
//dsm($current_node);
$credit_val = $current_node->field_credit_short_id[0]['value'] ;
$rating_sys_version_val = $current_node->field_credit_rating_sys_version[0]['value']; 

$result = db_query("SELECT DISTINCT(node.nid) AS nid,
		 node_data_field_li_id.field_li_id_value AS node_data_field_li_id_field_li_id_value,
		 node.language AS node_language,
		 node.type AS node_type, node.vid AS node_vid,
		 node_data_field_li_rating_system.field_li_rating_system_value AS node_data_field_li_rating_system_field_li_rating_system_value,
		 node_data_field_li_rating_system.delta AS node_data_field_li_rating_system_delta,
		 node_data_field_li_rating_sys_version.field_li_rating_sys_version_value AS node_data_field_li_rating_sys_version_field_li_rating_sys_version_value,
		 node_data_field_li_rating_sys_version.delta AS node_data_field_li_rating_sys_version_delta,
		 node_data_field_li_credit_category.field_li_credit_category_value AS node_data_field_li_credit_category_field_li_credit_category_value,
		 node_data_field_li_credit_category.delta AS node_data_field_li_credit_category_delta,
		 node_node_data_field_applicable_credits.title AS node_node_data_field_applicable_credits_title,
		 node_node_data_field_applicable_credits.nid AS node_node_data_field_applicable_credits_nid,
		 node_node_data_field_applicable_credits.language AS node_node_data_field_applicable_credits_language,
		 node_data_field_li_id.field_li_date_value AS node_data_field_li_id_field_li_date_value,
		 node_data_field_li_id.field_li_inquiry_value AS node_data_field_li_id_field_li_inquiry_value,
		 node_data_field_li_id.field_li_ruling_value AS node_data_field_li_id_field_li_ruling_value,
		 node_data_field_li_id.field_international_applicable_value AS node_data_field_li_id_field_international_applicable_value,
		 node_data_field_inter_appl_cntry.field_inter_appl_cntry_value AS node_data_field_inter_appl_cntry_field_inter_appl_cntry_value,
		 node_data_field_inter_appl_cntry.delta AS node_data_field_inter_appl_cntry_delta,
		 node_data_field_li_id.field_issue_value AS node_data_field_li_id_field_issue_value,
		 node_data_field_entry_type.field_entry_type_value AS node_data_field_entry_type_field_entry_type_value,
		 node_data_field_entry_type.delta AS node_data_field_entry_type_delta,
		 node_data_field_li_id.field_campus_applicable_value AS node_data_field_li_id_field_campus_applicable_value,
		 node_data_field_li_id.field_primary_credit_value AS node_data_field_li_id_field_primary_credit_value,
		 node_data_field_primary_rs.field_primary_rs_value AS node_data_field_primary_rs_field_primary_rs_value,
		 node_data_field_primary_rs.delta AS node_data_field_primary_rs_delta,
		 node_data_field_li_date.field_li_date_value AS node_data_field_li_date_field_li_date_value,
		 node_data_field_related_li.field_related_li_nid AS node_data_field_related_li_field_related_li_nid_value,
		 node_data_field_related_resources.field_related_resources_nid AS node_data_field_related_li_field_related_resources_nid_value
		 FROM node node
		 LEFT JOIN content_field_applicable_credits node_data_field_applicable_credits ON node.vid = node_data_field_applicable_credits.vid
		 LEFT JOIN content_field_related_li node_data_field_related_li ON node.vid = node_data_field_related_li.vid
		 LEFT JOIN content_field_related_resources node_data_field_related_resources ON node.vid = node_data_field_related_resources.vid
		 LEFT JOIN node node_node_data_field_applicable_credits ON node_data_field_applicable_credits.field_applicable_credits_nid = node_node_data_field_applicable_credits.nid
		 LEFT JOIN content_field_li_credit_category node_data_field_li_credit_category ON node.vid = node_data_field_li_credit_category.vid
		 LEFT JOIN term_data term_data_node_data_field_li_credit_category ON node_data_field_li_credit_category.field_li_credit_category_value = term_data_node_data_field_li_credit_category.tid
		 LEFT JOIN content_field_entry_type node_data_field_entry_type ON node.vid = node_data_field_entry_type.vid
		 LEFT JOIN term_data term_data_node_data_field_entry_type ON node_data_field_entry_type.field_entry_type_value = term_data_node_data_field_entry_type.tid
		 LEFT JOIN content_type_leed_interpretation node_data_field_li_id ON node.vid = node_data_field_li_id.vid
		 LEFT JOIN content_field_li_rating_system node_data_field_li_rating_system ON node.vid = node_data_field_li_rating_system.vid
		 LEFT JOIN content_field_li_rating_sys_version node_data_field_li_rating_sys_version ON node.vid = node_data_field_li_rating_sys_version.vid
		 LEFT JOIN content_field_inter_appl_cntry node_data_field_inter_appl_cntry ON node.vid = node_data_field_inter_appl_cntry.vid LEFT JOIN content_field_primary_rs node_data_field_primary_rs ON node.vid = node_data_field_primary_rs.vid
		 LEFT JOIN content_type_leed_interpretation node_data_field_li_date ON node.vid = node_data_field_li_date.vid
		 WHERE (node.type in ('leed_interpretation')) AND (node.status <> 0) AND (node_data_field_li_rating_sys_version.field_li_rating_sys_version_value = '".$rating_sys_version_val."') AND (node_data_field_li_id.field_primary_credit_value like '%".$credit_val."%') 
		 GROUP BY nid
		 ORDER BY node_data_field_li_date_field_li_date_value DESC");


$li_rows = array();
while ($row = db_fetch_array($result)){
	//dsm($row);
	$idx = $row['nid'];
	$li_rows[$idx] = $row;
	
}
/**
$result = db_query("SELECT distinct `li_id`, `applicability`, `primary_credit_id`, `flagged`
		, `credit_id`, `inquiry`, `interpretation`, `credit_nid`, `Post_Date`
		FROM insight.li
		WHERE `credit_nid` = %d order by Post_Date desc", $credit_nid);

$li_rows = array();

while ($row = db_fetch_array($result)){
	$idx = $row['li_id'];
	$li_rows[$idx] = $row;
}
*/
?>
<style>
.blocklink:hover{
	cursor:pointer;
    background-color: #F1F6F7;
}

.blocklink-selected{
    background-color: #F1F6F7;	
	border:1px solid #ddd;
	border-top:1px solid #ddd !important;
}

.blocklink-selected .criteria-head p.summary{
	display:none;
}
.blocklink-selected .criteria-head p.date{
	display:block;
	color:black;
}

</style>

<script type="text/javascript">
$(document).ready( function() {

	$(".sh-content").hide();
	$('.sh-trigger').click(function(e){
		e.preventDefault();
				
	});
	$('.blocklink').click(function(e){
		e.preventDefault();
		var blocksrc = $('.block-link-src',this);
		var parentDiv = blocksrc.parents('.criteria').find('.sh-content');
//		parentDiv.css("height", parentDiv.height() +"px");
		parentDiv.slideToggle(600);
		blocksrc.parents('.criteria-head').toggleClass("expanded")
		$(this).toggleClass('blocklink-selected');
		
	});
	

	$('#edit-title').val("Enter keyword");
	
	$('#edit-title').each(function() {
	    var default_value = "Enter keyword";
	    $(this).focus(function() {
	        if(this.value == default_value) {
	            this.value = '';
	        }
	    });
	    $(this).blur(function() {
	        if(this.value == '') {
	            this.value = default_value;
	        }
	    });
	});

});

</script>
<div class="threeCol" id="content">
<div id="navCol">
	<?php include_once './' . drupal_get_path ('theme', 'usgbc') . '/views/smartfilters-small-ui.php'; ?>
</div>
<div id="mainCol" style="margin-right:10px">
<?php if(sizeof($li_rows)>0){
		
		
		?>
	   <ul class="linelist ra-list"  style="min-height:400px;">
            <?php foreach($li_rows as $li_row){ 
            	
            	//load the LI node here as done in Leed-Interpretations***********
            	
            $node = node_load($li_row['nid']);
            $date = $li_row['node_data_field_li_id_field_li_date_value'];
            $str = strpos($date, "T");
            $date = substr($date,0,$str);
            ?>
        	<li  class="blocklink">
        	
<div class="criteria">
		<div class="criteria-head">
			
			<p class="date">
				<span class="right"><?php //print $li_row['node_data_field_entry_type_field_entry_type_value'];?></span>
				<span class="id"><a class="block-link-src sh-trigger" href="#">ID#<?php print $li_row['node_data_field_li_id_field_li_id_value'];?>
				</a> </span> made on
				<?php print $date;?><br/><br/>
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
					 <?php }?>
			</span> 
			</p>
			<br/>
			<p class="summary">
			<?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',trim(substr(str_replace('\n','<br>',str_replace("\&#039;","'",str_replace("&lt;br &gt;"," ",$li_row['node_data_field_li_id_field_li_inquiry_value']))),0,200)));
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
			<?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',str_replace('\n','<br>',str_replace("\'","'",str_replace("&lt;br &gt;"," ",$li_row['node_data_field_li_id_field_li_inquiry_value']))));?>
			</p>
			<br />
			<h3>Ruling</h3>
			<p>
			<?php print str_ireplace($searchterm,'<span class="highlight">'.$searchterm.'</span>',str_replace('\n','<br>',str_replace("\'","'",str_replace("&lt;br &gt;"," ",$li_row['node_data_field_li_id_field_li_ruling_value']))));?>
			<?php
			
			if ($li_rows['node_data_field_li_id_field_international_applicable_value'] == 1){
				echo '<br/><br/><em>Internationally applicable'; 
				if($li_row['node_data_field_inter_appl_cntry_field_inter_appl_cntry_value']){
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
			<?php if ($li_row['node_data_field_li_id_field_campus_applicable_value'] == 1):?>
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
					if($ratsys == ''):
						$ratsys = '<small>'.$term->name;
					else:
						$ratsys .= ', '.$term->name;
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
				  $result = db_query($query,$li_row['node_data_field_li_id_field_li_id_value']);
				 
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
			</p>
			<br/>
			<span><a data-id="<?php print $li_row['node_data_field_li_id_field_li_id_value'];?>" href="#" data-entry-type="<?php echo $li_row['node_data_field_entry_type_field_entry_type_value'];?>" data-credit="<?php echo $node->field_primary_credit[0]['value'];?>" data-rating-sys="<?php echo $node->field_primary_rating_system[0]['value'];?>" data-date="<?php echo strip_tags($li_row['node_data_field_li_date_field_li_date_value ']); ?>" data-url="<?php echo USGBCHOST.$currenturl[0].'?keys='.$li_row['node_data_field_li_id_field_li_id_value '];?>" class="share">Share Email</a></span>
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
        	<?php  }}?>
           	</li>
           
      </ul>


<?php ?>
</div>
<div class="sideCol">
	<div class="section">
	<p><em class="no-match" style="font-size:10px;">The LIs listed here do NOT include every applicable LI. Please refer to the link to the LI database, below, for comprehensive listings.</em></p>
	<h6>Interpretations &amp; Addenda Database</h6>
	<p class="note">LEED Interpretations are precedent-setting rulings reviewed by USGBC on Formal Inquiries submitted by LEED project teams that can be applied to multiple projects. Addenda are permanent changes and improvements to LEED 2009 resources, including rating systems and reference guides. <a href="/leed-interpretations" class="small-link more-link" target="_blank">Search the database</a></p>
	</div>
</div>
<p class="clears"></p>

