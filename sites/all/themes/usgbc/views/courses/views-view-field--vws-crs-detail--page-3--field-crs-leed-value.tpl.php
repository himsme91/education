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

<?php 	    
    //dsm($output);
    	    if (inStr($output,'LEED AP O+M')):?>
    	    	<span class="leed-certificate-om">O+M</span>
    	    <?php endif;
    	    if (inStr($output,'LEED AP ND')):?>
    	    	<span class="leed-certificate-nd">ND</span>
			<?php endif;
			if (inStr($output,'LEED AP ID+C')): ?>
				<span class="leed-certificate-idc">ID+C</span>
			<?php endif;
			if (inStr($output,'LEED AP Homes')):?>
				<span class="leed-certificate-homes">HOMES</span>
			<?php endif;
			if (inStr($output,'LEED AP BD+C')):?>
    	    	<span class="leed-certificate-bdc">BD+C</span>
    	    <?php endif;
	    
    if (inStr($output,'LEED Green Associate')):?>
   <span class="leed-certificate-ga">GA</span>
    <?php endif;?>
                                  