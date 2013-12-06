<?php 
//$node = node_load($row->nid);
//dsm($fields);       
list($arg0, $arg1, $arg2) = split('[/]', $_GET['q']);                                                                                                                              
?>

<li>
<?php if($arg2 == NULL):?>
<a href="/articles/archivelist/<?php print $fields['field_year_month_value']->content;?>" >
<?php else:?>
<a href="/articles/archivelist/<?php print $fields['field_year_month_value']->content;?>/<?php print strtolower($arg2);?>" >
<?php endif;?>
<?php print $fields['created']->content;?> 
<?php //print $fields['created_1']->content; ?> 
	<span class="count"><?php print $fields['nid']->content; ?></span>
</a>
<br/>
</li>