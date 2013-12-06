<?php

include_once './' . drupal_get_path ('module', 'diff') . '/diff.pages.inc';

if (arg(0) == 'node' && is_numeric(arg(1))) $nodeid = arg(1);
$node = node_load($nodeid);
//$form = diff_diffs_overview($node);
//print $form;

if($_GET['old'] && $_GET['new']){
	//dsm($_GET['old_vid']);
	$old_vid = $_GET['old'];
	$new_vid = $_GET['new'];
	drupal_set_title(t('Revisions for %title', array('%title' => $node->title)));
	
	$node_revisions = node_revision_list($node);
	
	$old_node = node_load($node->nid, $old_vid);
	$new_node = node_load($node->nid, $new_vid);
	
	if($old_node && $new_node){// Generate table header (date, username, logmessage).
		$old_header = t('!date by !username', array(
				'!date' => (format_date($old_node->revision_timestamp)),
				'!username' => theme('username', $node_revisions[$old_vid]),
		));
		$new_header = t('!date by !username', array(
				'!date' => (format_date($new_node->revision_timestamp)),
				'!username' => theme('username', $node_revisions[$new_vid]),
		));
		
		/*$old_log = $old_node->log != '' ? '<p class="revision-log">'. filter_xss($old_node->log) .'</p>' : '';
		$new_log = $new_node->log != '' ? '<p class="revision-log">'. filter_xss($new_node->log) .'</p>' : '';
		
		// Generate previous diff/next diff links.
		$next_vid = _diff_get_next_vid($node_revisions, $new_vid);
		if ($next_vid) {
			$next_link = l(t('next diff >'), 'node/'. $node->nid .'/revisions/view/'. $new_vid .'/'. $next_vid);
		}
		else {
			$next_link = '';
		}
		$prev_vid = _diff_get_previous_vid($node_revisions, $old_vid);
		if ($prev_vid) {
			$prev_link = l(t('< previous diff'), 'node/'. $node->nid .'/revisions/view/'. $prev_vid .'/'. $old_vid);
		}
		else {
			$prev_link = '';
		}*/
		
		
		$cols = _diff_default_cols();
		$header = _diff_default_header($old_header, $new_header);
		$rows = array();
		
		$rows = array_merge($rows, _diff_body_rows($old_node, $new_node));
		$output = theme('diff_table', $header, $rows, array('class' => 'diff details'), NULL, $cols);
		
		// Don't include node links (final argument) when viewing the diff.
		//$output .= node_view($new_node, FALSE, FALSE, FALSE);
	}
	else{
		$output = "Invalid nodes";
	}
	$back_link = l(t('<< Back To Revisions'), 'node/'. $node->nid, array('query' =>array('view'=>'revisions')));
	print $back_link;
	print $output;
	
}
else{
	$form = diff_diffs_overview($node);
	print $form;
}

?>

<script>
$(document).ready(function(){
	$("#diff-node-revisions #edit-submit").live('click',function(e){
		e.preventDefault();
		var old_vid = $(".form-item .radio input[name=old]:checked").val();
		var new_vid = $(".form-item .radio input[name=new]:checked").val();
		old_id = parseInt(old_vid);
		new_id = parseInt(new_vid);
		<?php
			$url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		?>
		if(old_id > new_id){
			url = '<?php print $url;?>'+'&old='+new_vid+'&new='+old_vid;
			window.location.assign(url);  
		}
		else if(old_id < new_id){
			url = '<?php print $url;?>'+'&old='+old_vid+'&new='+new_vid;
			window.location.assign(url); 
		}
		else{
			alert("Invalid Revision Selection");
		}
	});
	
});
</script>