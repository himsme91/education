<?php
$pageurl = $_SERVER["REQUEST_URI"];
$param_id = ($_GET['id'] != '') ? $_GET['id'] : '';
watchdog('pageurl', $param_id);
$GLOBALS['conf']['cache'] = FALSE;

if($param_id != '' && strstr($pageurl,'account/edit/profile')){
	
	$user = user_load(array('uid'=>$param_id));
	watchdog('loading uid', $user->uid);
}else{
 global $user; 
}
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
	           //	break;
	          }
	          if($subscription['type']=='usgbc_friend'){
	          	 $friend=$subscription['nid'];
	          	 $chpexpiredate = db_result (db_query ("SELECT FROM_UNIXTIME(expire) FROM {og_expire} WHERE uid = %d AND nid = %d", $user->uid, $friend));
	         
	          	 if($chpexpiredate){
		          	 if(strtotime(date("Y-m-d", strtotime($chpexpiredate))."-90 days") < strtotime(date("Y-m-d")))
			          {
			          	 $friendnumdays = round(abs(strtotime($chpexpiredate) - strtotime("today"))/(86400));
				         if($friendnumdays == 0){$friendnumdays = "today";}
				         else{$friendnumdays = "in ".$friendnumdays." days";} 
				         $friendmsg = "Your individual membership is due ".$friendnumdays;
			          }
			          if(date("Y-m-d") > date("Y-m-d", strtotime ( $chpexpiredate)))
						{ 
							 $friendmsg  = "Your individual membership is past due";
						}      
	          	 }else{
	          	 	$friendmsg  = "Your individual membership is pending";
	          	 }
	          }
	        }
	      }
	    }
	}
	else {
		$_SESSION['orgnid'] = $node->nid;     				
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



include('page_inc/page_top.php'); 


?>   

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
<?php if($currenturl[0] != '/account/purchases/orderdetails'):?>
<div id="content">
  
      <div id='navCol' class='clearfix'>
          <?php if (!empty($section_sub_menu)) print $section_sub_menu; ?>
      </div>
      <div class="subcontent-wrapper">
       	<div id="mainCol">
      		<?php print $content; ?>
  		</div>
 <?php if (!strstr($pageurl,'account/edit/profile')):?>
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
  				<?php if(!strstr($pageurl,'account/ballots') ){?>
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
			<?php if($friendmsg != ""){?>
				<?php if(!strstr($pageurl,'account/ballots')){?>
			<div class="inactive_member">
			    <div class="aside mem-status">
			    	<p class="active"><?php print $friendmsg;?></p>			    	
			        <a class="large-button" href="/join-center/individual/renew/">
			            <div class="arrow-button" href="/join-center/individual/renew/"><span>Pay now</span></div>
			        </a>
			    </div>
			</div>
				<?php }?>
			<?php }?>
			<!--  additions for membership and account alerts contact info -->
			<?php $pageurl = $_SERVER["REQUEST_URI"];?>
			<?php if(strstr($pageurl,'account/membership')){?>
			<?php if($user->uid)
				 { 
				 	
					if (isset($_SESSION['orgnid']))
 						{
 							$node1=node_load($_SESSION['orgnid']);
 							if($node1->nid)
 							{ ?>
 							<?php 
 							  global $user;
							     $values['uid'] = $user->uid;
								$userprefs = db_fetch_array(usgbc_select_user_alert_pref($values)) ;

								if($userprefs){
									$memalerts = !$userprefs['unsubscribe_alerts_account'];
									$mememails = !$userprefs['unsubscribe_alerts_email'];
								}else {
									$memalerts = 1;
									$mememails = 1;
								}
 							
 							?>
 							<div class="section">
								<h5>Membership account alerts</h5>
									<ul class="radiolist inputlist">
								        <li>
								            <label for="chbx1">
								             <span class="text-label"> 
								               <label class="option" for="edit-member-notifi-alerts">
								               <div id="uniform-edit-member-notifi-alerts" class="checker">
								               <span class="checked">
												<input id="edit-member-notifi-alerts" class="form-checkbox toggle" type="checkbox" <?php echo ($memalerts) ? 'checked="checked"': ''; ?> value="" name="member_notifi_alerts" style="opacity: 0;">
												</span> 
									                <?php print $render_form['member_notifi_alerts'];?>
									                </div>
									                </label>
									                </span>
									                  Send me alerts in my account
									               </label>                                        
								        </li>
								    </ul>
							</div>
 								<div class="padded">
 								<ul class="linelist small">
 								<li class="blank">Contact member services at 800-795-1747 or <a href="mailto:membership@usgbc.org">membership@usgbc.org</a></li>
 							
	 								<li class="blank">Manage employees connected to your membership account in your <a href="/account/profile/organization">organization&nbsp;profile</a></li>
	 								<li class="blank">View all employees who are currently connected to your membership account: <a href="/myaccount/downloadmemberslist" class="small-link">Download list</a></li>
 						
 								</ul>
 								</div>
 						<?php 	}
 						}
 					} 
 				} ?>
			
				<!--  additions for membership contact info ends -->
				
					<!--  additions for membership and account alerts contact info -->
		
			<?php if(strstr($pageurl,'account/ballots')){?>
				<div class="inactive_member">
			    <div class="aside mem-status">
			    <span><strong>How does voting work?</strong> </span>
			    <br/>
			    <span align="left">Voting is open to every person who has a usgbc.org site user account that is connected to his/her organization's membership. Each vote cast under the same membership counts as a percentage of the single, aggregate vote allotted to each participating member organization. </span>
				<br/><br/><span align="left">The ballot consists of a write-in function whereby voters have the option to write in a name of their choosing instead of selecting one of the candidate names on the ballot.</span>
				<br/><br/><span align="left"><strong>Need assistance?</strong> <br/>Contact <a href="mailto: board@usgbc.org">board@usgbc.org</a> </span>	   		      
			    </div>
			</div>
			<?php }?>
  		</div>
  		<?php endif;?>
  	  </div>
</div><!--content-->
<?php else:?>
	<?php print $content; ?>
<?php endif;?>

      
<?php include('page_inc/page_bottom.php'); ?>