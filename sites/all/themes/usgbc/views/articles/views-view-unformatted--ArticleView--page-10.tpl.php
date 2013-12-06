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

//dsm($_GET);
//list($arg0, $arg1, $arg2) = split('[/]', $_GET['q']);
//dsm($arg2);
//$tree= taxonomy_get_tree(2,0,-1,NULL);
//$dsm($row);
?> 

<div class="bg-agsort">
<?php foreach ($rows as $id => $row): ?>
     <?php print $row; ?>
 <?php endforeach; ?>
</div>


