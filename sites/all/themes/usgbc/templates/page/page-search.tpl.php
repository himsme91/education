<?php
// $Id: page.tpl.php 7027 2011-10-18 16:54:26Z pnewswanger $
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */

$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/search.js"></script>';
include('page_inc/page_top.php'); ?>
<style type="text/css">
.box{
 border: none;
 box-shadow: none;
 padding:0px; 
}
.glossary-box{
 border: 1px solid #DDDDDD;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    padding: 15px;
}
.apachesolr-unclick{
    background-image: url("/sites/all/themes/usgbc/lib/img/back-link.png");
    background-position: center;
    background-repeat: no-repeat;
}
.jumbo-search-container field:focus{
border-color: none;
 box-shadow: none;
}

</style>
<div class="twoColRight" id="content">
<div id="navCol">
<div class="ag-filter-list">
            		<h3>Filter by type</h3>
            			 <?php
	  	$type_block = module_invoke('apachesolr_search','block','view','type');
		print $type_block['content']; ?>
            	</div>
            	
            	<div class="ag-filter-list">
            		<h3>Sort by</h3>
            			<?php
	  	$sort_block = module_invoke('apachesolr','block','view','sort');
		print $sort_block['content']; ?>
            		
            	</div>


</div>
 <div id="mainCol">
	<?php print $content; ?>
</div>
<div id="sideCol" class="hidden">
            	<div class="padded ask-q">
  <div class="aside">
		     <p>Have a question or comment?</p>
			<?php if(server_host_isprd() == true):?>
       	<?php include('page_inc/salesforce_livechat_button_script_prd.php'); ?>
       	<?php elseif(server_host_isqa() == true):?>
       	<?php include('page_inc/salesforce_livechat_button_script_qa.php'); ?>
       	<?php else:?>
       	<?php include('page_inc/salesforce_livechat_button_script.php'); ?>
       	<?php endif?>
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

<?php if(server_host_isprd() == true):?>
	<?php include('page_inc/salesforce_deployment_script_prd.php'); ?>
<?php elseif(server_host_isqa() == true):?>
	<?php include('page_inc/salesforce_deployment_script_qa.php'); ?>
<?php else:?>
	<?php include('page_inc/salesforce_deployment_script.php'); ?>
<?php endif?>
       	

<?php include('page_inc/page_bottom.php'); ?>
