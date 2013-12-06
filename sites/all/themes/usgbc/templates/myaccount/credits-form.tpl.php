<?php   //Remove Form Element wrapper
    foreach ($form as $k => $v) {
        if (!is_array($v)) continue;
        if (substr($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
    }

    //Set var for custom display of error messages
    global $form_has_errors;
    $form_id = $form['form_id']['#value'];
    $message = filter_xss_admin(variable_get('ife_general_message', 'Please correct errors below.'));
    
    $render_form['credit_notifi_alerts'] = drupal_render($form['credit_notifi_alerts']);
    $render_form['credit_notifi_emails'] = drupal_render($form['credit_notifi_emails']);
?>
<div id="mainCol">
				<h1>Credit notifications</h1>
				<div class="section">				    
				    <ul class="radiolist inputlist">
				        <li>
				            <label for="chbx1">
				                <span class="text-label"> 
				                <?php print $render_form['credit_notifi_alerts'];?></span>
				                Send me alerts in my account
				            </label>                                        
				        </li>
				        <li>
				            <label for="chbx2">
				                <span class="text-label">
				                 <?php print $render_form['credit_notifi_emails'];?></span>
				                Send me alerts by email
				            </label>
				        </li>
				    </ul>
				</div><!-- padded -->
				<?php 
				global $user;
				$result = db_query("SELECT distinct node.nid AS nid, node.title AS node_title FROM node node  
				 INNER JOIN flag_content flag_content_node ON node.nid = 
				 flag_content_node.content_id AND (flag_content_node.uid = %d) 
				 WHERE node.status <> 0  AND node.type = 'credit_definition'",$user->uid);
				?>
				<?php if($result->num_rows > 0) {?>
                <ul class="linelist">
                <?php while($credit = db_fetch_object($result)) {
                	$node = node_load($credit->nid);
                	 $ratingsystems = '';
				  //$ratingsystemarray = aasort($node->field_credit_rating_system,"view");
				  foreach ($node->field_credit_rating_system as &$value) {
				   if ($ratingsystems == '') {
				      $ratingsystems = $value['view'];
				    } else {
				      $ratingsystems .= ', ' . $value['view'];
				    }
				  }
                	
                ?>
                    <li class="credit">
                       <?php    if ($ratingsystems) { ?>
					      <span class="small"><?php echo $ratingsystems;?>
					        | <?php echo $node->field_credit_rating_sys_version[0]['view'];?></span><br>
					      <? }?>
                        <strong><?php print $credit->node_title?> (<?php print $node->field_credit_short_id[0]['value']?>)</strong><br>
                         <a class="small jqm-form-trigger" data-js-callback="init_usgbc_core" href="/credit-watch?nid=<?php print $credit->nid;?>" style="font-family: 'helvetica neue', arial; ">Notification options</a> | 
                        <a class="small" href="#removeCredit" nid="<?php print $credit->nid;?>" style="font-family: 'helvetica neue', arial; ">Remove</a>
                    </li>
                 <?php }?>
            </ul>                
            <?php }
            else {
            ?>
            <p>You can start watching credits <a href="/credits">here</a>.</p>
            <?php }?>
            </div>