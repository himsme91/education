<?php 	
	global $user;
	$view = views_get_view('exam_registration');
	$view->set_items_per_page(0);
	$view->set_display('page_2');
	$args = array();
	$args[0] = $user->uid;
	$view->set_arguments ($args);
	print $view->preview();
?>
