<?php
  // $Id: template.comments.php 36100 2012-11-07 07:41:15Z pkhanna $
  /**
   * @file
   * comments usgbc overwrites
   */


  /**
   * Add a "Comments" heading above comments except on forum pages.
   */
  function usgbc_preprocess_comment_wrapper (&$vars) {
    $node = $vars['node'];
    if ($vars['content']) {
      //Create $title for comments
      if (intval ($node->comment_count) == 1) {
        $output .= '<h3>' . $node->comment_count . ' comment';
      } else {
        $output .= '<h3>' . $node->comment_count . ' comments';
      }
      // if ($node->comment_count > 1) $output .= 's';
      $output .= '<a href="' . $node->links['comment_add']['href'] . '#comment-form" class="right">Leave a comment</a></h3>';
      $vars['title'] = $output;

      //add hanging-images class
      $types = array('application', 'course', 'resource');
      $vars['class'] = '';
      if (in_array ($node->type, $types)) {
        $vars['class'] .= ' hanging-images';
      }

    }
  }


  function usgbc_preprocess_comment (&$variables) {
    $comment = $variables['comment'];
    $node = $variables['node'];

    $nodeauthor = '';
    $usertitle = '';
    $user_profile_img = 'sites/default/files/placeholder/person_placeholder.png';

    if ($comment->uid) {
      $person = content_profile_load ('person', $comment->uid);
      if ($person->nid) {
      	
      	$type = "organization";
    	$getorg = db_result (db_query ("SELECT n.nid FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s')", $comment->uid, 1, $type));
    	if ($getorg != '') {
      		$orgnode = node_load ($getorg);
    	}

        $usertitle = $person->field_per_job_title[0]['value'];
        if ($orgnode->nid){
        	if ($usertitle == '')  
        		$usertitle = $orgnode->title;
        	else
        		$usertitle .= ', ' . $orgnode->title;
        }
        elseif ($person->field_per_orgname[0]['value'] != ''){
        	if ($usertitle == '')
        		$usertitle = $person->field_per_orgname[0]['value'];
        	else 
        		$usertitle .= ', ' . $person->field_per_orgname[0]['value'];
        }
  

        if ($person->field_per_profileimg[0]['filepath'] != '') {
          $user_profile_img = $person->field_per_profileimg[0]['filepath'];
        }

      }

    }

    if ($comment->uid == $node->uid) {
      $nodeauthor = 'author-comment';
    }


    $variables['nodeauthor'] = $nodeauthor;
    $variables['companydata'] = $usertitle;
    $variables['picture'] = theme ('imagecache', 'fixed_060-060', $user_profile_img, $alt, $title, $attributes);


    global $user;
    if (!$user->uid) {
      $variables['links'] = '';
    } else {

      $comment_level = count (explode ('.', $comment->thread));
      $variables['comment_level'] = $comment_level;

      if ($comment_level >= 5) {
        $links = comment_links ($comment);
        unset($links['comment_parent']);
        unset($links['comment_reply']);
        $variables['links'] = theme ('links', $links, array('class' => 'links inline'));

      }


    }

  }


  // Comments submitted by
  function usgbc_comment_submitted ($comment) {

    $output = '<h5>' . format_interval ((time () - $comment->timestamp), 2) . t (' ago') . '</h5>';
    $output .= '<h4 class="replyee_name">' . theme ('username', $comment) . '</h4>';
    return $output;

  }
