<style type="text/css"> 
	#body-container{overflow:hidden;} 
	
	#navCol .nav-item .parent{
		background-image: url(/sites/all/themes/usgbc/lib/img/expand.gif);
		background-repeat: no-repeat;
		background-position: right;
	}
	
	#navCol .nav-item .parent:hover{
		background-image: url(/sites/all/themes/usgbc/lib/img/expand-over.gif);
	}
	
	#navCol .nav-item .parent.clicked{
		background-image: url(/sites/all/themes/usgbc/lib/img/collapse.gif);
	}
	
	#navCol .nav-item .parent.clicked:hover{
		background-image: url(/sites/all/themes/usgbc/lib/img/collapse-over.gif);
	}
	
	#navCol .nav-item.parent-menu{
		padding-right:10px !important;
	}
	
	#navCol .nav-item .child{
		font-style:italic;	
		font-size: 12px;
		color: #999;
	}
	
	#navCol li.hide{
		display:none;
	}
	
	.section div.center-content{
		text-align: center;
	}
	
	.pad-this-down{
		margin-bottom:70px;
	}
	
	.no-access{
		margin:5px 0px;
	}
	
</style>

<?php
  // $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
  /**
   * @file views-view-fields.tpl.php
   * Default simple view template to all the fields as a row.
   *
   * - $view: The view in use.
   * - $fields: an array of $field objects. Each one contains:
   *   - $field->content: The output of the field.
   *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
   *   - $field->class: The safe class id to use.
   *   - $field->handler: The Views field handler object controlling this field. Do not use
   *     var_export to dump this object, as it can't handle the recursion.
   *   - $field->inline: Whether or not the field should be inline.
   *   - $field->inline_html: either div or span based on the above flag.
   *   - $field->separator: an optional separator that may appear before a field. 
   * - $row: The raw result object from the query, with all data it fetched.
   *
   * @ingroup views_templates
   */

function get_field_value_reference ($fields, $parent, $grandparent, $step_children, $children, $field_name) {
	$value = NULL;
	if ($parent) {
		$f = $parent->$field_name;
		if (!empty($f[0]['nid'])) {
			foreach ($f as $ref) {
				$value[$ref['nid']] = $ref;
			}
		}
	}
	$c = $current_node->$field_name;
	if (!empty($c[0]['nid'])) {
		foreach ($c as $ref) {
			$value[$ref['nid']] = $ref;
		}
	}

}

