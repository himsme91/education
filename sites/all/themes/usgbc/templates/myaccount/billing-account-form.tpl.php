<?php
global $user;
//$subscriptions = og_get_subscriptions($user->uid);
//dsm($subscriptions);
//dsm($user);
$node1=content_profile_load('person', $user->uid);
//dsm($node1);

$eligibleautoar = false;
$cardonfile = false;
$orgnid = $_SESSION['orgnid'];
//TODO: PC check
 if($orgnid > 0 && usgbc_myaccount_checkuserrole($orgnid,$user->uid, ROLE_ORG_ADMIN) == true){
 	 $org = node_load($orgnid);
 	 //Members of the current structure only
 	 if($org->field_org_current_duescat[0]['value'] > 0){
 	 	 $eligibleautoar = true;
		  $result = getuserccinfo($user->uid,$orgnid,1);
		  
		  if($result && $result->num_rows > 0){
		  	$cardonfile = true;
		  	$resobject = db_fetch_object($result);
		  	$ccaddr1 = $resobject->billingaddr1.', '.$resobject->billingaddr2;
			$ccaddr2 = $resobject->billingcity.', '.$resobject->billingstate.' '.strtoupper($resobject->billingcountry).' '.$resobject->billingpostal;
		  	
		  }
		  
		  if($org->field_org_autorenewal[0]['value'] == 1):
		  	$autoartxt = "enabled";
		  	else :
		  	$autoartxt = "not enabled";
		  endif; 
 	 }
 }
//Remove Form Element wrapper
$rendered_form = array();
foreach($form as $k=>$v){
	if(!is_array($v)) continue;
	if(substr($k,0,1) != '#') $form[$k]['#wrapper'] = false;
}

$form['card_type']['mastercard']['#wrapper'] = false;
$form['card_type']['visa']['#wrapper'] = false;
$form['card_type']['discover']['#wrapper'] = false;
$form['card_type']['amex']['#wrapper'] = false;

//Set var for custom display of error messages
global $form_has_errors;
$form_id = $form['form_id']['#value'];
$message = filter_xss_admin(variable_get('ife_general_message', 'Please correct errors below.'));

	$render_form['card_type'] = drupal_render($form['card_type']);
    $render_form['card-name'] = drupal_render($form['card-name']);
    $render_form['card-number'] = drupal_render($form['card-number']);
    $render_form['expirymonth'] = drupal_render($form['expirymonth']);
    $render_form['expiryyear'] = drupal_render($form['expiryyear']);
    $render_form['cc_billing_address1'] = drupal_render($form['cc_billing_address1']);
    $render_form['cc_billing_address2'] = drupal_render($form['cc_billing_address2']);
    $render_form['cc_billing_city'] = drupal_render($form['cc_billing_city']);
    $render_form['cc_billing_state'] = drupal_render($form['cc_billing_state']);
    $render_form['cc_billing_country'] = drupal_render($form['cc_billing_country']);
    $render_form['cc_billing_zipcode'] = drupal_render($form['cc_billing_zipcode']);
    $render_form['chkautoar'] = drupal_render($form['chkautoar']);
    $render_form['disable_autoar'] = drupal_render($form['disable_autoar']);
    $render_form['add_card'] = drupal_render($form['add_card']);
    $render_form['del_card'] = drupal_render($form['del_card']);
    	
