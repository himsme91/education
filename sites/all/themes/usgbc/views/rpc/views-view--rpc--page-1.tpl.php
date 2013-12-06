<?php $_SESSION['rpc'] = 'rpc';
unset($_SESSION['pilot-credit']);

?>
<style type="text/css">
.hidden{
	display:none;
}
.credit-lib-nav .drop-menu {
    position: relative;
    float: left;
}

.credit-lib-nav .cred-sys{
    width: 236px;
}

.credit-lib-nav .country{
	margin-left: -10px;
    width: 225px;
}

.credit-lib-nav .drop-menu .placeholder {
    display: block;
    background: url('/sites/all/themes/usgbc/lib/img/credit-lib/ratingsystem.png') no-repeat;
    height: 31px;
    font-size: 13px;
    color: #59656A;
    padding-top: 10px;
    padding-left: 20px;
}

.credit-lib-nav .cred-ver {
    margin-left: -10px;
    width: 160px;
}

.credit-lib-nav .cred-ver .placeholder {
    background: url('/sites/all/themes/usgbc/lib/img/credit-lib/version.png') no-repeat;
/ / width : 301 px;
    padding-left: 34px;
}

.credit-lib-nav .country .placeholder {
    background: url('/sites/all/themes/usgbc/lib/img/credit-lib/country.png') no-repeat;
/ / width : 301 px;
    padding-left: 34px;
}

.credit-lib-nav .drop-menu .placeholder:active,
.credit-lib-nav .open .placeholder {
    background: url('/sites/all/themes/usgbc/lib/img/credit-lib/ratingsystem-active.png') no-repeat;
    color: #EBEEEF;
    text-shadow: 0 1px 2px rgba(0, 0, 0, .4);
}

.credit-lib-nav .cred-ver .placeholder:active,
.credit-lib-nav .cred-ver.open .placeholder {
    background: url('/sites/all/themes/usgbc/lib/img/credit-lib/version-active.png') no-repeat;
}

.credit-lib-nav .country .placeholder:active,
.credit-lib-nav .country.open .placeholder {
    background: url('/sites/all/themes/usgbc/lib/img/credit-lib/country-active.png') no-repeat;
}

div#mainCol h3, div#mainCol h4 {
    padding-top: 0;
}

.credit-lib-nav h4 {
	width:150px;
}

#body-container{overflow:hidden;} 

#content{min-height:800px}

.credit-lib-nav .drop-panel{
font-size: 12px;
}

</style>
<script type="text/javascript">
$(document).ready(function() {
	$("#submit-query").click(function() {
		submitform('','','');
	});

	$("#edit-title").live("keypress", function(e) {
        if (e.keyCode == 13) {
        	submitform('','','');
        }
	});


	$("#submit").click(function() {
		submitform('','','');
	});

	$('.country ul a').click(function() {
		$country = $(this).attr("rel");
		if($country.toLowerCase() != 'us'){
			$('#events-search').hide();
			$('#edit-title').val('');
			$ratingsystem = $('.cred-sys').find('.placeholder').text();
			$creditversion = $('.cred-ver').find('.placeholder').text();
			if (($creditversion.toLowerCase() == "select a version") || ($ratingsystem.toLowerCase() == "select a system")){
				//e.preventDefault();
				return;
			}
			else{
				submitform('','',$country.toLowerCase());
				
			}
		}else{
			$('#events-search').show();
			$('#edit-title').val('');	
		}
		
	});

	$('.cred-sys ul a').click(function() {
		$country = $('.country ul li.active a').attr("rel");
		if(typeof($country) != "undefined" && $country !== null){
			if($country.toLowerCase() != 'us'){
				//$ratingsystem = $('.cred-sys').find('.placeholder').text(); || ($ratingsystem.toLowerCase() == "select a system")
				$creditversion = $('.cred-ver').find('.placeholder').text(); 
				if (($creditversion.toLowerCase() == "select a version")){
					//e.preventDefault();
					return;
				}
				else{
					submitform($(this).attr("rel"),'','');
					
				}
			}
		}
		
	});

	$('.cred-ver ul a').click(function() {
		$country = $('.country ul li.active a').attr("rel");
		if(typeof($country) != "undefined" && $country !== null){
			if($country.toLowerCase() != 'us'){
				$ratingsystem = $('.cred-sys').find('.placeholder').text();
				//$creditversion = $('.cred-ver').find('.placeholder').text(); ($creditversion.toLowerCase() == "select a version") ||
				if ( ($ratingsystem.toLowerCase() == "select a system")){
					//e.preventDefault();
					return;
				}
				else{
					submitform('',$(this).attr("rel"),'');
					
				}
			}
		}
		
	});
	


	
});

