<?php
$GLOBALS['conf']['cache'] = FALSE;
 global $user; 

$isactive = true;
$renew = false;
$reactivate = false;
$yettorenew = false;

if ($user->uid){
    $person=content_profile_load('person', $user->uid);
	 if($user->uid){
	      $subscriptions = og_get_subscriptions($user->uid);
	      if($subscriptions){
	        foreach($subscriptions as $subscription){
	          if($subscription['type']=='organization'){
	            $node=node_load($subscription['nid']);
	          	 	 $_SESSION['orgnid'] = $node->nid;     
	          	 	 $sapordernumber = $node->field_org_saporderid[0]['value'];	
	          	 	 if($node->status == 0 || $node->field_order_status[0]['value'] == 'Pending') {
	          	 	 	$isactive = false;
	          	 	 	$rid = _user_get_rid(ROLE_ORG_ADMIN);
						$uid = db_result(db_query_range("SELECT uid FROM {og_users_roles} WHERE gid = %d AND rid = %d", $subscription['nid'], $rid, 0, 1));	 	 	
	          	 	 }
	          	 	 else {
	          	 		 if(strtotime(date("Y-m-d", strtotime($node->field_org_validto[0]['value']))."-90 days") < strtotime(date("Y-m-d")))
		          	 	 { 
		          	 	 	if($node->field_org_autorenewal[0]['value'] == 0){
			          	 	 	$reactivate  = false;
			          	 	 	$renew = false;
			          	 	 	$yettorenew = true;
			          	 	 	$numdays = round(abs(strtotime($node->field_org_validto[0]['value']) - strtotime("today"))/(86400));
			          	 	 	if($numdays == 0){$numdays = "today";}
			          	 	 	else{$numdays = "in ".$numdays." days";} 
		          	 	 	}
		          	 	 }
		          	 	 if(strtotime(date("Y-m-d", strtotime($node->field_org_validto[0]['value']))) < strtotime(date("Y-m-d")))
		          	 	 { 
		          	 	 	if($node->field_org_autorenewal[0]['value'] == 0){
			          	 	 	$renew  = true;
			          	 	 	$reactivate = false;
			          	 	 	$yettorenew = false;
		          	 	 	}		          	 	 	
		          	 	 }
		          	 	 if(strtotime(date("Y-m-d", strtotime($node->field_org_validto[0]['value']))."+90 days") < strtotime(date("Y-m-d")))
		          	 	 { 
		          	 	 	if($node->field_org_autorenewal[0]['value'] == 0){
			          	 	 	$reactivate  = true;
			          	 	 	$renew = false;
			          	 	 	$yettorenew = false;
		          	 	 	}
		          	 	 }       	 		
	          	 	 }
	           	break;
	          }
	        }
	      }
	    }
	}
	else {
		$destination =  $_SERVER['REQUEST_URI'];
		header("Location: /user/login?destination=$destination");
		

	}
/**
 * @file
 * Displays a single Drupal page.
 */
$scripts .= '<script type="text/javascript">$(document).ready(function(){$("checkbox").click(function(event) {alert("this is my account subscriptions - global.js");});});</script>';


$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/jquery.usgbc.panelNavigation.js"></script>';
$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/jquery.scrollbars.js"></script>';
$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/section/account.js"></script>';
$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/section/alerts.js"></script>';
$scripts .= '<script type="text/javascript" src="/sites/all/modules/usgbc_core/usgbc_core.js"></script>';
$styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/css/section/account.css" />';



include('page_inc/page_top.php'); ?>   

      <div id="account-mast">
        <h3><?php print $person->field_per_fname[0]['value']; ?>&rsquo;s account</h3>
        <?php if(!empty($_SESSION['orgnid'])):?>
        <?php //dsm($node);?>
        <?php if($node->field_org_accesscode[0]['value']!='') {?><h4><?php print $node->title; }?></h4>
        <?php if($node->field_org_accesscode[0]['value']!='') {?><h5>Member ID #<?php print $node->field_org_accesscode[0]['value']; }?></h5>
<!--
       	 <?php if($node->field_org_membersince[0]['value']!='') {?><h5>Member since <?php print date("F j, Y", strtotime($node->field_org_membersince[0]['value']));}?></h5>
-->
		<a class="more-link" href="/account/membership">Membership details</a>
    	<?php endif;?>
    	</div>
    		<script language="javascript" type="text/javascript">
		                        	<!--
		                        	function popitup(url) {
		                        		newwindow=window.open(url,'name','height=1100,width=870');
		                        		if (window.focus) {newwindow.focus()}
		                        		return false;
		                        	}

		                        	// -->
		     </script>
									
<?php $currenturl = explode("?", $_SERVER['REQUEST_URI']);?>
<div id="content">
  
      <div id='navCol' class='clearfix'>
          <?php if (!empty($section_sub_menu)) print $section_sub_menu; ?>
      </div>
      <div class="subcontent-wrapper">
       	<div id="mainCol">
      		<?php print $content; ?>
  		</div>
 
  		<div id="sideCol">
  			<?php if($yettorenew){?>
			<div class="inactive_member">
			    <div class="aside mem-status">
			    	<p class="active">Your membership is due <br/><?php print $numdays;?>.</p>			    	
			        <a class="large-button" href="/join-center/member/renew/<?php print $node->nid;?>">
			            <div class="arrow-button" href="/join-center/member/renew/<?php print $node->nid;?>"><span>Pay now</span></div>
			        </a>
			    </div>
			</div>
			<?php }?>
  			<?php if($isactive && !$renew && !$reactivate){?>
  			<div class="active_member">
	  			<div class="block block-content_complete" id="block-content_complete-person">	
				 <div class="block-content clear-block ">
				 <h4>NEXT STEPS</h4>
	  			<?php
	  				$block = module_invoke('content_complete','block','view','person');
					print $block['content']; ?>
				</div>
				</div>
			</div>
			<?php }?>	
			<?php if(!$isactive){
			
			?>
				<div class="renew_member">   
				    <div class="aside mem-status">
				        <p class="active">Your membership is pending.</p>
				        <?php if($uid == $user->uid){?>
				         <a class="large-button" href="/join-center/member/renew/<?php print $node->nid;?>">
			            	<div class="arrow-button" href="/join-center/member/renew/<?php print $node1->nid;?>"><span>Pay now</span></div>
			            <?php }?>
			        </a>       
				    </div>   
				</div>
			<?php }?>
			<?php if($renew){?>
			<div class="inactive_member">
			    <div class="aside mem-status">
			    	<p class="active">Your membership is past due.</p>			    	
			        <a class="large-button" href="/join-center/member/renew/<?php print $node->nid;?>">
			            <div class="arrow-button" href="/join-center/member/renew/<?php print $node->nid;?>"><span>Pay now</span></div>
			        </a>
			    </div>
			</div>
			<?php }?>
			<?php if($reactivate){?>
			<div class="inactive_member">
			    <div class="aside mem-status">
			    	<p class="active">Your membership is past due.</p>			    	
			        <a class="large-button" href="/join-center/member/reactivate/<?php print $node->nid;?>">
			            <div class="arrow-button" href="/join-center/member/reactivate/<?php print $node->nid;?>"><span>Pay now</span></div>
			        </a>
			    </div>
			</div>
			<?php }?>
		</div>
  		
  	  </div>
</div><!--content-->
      
<?php include('page_inc/page_bottom.php'); ?>