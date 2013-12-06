<?php //dsm($form);?>
<style type="text/css">
.fieldset-content .form-item label {
 	border-bottom: 1px solid #EEEEEE;
    clear: both;
    color: #222222;
    margin-bottom: 15px;
    padding: 0 0 5px;
    font-size: 16px;
    font-weight:normal;
    font-family: "proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;
}

#edit-chapterupdate-wrapper label {
    clear: both;
    color: #222222;
    margin-bottom: 15px;
    padding: 0 0 5px;
    font-size: 16px;
    font-weight:normal;
    font-family: "proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;
}


.fieldset-content .form-item label.option {
	border-bottom: 0px solid #EEEEEE;
}
#edit-chapterupdate-wrapper {
    padding: 0 0 15px;
}
.mailchimp-newsletter-wrapper .form-item .form-checkboxes .form-item {
    margin-bottom: 5px;
    padding:0;
    font-family: "Helvetica Neue",Arial,sans-serif;
}
.mailchimp-newsletter-wrapper span.label-text {
    font-size: 11px;
    font-weight: normal;
}

#edit-chapterupdate-wrapper span.label-text {
    font-size: 11px;
    font-weight: normal;
}

.mailchimp-newsletter-wrapper fieldset {
    border: 1px none;
    border-radius: 0px;
    margin-bottom: 0px;
    padding: 0px;
}

#edit-mailchimp-list-20404b2ecb-wrapper label.option{
	display:none;
} 

#edit-mailchimp-list-20404b2ecb-wrapper{
	padding:0;
}


/* */
</style>

<h1>Subscriptions</h1>
<?php 
	$form['submit']['#attributes'] = Array('class'=>' button');
    $form['submit']['#value'] = t('Update');
    $form['wrapper20404b2ecb']['interest_groups_20404b2ecb']['#title'] = t('');
    $form['wrapper20404b2ecb']['interest_groups_20404b2ecb']['#collapsible'] = FALSE;
    $form['wrapper20404b2ecb']['interest_groups_20404b2ecb']['#collapsed'] = FALSE;
    $form['wrapper20404b2ecb']['interest_groups_20404b2ecb']['9513']['#title'] = t('<b>Digest</b> (monthly)');
    $form['wrapper20404b2ecb']['interest_groups_20404b2ecb']['9501']['#title'] = t('<b>Insider updates</b> (occasional)');
     
?>
<div class="myaccountsubscription">
	<?php print drupal_render($form);?>
</div>