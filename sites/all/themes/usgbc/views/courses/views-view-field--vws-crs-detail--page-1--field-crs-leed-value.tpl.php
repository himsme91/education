<?php
// $Id: views-view-field.tpl.php,v 1.1 2008/05/16 22:22:32 merlinofchaos Exp $
 /**
  * This template is used to print a single field in a view. It is not
  * actually used in default Views, as this is registered as a theme
  * function which has better performance. For single overrides, the
  * template is perfectly okay.
  *
  * Variables available:
  * - $view: The view object
  * - $field: The field handler object that can process the input
  * - $row: The raw SQL result that can be used
  * - $output: The processed output that will normally be used.
  *
  * When fetching output from the $row, this construct should be used:
  * $data = $row->{$field->field_alias}
  *
  * The above will guarantee that you'll always get the correct data,
  * regardless of any changes in the aliasing that might happen if
  * the view is modified.
  */
?>
<pre><?php //dsm($row)?></pre>



<?php //print $output; ?>


<ul class="crs_certification-list-right">
     <?php 
    if (inStr($output,'LEED AP BD+C')   &&
	    inStr($output,'LEED AP Homes') 	&&
	    inStr($output,'LEED AP ID+C')	&&
	    inStr($output,'LEED AP O+M')	&&
	    inStr($output,'LEED AP ND')    ) :
?>
    <li class="crs_cert-ap-all" title="">LEED AP ALL</li>
<?php 	    
    
    else:
    	    if (inStr($output,'LEED AP O+M')):?>
    	    	<li class="crs_cert-ap-om" title="">LEED AP O+M</li>
    	    <?php endif;
    	    if (inStr($output,'LEED AP ND')):?>
    	    	<li class="crs_cert-ap-nd" title="">LEED AP ND</li>
			<?php endif;
			if (inStr($output,'LEED AP ID+C')): ?>
				<li class="crs_cert-ap-idc" title="">LEED AP ID+C</li>
			<?php endif;
			if (inStr($output,'LEED AP Homes')):?>
				<li class="crs_cert-ap-homes" title="">LEED AP Homes</li>
			<?php endif;
			if (inStr($output,'LEED AP BD+C')):?>
    	    	<li class="crs_cert-ap-bdc" title="">LEED AP BD+C</li>
    	    <?php endif;
    endif;
	    
    if (inStr($output,'LEED Green Associate')):?>
    <li class="crs_cert-ga" title="">LEED Green Associate</li>
    <?php endif;?>
       
       
</ul>                             