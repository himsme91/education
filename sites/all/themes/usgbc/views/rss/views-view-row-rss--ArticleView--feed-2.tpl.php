<?php
// $Id: views-view-row-rss.tpl.php,v 1.1 2008/12/02 22:17:42 merlinofchaos Exp $
/**
 * @file views-view-row-rss.tpl.php
 * Default view template to display a item in an RSS feed.
 *
 * @ingroup views_templates
 */
?>
  <item>
    <title><?php print $title; ?></title>
    <link><?php print $link; ?></link>
    <description><![CDATA[<?php
	//$desc = $node->teaser ? $node->teaser : $node->body;
	//if ($desc == '') $desc = $node->field_art_article[0]['value'];
  	
	$attributes = array(
      	'class'=> '',
      	'id'   => 'art_val'
    );
	$img_path = $node->field_art_feature_image[0]['filepath'];
    $img = theme ('imagecache', 'fixed_282-125', $img_path, $alt, $title, $attributes);
    $img = str_replace('%252F', '', $img);
/*
    $auth = '';
    if(is_array($node->field_all_authored_by)){
    	foreach($node->field_all_authored_by as $authors){
    		$author = node_load($authors['nid']);
    		if($auth == '') $auth = $author->title;
    		else $auth = $auth.', '.$author->title; 	
    	}
    }
    if($auth == '') $auth = $node->name;
    
    $auth = 'Authored by: '.$auth;
    $readmorelink = '<a href="/'.$node->path.'">Read more</a>'; */
    //$description = $auth.'<br/>'.$desc.'<br/>'.$img.'<br/>'.$readmorelink;
    $description = $img;
	print trim($description);
?>]]></description>
    <?php print $item_elements; ?>
  </item>