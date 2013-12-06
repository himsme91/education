<?php
$rat_sys = taxonomy_get_term($view->args[0]);
$rat_sys_ver = taxonomy_get_term($view->args[1]);
$path = 'credits/'.str_replace('&', '%26', usgbc_dashencode($rat_sys->name)).'/'.str_replace('&', '%26', usgbc_dashencode($rat_sys_ver->name));
$link = url($path, array('absolute' => FALSE));
$current_node = $fields['nid']->content;
header( 'Location: /node/'.$current_node.'?return='.$link ) ;
?>

	
