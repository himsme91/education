<?php
	global $user;

	$usgbcfriend = false;
	if($user->uid){
		$subscriptions = og_get_subscriptions($user->uid);
	    if($subscriptions){
	    	foreach($subscriptions as $subscription){        	
	        if($subscription['type'] == 'usgbc_friend'){
	        		$usgbcfriend = true;
	        	}
	    	}
	    }
	}
  
		$pendingcheck = false;
		$type = 'usgbc_friend';
  		$getfriend = db_fetch_object(db_query("SELECT n.nid, from_unixtime(ou.created) as created FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s')", $user->uid, 1, $type));
  		$chpexpiredate = db_result (db_query ("SELECT FROM_UNIXTIME(expire) FROM {og_expire} WHERE uid = %d AND nid = %d", $user->uid, $getfriend->nid));
		if ($getfriend)
		{
	     //  $chpnode=node_load($getchp->nid);
	       $friendcreated = $getfriend->created;
	    }
	    $reactivate = false;
		if($usgbcfriend == true && $chpexpiredate){
			if(date("Y-m-d") > date("Y-m-d", strtotime ( $chpexpiredate)))
			{ 
				$reactivate  = true;
				$renew = false;
			}      
		}else{
			//pending check payment
			$pendingcheck = true;
		}
 ?> 
<!-- 1st php ends -->
 
<div id="mainCol">
	<h1>Friend of USGBC account</h1>

	<?php if($usgbcfriend == true){?>
	 <?php if($pendingcheck == true){?>
		 <div class="inactive_member inactive-alert">
	        	<p>Your Friend of USGBC Account is pending</p>
	        </div>
	 <?php }else{?>
		<?php if($reactivate == true) { ?>	
		<div class="inactive_member inactive-alert">
        	<p>Please renew your account<a href="/join-center/friend/renew/"><br/>Renew Friend of USGBC</a></p>
        </div>
	    <?php }  ?>
	
 	<?php if ($reactivate == false):?>
	 	<div class="panel_label">
		<h4 class="left">Friend of USGBC</h4>
		</div>
			<div id="change_company" class="panel settings ">
					 					
					<div class="panel_content settings_val displayed">
					<div class="">
					<div class="mem-banner">
						<span class="title">Friend</span>
						<span class="meta">THROUGH <?php print strtoupper(date("F j, Y", strtotime($friendcreated)));?>					            	
								</span>	
								 
							<a class="more-link" href="#" onclick="return popitup('https://new.usgbc.org/benefits')">Benefits</a>
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
						            <dt>Friend since</dt>
						            <dd><?php print date("F j, Y", strtotime($friendcreated));?></dd>
						        </dl>
						     <dl class="form-confirm-list col">
						            <dt>Expires</dt>
						            <dd><?php print date("F j, Y", strtotime($chpexpiredate));?></dd>
						        </dl>
						    
						    </div>
							</div>
					</div>
				</div>
				
				 <p style="margin-top:25px;"> 
				 As a Friend of USGBC you are entitled to a directory listing with notation in our online People directory, discounts on LEED exams and publications, a certificate showcasing your affiliation, and a myriad of opportunities to participate in the global conversation on LEED and green building.
	   			 <a class="more-link small-link" href="/community/friend">Learn more</a>
	<?php endif;
	 }
	?>
	<?php }else {?>
		 <p style="margin-top:25px;">If you live and work outside of the United States, you can affiliate with USGBC as an individual Friend of USGBC.  Becoming a Friend will entitle you to a directory listing with notation in our online People directory, discounts on LEED exams and publications, a certificate showcasing your affiliation, and a myriad of opportunities to participate in the global conversation on LEED and green building.
		 <a class="more-link small-link" href="/community/friend">Learn more</a>
	    <div class="button-group">
	
	    <a class="button" href="/join-center/friend/">Become a friend</a>
	
	    </div>
    <?php }?>
</div>


<div  id="norender" class="hidden">
	<?php print drupal_render($form); ?>
</div>