function submitform(ratingsystem,creditversion,country){
	if(ratingsystem != ''){
		$ratingsystem = ratingsystem;
	}else{
		$ratingsystem = $('.cred-sys ul li.active a').attr("rel");
		if(typeof($ratingsystem) == 'undefined') $ratingsystem = '';
	}
	if(creditversion != ''){
		$creditversion = creditversion;
	}else{
		$creditversion = $('.cred-ver ul li.active a').attr("rel");
		if(typeof($creditversion) == 'undefined') $creditversion = '';
	}
	if(country != ''){
		$country = country;
	}else{
		$country = $('.country ul li.active a').attr("rel");
		if(typeof($country) == 'undefined') $country = '';
	}
	$zip = $('#edit-title').val();

	if($ratingsystem != '' && $creditversion != '')
		window.location='/rpc/' + $ratingsystem + '/' + $creditversion + '/' + $country + '/' + $zip;
	
}

</script>
<?php 
function getcountryName($countrycode){
	switch ($countrycode) {
	    case 'us':
	        return "United States";
	        break;
	    case 'ar':
	        return "Argentina";
	        break;
	    case 'br':
	        return "Brazil";
	        break;
	    case 'cl':
	        return "Chile";
	        break;
	    case 'cn':
	        return "China";
	        break;
	    case 'co':
	        return "Colombia";
	        break;
	    case 'fi':
	        return "Finland";
	        break;
	    case 'de':
	        return "Germany";
	        break;	        
	    case 'hk':
	        return "Hong Kong";
	        break;
	    case 'in':
	        return "India";
	        break;	        
	    case 'mo':
	        return "Macau";
	        break;		        
	    case 'mx':
	        return "Mexico";
	        break;	 
	    case 'no':
	        return "Norway";
	        break;	
	    case 'pe':
	        return "Peru";
	        break;		        
	    case 'ro':
	        return "Romania";
	        break;
	    case 'es':
	        return "Spain";
	        break;	
	    case 'se':
	        return "Sweden";
	        break;	
	    case 'tr':
	        return "Turkey";
	        break;
	    case 'jo':
	        return "Jordan";
	        break;
	    case 'qa':
	        return "Qatar";
	        break;	        	        
	    case 'other':
	        return "Other countries";
	        break;	        		        	               		        	               	        	        	        	        
	    default:
	       return "Select a Country";
	}
}
?>
<?php $args = $view->args;
$ratingsystem = ($args['0'] != '') ? $args['0'] : 'Select a System';
$creditversion = ($args['1'] != '') ? $args['1'] : 'Select a Version';
$country = ($args['2'] != '') ? $args['2'] : 'Select a Country';
$zip = ($args['3'] != '') ? $args['3'] : 'Search zip code';

$country_name = getcountryName(strtolower($country));

$ratingsys = ($args['0'] != '') ? $args['0'] : ''; 
$creditver = ($args['1'] != '') ? $args['1'] : '';
$ctry = ($args['2'] != '') ? $args['2'] : ''; 
$zipcode = ($args['3'] != '') ? $args['3'] : ''; 

?>
<div class="credit-lib-nav ">
	<h4>Filter</h4>
	<div class="cred-sys drop-menu">
		<a href="#" class="placeholder"><?php print getRPCRatingSystem($ratingsystem);?></a>
		<ul class="drop-panel">
			<li <?php if($ratingsystem == 'LEED-NC'):?>class="active"<?php endif;?>><a href="#" rel="LEED-NC"><?php print getRPCRatingSystem('LEED-NC');?></a></li>
			<li <?php if($ratingsystem == 'LEED-EB:OM'):?>class="active"<?php endif;?>><a href="#" rel="LEED-EB:OM"><?php print getRPCRatingSystem('LEED-EB:OM');?></a></li>
			<li <?php if($ratingsystem == 'LEED-CI'):?>class="active"<?php endif;?>><a href="#" rel="LEED-CI"><?php print getRPCRatingSystem('LEED-CI');?></a></li>
			<li <?php if($ratingsystem == 'LEED-CS'):?>class="active"<?php endif;?>><a href="#" rel="LEED-CS"><?php print getRPCRatingSystem('LEED-CS');?></a></li>
			<li <?php if($ratingsystem == 'LEED FOR SCHOOLS'):?>class="active"<?php endif;?>><a href="#" rel="LEED FOR SCHOOLS"><?php print getRPCRatingSystem('LEED FOR SCHOOLS');?></a></li>
			<li <?php if($ratingsystem == 'LEED-NC Retail'):?>class="active"<?php endif;?>><a href="#" rel="LEED-NC Retail"><?php print getRPCRatingSystem('LEED-NC Retail');?></a></li>
			<li <?php if($ratingsystem == 'LEED-CI Retail'):?>class="active"<?php endif;?>><a href="#" rel="LEED-CI Retail"><?php print getRPCRatingSystem('LEED-CI Retail');?></a></li>
			<li <?php if($ratingsystem == 'LEED-HC'):?>class="active"<?php endif;?>><a href="#" rel="LEED-HC"><?php print getRPCRatingSystem('LEED-HC');?></a></li>
	<!--	<li <?php if($ratingsystem == 'LEED-CS PRECERT'):?>class="active"<?php endif;?>><a href="#" rel="LEED-CS PRECERT"><?php print getRPCRatingSystem('LEED-CS PRECERT');?></a></li>
			<li <?php if($ratingsystem == 'LEED Italia NC'):?>class="active"<?php endif;?>><a href="#" rel="LEED Italia NC"><?php print getRPCRatingSystem('LEED Italia NC');?></a></li>			
	 -->	<li <?php if($ratingsystem == 'LEED-ND'):?>class="active"<?php endif;?>><a href="#" rel="LEED-ND"><?php print getRPCRatingSystem('LEED-ND');?></a></li>
			
