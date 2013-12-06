<?php
	global $user;
	$isactive = true;
	$renew = false;
	$reactivate = false;
	$yettorenew = false;
	$person=content_profile_load('person', $user->uid);
	$usgbcfriend = false;
	
	if($user->uid){
		$subscriptions = og_get_subscriptions($user->uid);
	    if($subscriptions){
	    	foreach($subscriptions as $subscription){
	        	if($subscription['type']=='organization'){
	        		$_SESSION['orgnid'] = $subscription['nid'];	
	        	}
	    	 	 if($subscription['type'] == 'usgbc_friend'){
	        		$usgbcfriend = true;
	        	}
	    	}
	    }
	    //MEMBER SECTION
		if (isset($_SESSION['orgnid']))
 		{
            $node1=node_load($_SESSION['orgnid']);
            $sapordernumber = $node1->field_org_saporderid[0]['value'];
            $rid = _user_get_rid(ROLE_ORG_ADMIN);
        	$uid = db_result(db_query_range("SELECT uid FROM {og_users_roles} WHERE gid = %d AND rid = %d", $node1->nid, $rid, 0, 1));
     //   	watchdog("pcuid",$uid);
             
            //dsm($node1);1
 		 		$isactive = true;
	          	 	if($node1->status == 0 || $node1->field_order_status[0]['value'] == 'Pending'){
	          	 	 	$isactive = false;
	          	 	 } 		
	          	 	 else {
	          	 	  	 if(strtotime(date("Y-m-d", strtotime($node1->field_org_validto[0]['value']))."-90 days") < strtotime(date("Y-m-d")))
		          	 	 { 
		          	 	 	if($node1->field_org_autorenewal[0]['value'] == 0){
			          	 	 	$reactivate  = false;
			          	 	 	$renew = false;
			          	 	 	$yettorenew = true;
			          	 	 	$numdays = round(abs(strtotime($node1->field_org_validto[0]['value']) - strtotime("today"))/(86400));
			          	 	 	if($numdays == 0){$numdays = "today";}
			          	 	 	else{$numdays = "in ".$numdays." days";} 
		          	 	 	}
		          	 	 }
		          	 	 if(strtotime(date("Y-m-d", strtotime($node1->field_org_validto[0]['value']))) < strtotime(date("Y-m-d")))
		          	 	 { 
		          	 	 	if($node1->field_org_autorenewal[0]['value'] == 0){
			          	 	 	$renew  = true;
			          	 	 	$reactivate = false;
			          	 	 	$yettorenew = false;
		          	 	 	}
		          	 	 }
		          	 	 if(strtotime(date("Y-m-d", strtotime($node1->field_org_validto[0]['value']))."+90 days") < strtotime(date("Y-m-d")))
		          	 	 { 
		          	 	 	if($node1->field_org_autorenewal[0]['value'] == 0){
			          	 	 	$reactivate  = true;
			          	 	 	$renew = false;
			          	 	 	$yettorenew = false;
		          	 	 	}
		          	 	 }
	          	 		
	          	 	 }
 		}
 		
 		//CHAPTER SECTION
 		$type = "chapter";
	  	
	  	/*
  		$getchp = db_fetch_object(db_query("SELECT n.nid, from_unixtime(ou.created) as created FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s')", $user->uid, 1, $type));
  		$chpexpiredate = db_result (db_query ("SELECT FROM_UNIXTIME(expire) FROM {og_expire} WHERE uid = %d AND nid = %d", $user->uid, $getchp->nid));
		if ($getchp)
		{
	       $chpnode=node_load($getchp->nid);
	       $chpcreated = $getchp->created;
	    }*/
	  	$result = db_query("SELECT n.nid, from_unixtime(ou.created) as created ,  FROM_UNIXTIME(oe.expire) AS expire
	  			FROM {og_uid} ou
	  			INNER JOIN {node} n ON ou.nid = n.nid
	  			INNER JOIN {content_type_chapter} c on c.nid = n.nid
	  			INNER JOIN {og_expire} oe ON oe.nid = n.nid AND oe.uid = ou.uid
	  			WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s') and c.field_chp_handle_registration_value = 1", $user->uid, 1, $type);
	  	if($result->num_rows > 0) {
	  		$idx = 0;
	  	
	  		while ( $row  =  db_fetch_array($result) )  {
	  				
	  			$chpnode = node_load($row['nid']);
	  				
	  			$chp_array[$idx]['title'] 	= $chpnode->title;
	  			$chp_array[$idx]['created'] = $row['created'];
	  			$chp_array[$idx]['expire'] 	= $row['expire'];
	  			$idx++;
	  		}
	  	
	  	}
    }

    //INDIVIDUAL MEMBER
   		 $pendingcheck = false;
		$type = 'usgbc_friend';
  		$getfriend = db_fetch_object(db_query("SELECT n.nid, from_unixtime(ou.created) as created FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s')", $user->uid, 1, $type));
  		$friendexpiredate = db_result (db_query ("SELECT FROM_UNIXTIME(expire) FROM {og_expire} WHERE uid = %d AND nid = %d", $user->uid, $getfriend->nid));
		if ($getfriend)
		{
	     //  $chpnode=node_load($getchp->nid);
	       $friendcreated = $getfriend->created;
	    }
	    $friendreactivate = false;
		if($usgbcfriend == true && $friendexpiredate){
			if(date("Y-m-d") > date("Y-m-d", strtotime ( $friendexpiredate)))
			{ 
				$friendreactivate  = true;
				$friendrenew = false;
			}      
		}else{
			//pending check payment
			$pendingcheck = true;
		}
	   foreach ($form as $k => $v) {
        if (!is_array($v)) continue;
        if (substr($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
    }
     $render_form['member_notifi_alerts'] = drupal_render($form['member_notifi_alerts']);
    $render_form['member_notifi_emails'] = drupal_render($form['member_notifi_emails']);
    
 ?> 
<!-- 1st php ends -->
 
<div id="mainCol">
	<h1>Membership account</h1>
 
 <div class="panels enabled ">
<?php if($usgbcfriend == true){?>
 <div id="show_friend" class="panel hide_link">
				
	 	<div class="panel_label"   style="margin-top:25px;">
			<h4 class="left">Membership for Individuals (outside US)</h4>
		 	<div class="label_link right">
				            <a class="show_link" href="">show</a>
				            <a class="hide_link" href="">hide</a>
				        </div>
		</div>
		  <div class="panel_content">
				<div class="mem-banner">
						<span class="title">Individual Member</span>
						<span class="meta">THROUGH <?php print strtoupper(date("F j, Y", strtotime($friendexpiredate)));?>					            	
								</span>	
								 
							<a class="more-link" href="#" onclick="return popitup('<?php print USGBCHOST;?>/community/membership_individual#savings')">Benefits</a>
								<script language="javascript" type="text/javascript">
		                        	<!--
		                        	function popitup(url) {
		                        		newwindow=window.open(url,'name','height=1100,width=870,scrollbars=yes');
		                        		if (window.focus) {newwindow.focus()}
		                        		return false;
		                        	}

		                        	// -->
		                        	</script>
									
							</div>
					
						    <div class="two-col">
						      <dl class="form-confirm-list col">
						            <dt>Member since</dt>
						            <dd><?php print date("F j, Y", strtotime($friendcreated));?></dd>
						        </dl>
						     <dl class="form-confirm-list col">
						            <dt>Expires</dt>
						            <dd><?php print date("F j, Y", strtotime($friendexpiredate));?></dd>
						        </dl>
						    
						    </div>				
			</div>	
			</div>
	<?php }else if($node1->nid) {?>
		  <div id="show_friend" class="panel hide_link">
				
				    <div class="panel_label"  style="margin-top:25px;">
				        <h4 class="left">Membership for Individuals (outside US)</h4>
				 
				    </div>
				
				    <div class="panel_content">

				     <p style="margin-top:25px;">If you live outside the United States you can become an individual member<br/> <a class="more-link small-link" href="/community/chapters"> Learn more</a></p>
						<div class="btn-group">
							 <a class="alt-button left" href="/join-center/individual">Join as an individual</a>
						</div>
				    </div>
				</div>

    <?php }?>
</div>
 
 <?php 
 if(!$node1->nid){
 	
 	$type = "organization";
	$getstatus = db_result(db_query("SELECT ou.nid FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.is_active = %d AND ou.uid = %d AND n.type IN ('%s')", 0, $user->uid, $type));
	if($getstatus) {
		$node1=node_load($getstatus);
		
        	$rid = _user_get_rid(ROLE_ORG_ADMIN);
        	$uid = db_result(db_query_range("SELECT uid FROM {og_users_roles} WHERE gid = %d AND rid = %d", $node1->nid, $rid, 0, 1));
        	watchdog("pcuid",$uid);
        	$admin = user_load(array('uid' => $uid));
        	$adminprofile = content_profile_load('person', $uid);

	?>

				<div class="panels enabled">
	                <div id="change_name" class="static-panel panel">
	                		<div class="panel_label">
	                			<h4 class="left">Details</h4>
	                		</div>
	                		<ul class="simple-feedback-box">
	                        	<li class="warning">
									Your request to be connected to <?php print $node1->title;?>'s membership account is pending approval by 
									the primary contact of your organization: 
									<b><?php if($adminprofile->field_per_fname[0]['value']!='')print $adminprofile->field_per_fname[0]['value']?> <?php if($adminprofile->field_per_lname[0]['value']!='')print $adminprofile->field_per_lname[0]['value']?></b>. <br/><br/>
									However, if you have a member ID, you can search below using your member ID and join the organization.  This does not require an approval by your primary contact.
								</li>
	                    	</ul>
							
						    <div class="find-by-id">
						        <div class="element">
						            <label for="memberid-field" title="">Member ID</label>
						            <p><input id="memberid-field" class="field" type="text" name="" value="" /></p>
						            <div class="element button-group">
						                <a class="small-button triggerSearch" href="/registration/orgsbymemid">Search</a>
						            </div>

						        </div>

						        <div class="aside hidden" id="company-link-results2">

						        </div>
						        <div class="element button-group" style="display:none;">
						                   <?php print drupal_render($form['joincompanybyid']);?>
						             </div>

						    </div>							
	                </div>
	               </div>

 <?php } else {?>
 					<div class="panel_label"   style="margin-top:25px;">
						<h4 class="left">Membership</h4>
					 	
					</div>
				<p><em class="lightweight">Your account is not currently connected to a member organization.</em></p>
                <p>Is your organization already a member of USGBC? Join your company's membership account</p>
				<script type="text/javascript">
                $( document ).ready( function() {
                    $("a[href='#link-to-existing-co']").click(function(){
                        $("#link-to-existing-co").show();
                        return false;
                	});
                });
				</script>
				<div class="button-group">
				    <a class="button" href="#link-to-existing-co">Connect to membership account</a>
                </div>
				<div id="link-to-existing-co" class="hidden aside-dark">
				    <h4 class="form-section-head">Connect to member organization</h4>
				     <ul class="inputlist">
                                <li>
                                    <?php
                                    $form['find-co-by-id']['#help'] = 'The Member ID is the unique identifier for your organization&rsquo;s membership. Providing the Member ID connects your account to your organizations&rsquo;s membership account.';
                                    print drupal_render($form['find-co-by-id']);?>
                                </li>
                                <li>
                                    <?php
                                    print drupal_render($form['find-co-by-name']);?>
                                </li>
                            </ul>

				    <div class="find-by-id hidden">
				        <div class="element">
				            <label for="memberid-field" title="">Member ID</label>
				            <p><input id="memberid-field" class="field" type="text" name="" value="" /></p>
				            <div class="element button-group">
				                <a class="small-button triggerSearch" href="/registration/orgsbymemid">Search</a>
				            </div>

				        </div>

				        <div class="aside hidden" id="company-link-results2">

				        </div>
				        <div class="element button-group" style="display:none;">
				                   <?php print drupal_render($form['joincompanybyid']);?>
				             </div>

				    </div>
				    <div class="find-by-name hidden">
				        <div class="element">
				            <label for="companyname-field" title="My Great Company">Name</label>
				            <div class="autocomplete-anchor"><?php print drupal_render($form['companyname-field']); ?></div>
				            <div class="element button-group">
				                <a class="small-button triggerSearchName" href="/registration/orgsbymemname">Search</a>
				            </div>
				            <div class="aside hidden" id="company-link-results10">


				       		</div>
				       		 <div class="element button-group" style="display:none;">
				                   <?php print drupal_render($form['joincompanybyname']);?>
				             </div>
	        </div>

				    </div>

				</div><!-- link-to-existing-co -->
    	<p style="margin-top:25px;">If your organization is not yet a member of USGBC, membership brings you to the center of green building dialog. If you live outside the United States you can become an individual member. <a class="more-link small-link" href="/community/members">Learn more</a></p>

                    <div class="button-group">

                    <a class="button" href="/join-center/member/">Join as an organization</a>
                    <?php if($usgbcfriend == false){?>
                    <a class="alt-button left" href="/join-center/individual">Join as an individual</a>
					<?php }?>
                    </div>
 				

<?php }
 } else { ?>
	<ul class="simple-feedback-box">	
			<?php if($reactivate)
						{ 	?>	
				    <li class="error inactive_member">Your organization's membership is past due. 
				     <a class="small-link more-link-dark" href="/join-center/member/reactivate/<?php print $node1->nid;?>" style="font-family: 'helvetica neue', arial; ">Pay now</a></li>
			<?php 	   
					}
				?>	
					<?php if($renew)
						{ 	?>	
				    <li class="error inactive_member">Your organization's membership is past due. 
				     <a class="small-link more-link-dark" href="/join-center/member/renew/<?php print $node1->nid;?>" style="font-family: 'helvetica neue', arial; ">Pay now</a></li>
			<?php 	   
					}
				?>	
					<?php if($yettorenew)
						{ 	?>	
				    <li class="error inactive_member">Your organization's membership is due in <?php print $numdays?>. 
				     <a class="small-link more-link-dark" href="/join-center/member/renew/<?php print $node1->nid;?>" style="font-family: 'helvetica neue', arial; ">Pay now</a></li>
			<?php 	   
					}
				?>	
			<?php if(!$isactive){?>		        
				    <li class="error renew_member">Your organization's membership is currently pending receipt of payment.
				    <a class="small-link more-link-dark" href="/join-center/member/renew/<?php print $node1->nid;?>" style="font-family: 'helvetica neue', arial; ">Pay now</a></li>
			<?php }?>
				     <!--
				     <li class="blank">Contact member services at 800-795-1747 or <a href="mailto:membership@usgbc.org">membership@usgbc.org</a></li>
				    <li class="blank">Manage employees connected to your membership account in your <a href="/account/profile/organization">organization&nbsp;profile</a></li>
				    <li class="blank">View all employees who are currently connected to your membership account: <a href="/myaccount/downloadmemberslist" class="small-link">Download list</a></li>
				-->
				</ul>
				<div class="panels enabled ">
				<div id="change_company" class="panel settings ">
					<div class="panel_label">
						<h4 class="left">Membership for Organizations</h4>
					</div>
					 <?php
					 	 global $user;
						 $rid = _user_get_rid(ROLE_ORG_ADMIN);
						 $uid = db_result(db_query_range("SELECT uid FROM {og_users_roles} WHERE gid = %d AND rid = %d", $node1->nid, $rid, 0, 1));
						 $admin = user_load(array('uid' => $uid));
						 $adminprofile = content_profile_load('person', $uid);
					?>
					
					<div class="panel_content settings_val displayed">
					<div class="">
					<div class="mem-banner">
								<?php
									switch($node1->field_org_current_duescat[0]['value']){
									case TAXID_DUESCAT_ORG:
									$murl = 'https://new.usgbc.org/benefits/organizational#mainCol';
									?>
								<span class="title">Organizational</span>
								<?php break;
								case TAXID_DUESCAT_SILVER:
								$murl = 'https://new.usgbc.org/benefits/silver#mainCol';
									?>
								<img class="flag" src="/sites/all/themes/usgbc/lib/img/mem-badges/silver-large.png" alt="">
								<span class="title">Silver</span>
								<?php break;
								case TAXID_DUESCAT_GOLD:
								$murl = 'https://new.usgbc.org/benefits/gold#mainCol';
									?>
								<img class="flag" src="/sites/all/themes/usgbc/lib/img/mem-badges/gold-large.png" alt="">
								<span class="title">Gold</span>
								<?php break;
								case TAXID_DUESCAT_PLATINUM:
								$murl = 'https://new.usgbc.org/benefits/platinum#mainCol';
									?>
								<img class="flag" src="/sites/all/themes/usgbc/lib/img/mem-badges/platinum-large.png" alt="">
								<span class="title">Platinum</span>
								<?php break;
									default:?>
										<span class="title">Member</span>
								<?php }?>
								<?php 
									
									if($node1->field_org_currentlvl_to[0]['value'] != $node1->field_org_validto[0]['value']){
										if($node1->field_org_currentlvl_to[0]['value']){
											$validto = $node1->field_org_currentlvl_to[0]['value'];
										}
										else {
											$validto = $node1->field_org_validto[0]['value'];
										}
									}else {
										$validto = $node1->field_org_validto[0]['value'];
									}
									if(strtotime($validto) > 0){
								?>
 								<span class="meta">THROUGH <?php print strtoupper(date("F j, Y", strtotime($validto)));?>
						            	
								</span>	
								<?php }   //if they have 3 years and platinum -- no upgrade button
								if((strtotime(date("Y-m-d", strtotime($node1->field_org_validto[0]['value']))) < strtotime(date("Y-m-d")."+3 years")) || 
								$node1->field_org_current_duescat[0]['value'] != TAXID_DUESCAT_PLATINUM ){	
									if($node1->field_org_autorenewal[0]['value'] == 1){ //for autorenewal customers, upgrade is available for PCs only
										if($uid > 0 & $user->uid == $uid){
										?>
											<div class="upgrade-button"><a href="/join-center/member/renew/<?php print $node1->nid;?>" class="small-alt-button" style="font-family: 'helvetica neue', arial; ">Upgrade</a></div>
									<?php }
										}else {?> 
											<div class="upgrade-button"><a href="/join-center/member/renew/<?php print $node1->nid;?>" class="small-alt-button" style="font-family: 'helvetica neue', arial; ">Upgrade</a></div>
										<?php }?>
									<?php } if($murl){ ?>
										<a class="more-link" href="#" onclick="return popitup('<?php print $murl;?>')">Membership benefits</a>
									<?php }?>
		                        	<script language="javascript" type="text/javascript">
		                        	<!--
		                        	function popitup(url) {
		                        		newwindow=window.open(url,'name','height=1100,width=870,scrollbars=yes');
		                        		if (window.focus) {newwindow.focus()}
		                        		return false;
		                        	}

		                        	// -->
		                        	</script>
									
							</div>
					
						    <div class="two-col">
						        <dl class="form-confirm-list col">
						            <dt>Company</dt>
						            <dd> <?php print $node1->title;?></dd>
						        </dl>
						        <dl class="form-confirm-list col">
						            <dt>Member ID</dt>
						            <dd><?php print $node1->field_org_accesscode[0]['value'];?></dd>
								</dl>
							</div>
							<div class="two-col">
							
						          <dl class="form-confirm-list col">
						            <dt>Primary contact</dt>
						            <dd><?php if($adminprofile->field_per_fname[0]['value']!='')print $adminprofile->field_per_fname[0]['value']?> <?php if($adminprofile->field_per_lname[0]['value']!='')print $adminprofile->field_per_lname[0]['value']?><br />
						            <?php if($adminprofile->field_per_email[0]['url']!='')print $adminprofile->field_per_email[0]['url']?> <br />
						            <?php if($adminprofile->field_per_phone[0]['value']!='')print $adminprofile->field_per_phone[0]['value']?> </dd>
						        </dl>
						      	<dl class="form-confirm-list col">
						            <dt>Country</dt>
						            <dd><?php if($node1->locations[0]) print location_country_name($node1->locations[0]['country']); ?></dd>
						        </dl>
						    </div>
						    <div class="two-col">
						      <dl class="form-confirm-list col">
						            <dt>Member since</dt>
						            <dd><?php if($node1->field_org_membersince[0]['value']) {print date("F j, Y", strtotime($node1->field_org_membersince[0]['value']));}
						            	else {print "NA";}
						            ?></dd>
						        </dl>
						     <dl class="form-confirm-list col">
						            <dt>Expires</dt>
						            <dd><?php if($node1->field_org_validto[0]['value']) {print date("F j, Y", strtotime($node1->field_org_validto[0]['value']));}
						            	else {print "NA";}
						            ?></dd>
						        </dl>
						    
						    </div>
						    <div class="two-col">
						        
						       <dl class = "form-configm-list col">
									<dt></dt>
									<dd><div class="button-group">
				                     <?php
	                                    print drupal_render($form['leaveorg']);?>
					                   <!--     <a class="small-warning-button" href="membership-notlinked.php">Leave organization</a> -->
					                 </div>
									<p class="small"><strong>Warning:</strong> This action cannot be undone.</p>
									</dd>
								</dl>
								<?php // for members in the new structure only
									if($node1->field_org_current_duescat[0]['value'] > 0) {?>								
								 <dl class="form-confirm-list col">
						            <dt>Auto renewal</dt>
						            <dd><?php if($node1->field_org_autorenewal[0]['value'] == 1) {print "On";}
						            	else {print "Off";} ?> <?php 
						            	if($uid > 0 && $user->uid == $uid){ //only admins have option to change
						            	?>(<a href='/account/billing'>change</a>)
						            	<?php }?>
						            </dd>
						        </dl>
						    	<?php }?>
						    </div>
						<!-- 	<div id="two-col">
								<dl class="form-confirm-list col">
									<dt>Membership account alerts</dt>
									<dd>
										<ul class="radiolist inputlist">
								        <li>
								            <label for="chbx1">
								               <span class="text-label"> 
									                <?php print $render_form['member_notifi_alerts'];?></span>
									                Send me alerts in my account
								            </label>                                        
								        </li>
								    </ul>
							    	</dd>
								</dl>					
							</div>
							-->
						</div>
					</div>

				</div>
			<div id="show_memberonly" class="panel hide_link">
				<?php if(!$murl){ ?>
				    <div class="panel_label">
				        <h4 class="left">Members-only access</h4>
				        <div class="label_link right">
				            <a class="show_link" href="">show</a>
				            <a class="hide_link" href="">hide</a>
				        </div>
				    </div>
				<? } ?>

				    <div class="panel_content">

				        <p>USGBC member organizations make up a community of true leaders in their industries and the green building movement. As a member, you can:</p>

				        <ul class="styledlist">
				            <li>Maintain your competitive edge thanks to unique members-only resources and educational opportunities.</li>
				            <li>Get involved in key decision-making processes that guide the future of USGBC and push the green building industry forward.</li>
				            <li>Save on all USGBC publications, courses, registration fees and more</li>
				        </ul>

				        <p>The benefits of USGBC national membership extend to all full-time employees of USGBC member organizations. <a href="/member" class="more-link small-link">View benefits</a></p>

				    </div>
				</div>
              <div id="show_logo" class="panel show_link">
	                		<div class="panel_label">
	                			<h4 class="left">Member logo</h4>

			                    <div class="label_link right">
			                   		<a class="hide_link" href="">hide</a>
			                   		<a class="show_link" href="">show</a>
			                   		
			                    </div>
	                		</div>

	                		<div class="panel_content hidden">
    	                		<div class="logo-display right">
                              <?php print theme('imagecache', 'fixed_100-100', 'sites/default/files/logos/blk/usgbc-member-logo.png', 'USGBC Member logo');  ?>
    	                		    <p class="caption">Member logo</p>
    	                		</div>

    	                		<div>
    	                		   <!-- <p>Included are several versions of the USGBC member logo for use in your organization's marketing and promotions.</p> -->
    	                		    <p>Access several versions of the USGBC member logo for use in your organization's marketing and promotions.</p>

    	                		    <p class="small">
    	                		        You must comply with the <a href="/trademarks">trademark guidelines</a>.

    	                		    </p>

    	                		    <div class="button-group">
	                                    <a class="large-button" href="/myaccount/downloadmemberlogo">
	                                        <div class="arrow-button">
	                                            <span class="small">Download</span>
	                                        </div>
	                                    </a>
	                                </div>
	                		</div>
	                		</div>
	                </div>
	                <!--  <div id="show_policies" class="panel show_link">
	                    <div class="panel_label">
	                        <h4 class="left">Policies &amp; guidelines</h4>
	                        <div class="label_link right hidden">
	                            <a class="show_link" href="">show</a>
	                            <a class="hide_link" href="">hide</a>
	                        </div>
	                    </div>

	                    <div class="panel_content">
	                        <ul class="styledlist">
	                            <li><a href="/resources/usgbc-national-membership-policies">USGBC National Membership Policy</a></li>
	                            <li><a href="/resources/usgbc-policies-and-procedures-committees-and-working-groups">USGBC Policies and Procedures for Committees and Working Groups</a></li>
	                            <li><a href="/resources/usgbc-bylaws">USGBC Bylaws</a></li>
	                            <li><a href="/resources/usgbc-conflict-interest">Conflict of Interest Policy</a></li>
	                            <li><a href="/resources/usgbc-perceived-conflict-interest">Perceived Conflict of Interest Policy</a></li>
	                            <li><a href="/resources/usgbc-trademark-policy">USGBC Trademark Policy</a></li>
	                        </ul>
	                    </div>

    				 </div>
    				 -->
		 </div>
   <?php } ?>
<div class="panels enabled ">
    <!-- <p style="margin-top:25px;">USGBC Chapters are the local voice of USGBC, and chapter leaders and members are the heart of USGBC's grassroots efforts. Members act locally to realize USGBC's mission of transforming the built environment within a generation. <a class="more-link small-link" href="/community/chapters">Learn more</a></p> -->
    <?php if(!empty($chp_array)) {?>
		
		<div class="panel_label" style="padding-top:10px;">
		<h4 class="left">Membership for Individuals in a U.S Chapter</h4>
		</div>
	
    	<div class="panel settings show_link" id="chapters">
	            <div class="panel_summary settings_val displayed">
	           
	           	               	<div>
	            	    <div class="three-col">
	                        <dl class="form-confirm-list col">
	                            <dt>Name</dt>
					                                  	     	
					             <?php foreach($chp_array as $item){?>
					               <dd style="height: 36px;"><?php print $item['title'];?></dd>
					             <?php }?>
	                	        
	                        </dl>
	                        <dl class="form-confirm-list col">
	                            <dt>Member since</dt>
	                            <?php foreach($chp_array as $item){?>
					               <dd style="height: 36px;"><?php print date("F j, Y", strtotime($item['created']));?></dd>
					             <?php }?> 
	                
	                		</dl>
	                		<dl class="form-confirm-list col">
	                            <dt>Expires</dt>
	                              <?php foreach($chp_array as $item){?>
					               <dd style="height: 36px;"><?php print date("F j, Y", strtotime($item['expire']));?></dd>
					             <?php }?>
	                
	                        </dl>
	            	    </div>
	            	</div>
	            </div>
	           
			</div>
	<?php } else{?><!-- 
		<div class="button-group">
        	<a class="gray-button" href="/join-center/chapter/">Join a chapter</a>
        </div>
         -->
      <!-- Additions for local chapter -->
          <div id="show_chaptermem" class="panel show_link">
				
				    <div class="panel_label">
				        <h4 class="left">Membership for Individuals in a U.S Chapter</h4>
				        <div class="label_link right">
				            <a class="show_link" href="">show</a>
				            <a class="hide_link" href="">hide</a>
				        </div>
				    </div>
				

				    <div class="panel_content hidden">

				     <p style="margin-top:25px;">USGBC Chapters are the local voice of USGBC, and chapter leaders and members are the heart of USGBC's grassroots efforts. <a class="more-link small-link" href="/community/chapters">Learn more</a></p>
						<div class="btn-group">
							<a class="btn btn-primary btn-small" href="/join-center/chapter/">Join a chapter</a>
						</div>
				    </div>
				</div>
    <!-- Additions for local chapter ends -->
  
	
	<?php }?>   
	</div>
</div>


<div  id="norender" class="hidden">
	<?php print drupal_render($form); ?>
</div>
