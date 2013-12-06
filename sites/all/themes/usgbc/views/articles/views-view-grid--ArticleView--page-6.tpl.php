<?php
// $Id: views-view-grid.tpl.php,v 1.3.4.1 2010/03/12 01:05:46 merlinofchaos Exp $
/**
 * @file views-view-grid.tpl.php
 * Default simple view template to display a rows in a grid.
 *
 * - $rows contains a nested array of rows. Each row contains an array of
 *   columns.
 *
 * @ingroup views_templates
 */
?>
<?php 
//$form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
//$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');	
//print_r($rows);	

?> 

<?php if (!empty($title)) : ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<!-- 
<div id="-involved-box" class="emphasized-box">
	<div class="container">
		<h5>Share your insight</h5>
		<p>Do you have any green insight that you would like to share with our community?</p>
		<div class="">
			<a href="/node/add/article" class="button">Submit an article</a>
		</div>
	</div>
</div> -->
<!--
<div class="supporter-block">
	 <div class="ad">
    	  <span>Advertisement</span>
       <p>
          <a href="#">
       		   <img src="http://placehold.it/180x150">
           </a>
       </p>
     </div>
</div>
-->