<!-- 
LEED FOR SCHOOLS v2010
LEED FOR SCHOOLS v2011
LEED FOR SCHOOLS v2012
LEED FOR SCHOOLS v2013
LEED FOR SCHOOLS v2014
LEED-CI v2010
LEED-CI v2011
LEED-CI v2012
 -->
		</ul>
	</div>

	<div class="cred-ver drop-menu">
		<a href="#" class="placeholder"><?php print $creditversion;?></a>
		<ul class="drop-panel">
			<li <?php if($creditversion == 'v2009'):?>class="active"<?php endif;?>><a href="#" rel="v2009">v2009</a></li>
		</ul>
	</div>
	
	<div class="country drop-menu">
		<a href="#" class="placeholder"><?php print $country_name ;?></a>
		<ul class="drop-panel">
			<li <?php if(strtolower($country) == 'us'):?>class="active"<?php endif;?>><a href="#" rel="US">United States</a></li>
			<li <?php if(strtolower($country) == 'ar'):?>class="active"<?php endif;?>><a href="#" rel="AR">Argentina</a></li>
			<li <?php if(strtolower($country) == 'br'):?>class="active"<?php endif;?>><a href="#" rel="BR">Brazil</a></li>
			<li <?php if(strtolower($country) == 'cl'):?>class="active"<?php endif;?>><a href="#" rel="CL">Chile</a></li>
			<li <?php if(strtolower($country) == 'cn'):?>class="active"<?php endif;?>><a href="#" rel="CN">China</a></li>
			<li <?php if(strtolower($country) == 'co'):?>class="active"<?php endif;?>><a href="#" rel="CO">Colombia</a></li>
			<li <?php if(strtolower($country) == 'fi'):?>class="active"<?php endif;?>><a href="#" rel="FI">Finland</a></li>
			<li <?php if(strtolower($country) == 'de'):?>class="active"<?php endif;?>><a href="#" rel="DE">Germany</a></li>
			<li <?php if(strtolower($country) == 'hk'):?>class="active"<?php endif;?>><a href="#" rel="HK">Hong Kong</a></li>
			<li <?php if(strtolower($country) == 'in'):?>class="active"<?php endif;?>><a href="#" rel="IN">India</a></li>
			<li <?php if(strtolower($country) == 'jo'):?>class="active"<?php endif;?>><a href="#" rel="JO">Jordan</a></li>
			<li <?php if(strtolower($country) == 'mo'):?>class="active"<?php endif;?>><a href="#" rel="MO">Macau</a></li>
			<li <?php if(strtolower($country) == 'mx'):?>class="active"<?php endif;?>><a href="#" rel="MX">Mexico</a></li>
			<li <?php if(strtolower($country) == 'no'):?>class="active"<?php endif;?>><a href="#" rel="NO">Norway</a></li>
			<li <?php if(strtolower($country) == 'pe'):?>class="active"<?php endif;?>><a href="#" rel="PE">Peru</a></li>
			<li <?php if(strtolower($country) == 'qa'):?>class="active"<?php endif;?>><a href="#" rel="QA">Qatar</a></li>
			<li <?php if(strtolower($country) == 'ro'):?>class="active"<?php endif;?>><a href="#" rel="RO">Romania</a></li>
			<li <?php if(strtolower($country) == 'es'):?>class="active"<?php endif;?>><a href="#" rel="ES">Spain</a></li>
			<li <?php if(strtolower($country) == 'se'):?>class="active"<?php endif;?>><a href="#" rel="SE">Sweden</a></li>
			<li <?php if(strtolower($country) == 'tr'):?>class="active"<?php endif;?>><a href="#" rel="TR">Turkey</a></li>
			<li <?php if(strtolower($country) == 'other'):?>class="active"<?php endif;?>><a href="#" rel="Other">Other countries</a></li>
		</ul>
	</div>