?>
<style type="text/css">
.columnlist li,#mainCol .columnlist li {
	width: 60px;
}
.blocklist li {
	width: 510px;
}
.page-account-billing #modal {
	width:800px !important;
	margin-left:-375px !important;
}
</style>
<div class="form form-form clear-block <?php print $form_classes ?>"
	id="divBilling">

	<h1>Billing</h1>

	<div class="panels enabled show_single">

	<?php if($eligibleautoar == true) :?>
		<div id="auto-renewal-org" class="panel show_link">
			<div class="panel_label">
				<h4 class="left">Credit card</h4>

				<div class="label_link right">
					<a class="show_link" href="">change</a> <a class="hide_link"
						href="">hide</a>
				</div>
			</div>
		<div class="panel_summary settings_val displayed">
			<?php if($cardonfile == false){?>			
				<p class=""><em>You currently have no credit card on file.</em></p>
			<?php }else { ?>
				<ul class="blocklist">                			
	                			<li>
	                				<h4 class="card-header">
	                			<?php switch ($resobject->cctype){
					case "visa":
					?>					
			              <img src="/sites/all/themes/secluded/lib/img/credit_cards/visa.png" alt="" class="vert-middle">
			              Visa **** **** **** <?php print $resobject->cclast4nums;
			              ?>
			        <?php break;
					case "mastercard":
			        ?>				
			        			              <img src="/sites/all/themes/secluded/lib/img/credit_cards/mastercard.png" alt="" class="vert-middle">
			              Mastercard **** **** **** <?php print $resobject->cclast4nums;?>
			        <?php break;
					case "discover":
			        ?>				
			              <img src="/sites/all/themes/secluded/lib/img/credit_cards/discover.png" alt="" class="vert-middle">
			              Discover **** **** **** <?php print $resobject->cclast4nums;
			              ?>
			        <?php break;
					case "amex":
			        ?>				
			              <img src="/sites/all/themes/secluded/lib/img/credit_cards/amex.png" alt="" class="vert-middle">
			              American Express **** **** **** <?php print $resobject->cclast4nums;
			              ?>
			        <?php break;
	          }?>
	         </h4>
	                				
	                				<dl class="pseudo-table">
	                					<dt>Card #:</dt>
	                					<dd>**** **** **** <?php print $resobject->cclast4nums;?></dd>
	                					<dt>Cardholder:</dt>
	                					<dd><?php print $resobject->ccname;?></dd>
	                					<dt>Address:</dt>
	                					<dd><?php print $ccaddr1;?> <br><?php print $ccaddr2?></dd>
	                					<dt>Expiration:</dt>
	                					<dd><?php print $resobject->ccexpmth;?>/<?php print $resobject->ccexpyr;?></dd>
	                				</dl>
	                			</li>	                			
	                		</ul>
			<?php }?>
						</div>
			               	<div class="panel_content hidden">
	                			<div class="quick-edit-form sub-form-element">
	                				    <div id="card_data" class="sub-form-element" style="padding-left:0px;">
									  
									    	<?php if($resobject->cctype == ''){?>
												   <label id="card_data_lbl" for="card-name">Card type</label>
												    <div id="credit-card-types"> 
												         <?php print $render_form['card_type']; ?>
												     </div>
				
								<!--  	        <h4 class="label pad-bottom">Card</h4> -->	
										
										        <div class="pulled-item element">
										            <label for="card-name">Name on card</label>
										            <?php print $render_form['card-name'];?>
										        </div>
										
										        <div class="pulled-item element">
										            <label for="card-number">Card number</label>
										            <?php print $render_form['card-number'];?>
										        </div>
	
		                				    <div class="pulled-item element" id="expiration-form">
									            <label for="card-exp-mo">Expiration</label>
									            <ul class="selectlist">
									                <li>
									                    <label for="card-exp-mo">
									                        <span class="sub-label">Month</span>
									                        <?php print $render_form['expirymonth'];?>
									                    </label>
									                </li>
									                <li>
									                    <label for="card-exp-yr">
									                        <span class="sub-label">Year</span>
									                        <?php print $render_form['expiryyear'];?>
									                    </label>
									                </li>
									            </ul>
									        </div>
						<span class="pulled-item"></span>
						<div class="pulled-item int-item uf-xlg element">
							<label>Country</label>
							<?php print $render_form['cc_billing_country'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item">
							<label>Address</label>
							<?php print $render_form['cc_billing_address1'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item">
							<label class="compress">&nbsp;</label>
							<?php print $render_form['cc_billing_address2'];?>
						</div>

						<div class="pulled-item element">
							<label>City</label>
							<?php print $render_form['cc_billing_city'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item">
							<!-- 	<label>State/Province</label> -->
						<?php print $render_form['cc_billing_state'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item us-item element">
							<label>Zip/Postal code</label>
							<?php print $render_form['cc_billing_zipcode'];?>
							<span class="validation-label invalid"></span>
						</div>

								        <?php } else { ?>
								        	<div class="pulled-item us-item">
	                							<label>Card #</label>
	                							<p>************<?php print $resobject->cclast4nums;?> (<?php print $resobject->cctype;?>)</p>
	                						</div>
	                						<div class="pulled-item us-item">
			                					<label>Cardholder</label>
			                					<p><?php print $resobject->ccname;?></p>
			                				</div>
			                				<div class="pulled-item us-item">
			                					<label>Address</label>
			                					<p><?php print $ccaddr1;?> <br><?php print $ccaddr2?></p>
			                				</div>
			                				<div class="pulled-item us-item">
			                					<label>Expiration</label>
			                					<p><?php print $resobject->ccexpmth;?>/<?php print $resobject->ccexpyr;?></p>
			                				</div>
								       <?php  }?>
								        <div class="pulled-item us-item">
	                					<div class="button-group" style="float:right;padding-top:8px;">
	                						<?php if($resobject->cctype != ''){ print $render_form['del_card'];?><?php }?>
	                						<?php if($resobject->cctype == '') { print $render_form['add_card'];?><?php }?>
	                					</div> 
	                				</div>
	              				</div>
	        	                	</div>		                	                	
	 	          </div>
	       </div>
	<?php endif;?>                	                
	                	                

	<?php if($eligibleautoar == true) :?>
		<div id="auto-renewal-org" class="panel show_link">
			<div class="panel_label">
				<h4 class="left">Auto renewal</h4>

			<?php if($cardonfile == true):?>
				<div class="label_link right">
					<a class="show_link" href="">change</a> <a class="hide_link"
						href="">hide</a>
				</div>
			<?php endif;?>
			</div>

			
			<div class="panel_summary settings_val displayed">
			
			<?php if($cardonfile == false):?>
				<p class=""><em>To enable auto renewal, you must first add a credit card, above.</em></p>
			<?php else :?>
				<?php switch ($resobject->cctype){
					case "visa":
			              $card = "Visa **** **** ****".$resobject->cclast4nums;
			              ?>
			        <?php break;
					case "mastercard":
			               $card = "Mastercard **** **** ****".$resobject->cclast4nums;?>
			        <?php break;
					case "discover":
			              $card = "Discover **** **** ****".$resobject->cclast4nums;?>
			        <?php break;
					case "amex":
			              $card = "American Express **** **** ****".$resobject->cclast4nums;?>
			        <?php break;
	          	}?>
				<?php if($org->field_org_autorenewal[0]['value'] == 1){?>
				<p class="">Auto renewal for <?php print $org->title;?>'s
					membership dues is enabled.</p>

				<?php switch ($resobject->cctype){
					case "visa":
					?>	
					<div class="subtle-box">				
			              <img src="/sites/all/themes/secluded/lib/img/credit_cards/visa.png" alt="" class="vert-middle">
			              Visa **** **** **** <?php print $resobject->cclast4nums;
			              ?>
			         </div>
			        <?php break;
					case "mastercard":
			        ?>
			        <div class="subtle-box">				
			              <img src="/sites/all/themes/secluded/lib/img/credit_cards/mastercard.png" alt="" class="vert-middle">
			              Mastercard **** **** **** <?php print $resobject->cclast4nums;?>
			         </div>
			        <?php break;
					case "discover":
			        ?>
			        <div class="subtle-box">				
			              <img src="/sites/all/themes/secluded/lib/img/credit_cards/discover.png" alt="" class="vert-middle">
			              Discover **** **** **** <?php print $resobject->cclast4nums;
			              ?>
			         </div>
			        <?php break;
					case "amex":
			        ?>
			        <div class="subtle-box">				
			              <img src="/sites/all/themes/secluded/lib/img/credit_cards/amex.png" alt="" class="vert-middle">
			              American Express **** **** **** <?php print $resobject->cclast4nums;
			              ?>
			         </div>
			        <?php break;
	          }
			} else {?>
			<p class=""><em>Auto renewal for U.S. Green Building Council's
					membership dues is not enabled.</em></p>
			<?php }?>
				       <?php endif;?>
			</div>
			               	<div class="panel_content hidden">
	                			<div class="quick-edit-form sub-form-element">
	                			<?php if($resobject->cclast4nums != ''){
	                					$card = '['.$resobject->cclast4nums.']';
	                			}else {
	                					$card = 'your card';
	                			}?>
	                			<?php if($org->field_org_autorenewal[0]['value'] == 0):?>
	                			<span><i>Enabling auto renewal will authorize USGBC to automatically charge <?php print $card?> on the date of renewal.</i></span>
	                			<br/><br/>
	                			<p>
	                	          <?php print $render_form['chkautoar'];?> <br/>  
	                	          
		                        	<script language="javascript" type="text/javascript">
		                        	<!--
		                        	function popitup(url) {
		                        		newwindow=window.open(url,'name','height=1100,width=870,scrollbars=yes ,modal=yes');
		                        		if (window.focus) {newwindow.focus()}
		                        		return false;
		                        	}

		                        	// -->
		                        	</script>
								
	                	         </p>						                			
	                			<?php else :?>
	                			<span><i>Auto renewal for <?php print $org->title;?>'s membership dues is enabled. USGBC is authorized to automatically charge <?php print $card;?> on the date of renewal.</i></span>
	                			<br/><br/>
	                			 <div>
	                					<div class="button-group" style="float:right;padding-top:8px;">
												<?php print $render_form['disable_autoar'];?>
											</div>
	                				</div>	              
	                			<?php endif;?>	    
	                	</div>		                	                	
	 	          </div>
	       </div>
	<?php endif;?>
	
	</div>
</div>
<div>
<?php print drupal_render($form); ?>
</div>
