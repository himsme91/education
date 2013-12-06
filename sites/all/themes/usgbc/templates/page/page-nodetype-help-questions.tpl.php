<?php
  // $Id: page-nodetype-help-questions.tpl.php 6900 2011-10-17 22:43:44Z jmehta $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */
    $styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/help.css" />';
  include('page_inc/page_top.php'); ?>


<div id="content" itemscope itemtype="http://schema.org/Helptopics">
  <?php print $content; ?>

   <div id="sideCol">
    <div class="padded ask-q">

   	<div class="aside">
		     <p>Have a question or comment?</p>
			<?php if(server_host_isprd() == true):?>
       	<?php //include('page_inc/salesforce_livechat_button_script_prd.php'); ?>
       	<?php elseif(server_host_isqa() == true):?>
       	<?php //include('page_inc/salesforce_livechat_button_script_qa.php'); ?>
       	<?php else:?>
       	<?php //include('page_inc/salesforce_livechat_button_script.php'); ?>
       	<?php endif?>
       	<div class="large-button" href=""><a href="/ask-a-question" class="arrow-button jqm-form-trigger" data-js-callback="init_ask_question"><span>Ask a Question</span></a></div>
       </div>

    </div>
    <div>
      <h7 class="sub-compact phone-link"><strong>800-795-1747</strong></h7>
      <p>(within U.S.)</p>
      <h7 class="sub-compact phone-link"><strong>202-742-3792</strong></h7>
      <p>(outside U.S.)</p>

      <p>M-F 9:00 AM to 5:30 PM EST</p><br>
      <h5>Billing</h5>

      <p>U.S. Green Building Council<br>P.O. Box 404296<br>Atlanta, GA 30384-4296</p><br>
      <h5>Location</h5>

      <p>2101 L Street, NW<br>Suite 500<br>Washington DC 20037<br>
        <a class="map-link" target="_blank" href="http://maps.google.com/maps?q=2101+L+Street,+NW+Suite+500+Washington+DC+20037&hl=en&ie=UTF8&view=map&ftt=180&geocode=FYGiUQId81to-w&split=0&sll=38.904449,-77.046797&sspn=0.000000,0.000000&hq=&hnear=2101+L+St+NW+%23500,+Washington,+District+of+Columbia+20037&t=h&z=16&vpsrc=0&iwloc=A">
          Map</a></p>
    </div>
  </div>
</div>
</div>

<?php if(server_host_isprd() == true):?>
	<?php include('page_inc/salesforce_deployment_script_prd.php'); ?>
<?php elseif(server_host_isqa() == true):?>
	<?php include('page_inc/salesforce_deployment_script_qa.php'); ?>
<?php else:?>
	<?php include('page_inc/salesforce_deployment_script.php'); ?>
<?php endif?>
       	

<?php include('page_inc/page_bottom.php'); ?>
