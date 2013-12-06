<?php
$GLOBALS['conf']['cache'] = FALSE;
    global $user;
    $person = content_profile_load('person', $user->uid);

    $chapters = array();
    if ($user->uid) {
        $subscriptions = og_get_subscriptions($user->uid);
        if ($subscriptions) {
            foreach ($subscriptions as $subscription) {
                if ($subscription['type'] == 'chapter') {
                    $chapternid = $subscription['nid'];
                    array_push($chapters, $chapternid);
                 }
            }
        }
    }

     if($_GET['nid'] == ""){
     	$chapternid = $chapters[0];
     }
     else{
     	$chapternid = $_GET['nid'];
     }
     
    $node1 = node_load($chapternid);
    if($node1->field_chp_handle_registration[0]['value'] == 1){
	    $chpexpiredate = db_result (db_query ("SELECT FROM_UNIXTIME(expire) FROM {og_expire} WHERE uid = %d AND nid = %d", $user->uid, $chapternid));
		$reactivate = false;
		
		if(date("Y-m-d") > date("Y-m-d", strtotime ( $chpexpiredate)))
		{ 
			$reactivate  = true;
			$renew = false;
		}        	 	 
    }
	$assignedroles = og_user_roles_get_roles_by_group($chapternid, $user->uid);
    $adminrid = _user_get_rid(ROLE_CHP_ADMIN);
    $isadmin = in_array($adminrid, $assignedroles);

    //Remove Form Element wrapper
    foreach ($form as $k => $v) {
        if (!is_array($v)) continue;
        if (substr($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
    }


    //Set var for custom display of error messages
    global $form_has_errors;
    $form_id = $form['form_id']['#value'];
    $message = filter_xss_admin(variable_get('ife_general_message', 'Please correct errors below.'));

?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#edit-chp-txtfoundationstatement").charCount({
            limitUnit: 'words',
            textMax: 100,
            limitAlert: 10
        });

        $("#edit-chp-txtdescription").charCount({
            limitUnit: 'words',
            textMax: 200,
            limitAlert: 30
        });
    });
</script>

