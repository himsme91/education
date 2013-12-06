<?php
// $Id: template.functions.php 6568 2011-10-13 18:26:19Z pnewswanger $ 
/**
 * @file
 * Base theme
 * template includes + preprocess
 */


/**
 * include template overwrites
 */
  include_once './' . drupal_get_path('theme', 'base') . '/template_inc/template.functions.php';
  include_once './' . drupal_get_path('theme', 'base') . '/template_inc/template.form.php';
  include_once './' . drupal_get_path('theme', 'base') . '/template_inc/template.pager.php';
  include_once './' . drupal_get_path('theme', 'base') . '/template_inc/template.error.php';


/**
 * Preprocess functions ===============================================
 */


/**
 * Implementation of preprocess().
 */
function base_preprocess(&$vars, $hook) {
  //add path args to template vars
  $path = drupal_get_path_alias($_GET['q']);
  $vars['path'] = $path;
  $vars['path_args'] = explode('/', $path);
}

/**
 * Implementation of preprocess_page().
 */
function base_preprocess_page(&$vars, $hook) {

  // Add IE conditional javascript
  // ** ------------------------------------------------------------------------ **
  $vars['conditional_scripts'] .= '<!--[if IE]>' . "\n" . '<script type="text/javascript" src="/sites/all/libraries/selectivizr/selectivizr.js"></script><![endif]-->' . "\n";



  // Add template suggestion and body class to all pages except front.
  // ** ------------------------------------------------------------------------ **

  if (!$vars['is_front']) {

    $path = drupal_get_path_alias($_GET['q']);
    list($section, ) = explode('/', $path, 2);

    //Add node type to template file suggestion
    if (isset($vars['node'])) {
      // If the node type is "blog" the template suggestion will be "page-blog.tpl.php".
      $vars['template_files'][] = base_id_safe('page-nodetype-'. $vars['node']->type);
      //Add url path and section back into template file suggestion if type=node.
      array_unshift ($vars['template_files'], base_id_safe('page-'. $section), base_id_safe('page-'. $path));
    }


    // Classes for body element. Allows advanced theming based on context
    // (home page, node of certain type, etc.)
    $body_classes = array($vars['body_classes']);

    // Add unique classes for each page and website section
    $body_classes[] = base_id_safe('page-' . $path);
    $body_classes[] = base_id_safe('section-' . $section);
    if (arg(0) == 'node') {
      if (arg(1) == 'add') {
        if ($section == 'node') {
          array_pop($body_classes); // Remove 'section-node'
        }
        $body_classes[] = 'section-node-add'; // Add 'section-node-add'
      }
      elseif (is_numeric(arg(1)) && (arg(2) == 'edit' || arg(2) == 'delete')) {
        if ($section == 'node') {
          array_pop($body_classes); // Remove 'section-node'
        }
        $body_classes[] = 'section-node-' . arg(2); // Add 'section-node-edit' or 'section-node-delete'
      }
    }

    $vars['body_classes'] = implode(' ', $body_classes); // Concatenate with spaces

  }


  // Set default variables that depend on the database.
  $variables['is_admin']            = FALSE;
  $variables['is_front']            = FALSE;
  $variables['logged_in']           = FALSE;
  if ($variables['db_is_active'] = db_is_active()   && !defined('MAINTENANCE_MODE')) {
    // Check for administrators.
    $is_admin = user_access('access administration pages');
    if ($is_admin) {
      $variables['is_admin'] = TRUE;
      //add custom css for admin section
      $admin_css['all']['theme'][drupal_get_path('theme', 'base').'/lib/css/drupal_admin.css'] = TRUE;
      $vars['styles'] .= drupal_get_css($admin_css);
    }
    // Flag front page status.
    $variables['is_front'] = drupal_is_front_page();
    // Tell all templates by which kind of user they're viewed.
    $variables['logged_in'] = ($user->uid > 0);
  }

  // Split primary and secondary local tasks
  $vars['tabs'] = theme('menu_local_tasks', 'primary');
  $vars['tabs2'] = theme('menu_local_tasks', 'secondary');

}

/**
 * Implementation of preprocess_fieldset().
 */
function base_preprocess_fieldset(&$vars) {
  $element = $vars['element'];

  $attr = isset($element['#attributes']) ? $element['#attributes'] : array();
  $attr['class'] = !empty($attr['class']) ? $attr['class'] : '';
  $attr['class'] .= ' fieldset';
  $attr['class'] .= !empty($element['#title']) ? ' titled' : '';
  $attr['class'] .= !empty($element['#collapsible']) ? ' collapsible' : '';
  $attr['class'] .= !empty($element['#collapsible']) && !empty($element['#collapsed']) ? ' collapsed' : '';
  $vars['attr'] = $attr;

  $description = !empty($element['#description']) ? "<div class='description'>{$element['#description']}</div>" : '';
  $children = !empty($element['#children']) ? $element['#children'] : '';
  $value = !empty($element['#value']) ? $element['#value'] : '';
  $vars['content'] = $description . $children . $value;
  $vars['title'] = !empty($element['#title']) ? $element['#title'] : '';
  if (!empty($element['#collapsible'])) {
    $vars['title'] = l(filter_xss_admin($vars['title']), $_GET['q'], array('fragment' => 'fieldset', 'html' => TRUE));
  }
  $vars['hook'] = 'fieldset';
}

/**
 * Implementation of preprocess_form_element().
 * Take a more sensitive/delineative approach toward theming form elements.
 */
function base_preprocess_form_element(&$vars) {
  $element = $vars['element'];

  // Main item attributes.
  $vars['attr'] = array();
  $vars['attr']['class'] = 'form-item';
  $vars['attr']['id'] = !empty($element['#id']) ? "{$element['#id']}-wrapper" : NULL;
  if (!empty($element['#type']) && in_array($element['#type'], array('checkbox', 'radio'))) {
    $vars['attr']['class'] .= ' form-option';
  }
  $vars['description'] = isset($element['#description']) ? $element['#description'] : '';

  // Generate label markup
  if (!empty($element['#title'])) {
    $t = get_t();
    $required_title = $t('This field is required.');
    $required = !empty($element['#required']) ? "<span class='form-required' title='{$required_title}'>*</span>" : '';
    $vars['label_title'] = $t('!title: !required', array('!title' => filter_xss_admin($element['#title']), '!required' => $required));
    $vars['label_attr'] = array();
    if (!empty($element['#id'])) {
      $vars['label_attr']['for'] = $element['#id'];
    }

    // Indicate that this form item is labeled
    $vars['attr']['class'] .= ' form-item-labeled';
  }
}