function get_field_value($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, $field_name) {
	$value = NULL;
	if ($grandparent) {
		$f = $grandparent->$field_name;
		if (!empty($f[0]['value'])) {
			$value .= content_format ($field_name, $f[0]);
		}
	}
	if ($parent) {
		$f = $parent->$field_name;
		if (!empty($f[0]['value'])) {
			$value .= content_format ($field_name, $f[0]);
		}
	}

	if (!empty($fields[$field_name . '_value']->content)) {
		$value .= $fields[$field_name . '_value']->content;
	}

	foreach ($step_children as $stepchild_id => $stepchild) {
		$f = $stepchild->$field_name;
		if (!empty($f[0]['value'])) {
			if ($children[$stepchild_id]) {
				$f = $children[$stepchild_id]->$field_name;
				if (!empty($f[0]['value'])) {
					if ($fields['field_credit_type_value']->raw == 1 && $parent) {
						$value .= '<h6>Specific to ' . $fields['field_credit_rating_system_value']->content . '</h6>';
					}
					foreach($f as $f_element){
						$value .= content_format ($field_name, $f_element);
					}
		  		}		
			}
		}
	}

	foreach ($children as $child_id => $child) {
		if (!$step_children[$child_id]) {
			$f  = $child->$field_name;
			if (!empty($f[0]['value'])) {
				foreach($f as $f_element){
					$value .= content_format ($field_name, $f_element);
				}
			}
			if($grandchildrenof[$child_id]){
				$grandchildren = $grandchildrenof[$child_id];
				foreach ($grandchildren as $grandchild_id => $grandchild){
					$f = $grandchild->$field_name;
					if (!empty($f[0]['value'])) {
						foreach($f as $f_element){
							$value .= content_format ($field_name, $f_element);
						}
					}
				}
			}
		}
	}
	return $value;
}


  $current_node = node_load ($fields['nid']->content);
  $current_nid = $current_node->nid;
  $user_access = false;
  $reactivate = false;
  $renew = false;

  global $user;
  
  if($user->uid || $user->uid != 0 ) {
  
  	$uid = $user->uid;
	
	if($current_node->field_credit_public_access[0]['value']== 1){
		$user_access = true;
	}else{
		//alternative approach having hard-coded resource node ids.
		$subscriptions = og_get_subscriptions($user->uid);
		dsm($subscriptions);
	    if($subscriptions){
	    	foreach($subscriptions as $subscription){
	        	if($subscription['type']=='subscription' && $subscription['nid'] == WEBBASEDSUBSCRIPTIONNID){
	        		$user_access = true;
	        	}
	    	}
	    }
		
		if($user_access){
			$subexpiredate = db_result (db_query ("SELECT FROM_UNIXTIME(expire) FROM {og_expire} WHERE uid = %d AND nid = %d", $user->uid, WEBBASEDSUBSCRIPTIONNID));
			
			if(strtotime(date("Y-m-d", strtotime($subexpiredate))) < strtotime(date("Y-m-d"))){
				$message = "Your subscription is past due. Please reactivate";
				$reactivate  = true;
				$display = "Reactivate Subscription";
				$user_access = false;
			 }else{
			 	$message = "Your subscription is valid until ".date("Y-m-d", strtotime($subexpiredate));
			 	if(strtotime(date("Y-m-d", strtotime($subexpiredate))."-90 days") < strtotime(date("Y-m-d")))
			    { 
			    	$renew = true;
			    	$display = "Renew Subscription";
			        $numdays = round(abs(strtotime($subexpiredate) - strtotime("today"))/(86400));
			        if($numdays == 0)
			        	$numdays = "today";
			        else
			        	$numdays = "in ".$numdays." days"; 
			        $message = "Your subscription expires in ".$numdays.".";
	
			    }
			 } 
		} 	   
	}
	
	if(is_array($user->roles) && in_array('content admin', $user->roles)){
		$user_access = true;
	}
  }
	