</div>
<div id="events-search" class="jumbo-search <?php if(strtolower($country) != 'us' || strtolower($country) == 'select a country'):?> hidden <?php endif;?>">
	<div class="jumbo-search-container">
        <input id="edit-title" type="text" class="jumbo-search-field default" name="keys" value="<?php echo $zip ; ?>">
        <input id="submit-query" type="submit" class="jumbo-search-button" name="" value="Search" src="/themes/usgbc/lib/img/search-icon-button.gif">   
    </div>
</div>

<?php 

	//$query = "select ZZONE from extracts.ZL3_ZIP_ZONE where ZLAND = '%s' and PSTLZ = '%s' and ZRATINGSYSTEM LIKE '%".$ratingsystem." v%';";
	//$zone = db_result(db_query($query, strtoupper($country), $zipcode));

	//$query_credit_id = "select DISTINCT CREDIT_ID from extracts.ZL3_RBC where ZIPCODE like '".$zone."' and RATING_SYSTEM like '%".$ratingsystem." v%';";
   //$result = db_query($query_credit_id); 
   	
	if($ratingsys != ''){
   		$res = get_rpcs($zipcode,strtoupper($country),"ALL");
   		//$ratingsys.' '.$creditver
	}else{
		$res = '';
	}

   	$rpcs = array();
   	$i = 0;
   	if($res != '' && is_array($res->EtRbcList->item)){
	   	foreach($res->EtRbcList->item as $item){
	   		if(strpos(strtolower($item->RatingSystem),strtolower($ratingsys.' '.$creditver)) !== false){
	   			$rpcs[$i]['Zipcode'] = $item->Zipcode;
	   			$rpcs[$i]['RatingSystem'] = $item->RatingSystem;
	   			$rpcs[$i]['CreditId'] = $item->CreditId;
	   			$rpcs[$i]['Threshold'] = $item->Threshold;
	   			$rpcs[$i]['Options'] = $item->Options;
	   			$rpcs[$i]['Path'] = $item->Path;
	   			$rpcs[$i]['Zpoint'] = $item->Zpoint;
	   			$i += 1;
	   		}
	   	}
   	}
   //dsm($rpcs);
   	?>
   	<?php 

   		$tmp = array();
   		foreach($rpcs as $item){
   			if ($item['RatingSystem'] == "LEED-ND v2009"){
   				$tmp[] = substr($item['CreditId'], 2);
   			}else{
   				$tmp[] = $item['CreditId'];
   			}
   		}
   		
   		$result = array_unique($tmp);
  	?>
	<div class="credit-list linelist">
		<ul>
		<?php
		$param = $ratingsys.' '.$creditver;
		$rs_query = "select map_rating_system from extracts.LIRatingSystemMap where rating_system like '%s';";
		$rsv_query = "select map_version from extracts.LIRatingSystemMap where rating_system like '%s';";
		$rs = db_result(db_query($rs_query,$param));
		$rsv = db_result(db_query($rsv_query,$param));

		foreach ($result as $row){

		$query = "select cd.nid from drupal.content_type_credit_definition cd 
				inner join drupal.content_field_credit_rating_system rs
				on cd.nid = rs.nid
				inner join drupal.content_field_credit_rating_sys_version rsv
				on cd.nid = rsv.nid
				where trim(cd.field_credit_short_id_value) like '%s'
				and rs.field_credit_rating_system_value = '%d'
				and rsv.field_credit_rating_sys_version_value = '%d'";
		
		$nid = db_result(db_query($query, $row, $rs));
		if ($nid == ''){
			$query = "select nid from drupal.content_type_credit_definition where field_credit_short_id_value like '%s';";
			$nid = db_result(db_query($query, $row, $rs));
		}
			
		$credit = node_load($nid);

		$path = isset($_GET['q']) ? $_GET['q'] : '<front>';
			$link = url($path, array('absolute' => FALSE));
			$shortid = $credit->field_credit_short_id[0]['value'];
			$catid  = substr($shortid,0,2);
			$catid = strtolower($catid);
			if($catid == 'lt') $catid = 'll';
			if($catid == 'sl') $catid = 'll';
			if($catid == 'gi') $catid = 'gib';
			if($catid == 'in') $catid = 'id';

			$alt_image_path = "/sites/default/files/$catid-blank.png";
			if($catid == 'ip'){
				$alt_image_path = "/sites/default/files/ipc.png";
			}

			$current_nid  = $credit->nid;
			$parent_id = $credit->field_credit_parent[0]['nid'];
			$parent = node_load($parent_id);

			$parent_nid = $credit->field_credit_parent[0]['nid'];
			if($parent_nid){
				$parent_node = node_load($parent_nid);
				$parent_image = $parent_node->field_credit_icon[0]['filepath'];
			}

			if($parent_image)
			$credit_icon_path = $parent_image;
			if($credit->field_credit_icon[0]['filepath'])
			$credit_icon_path = $credit->field_credit_icon[0]['filepath'];
			?>

				<li>

					<div class="views-field-field-category-logo-fid">
					<?php if($credit_icon_path){?>
						<img width="40" height="40" alt=""
							src="<?php print file_create_url($credit_icon_path);?>"
							class="left">
							<?php } else {?>
						<img width="40" height="40" alt=""
							src="<?php print $alt_image_path;?>" class="left">
							<?php }?>
					</div> 

					<h2>

					<?php
					$node_title = $credit->title;
					print "<a href='/node/$credit->nid?return=$link'>$node_title</a>" ?>
					</h2> <?php $points = '';
					$low = $credit->field_credit_points_possible_low[0]['value'];
					$upp = $credit->field_credit_points_possible_upp[0]['value'];
					if($credit->field_credit_required_flag[0]['value'] == "Required"){
						$points = "Required";
					}else if ($low == $upp){
						if (intval($low) > 1){
							$points = $low.' points';
						}else{
							$points = $low.' point';
						}
					}else{
						if (intval($upp) > 1){
							$points = 'Up to '.$upp.' points';
						}else{
							$points = 'Up to '.$upp.' point';
						}

					}

					?> 
					<?php //Hide Credit Short Id for v4 version tid=1223 ?>
					<?php if($credit->field_credit_rating_sys_version[0]['value'] == '1223'):?> 
						<p class="credit-id">
							<?php echo $points;?>
						</p>
					<?php else:?>
						<p class="credit-id">
						<?php print $credit->field_credit_short_id[0]['value'];?>
							|
							<?php echo $points;?>
						</p>
					<?php endif;?>
				<?php foreach($rpcs as $item){ 
						if (strpos($item['CreditId'], $credit->field_credit_short_id[0]['value']) !== false){
						if($item['Options'] != '' || $item['Path'] != '' || $item['Threshold'] != ''  || $item['Zpoint'] != ''){
					$string = '';
				?>
					<?php if($item['Options'] != ''){
						$string = '<p class="credit-id">Options: '.$item['Options'];
						} ?>
					<?php if($item['Path'] != '' || $item['Threshold'] != ''){
						if($string != ''){
							$string .= " | ";	
						}
						if($string == ''){
						$string .= '<p class="credit-id">Threshold/Path: ';
							if($item['Path'] != '' && $item['Threshold'] != ''){
								$string .= $item['Threshold'].'/'.$item['Path'];
							}else{
								if($item['Threshold'] != '') $string .= $item['Threshold'];
								if($item['Path'] != '') $string .= $item['Path'];
							}
						}else{
							$string .= 'Threshold/Path: ';
							if($item['Path'] != '' && $item['Threshold'] != ''){
								$string .= $item['Threshold'].'/'.$item['Path'];
							}else{
								if($item['Threshold'] != '') $string .= $item['Threshold'];
								if($item['Path'] != '') $string .= $item['Path'];
							}
						}
						} ?>
				<?php	$string .= "</p>";
				print $string;
						
						}
						}
				}  ?>
				</li>
				
	<?php 	
	}
	?>
	</ul>
</div>
<?php if (empty($result) && $ratingsys == 'LEED-ND' && strtolower($country) != 'us'):?>
	<div class="dotted-box ">
	    <p class="centered-text">At this time, Regional Priority Credit selections are not available for LEED for Neighborhood Development outside of the U.S.</p>
    </div>
<?php elseif(empty($result)):?>
	<div class="dotted-box ">
	    <p class="centered-text">Select a Version, System, Country and Zip code to view the available regional priority credits.</p>
    </div>
<?php endif;?>

