<?php
// $Id: views-view-list.tpl.php,v 1.3 2008/09/30 19:47:11 merlinofchaos Exp $
/**
 * @file views-view-list.tpl.php
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates
 */
//dsm($rows[0]);
//$month_list=array("January","February","March","April","May","June","July","August","September","October","November","December");
//dsm(count($month_list));
//dsm($rows[0]);
$page_title = $build_info['title'];
$build_info['title'] = ucfirst($page_title);
$month=array();

for($i=0;$i<=count($month_list);$i++)
{
	foreach ($rows as $id => $row){
 		if (strrchr($row,$month_list[$i])!=NULL)
 		{
 			array_push($month, $row);
 		}
 		else 
 		{
 			array_push($month, $month_list[$i]);
  		}
  	}
  	
}
//dsm($month);
 
//dsm($view);
$channel = $view->args[0];
$channel = str_replace("-", " ", $channel);

if (!empty($channel)){
	if ($channel == 'leed'){
		$page_title = "LEED archive";
	}else{
		$page_title = ucfirst($channel)." archive";
	}
}else{
	$page_title = "Archive";
}
//$page_title = $view->build_info['title'];
?>

  	<ul class="archive-list">
  		<li>
  		    <?php print $title; ?>
    			<ul>
            <?php foreach ($rows as $id => $row): ?>
            	<?php print $row; ?>
            <?php endforeach; ?>
      		</ul>
    	</li>
   	</ul> 
