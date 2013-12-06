<?php
  // $Id: template.functions.php 6568 2011-10-13 18:26:19Z pnewswanger $
  /**
   * @file
   * USGBC theme
   * template includes + preprocess
   */


  /**
   * include template overwrites
   */
  include_once './' . drupal_get_path ('theme', 'usgbc') . '/template_inc/template.functions.php';
  include_once './' . drupal_get_path ('theme', 'usgbc') . '/template_inc/template.theme.php';
  include_once './' . drupal_get_path ('theme', 'usgbc') . '/template_inc/template.menu.php';
  include_once './' . drupal_get_path ('theme', 'usgbc') . '/template_inc/template.comments.php';


  /**
   * Page Preprocess
   */
  function usgbc_preprocess_page (&$vars, $hook) {
	
	global $user;
	usgbc_set_orgid();
	$path = drupal_get_path_alias ($_GET['q']);

/*	if(!($user->uid)){		
		if($path!="new-usgbc" && $path!="user/login" && $path!="registration/create-user"){
			drupal_goto("<front>");
		}
	}
	
	if($user->uid){
		if($path == "new-usgbc"){
			drupal_goto("private-beta");
		}
	}*/
	

    // if this is a panel page, add template suggestions
    if ($panel_page = page_manager_get_current_page ()) {
      $panel_handler = $panel_page['handler'];
      $panel_display = $panel_handler->conf['display'];
      $layout_name = $panel_display->layout;
      $vars['panel_layout_name'] = $layout_name;
      //set theme var if layout name includes 'landing'
      $vars['is_landing_pg'] = false;
      if (preg_match ('/landing/', $layout_name)) $vars['is_landing_pg'] = true;

      // add a generic suggestion for all panel pages
      $suggestions[] = 'page-panel';
      // add the panel page machine name to the template suggestions
      $suggestions[] = 'page-panel-' . $panel_page['name'];

      $vars['template_files'] = $suggestions;

    }

    if(arg(0) == 'node' && arg(2) == 'edit'){
      $vars['template_files'][] = 'page-node-edit';
    }

    // Add menus to the page var
    $menus = Array(
      "footer_menu" => "menu-footer",
      "legal_menu"  => "menu-legalmenu"
    );
    foreach ($menus as $k=> $v) {
      $m = menu_navigation_links ($v);
      $vars[$k] = theme ('links', $m, array('class' => 'links ' . $k));
    }
    // Add menu blocks to the page var
    $menu_blocks = Array(
      "global_menu"      => array(6),
      "utility_menu"     => array(1),
      "personal_menu"    => array(7),
      "section_menu"     => array(2, 4),
      "section_sub_menu" => array(8, 20, 19, 14, 15, 18)
    );
    foreach ($menu_blocks as $k=> $v_group) {
      foreach ($v_group as $v) {
        $menu_block = module_invoke ('menu_block', 'block', 'view', $v);
        if (!empty($menu_block['content']) || $menu_block['content'] != '') break;
      }

      $vars[$k] = $menu_block['content'];
    }


    if (isset ($vars['node']->type) && $vars['node']->type == 'resource') {
      //   $tid = $vars['node']->field_res_type[0]['view'];
      //  $term = taxonomy_term_load($tid);
      menu_set_active_item ('resources/grid/studies/all');
    }


    $path = drupal_get_path_alias ($_GET['q']);
    list($section,) = explode ('/', $path, 2);
    $vars['page_header'] = get_section_header ($section);
    

  }

  /**
   * Node Preprocess
   */
  function usgbc_preprocess_node (&$variables) {
    $node = $variables['node'];

    //explode $content into separate vars for the following content types
    $types = array('article');
    if (in_array ($node->type, $types)) {

      $fields = reset_printed_flag ($node->content);
      $rendered_field = array();
      foreach ($fields as $name=> $field) {
        if (!is_array ($field)) continue;
        if (substr ($name, 0, 1) != '#') $rendered_field[$name] = drupal_render ($field);
      }

      $variables['rendered_field'] = $rendered_field;
    }

  }

