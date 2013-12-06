<?php
// $Id: template.functions.php 9300 2011-11-23 14:53:42Z pnewswanger $
/**
 * @file
 * general functions for Base theme
 */


/**
 * Override of theme_menu_local_tasks().
 * Add argument to allow primary/secondary local tasks to be printed
 * separately. Use theme_links() markup to consolidate.
 */
function base_menu_local_tasks($type = '') {
  if ($primary = menu_primary_local_tasks()) {
    $primary = "<ul class='links primary-tabs'>{$primary}</ul>";
  }
  if ($secondary = menu_secondary_local_tasks()) {
    $secondary = "<ul class='links secondary-tabs'>$secondary</ul>";
  }
  switch ($type) {
    case 'primary':
      return $primary;
    case 'secondary':
      return $secondary;
    default:
      return $primary . $secondary;
  }
}


function base_id_safe($string, $vars = "default") {
  // Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
  if($vars == "remove-numbers"){
    $string = strtolower(preg_replace('/[^a-zA-Z_-]+/', '-', $string));
  }else{
    $string = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $string));  
  }
  // change the  "_" to "-"
  $string = strtolower(str_replace('_', '-', $string));
  
  // If the first character is not a-z, add 'n' in front.
  if (function_exists('ctype_lower')) {
    if (!ctype_lower($string{0})) { // Don't use ctype_alpha since its locale aware.
      $string = 'id' . $string;
    }  
  }
  else {
    preg_match('/[a-z]+/', $string{0}, $matches);
    if (count($matches) == 0) {
      $string = 'id' . $string;
    }
  }
  return $string;
}
