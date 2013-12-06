   <?php 
   		//Display below message for eligible voters only
   		$hidenote = "hidden";
   		$electionnid = db_result(db_query("select e.nid from drupal.content_type_election e left join drupal.node n on n.nid = e.nid where e.field_election_open_value = 1  and n.status = 1 and date(e.field_voting_startdate_value) <= CURDATE() and date(e.field_voting_enddate_value) >= CURDATE();"));
   		$electionnode = node_load($electionnid);
   		if($electionnid > 0 && election_eligible($electionnode)){
			if(!election_voted($electionnode)){
				$hidenote = "";
			}
   		}
   ?>
   
   <div class="emphasized-box has-close-btn <?php print $hidenote?>">                	
                	            
                	<h4>2014 Board Elections</h4> 
                	<p style="margin: 0;"> Vote now for the 2014 USGBC Board of Directors. </p>  
                	<br/>
                	<div class="button-group">
                		<a class="button" href="/account/ballots">View Ballot</a>
                		</div>
                	</div>
   					
   
   <?php 
   		global $user;
		$renew = false;
		$reactivate = false;
		$yettorenew = false;   		
		$isactive = true;
		$orgnid=$_SESSION['orgnid'];

		$values['uid'] = $user->uid;
		$values['alert_type'] = 3;
		$selnum = db_fetch_array(usgbc_select_user_alert_pref($values));
		//if they have chosen to unsubscribe from the alerts, do not display
		if($selnum['unsubscribe_alerts_account'] != 1){
   		if (isset($_SESSION['orgnid']))
		 {
		      $orgnid=$_SESSION['orgnid'];
		      $node=node_load($orgnid);	
		       $sapordernumber = $node->field_org_saporderid[0]['value'];
		      	$rid = _user_get_rid(ROLE_ORG_ADMIN);
				$uid = db_result(db_query_range("SELECT uid FROM {og_users_roles} WHERE gid = %d AND rid = %d", $orgnid, $rid, 0, 1));	 	 	
		 	 	 if($node->status == 0 || $node->field_order_status[0]['value'] == 'Pending'){
		 	 	 /*	if($uid == $user->uid){*/
	          	 	 	$isactive = false;
	          	 	 	$reactivate  = false;
				          $renew = false;
				          $yettorenew = false;
				          $message = "Your organization's membership is currently pending receipt of payment.";		        
				          $linktext = "Cancel";
				          $link = "/contact";
				          $linktext1 = "Pay now";
				          $link1 = "/join-center/member/renew/".$orgnid;
		 	 	 	//	}
	          	 	 }
	          	 	 else {
		 	 	if(strtotime(date("Y-m-d", strtotime($node->field_org_validto[0]['value']))) < strtotime(date("Y-m-d"))){
		 	 		 if(strtotime(date("Y-m-d", strtotime($node->field_org_validto[0]['value']))."+90 days") < strtotime(date("Y-m-d")))
				        { 
				        	if($node->field_org_autorenewal[0]['value'] == 0){
					          	 $reactivate  = true;
					          	 $renew = false;
					          	 $yettorenew = false;
					          	 $message = "Your organization's membership is past due.";
					          	 $linktext = "Pay now";
					          	 $link = "/join-center/member/reactivate/".$orgnid;
				        	}
				           }
				           else{
				           	if($node->field_org_autorenewal[0]['value'] == 0){
				           		$renew  = true;
			          	 	 	$reactivate = false;
			          	 	 	$yettorenew = false;		
			          	 	 	$message = "Your organization's membership is past due.";
			          	 	 	$linktext = "Pay now";
			          	 	 	$link = "/join-center/member/renew/".$orgnid;
				           	}
				           }
		 	 	}else{
		 		 if(strtotime(date("Y-m-d", strtotime($node->field_org_validto[0]['value']))."-90 days") < strtotime(date("Y-m-d")))
		         { 
		         	if($node->field_org_autorenewal[0]['value'] == 0){
		          	 	 	$reactivate  = false;
		          	 	 	$renew = false;
		          	 	 	$yettorenew = true;
		          	 	 	$numdays = round(abs(strtotime($node->field_org_validto[0]['value']) - strtotime("today"))/(86400));
		          	 	 	if($numdays == 0){$numdays = "today";}
		          	 	 	else{$numdays = "in ".$numdays." days";} 
		          	 	 	$message = "Your organization's membership is due ".$numdays.".";
		          	 	 	$linktext = "Pay now";
		          	 	 	$link = "/join-center/member/renew/".$orgnid;
		         	}
		          }
		 	 	}  	   
         	 }    
		 } 	 	 		
		}
   		$values['viewedbyorg'] = '1';
   		$values['orgnid'] = $orgnid;
   		$values['readonceorg'] = '0';
   		$values['viewedbyuser'] = '2';
   		$values['userid'] = $user->uid;
   		$values['readonceuser'] = '0';
   		$result = usgbc_select_alerts($values);
   		if($result->num_rows > 0) {
	   			$output = '<div id="attention-feed">';
	   			  $output.='<ul class="linelist uniform-mini">';
	   			  //Plugin the membership alert
	   			  if($yettorenew || $renew || $reactivate || !$isactive){
	   			  	if($renew || $reactivate){
	   			  		$output.= '<li class="alert-negative first active_member">';
	   			  	}
	   			  	elseif($yettorenew || !$isactive){
	   			  		$output.= ' <li class="alert-neutral active_member">';
	   			  	}
	   			  	$output.='<span class="alert-msg">';
		            $output.=$message;
		            $output.='<div class="button-group">';
	            	$output.='<a href="'.$link.'">'.$linktext."</a>";
	            	if($link1)
	            		$output.='<a href="'.$link1.'">'.$linktext1."</a>";
		            $output.='</div></span>';               
	   			  	$output.='</li>';
	   			  }	   			  
			while (  $row  =  db_fetch_array($result) )  {
			  if($row['priority'] == '1')
			  	$output.= '<li class="alert-negative first active_member">';
			  elseif ($row['priority'] == '2')
			  	$output.= '   <li class="alert-neutral active_member">';
			  elseif ($row['priority'] == '3')
			  	$output.= ' <li class="alert-positive active_member">'; 
			  	 
			  	$output.='<span class="container">';
			  	if($row['candelete'] == 1)
			  		$output.='<a href="#close" class="alert-dismissal" id="'.$row['idusgbc_alerts'].'">Dismiss alert</a>';
	            $output.='<span class="alert-msg">';
	            $output.=$row['message'];
	            if($orgnid){
		            $output.='<div class="button-group">';
		    //        watchdog('orgnid', $orgnid);
		            if($row['actionhyperlink1']){
		            	if($row['actiontext1'] != 'Approve'){
		            		$output.='<a href="'.$row['actionhyperlink1'].'">'.$row['actiontext1']."</a>";
		            	}else {
		            		$output.='<a class="acceptdeny" id="acceptuid'.$row['relateduid']. '" href="#" action="accept" user-value="'.$row['relateduid'].'" nid="'.$orgnid.'">Accept</a>';     
		            	}
		            }
		            if($row['actionhyperlink2']){
		            	if($row['actiontext2'] != 'Deny'){
		            		$output.='<a href="'.$row['actionhyperlink2'].'">'.$row['actiontext2']."</a>";
		            	}else {
		            		$output.='<a class="acceptdeny" id="denyuid'.$row['relateduid']. '" href="#" action="deny" user-value="'.$row['relateduid'].'" nid="'.$orgnid.'">Deny</a>';
		            	}
		            }
	            }else {
	              $output.='<div class="button-group">';
		    //        watchdog('orgnid', $orgnid);
		            if($row['actionhyperlink1']){
		            	$output.='<a href="'.$row['actionhyperlink1'].'">'.$row['actiontext1']."</a>";
		            }
		            if($row['actionhyperlink2']){
		            	$output.='<a href="'.$row['actionhyperlink2'].'">'.$row['actiontext2']."</a>";
		            }
	            }
	  //          if($row['visibility'] == '2' && $row['dontshowbutton'])
	    //        	$output.='<label><div class="checker" id="uniform-undefined"><span class="checked"><input class="uniform-small" type="checkbox" name="" value="" style="opacity: 0; "></span></div> Don\'t show this type of message again</label>';
	            $output.='</div></span></span>';                     
			   	$output.='</li>';
			   	if($row['visibility'] == '1') {
			   		//Update readonce flag to 1 -- hence wont show up in the next refresh
			   		$whereclause = "idusgbc_alerts =".$row['idusgbc_alerts'];
			   		$setclause = "readonce = 1";
			   		usgbc_update_alert($whereclause, $setclause);
			   	}
			}
			$output.='</ul></div>';
			print $output;
   		}
   		else {
   			//check if there are any membership alerts
   	   			  //Plugin the membership alert
	   		if($yettorenew || $renew || $reactivate || !$isactive){
	   			  	$output = '<div id="attention-feed">';
	   			  	$output.='<ul class="linelist uniform-mini">';
	   				if($renew || $reactivate){
	   			  		$output.= '<li class="alert-negative first active_member">';
	   			  	}
	   			  	else{
	   			  		$output.= ' <li class="alert-neutral active_member">';
	   			  	}
	   			  	$output.='<span class="alert-msg">';
		            $output.=$message;
		            $output.='<div class="button-group">';
	            	$output.='<a href="'.$link.'">'.$linktext."</a>";
	            	if($link1)
	            		$output.='<a href="'.$link1.'">'.$linktext1."</a>";
		            $output.='</div></span>';               
	   			  	$output.='</li>';
	   			  	$output.='</ul></div>';
					print $output; 			  
	 		  }
	 		  else {	  
	   		//If not, redirect to Account/settings
	   		//Not required with the new tab below
//   				header("Location: /account/settings");
//				exit();
	 		  }
   		}
   ?>

   <div id="tracking-widget">
            		<div id="credentials" class="tracking-panel" style="display: block; ">
            			<div class="entry">          			           			
            			<h2>LEED projects</h2>
            			<h3>Manage your projects and register new projects on LEED Online.</h3>
            			<br/>   			
            			<div class="button-group">
            					<a class="small-alt-button" href="http://www.leedonline.com" target="_blank" style="font-family: 'helvetica neue', arial; ">Go to leedonline.com</a>
            			</div>
            
            			<div class="entry foot">
            			</div>  
           	
           				<br>
           				<h2>LEED credentials</h2>
            			<h3>Manage your credentials and register for an exam on GBCI.org.</h3>
            			<br/>
      		  			<div class="button-group">
            					<a class="small-alt-button" href="http://www.gbci.org/mycredentials" target="_blank" style="font-family: 'helvetica neue', arial; ">Go to gbci.org</a>
            			</div>
     			            			
            			<div class="entry foot">
            	       	</div> 
            		</div>
           </div>
  </div>
                 <div  id="norender" class="hidden">
	<?php print drupal_render($form); ?>
	</div>