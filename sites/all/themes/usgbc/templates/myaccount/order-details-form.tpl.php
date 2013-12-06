<?php global $user; 
//$orderid = ($_GET['orderid'] > 0) ? $_GET['orderid'] : "";

if($_GET['orderid'] ){	
	$orderid =$_GET['orderid'];
} 

//$orderid = 221;
if (!$user->uid || $orderid == ""){
	header("Location: /account/purchases/history");
}


if(substr($orderid,0,3)=='SAP'){
	$order = usgbc_order_load_SAP($orderid);
} else {
	$order = uc_order_load($orderid);
}

if (isset($_SESSION['orgnid'])){
	$node1=node_load($_SESSION['orgnid']);
}

$returnedsapresults = false;
if($order != FALSE){
	$u = content_profile_load('person',$order->uid);
} else {
	//LOAD order from SAP
	if(substr($orderid,0,3)=='SAP'){
		$orderid = str_replace('SAP', '', $orderid);
	}
	$values['ordernumber'] = $orderid;
   	$sapresult = get_order_list_sap_integration($values);
   
   	if(is_array($sapresult->SalesOrders->item)){
   		foreach($sapresult->SalesOrders->item as $item)
				   		 {
				   		 	$ordertotal += $item->NetValue;
				   		 }
   			if($sapresult->SalesOrders->item[0]){
   				$returnedsapresults = true;
			   	if(strtoupper($sapresult->SalesOrders->item[0]->DocStatus) == 'OPEN' || strtoupper($sapresult->SalesOrders->item[0]->DocStatus) == 'NOT CLEARED'){
			   		$orderstatus = 'processing';	
			   	}  	
   				$products[] = array('nid'=>'0');
   				$data = array('attributes'=>'');
   					  $order = (object)array(
				      'order_id' => $orderid,
				      'order_total' => $ordertotal,
				      'created' => strtotime($sapresult->SalesOrders->item[0]->DocDate),
				      'data' => $data,
   					  'title' => $sapresult->SalesOrders->item[0]->ShortText,
				      'order_status' => $orderstatus,
   					  'products'=>$products,
   					  'line_items' =>array(),
   					  'userbp' =>$sapresult->SalesOrders->item[0]->SoldTo
				    );
   			}
   	} else {
   		if($sapresult->SalesOrders->item){
   		$returnedsapresults = true;
	   	if(strtoupper($sapresult->SalesOrders->item->DocStatus) == 'OPEN' || strtoupper($sapresult->SalesOrders->item->DocStatus) == 'NOT CLEARED'){
	   		$orderstatus = 'processing';	
	   	}  	
   		$products[] = array('nid'=>'0');
   		$data = array('attributes'=>'');
   					  $order = (object)array(
				      'order_id' => $orderid,
				      'order_total' => $sapresult->SalesOrders->item->NetValue,
				      'created' => strtotime($sapresult->SalesOrders->item->DocDate),
				      'data' => $data,
   					  'title' => $sapresult->SalesOrders->item->ShortText,
				      'order_status' => $orderstatus,
   					  'products'=>$products,
   					  'line_items' =>array(),
   					  'userbp' =>$sapresult->SalesOrders->item->SoldTo
				    );
   				}
   	}
   	$uid = db_result(db_query("SELECT uid FROM drupal.users u 
						left join drupal.content_type_person p on u.mail = p.field_per_email_url WHERE field_per_id_value =  '%s'",  $order->userbp));
	if($uid != ''){
		$u = content_profile_load('person',$uid);			
	}
}
//This query gets the date of payment for the given order
$temp_result = db_query("SELECT received FROM {uc_payment_receipts} WHERE order_id = %d", $orderid);
$receipt_result = db_fetch_object($temp_result);

$displaySubtotal = false;
?>

<div class="section-head">

				<h1 class="section-head-title">Order details</h1>
				<ul class="section-head-options">
					<li><a class="back-link" href="/account/purchases/history">Order history</a></li>
				</ul>
			</div>
			
			<div id="content" class="twoColRight">
			
				<div id="navCol">
					<div class="aside-dark">

						<h3><?php print format_date($order->created, 'custom', variable_get('uc_date_format_default', 'M j, Y'));?></h3>
						<dl>
							<dt><h4 class="small sub-compact">Order #</h4></dt>
							<dd><?php 
								if($order->data['attributes']['sapordernumber']){
									print $order->data['attributes']['sapordernumber'];
								}else{
									print str_replace('SAP', '', $order->order_id);
								}
							?></dd>
											
							
							<dt><h4 class="small sub-compact">Total</h4></dt>
							<dd>$<?php print round($order->order_total,2);?></dd>
							
							<?php if($order->order_status == "completed"):?>
								<dt><h4 class="small sub-compact">Paid on</h4></dt>
								<?php if(substr($order->order_id,0,3)=='SAP'):?>
									<dd><?php print date("m/d/Y",strtotime($order->cleared_date));?></dd>
								<?php else:?>
									<dd><?php print date("m/d/Y", $receipt_result->received);?></dd>
								<?php endif;?>
							<?php endif;?>
							<dt><h4 class="small sub-compact">Order status</h4></dt>
							<dd><?php print ucfirst($order->order_status);?></dd>
							
							
							<?php if ($order->delivery_first_name != ""):?>
							<dt><h4 class="small sub-compact">Recipient</h4></dt>
							<dd><?php print $order->delivery_first_name;?> <?php print $order->delivery_last_name;?></dd>
							<?php endif;?>
						</dl>
					</div>
				</div>
				
				<div class="subcontent-wrapper">
				
					<div id="mainCol">
				
					<?php foreach($order->products as $product){ ?>
                   
                  <div class="order-item">
							<?php $node = node_load($product->nid); ?>
						
					
							<?php if ($node->type == 'resource' || $node->type == 'merchandise') :?>
							<h3><a target="_blank" href="/<?php print $node->path;?>"><?php print $product->title;?></a></h3>
							<h4 class="small">ITEM # <?php print $product->model;?></h4>
							
							<div class="oi-inner">
								<dl>
									<?php if(!empty($product->data['attributes']['size'])){?>
										<dt>Size</dt>
										<dd><?php print $product->data['attributes']['size'][0]; ?></dd>
									<?php }?>
									
									<dt>Price</dt>
									<dd>$<?php print round($product->price,2);?></dd>
									
									<dt>Qty</dt>
									<dd><?php print $product->qty;?></dd>
									
									<span>
										<dt>Subtotal</dt>
										<dd>$<?php print round($product->qty * $product->price,2);?></dd>
									</span>
								</dl>
								
								<div class="bundle-items">
								</div>
								<?php if ($node->field_res_profileimage[0]['filepath'] != ""):?>
								<img class="main-img" src="<?php print file_create_url($node->field_res_profileimage[0]['filepath']);?>" width="80" />
								<?php  endif;?>
								<p><?php print $node->teaser; 
								$displaySubtotal = true;
								?></p>
							</div>
							<?php elseif($node->type == 'donation'):?>
							<h3><a href="/give-center/donation">Donation to USGBC's Project Haiti</a></h3>

    							<h4 class="small">ITEM # <?php print $product->order_product_id;?></h4>
    				
    							<div class="oi-inner">
    				    
    				    		<dl>
    				        		<dt>Amount</dt>
    				        		<dd>$<?php print round($order->order_total,2);?></dd>
    				    		</dl>
                        
    				    		<p>Thank you for your generosity.</p>
								</div>
							<?php //$displaySubtotal = true;?>
						<?php elseif($node->type == 'workshp'):?>
							<h3><a target="_blank" href="/<?php print str_replace('content/','courses/',$node->path);?>?workshop_nid=<?php print $node->nid;?>"><?php print $product->title;?></a></h3>
							<?php $node1 = node_load($node->field_wrksp_course[0]['nid']);?>
							<h4 class="small">Level <?php print $node1->taxonomy[$node1->field_crs_level[0][value]]->name;?> - ID#<?php print $node->field_wrksp_id[0]['value'];?></h4>
							
							<div class="oi-inner">
								<dl>
									<dt>Price</dt>
									<dd>$<?php print round($product->price,2);?></dd>
									
									<dt>Qty</dt>

									<dd><?php print $product->qty;?></dd>
									
									<span>
										<dt>Subtotal</dt>
										<dd>$<?php print round($product->price,2);?></dd>
									</span>
								</dl>
								
								<p><?php print $node1->teaser; ?></p>
								<?php //$displaySubtotal = true;?>
							</div>
						<?php elseif($node->type == 'chapter'):?>
							<h3><a target="_blank" href="/community/chapters">Chapter membership</a></h3>
							<div class="oi-inner">
								<dl>
								<?php 
										foreach($order->line_items as $line_items){ 
									
										 if ($line_items['type'] == 'chapter'){
											$subtotal = round($line_items['amount'],2);
										 }
										 }
								
								?>
									<dt>Price</dt>
									<dd>$<?php print round($subtotal,2);?></dd>
									
									<dt>Qty</dt>

									<dd><?php print $product->qty;?></dd>
									
									<span>
										<dt>Subtotal</dt>
										<dd>$<?php print round($subtotal,2);?></dd>
									</span>
								</dl>
								
								<p>
									<strong>Chapter:</strong>
									<?php print $product->title;?>
									<br>
									<strong>Payment:</strong>
									<?php 
									if ($order->payment_method == 'credit'){
										print $order->payment_details['cc_type'];?> XXXX XXXX XXXX <?php print $order->payment_details['cc_number'];?>
																		<?php }else{
																			print 'Check';
																			}?>
									<br>
									<!-- 
									<strong>Renewal date:</strong>
										 -->							
								
								</p>
								
							</div>	
							<?php elseif($node->type == 'usgbc_friend'):?>
							<h3><a target="_blank" href="/community/chapters">Individual Member of USGBC</a></h3>
							<div class="oi-inner">
								<dl>
								<?php 
										foreach($order->line_items as $line_items){ 
									
										 if ($line_items['type'] == 'usgbc_friend'){
											$subtotal = round($line_items['amount'],2);
										 }
										 }
								
								?>
									<dt>Price</dt>
									<dd>$<?php print round($subtotal,2);?></dd>
									
									<dt>Qty</dt>

									<dd><?php print $product->qty;?></dd>
									
									<span>
										<dt>Subtotal</dt>
										<dd>$<?php print round($subtotal,2);?></dd>
									</span>
								</dl>
								
								<p>
									<strong>Individual Member of USGBC</strong>
									<?php //print $product->title;?>
									<br>
									<strong>Payment:</strong>
									<?php 
									if ($order->payment_method == 'credit'){
										print $order->payment_details['cc_type'];?> XXXX XXXX XXXX <?php print $order->payment_details['cc_number'];?>
																		<?php }else{
																			print 'Check';
																			}?>
									<br>
									<!-- 
									<strong>Renewal date:</strong>
										 -->							
								
								</p>
								
							</div>											
							<?php //$displaySubtotal = true;?>
							<?php elseif($node->type == 'usgbc_membership' || instr($product->title,'USGBC Membership') || instr($product->title,'USGBC New Membership')):?>
							<h3><a target="_blank" href="/community/members/join">USGBC National Membership</a></h3>
							<div class="oi-inner">
								<dl>
								<?php 
										foreach($order->line_items as $line_items){ 
									//$line_items['type'] == 'membership' || 
										 if ($line_items['title'] == 'USGBC Membership'){
											$subtotal = round($line_items['amount'],2);
										 }
										 }
								
								?>
									<dt>Price</dt>
									<dd>$<?php print round($subtotal,2);?></dd>
									
									<dt>Qty</dt>

									<dd><?php print $product->qty;?></dd>
									
								  	<span>
										<dt>Subtotal</dt>
										<dd>$<?php print round($subtotal,2);?></dd>
									</span> 
								</dl>
								
								<p>
									<strong>Organization:</strong>
									<?php print $product->title;?>
									<br>
									<strong>Payment:</strong>
									<?php if ($order->payment_method == 'credit'):?>
										<?php print $order->payment_details['cc_type']?> XXXX XXXX XXXX <?php print $order->payment_details['cc_number']?>
									<?php else:?>
										Check
									<?php endif;?>
									<br>
									<strong>Renewal date:</strong>
									<?php if($node1->field_org_validto[0]['value']): print date("F j, Y", strtotime($node1->field_org_validto[0]['value']));
										else : print "N/A";
										endif;
									?>	
									<?php if($order->order_status == 'processing' || $order->order_status == 'pending') { ?>
										<div style="float:left;">
										<a class="button" href="/join-center/member/renew/<?php print $node1->nid;?>" style="font-family: 'helvetica neue', arial; ">Pay Now</a></div>
									<?php }?> 
								<?php $displaySubtotal = true;?>
							</div>
							<?php elseif($node->type == 'subscription'):?>
							<h3><a target="_blank" href="/community/members/join">USGBC Subscription</a></h3>
							<div class="oi-inner">
																
								<p>
									<strong>Subscription:</strong>
									<?php print $product->title;?>
									<br>
									<strong>Payment:</strong>
									<?php if ($order->payment_method == 'credit'):?>
										<?php print $order->payment_details['cc_type']?> XXXX XXXX XXXX <?php print $order->payment_details['cc_number']?>
									<?php else:?>
										Check
									<?php endif;?>
									<br>
									<strong>Expiry date:</strong>
									<?php 
									$subexpiredate = db_result (db_query ("SELECT FROM_UNIXTIME(expire) FROM {og_expire} WHERE uid = %d AND nid = %d", $user->uid, $product->nid));
									if($subexpiredate){
										$expiry_date = date('M&\nb\sp;d,&\nb\sp;Y', strtotime($subexpiredate));
										print $expiry_date;
									}else{
										print "N/A";
									}	
									?>	
									 
								<?php $displaySubtotal = true;?>
							</div>
							
						<?php else:?>
							<?php 
							if($returnedsapresults == false){
								$result = db_query("SELECT title, nid FROM insight.stg_usgbc_uc_order_products_SAP WHERE order_id ='%s'", $order->order_id);
            					$row = db_fetch_object($result);
							?>							
    						<p>
    							<strong><?php print $row->title;?></strong>
    						<?php }else {?>
    							<strong><?php print $order->title;?></strong>
    						<?php }?>								
									<br>
							<!-- 		<strong>Payment:</strong>
									<?php if($order->order_status == 'processing'){ ?>
										Check 
									<?php } else {?>
										Credit
									<?php }?>
									<br>  -->
								
								   <?php if ($u->field_per_fname[0]['value'] != ""):?>
           					
									<strong>Order placed by:</strong>
						             <?php print $u->field_per_fname[0]['value'];?>
									<?php print $u->field_per_lname[0]['value'];?>       
										
            							<?php endif;?>
            							<?php if($order->order_status == 'processing' || $order->order_status == 'pending'){ ?>
            							<br/>
										<div style="float:left;">
										<?php if(instr($order->title, "Membership") && !instr($order->title, "Chapter")){?>
											<?php $orgnid = db_result(db_query("Select nid from drupal.content_type_organization where field_org_saporderid_value='%s'"), $order->order_id);
												if($ordnid){
											?>
														<a class="button" href="/join-center/member/renew/<?php print $ordnid;?>" style="font-family: 'helvetica neue', arial; ">Pay Now</a>
													<?php }else {?>
														<a class="button" href="/join-center/order/changepayment?orderid=<?php print $order->order_id;?>" style="font-family: 'helvetica neue', arial; ">Pay Now</a>
												<?php 
													}
												}
													else {?>
											<a class="button" href="/join-center/order/changepayment?orderid=<?php print $order->order_id;?>" style="font-family: 'helvetica neue', arial; ">Pay Now</a>
										<?php }
													}?>
										</div>                   			
            			</p>	<?php endif;?>
						</div>  

		         <?php  }												
					?>
					
						<div class="order-summary">
							<dl>
							
					<?php 
					$subtotal = 0.00;
					$tax = 0.00;
					$shipping = 0.00;
					$discounts = 0.00;
					$counter = 0;
					
					foreach($order->line_items as $line_items){ 
				
						if($displaySubtotal){
							 if ($line_items['type'] == 'subtotal' || $line_items['type'] == 'donation' || $line_items['type'] == 'chapter')
									{
								$subtotal = round($line_items['amount'],2);
								?>
										<dt>Subtotal</dt>
										
									    <dd><?php print uc_currency_format($subtotal);?></dd>
							<?php 
					 }
						}else {if($counter == 0){?>
						
							<dt>Subtotal</dt>
							
									    <dd><?php print uc_currency_format($order->order_total);?></dd>
						<?php  $counter++;}}
					 if (InStr( strtolower($line_items['type']), 'tax')){
						$tax = round($line_items['amount'],2);
					?>
								<dt>Taxes</dt>
								<dd><?php print uc_currency_format($tax);?></dd>
					
					<?php 
					 }
								
					if ($line_items['type'] == 'shipping and handling'){
						$shipping = round($line_items['amount'],2);
						?>
								<dt>Shipping and Handling</dt>
								<dd><?php print uc_currency_format($shipping);?></dd>
						
					<?php 
												
					}
					
					if ($line_items['type'] == 'member discount' || $line_items['type'] == 'promo' || $line_items['type'] == 'promotion' || $line_items['title'] == 'Promo'){
						$discounts =  round($line_items['amount'],2);
						
						?>
								<dt><?php print $line_items['title'];?></dt>
								<dd><?php print uc_currency_format($discounts);?></dd>
					<?php 
					}
						
				 }	?>					
							
						</dl>
							
							<div class="aside-dark">
								<p><a href="/contact">Contact us</a> for payment inquiries.</p>
								<dl>
									<dt>Total</dt>
									<dd><?php print uc_currency_format($order->order_total);?></dd>
								</dl>

							</div>
							
							<p class="small">
								<strong>REFUNDS or CANCELLATIONS</strong><br />
								Refund/cancellation requests are handled in the order they are received. <a href="/contact">Contact us</a> if further assistance is required.
							</p>
						</div>
						
					</div><!-- mainCol -->

				</div>
			</div><!-- content -->
