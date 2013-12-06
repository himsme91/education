<?php 
global $user;
$pviewname = 'ce_hours_activity';
$pargs [0] = $user->uid;
$pdisplay_id = 'page_3'; // or any other display
$pview = views_get_view ($pviewname);
$pview->set_display ($pdisplay_id);
$pview->set_arguments ($pargs);
print $pview->preview ();
?>