<div class="form form-form clear-block <?php print $form_classes ?>" id="divPer">

	<h1>Chapter profile</h1>

 <div class="pulled-item element" style="margin-bottom: 1.2em;">
	<select id="chapter-select" style="opacity: 0; ">
	<?php foreach($chapters as $chpid) {
			$chp = node_load($chpid);
			if($chpid == $chapternid){
				$selected = "true";
			}else{
				$selected = "";
			}
		?>
		<option value="<?php print $chpid;?>" <?php if($selected):?>selected="selected"<?php endif;?>><?php print $chp->title;?></option>
	<?php }?>
	</select>
 </div>
	<h2><?php print $node1->title ?></h2>

 	<ul class="inputlist"></ul>

	<?php if($reactivate == true) { ?>	
		<div class="inactive_member inactive-alert">
        	<p>Please renew your account to gain access to profile settings. <a href="/join-center/chapter/renew/<?php echo $chapternid;?>">Renew chapter membership</a></p>
        </div>
    <?php }  ?>
 
	<?php if ($reactivate == false):?>

	<div class="tabs tabbed-box">

		<ul class="tabNavigation">
		    <li class="selected"><a href="#tab-compProfile">Profile</a></li>
		    <!--          <li class=""><a href="#tab-compMembers">Members</a></li>
		<li class=""><a href="#tab-compEmployees">Employees</a></li>
		<li class=""><a href="#tab-pendingEmployees">Pending<span class="count" id="pending-employee-count">0</span></a></li> -->
		</ul>

		<div class="aside padded displayed" id="tab-compProfile">
		   <?php if ($isadmin) {
		    	$classval = "panels  enabled show_single";
		    	}
		    	else
		    	{
		    		$classval = "show_single";
		    }?>

			<div class="<?php print $classval;?>">

				<!-- LOGO  -->
				<div class="panel settings show_link" id="change_complogo">
				    <div class="panel_label" style="cursor: <?php echo ($isadmin) ? 'pointer' : 'default';?> ;">
				        <h4 class="left">Logo</h4>

				        <div class="label_link right">
				            <?php if ($isadmin) { ?>
				            <a href="" class="show_link">change</a>
				            <?php }?>
				            <a href="" class="hide_link">hide</a>
				        </div>
				    </div>
				    <div class="panel_summary settings_val displayed" style="cursor: <?php echo ($isadmin) ? 'pointer' : 'default';?> ;">
				    <?php  if ($node1->field_chp_profileimg[0]['filepath'] == '') {
				            $img_path = '/sites/all/assets/section/placeholder/company_placeholder.png';
							print "<img src='$img_path' height=100 width=100></img>";
				          } else {
				            $img_path = $node1->field_chp_profileimg[0]['filepath'];
							print theme ('imagecache', 'max-both_100-100', $img_path, $alt, $title, $attributes);
				          }?>
				    </div>
				       <?php if ($isadmin) { ?>
				    <div class="panel_content hidden">
				        <div class="quick-edit-form">

				            <?php
				            $rendered_form['chp_image_upload'] = drupal_render($form['chp_image_upload']);

				            if ($form_has_errors[$form_id] === true):
				                $form_has_errors[$form_id] = 'displayed';
				                ?>
				                <div>
				                    <p class="notification negative"><?php echo $message; ?></p>
				                </div>
				                <?php endif; ?>

				            <div class="element">

				                <?php if ($node1->field_chp_profileimg[0]['filepath'] == ''): ?>
				                <img class="left" WIDTH="100" HEIGHT="100" id="change_perslogo_val" src="/sites/all/themes/usgbc/lib/img/usgbc-chapter.png">

				                <?php else: ?>
				                <img class="left" WIDTH="100" HEIGHT="100" id="change_complogo_val" src="<?php print file_create_url($node1->field_chp_profileimg[0]['filepath']);?>">

				                <?php  endif; ?>


				                <div class="upload-wrapper">
				 <?php print $rendered_form['chp_image_upload']; ?>
				                </div>

				            </div>
				            <div class="button-group">
				                <?php   print drupal_render($form['chpupload']);?>
				                <a class="small-button cancel-settings-btn" href="#">Cancel</a>
				            </div>
				        </div>
				    </div>
				    <?php }?>
				</div>

				<!-- website -->
				<div class="panel settings show_link" id="change_website">
				    <div class="panel_label" style="cursor: <?php echo ($isadmin) ? 'pointer' : 'default';?> ;">
				        <h4 class="left">Website</h4>

				        <div class="label_link right">
				            <?php if ($isadmin) { ?>
				            <a href="" class="show_link">change</a>
				            <?php }?>
				            <a href="" class="hide_link">hide</a>
				        </div>
				    </div>

				    <div class="panel_summary settings_val displayed" style="cursor: <?php echo ($isadmin) ? 'pointer' : 'default';?> ;">
				        <?php if ($node1->field_chp_website[0]['url'] == ''): ?>
				        <p class="left" id="change_membership_val"><em>You currently have no website</em></p>
				        <?php else: ?>
				        <p class="left" id="change_membership_val"><a href="<?php print $node1->field_chp_website[0]['url'];?>">
				            <?php print $node1->field_chp_website[0]['url'];?></a></p>
				        <?php endif; ?>
				    </div>
				   <?php if ($isadmin) { ?>
				    <div class="panel_content hidden">
				            <div class="quick-edit-form">

				                <?php
				                $rendered_form['chp_txtwebsite'] = drupal_render($form['chp_txtwebsite']);

				                if ($form_has_errors[$form_id] === true):
				                    $form_has_errors[$form_id] = 'displayed';
				                    ?>
				                    <div>
				                        <p class="notification negative"><?php echo $message; ?></p>
				                    </div>
				                    <?php endif; ?>

				                <div class="element">
				                    <?php print $rendered_form['chp_txtwebsite']; ?>

				                </div>
				                <div class="button-group">
				                    <?php print drupal_render($form['save_chpwebsite'])?>
				                    <a class="small-button cancel-settings-btn" href="#">Cancel</a>
				                </div>
				            </div>

				    </div>
				    <?php }?>
				</div>

				<!-- Contact -->
				<div class="panel settings show_link" id="change_compcontact">
				    <div class="panel_label" style="cursor: <?php echo ($isadmin) ? 'pointer' : 'default';?> ;">
				        <h4 class="left">Contact</h4>

				        <div class="label_link right">
				           <?php if ($isadmin) { ?>
				            <a href="" class="show_link">change</a>
				            <?php }?>
				            <a href="" class="hide_link">hide</a>
				        </div>
				    </div>

				    <div class="panel_summary settings_val displayed" style="cursor: <?php echo ($isadmin) ? 'pointer' : 'default';?> ;">
				        <?php if ($node1->locations[0]['lid'] == ''): ?>
				        <p class="left" id="change_compcontact_val"><em>You currently have no contact</em></p>
				        <?php else: ?>
				        <p class="left tight" id="change_compcontact_val"><?php
				            if ($node1->locations[0]['street'] != '') {
				                print $node1->locations[0]['street'];
				            }
				            if ($node1->locations[0]['additional'] != '') {
				                print '<br/>' . $node1->locations[0]['additional'];
				            }
				            if ($node1->locations[0]['city'] != '') {
				                print '<br/>' . $node1->locations[0]['city'];
				            }
				            if ($node1->locations[0]['province'] != '') {
				                print ', ' . $node1->locations[0]['province'];
				            }
				            if ($node1->locations[0]['postal_code'] != '') {
				                print ' ' . $node1->locations[0]['postal_code'];
				            }
				            if ($node1->locations[0]['country'] != '' && $node1->locations[0]['country'] != 'us') {
				                print '<br/>' . $node1->locations[0]['country_name'];
				            }
				            if ($node1->field_chp_phone[0]['value'] != '') {
				                print '<br/><br/>' . format_phone_number($node1->field_chp_phone[0]['value']);
				            }
				            //if($node1->field_org_email[0]['url']!='')
				            //{print '<br/>'.$node1->field_org_email[0]['url'];}
				            ?></p>

				        <?php endif; ?>
				    </div>
				   <?php if ($isadmin) { ?>
				    <div class="panel_content hidden">
				        <div class="company-contact-information quick-edit-form sub-form-element">

				            <?php
				            $rendered_form['chp_country'] = drupal_render($form['chp_country']);
				            $rendered_form['chp_address1'] = drupal_render($form['chp_address1']);
				            $rendered_form['chp_address2'] = drupal_render($form['chp_address2']);
				            $rendered_form['chp_city'] = drupal_render($form['chp_city']);
				            $rendered_form['chp_state'] = drupal_render($form['chp_state']);
				            $rendered_form['chp_zipcode'] = drupal_render($form['chp_zipcode']);
				            $rendered_form['chp_phone'] = drupal_render($form['chp_phone']);

				            if ($form_has_errors[$form_id] === true):
				                $form_has_errors[$form_id] = 'displayed';
				                ?>
				                <div>
				                    <p class="notification negative"><?php echo $message; ?></p>
				                </div>
				                <?php endif; ?>


				            <div class="" id="contact_country">

				                <div class="pulled-item int-item uf-xlg">
				                    <label for="card-state">Country</label>
				                    <?php print $rendered_form['chp_country'];?>
				                </div>

				                <div class="pulled-item">
				                    <label for="card-name">Address</label>
				                    <?php print $rendered_form['chp_address1'];?>
				                </div>

				                <div class="pulled-item">
				                    <label class="compress" for="card-number">&nbsp;</label>
				                    <?php print $rendered_form['chp_address2'];?>
				                </div>

				                <div class="pulled-item">
				                    <label for="city">City</label>
				                    <?php print $rendered_form['chp_city'];?>
				                </div>

				                <div id="us_state" class="pulled-item uf-xlg">
				                <!--   <label for="state">State/Province</label> -->  
				                    <?php print $rendered_form['chp_state'];?>
				                </div>

				                <div class="pulled-item us-item" id="card-zip-form">
				                    <label for="card-zip">Zip/Postal code</label>
				                    <?php print $rendered_form['chp_zipcode'];?>
				                </div>


				                <div class="pulled-item us-item" id="card-zip-form">
				                    <label class="compress" for="card-zip">Phone <em class="small">(optional)</em></label>
				                    <?php print $rendered_form['chp_phone'];?>
				                </div>

				                <div class="pulled-item us-item" id="card-zip-form">
				                    <div class="button-group">
				                        <?php print drupal_render($form['save_chpcontact'])?>
				                        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
				                    </div>
				                </div>

				            </div>

				        </div>
				        </div>
				  <?php }?>
				</div>

				<!-- Overview -->
				<div class="panel settings show_link" id="change_compdesc">

				    <div class="panel_label" style="cursor: <?php echo ($isadmin) ? 'pointer' : 'default';?> ;">
				        <h4 class="left">Overview</h4>

				        <div class="label_link right">
				            <?php if ($isadmin) { ?>
				            <a href="" class="show_link">change</a>
				            <?php }?>
				            <a href="" class="hide_link">hide</a>
				        </div>
				    </div>

				    <div class="panel_summary settings_val displayed" style="cursor: <?php echo ($isadmin) ? 'pointer' : 'default';?> ;">

				        <?php if ($node1->body == '' && $node1->field_chp_foundation_stmt[0]['value'] == ''): ?>
				        <p class="left" id="change_compdesc_val"><em>You currently have no description</em></p>
				        <?php else: ?>
				        <h2><?php if ($node1->field_chp_foundation_stmt[0]['value'] != "") {
				            print ($node1->field_chp_foundation_stmt[0]['value']);
				        } ?></h2>
				        <p class="left" id="change_compdesc_val"><?php if ($node1->body != "") {
				            print ($node1->body);
				        } ?></p>
				        <?php endif; ?>
				    </div>
				       <?php if ($isadmin) { ?>
				    <div class="panel_content hidden">
				        <div class="quick-edit-form">

				            <?php
				            $form['chp_txtfoundationstatement']['#suffix'] = t('');
				            $form['chp_txtdescription']['#suffix'] = t('');
				                                                        $rendered_form['chp_txtfoundationstatement'] = drupal_render($form['chp_txtfoundationstatement']);
				            $rendered_form['chp_txtdescription'] = drupal_render($form['chp_txtdescription']);

				            if ($form_has_errors[$form_id] === true):
				                $form_has_errors[$form_id] = 'displayed';
				                ?>
				                <div>
				                    <p class="notification negative"><?php echo $message; ?></p>
				                </div>
				                <?php endif; ?>

			<div class="modal-tip hidden" id="foundation-statment-modal">
            	<p>In 3 sentences or less, state how your organization, services, products values align with the shared mission of USGBC.</p>
            </div>
            <p>Foundation statement <span class="small">(less than 100 words)</span><sup><a href="#foundation-statment-modal" class="jqm-tip-trigger -tip"><img src="/sites/all/themes/usgbc/lib/img/help-hint.gif";" alt="What's this?"/></a></sup></p>
				            <?php
				            print $rendered_form['chp_txtfoundationstatement']; ?>
				            <p>Description <span class="small">(less than 200 words)</span></p>
				            <?php print $rendered_form['chp_txtdescription'];  ?>
				            <div class="button-group">
				                <?php print drupal_render($form['save_chpoverview']);?>

				                <a class="small-button cancel-settings-btn" href="#">Cancel</a>
				            </div>

				        </div>

				    </div>
				    <?php }?>
				</div>

				<!-- social nw -->
				<div class="panel settings show_link" id="org_change_social">

				    <div class="panel_label" style="cursor: <?php echo ($isadmin) ? 'pointer' : 'default';?> ;"><h4 class="left">Social networks</h4>

				        <div class="label_link right">
				             <?php if ($isadmin) { ?>
				            <a href="" class="show_link">change</a>
				            <?php }?>
				            <a href="" class="hide_link">hide</a>
				        </div>
				    </div>
				    <div class="panel_summary settings_val displayed" style="cursor: <?php echo ($isadmin) ? 'pointer' : 'default';?> ;">
				        <?php if ($node1->field_chp_xing[0]['url'] == '' && $node1->field_chp_facebook[0]['url'] == '' && $node1->field_chp_twitter[0]['url'] == ''): ?>
				        <p class="left" id="change_membership_val"><em>You currently have no social networks</em></p>
				        <?php else: ?>
				        <ul class="social-network-list">
				            <?php if ($node1->field_chp_facebook[0]['url'] != ""): ?>
				            <li class="facebook">
				                <a href="<?php print $node1->field_chp_facebook[0]['url'] ?>"><?php print $node1->field_chp_facebook[0]['url'] ?></a>
				            </li><?php endif;?>
				            <?php if ($node1->field_chp_twitter[0]['url'] != ""): ?>
				            <li class="twitter">
				                <a href="<?php print $node1->field_chp_twitter[0]['url'] ?>"><?php print $node1->field_chp_twitter[0]['url'] ?></a>
				            </li><?php endif;?>
				            <?php if ($node1->field_chp_xing[0]['url'] != ""): ?>
				            <li class="xing">
				                <a href="<?php print $node1->field_chp_xing[0]['url'] ?>"><?php print $node1->field_chp_xing[0]['url'] ?></a>
				            </li><?php endif;?>				            
				        </ul>
				        <?php  endif; ?>
				    </div>
				    <?php if ($isadmin) { ?>
				    <div class="panel_content hidden">
				        <div class="quick-edit-form" id="social-network-edit-form">

				            <?php
				            $rendered_form['chp_txtfacebook'] = drupal_render($form['chp_txtfacebook']);
				            $rendered_form['chp_txttwitter'] = drupal_render($form['chp_txttwitter']);
				            $rendered_form['chp_txtxing'] = drupal_render($form['chp_txtxing']);

				            if ($form_has_errors[$form_id] === true):
				                $form_has_errors[$form_id] = 'displayed';
				                ?>
				                <div>
				                    <p class="notification negative"><?php echo $message; ?></p>
				                </div>
				                <?php endif; ?>

				            <p>Paste in URL of social network page to include in profile.</p>

				            <div class="element">
				                <label class="left social"><img alt="Facebook" src="/<?php print drupal_get_path('theme', 'usgbc') . '/lib/img/icons/facebook_16.png'?>"></label>
				                <?php print $rendered_form['chp_txtfacebook'];?>
				            </div>
				            <div class="element">
				                <label class="left social"><img alt="Twitter" src="/<?php print drupal_get_path('theme', 'usgbc') . '/lib/img/icons/twitter_16.png'?>"></label>
				                <?php print $rendered_form['chp_txttwitter'];?>
				            </div>
				      		<div class="element">
				                <label class="left social"><img alt="Xing" src="/<?php print drupal_get_path('theme', 'usgbc') . '/lib/img/icons/xing_16.png'?>"></label>
				                <?php print $rendered_form['chp_txtxing'];?>
				            </div>
				            <div class="button-group">
				                <?php print drupal_render($form['save_chpsocialnw']);?>

				                <a class="small-button cancel-settings-btn" href="#">Cancel</a>
				            </div>
				        </div>
				     </div>
				<?php }?>

				</div>
		</div>
	</div>

	<div class="hidden">
	    <?php print drupal_render($form); ?>
	</div>
</div>
<?php endif;?>
</div>