if($user_access){
	
  
  	$parent_field = $fields['field_credit_parent_nid']->handler->field_values[$current_nid];

  	$parent_id = $parent_field[0]['nid'];
  	$parent = node_load ($parent_id);
  	if ($parent) {
  		$grandparent = node_load ($parent->field_credit_parent[0]['nid']);
  	}

  	$children = array();
  	$grandchildren = array();
  	$grandchildrenof = array();
	$dupIndex = 0;
	foreach ($fields['field_credit_options_nid']->handler->field_values as $oid => $oids) {
		foreach ($oids as $option_id => $option) {	
			$child_node = node_load ($option['nid']);
			if($children[$child_node->nid]){
				$dupIndex++;
				$index = $child_node->nid."".$dupIndex;
				$children[$index] = $child_node;
			}else{
				$children[$child_node->nid] = $child_node;
			}
			if($child_node){
				$grandchildren = null;
				if($child_node->field_credit_options[0]){
					foreach($child_node->field_credit_options as $gcid=>$grandchild){
						$grandchild_node = node_load($grandchild['nid']);
						if($grandchild_node){
							$grandchildren[$grandchild_node->nid] = $grandchild_node;
						}
						$grandchildrenof[$child_node->nid] = $grandchildren;
					}

				}
			}
		}
	}		

	$options_array = array();
	$options_array = $parent->field_credit_options;
	$step_children = array();
  	foreach ((array)$options_array as $o) {
    	if ($o['nid'] != $fields['nid']->raw) {
    		$child_node = node_load ($o['nid']);
      		$step_children[$child_node->field_credit_short_id[0]['value']] = $child_node;
    	}
   		 $i++;
  	}
  
	  $introduction        = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_guide_introduction');
	  $behind_intent       = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_behind_the_intent');
	  $guidance            = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_step_by_step_guidance');
	  $documentation       = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_credit_doc_guidance');
	  $further_explanation = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_further_explanation');
	  $calculations        = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_credit_calculations');
	  $examples            = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_credit_examples');
	  $regional            = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_credit_regional_variations');
	  $project_type        = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_project_type_variations');
	  $international_tips  = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_international_tips');
	  $campus              = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_guide_campus');
	  $related_tips        = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_related_credit_tips');
	  $changes             = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_changes_from_previous_ver');
	  $changes_homes_2008  = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_changes_leed_homes_2008');
	  $lang_reco           = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_contract_language_rec');
	  $technical_resources = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_technical_resources');
	  $exemplary           = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_credit_exemp_performance');
	  $verifications_submittals = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_verifications_submittals');
	  $team                = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_team_members');
	  
	  $side_col               = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_credit_side_col_embed');
 
	//This array is full of key->valueArray pairs for all the fields from the view
		$field_class_pair_var = array(
				'field_behind_the_intent' 			=> array('behind_intent', 		'Behind the Intent', 					'menuitem'),
				'field_step_by_step_guidance' 		=> array('guidance', 			'Step-by-Step Guidance', 				'menuitem'),
				'field_credit_doc_guidance' 		=> array('documentation', 		'Required documentation', 				'menuitem'),
				'field_further_explanation' 		=> array('further_explanation', 'Further explanation', 					'menuparent'),
				//'field_credit_calculations' 		=> array('calculations', 		'Calculations', 						'menuchild'),
				//'field_credit_examples' 			=> array('examples', 			'Examples', 							'menuchild'),
				//'field_credit_regional_variations' 	=> array('regional', 			'Rating system variations', 			'menuchild'),
				//'field_project_type_variations' 	=> array('project_type', 		'Project type variations', 				'menuchild'),
				//'field_international_tips'      	=> array('international_tips', 	'International tips', 					'menuchild'),	
				//'field_guide_campus'      			=> array('campus', 				'Campus', 								'menuchild'),
				'field_related_credit_tips'      	=> array('related_tips', 		'Related credit tips', 					'menuitem'),
				'field_changes_from_previous_ver'   => array('changes',				'Changes from LEED 2009', 				'menuitem'),
				'field_changes_leed_homes_2008'     => array('changes_homes_2008',	'Changes from LEED for Homes 2008', 	'menuitem'),
				'field_contract_language_rec'       => array('lang_reco',	'Contract Language Recommendations', 			'menuitem'),
				'field_technical_resources'         => array('technical_resources',	'Technical Resources', 					'menuitem'),		
				'field_all_reference_resources' 	=> array('standards_a', 		'Referenced Standards', 				'menuitem'),
				'field_credit_exemp_performance' 	=> array('exemplary', 			'Exemplary performance', 				'menuitem'),			
				'field_verifications_submittals' 	=> array('verifications_submittals', 	'Verification and Submittals',	'menuitem'),
				'field_team_members' 				=> array('team', 				'Definitions', 							'menuitem'),
		
		);
		
		/* 
		 * #1) Have the $field_class_pair_var array
		 * #2) get the value for the given view-field classname
		 * #3) put that value, paired with its classname, into $usable_fields
		 */
		$usable_fields = array();
		foreach($field_class_pair_var as $class_name => $classInfo){
			$temp_value = get_field_value($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, $class_name);
			$usable_fields[$class_name] =  $temp_value;
		}
		
		$standards_a = array();
		if($current_node->field_all_reference_resources[0]['nid']){
			foreach($current_node->field_all_reference_resources as $reference){
				array_push($standards_a, $reference);
			}
		}
		
		foreach ($step_children as $stepchild_id => $stepchild) {
			if($stepchild->field_all_reference_resources[0]['nid']){
				foreach($stepchild->field_all_reference_resources as $reference){
					array_push($standards_a, $reference);
				}
			}
		}
	
		foreach ($children as $child_id => $child) {
			if($child->field_all_reference_resources[0]['nid']){
			foreach($child->field_all_reference_resources as $reference){
					array_push($standards_a, $reference);
				}
			}	
		}
		
		$resources_a = $current_node->field_all_reference_resources;
	
		if ($standards_a[0]['nid']) {
	    	$usable_fields['field_all_reference_resources']  =  $standards_a[0]['nid'];		
		}

		?>

		<script>
		$(document).ready(function() {
			sections = [];
			
			$('#mainCol .section').each(function(){
				sections.push($(this));
			});
			//mOffset = $('#navCol.sticky').offset();
			//$('.sticky').stickyScroll({ topBoundary: mOffset.top, bottomBoundary: 100 });
			
			var id = $('.menu').find('.active').attr('sid');
			$('#mainCol .section').not('#'+id).hide();
			$('#navCol a:not(.parent)').live('click',function(e){				
				var targetID = $(this).attr('sid');
				$('#navCol .active').removeClass('active');
				$(this).addClass('active');
				
				$('#mainCol .section').hide();
				$('#'+targetID).show();
				return false;
			});
		
			$('#navCol a.parent').click(function(){
				$(this).toggleClass('clicked');			
				$('#navCol a.child').parent().slideToggle();
					return false;
			});
		
			var i = 0;
			$('#mainCol .custom_section').each(function(){
				if (i == 0)
					$('#navCol li.parent-menu').after('<li class="nav-item hide"><a sid="' + $(this).attr('id') + '" class="child ' + $(this).attr('id') + '"" href="#">' + $(this).children('h1').html() + '</a></li>');
				else
					$('#navCol a.child').last().parent().after('<li class="nav-item hide"><a sid="' + $(this).attr('id') + '" class="child ' + $(this).attr('id') + '"" href="#">' + $(this).children('h1').html() + '</a></li>');
		
				i += 1;
			});
			
			$('.section .linknavCol').live('click',function(e){			
				var targetID = $(this).attr('sid');
				$('#navCol .active').removeClass('active');
				$('.'+targetID).addClass('active');
				
				$('#mainCol .section').hide();
				$('#'+targetID).show();
				return false;
			});
			
			
		});
		
		</script>
    
<div id="content" >
<?php if($current_node->field_promotion_text[0]['value'] != ''){?>
	<?php echo $current_node->field_promotion_text[0]['value'] ?>
<?php }?>
<?php if($renew){?>
<div style="border:1px solid #DDD6D6;border-radius:6px 6px 6px 6px;margin-bottom:20px;padding:10px;">
	<form id="subscription-renew" name="subscription-renewal" action="/subscription/contact" method="post">
		<input type="hidden" name="renew_id" value="<?php print WEBBASEDSUBSCRIPTIONNID; ?>" />
	</form>
	<em><?php print $message;?>	Please renew to have continuous access to the guide content by <a class="" href="" onclick="$('#subscription-renew').submit();return false;">clicking here</a>.</em> 
</div>
<?php }?>
  <div id="navCol" class="">
  
  	<!-- Begin sticky-menu-nav -->
  	
	<?php
		echo '<ul class="menu">';
		$i = 0;
		$end_value = sizeof($usable_fields);
		foreach($usable_fields as $class_name => $field_value){
			if($field_value){
				if( $i == 0 ){
					//print the first entry
					echo '<li  class="nav-item first"><a sid="' . $class_name. '" class="active ' . $class_name .'""  href="#">' . $field_class_pair_var[$class_name][1] . '</a></li>';
				}else if( $i != 0 && $i != $end_value){
					if($field_class_pair_var[$class_name][2] == menuitem){
					//print a middle entry
						echo '<li class="nav-item"><a sid="' . $class_name . '" class="' . $class_name . '"" href="#">' . $field_class_pair_var[$class_name][1] . '</a></li>';
					}
					else if($field_class_pair_var[$class_name][2] == menuparent){
						//print a middle entry
						echo '<li class="nav-item parent-menu"><a sid="' . $class_name . '" class="parent ' . $class_name . '"" href="#">' . $field_class_pair_var[$class_name][1] . '</a></li>';
					}
					else if($field_class_pair_var[$class_name][2] == menuchild){
						//print a middle entry
						echo '<li class="nav-item hide"><a sid="' . $class_name . '" class="child ' . $class_name . '"" href="#">' . $field_class_pair_var[$class_name][1] . '</a></li>';
					}
				}else if( $i == $end_value ){
					//print the last entry
					echo '<li class="class="nav-item last"><a sid="' . $class_name . '" class="' . $class_name . '"" href="#">' . $field_class_pair_var[$class_name][1] . '</a></li>';
				}
				$i++;
			}
		}
		echo '</ul>';
	?>
	
	<!-- End sticky-menu-nav  -->

  </div>
  <div id="mainCol">
    <div class="aside">
      <ul class="visual-helpers">
        <li class="glossary">
          <a class="trigger" href="">
            <span class="text">Glossary</span>
          </a>
        </li>
      </ul>
    </div>

    <div class="contributed-content">
    <?php if (!empty($introduction)){ ?>
	    <div style="font-size: 13px;line-height: 1.4;margin-bottom:10px;">
	    <?php print $introduction; ?>
	    </div>
    <?php }?>
    
	<?php if (!empty($fields['field_credit_technologies_value']->content)) { ?>
	<h3>Technologies &amp; strategies</h3>
	<?php print $fields['field_credit_technologies_value']->content; ?>
	<?php }?>

	<!-- Begin view-field sections -->
	
	<?php 
	foreach($usable_fields as $class_name => $field_value){
		if($field_value){
			if($class_name != 'field_further_explanation' && $class_name != 'field_all_reference_resources'){
			echo '<div id="' . $class_name . '" class="section"><h1>' . $field_class_pair_var[$class_name][1] . '</h1>';
			echo $field_value . '</div>';
			}elseif($class_name == 'field_all_reference_resources'){
				
			}else{
				echo $field_value;	
			}
		}	
	}
	
	?>
         
      <?php if ($standards_a[0]['nid']) { ?>
      <div class="section" id="field_all_reference_resources" style="display: none;">
      <?php
      $count = 0;
      
      //check displayed values in $displayed to avoid duplicates
      $displayed = array();
      foreach ($standards_a as $standard) {
		if(! in_array($standard['nid'],$displayed)){
			array_push($displayed, $standard['nid']);
	        $standard_node = node_load ($standard['nid']);
	        $resource_type_term = taxonomy_get_term ($standard_node->field_res_type[0]['value']);
	        $resource_type = $resource_type_term->name;
	        $standard_id = $standard_node->field_res_id[0]['value'];
	        if ($standard_id) {
	          $standard_id = ' [' . $standard_id . ']';
	        }
	        if ($resource_type == "Standards") {
	          $count++;
	          if ($count == 1) {
	            print "<h1>Referenced Standards</h1>";
	          }
	          print "<h5><a target='_blank' href='/node/" . $standard_node->nid . "'>" . $standard_node->title . $standard_id . "</a></h5>";
	          print "</a>";
	          print '<p>' . $standard_node->field_all_description_short[0]['value'] . '</p>';
	        }
		}
      }
      ?>
		</div>
      <?php }?>

</div>
    <?php
    $viewname = 'leed_credits';
    $args = array();
    $args [0] = $fields['nid']->content;
    $display_id = 'page_7'; // or any other display
    $view = views_get_view ($viewname);
    $view->set_display ($display_id);
    $view->set_arguments ($args);
    print $view->preview ();
    ?>
  </div>

  <div id="sideCol">
	  <?php print $side_col;  ?>
	</div> <!-- sideCol -->
		  

</div> <!-- content -->

<?php  }else{
	/*if user is not subscribed to this credit */
?>
<div id="content">
	
<?php  if(!$user->uid || $user->uid == 0 ) {
  	$destination =  $_SERVER['REQUEST_URI'];
  	header("Location: /user/login?destination=$destination");?>
    	<em><a class="jqm-trigger" href="/user/login?destination=<?php echo $destination ?>">Sign in</a> to access the web-based guide content.</em>
  	<?php }elseif(!$reactivate){
	$guide_node = node_load(WEBBASEDSUBSCRIPTIONNID);
	?>
	<a class="jumbo-button-dark right" href="" onclick="$('#subscription-renew').submit();return false;">Subscribe now</a>
	<h2>Web-based Reference Guide</h2>
	<h3>$99/year</h3>	
	<?php print $guide_node->body;?>
		<div class="addtocart">
			<form id="subscription-renew" name="subscription-renewal" action="/subscription/contact" method="post">
		    	<input type="hidden" name="renew_id" value="<?php print WEBBASEDSUBSCRIPTIONNID; ?>" />
		    </form>
		</div>
	<?php }?>
  
   <?php if($reactivate){ ?>
      	<form id="subscription-renew" name="subscription-renewal" action="/subscription/contact" method="post">
	   		<input type="hidden" name="renew_id" value="<?php print WEBBASEDSUBSCRIPTIONNID; ?>" />
	   		<em>Your subscription is past due. To gain access to the guide content please renew by <a href="" onclick="$('#subscription-renew').submit();return false;">clicking here</a>.</em>
	   		<br><br><em>For more information on the LEED v4 web-based guide content go to <a href="/guide">www.usgbc.org/guide</a>.</em>
		</form>
   	<div id="mainCol">
   	</div>
   	<div id="sideCol">
   	</div>
   <?php } ?>
 </div><!--content--> 
 <?php 
} 
?>
