<?php
  // $Id: views-view-table.tpl.php,v 1.8 2009/01/28 00:43:43 merlinofchaos Exp $
  /**
   * @file views-view-table.tpl.php
   * Template to display a view as a table.
   *
   * - $title : The title of this group of rows.  May be empty.
   * - $header: An array of header labels keyed by field id.
   * - $fields: An array of CSS IDs to use for each field id.
   * - $class: A class or classes to apply to the table, based on settings.
   * - $row_classes: An array of classes to apply to each row, indexed by row
   *   number. This matches the index in $rows.
   * - $rows: An array of row items. Each row is an array of content.
   *   $rows are keyed by row number, fields within rows are keyed by field ID.
   * @ingroup views_templates
   */
?>
<?php 
$path = isset($_GET['q']) ? $_GET['q'] : '<front>';
$link = url($path, array('absolute' => FALSE));


?>
<pre><?php //dsm($rows);?></pre>
<div id="mainCol">
<ul class="course-list">
  <?php foreach ($rows as $count => $row): 
	 ?>
  <li class="block-link" style="cursor: pointer;" title="<?php print $row['title']; ?>">
                		<div class="info-primary">
		                	<p class="course-id">ID #<?php print $row['field_crs_id_value'];?> Level <?php print $row['field_crs_level_value'];?></p>
		                	
		                	<h3><a href="<?php print $row['path'];?>?workshop_nid=<?php print $row['nid'];?>&return=<?php print $link;?>" class="block-link-src"><?php print $row['title']; ?></a></h3>
		                	
		                	<?php if($row['field_crs_pvd_nid']){?>
		                	<p class="course-provider">Provided by <?php print $row['field_crs_pvd_nid']; ?>
		                	<?php }elseif($row['field_crs_pvd_name_value']){?>
		                	<p class="course-provider">Provided by <?php print $row['field_crs_pvd_name_value'];?></p>
		                	<?php }?>
                		</div>
                		<div class="info-secondary">
		                	<p class="course-type"><?php print $row['field_crs_fmt_value'];?></p>
		                	<div class="course-specialties">
			                	<?php print $row['field_crs_leed_value'];?>
		                	</div>
                		</div>
	                	
	                	<div class="info-poi">
	                		<?php if($row['list_price'] == '$0.00'){?>
	                			<span class="course-price">FREE</span>
	                		<?php }else{?>
	                			<span class="course-price"><?php if(strstr($row['list_price'], ".")){
 											$price = rtrim($row['list_price'], "0"); 
	                						if(substr($price,-1,1) == "."){
	                							print rtrim($price, ".");
	                						}else {print $price;}
	                			} else {
 											print round($row['list_price']);
	                		}?></span>
			                	<?php }?>
	                		<?php if($row['field_crs_leed_ap_hours_value'] > 0) {?>
	                		<span class="course-ce"><?php if(strstr($row['field_crs_leed_ap_hours_value'], ".")){
 											$hrs = rtrim($row['field_crs_leed_ap_hours_value'], "0"); 
 											
	                						if(substr($hrs,-1,1) == "."){
	                							print rtrim($hrs, ".");
	                						} else {print $hrs;}
	                		}else {
 											print round($row['field_crs_leed_ap_hours_value']);
	                		}?> CE hrs</span>
	                		<?php } ?>
	                	</div>
	                	
	                	<div class="info-tertiary">
	                	<?php
	                		date_default_timezone_set('America/New_York');
	                		if($row['field_country_name_value'] && $row['field_wrksp_startdate_value'] && (stristr($row['field_crs_fmt_value'],'on-demand') == false)){?>
	                		<p class="course-time"><?php print str_replace('(All day)','',$row['field_wrksp_startdate_value']);?></p>
	                		<?php }else {
	                				if(stristr($row['field_crs_fmt_value'],'on-demand') != false){
	                					$format = 'On demand - always available!';?>
	                					<p class="course-time"><?php print $format;?></p>
	                				<?php 
	                				}elseif(stristr($row['field_crs_fmt_value'],'instructor-led') == false) {
	                					$format = $row['field_crs_fmt_value'];?>
	                						 <p class="course-time"><?php print $format;?></p>
	                				<?php }else {$format = '';}
	                			?>	                		
	                	<?php 	}?>
					         <p class="course-location" id="course-location"> 
					         	<?php      
								$state = explode('[',$row['field_state_name_value']);
	    						$state = str_replace(']','',$state[1]);
					            $country = explode('[',$row['field_country_name_value']);
	    						$country = str_replace(']','',$country[1]);
	    						if((strlen($row['field_city_name_value'])>0 || strlen($state)>0 || strlen($country)>0) && (stristr($row['field_crs_fmt_value'],'on-demand') == false)){
									if(strlen($row['street'])>0){
										$location_address = str_replace(' ','+',$row['street'].' '.$row['field_city_name_value'].' '.$row['province'].' '.$row['postal_code'].' '.$country);?>
						         		<a  class="" target="_blank" href="http://maps.google.com/maps?q=<?php print $location_address;?>" itemprop="maps"><img title="map" src="/sites/all/assets/section/courses/icon-map_pin-xsm.png" alt="map"/></a>
						         		 
						         	<?php }
						         	if (strlen($row['field_city_name_value'])>0   && (stristr($row['field_crs_fmt_value'],'on-demand') == false)){
						                print $row['field_city_name_value'];
						            }
					                if(strlen($state)>0  && (stristr($row['field_crs_fmt_value'],'on-demand') == false))
						            {
						             	print ', '. strtoupper($state);
						            }
						            if(strlen($country)>0 && strtolower($country) !='us'  && (stristr($row['field_crs_fmt_value'],'on-demand') == false))            
						            {     
						            	print ', '. strtoupper($country);
						            }
								}?> 
				            </p>
	                	</div>
   </li>
    <?php endforeach; ?>
</ul>
</div>