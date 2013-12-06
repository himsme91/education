<?php
// $Id: template.menu.php 44131 2013-04-09 22:14:57Z jmehta $
/**
 * @file
 * menu usgbc overwrites
 */
 

/* override theme_menu_item_link()
 * If link have attr (name="nolink") replace href url with "#"
 */
function usgbc_menu_item_link($link) {
  if ($link['options']['attributes']['name'] == 'nolink') {
    // add nolink class and rel nofollow if not included.
    if (!preg_match('/nolink/',$link['localized_options']['attributes']['class'])) $link['localized_options']['attributes']['class'] .= ' nolink';
    if ($link['localized_options']['attributes']['rel'] != 'nofollow') $link['localized_options']['attributes']['rel'] = 'nofollow';

    $options = $link['localized_options'];
    $text = $link['title'];
    return '<a href="#"' . drupal_attributes($options['attributes']) . '>' . ($options['html'] ? $text : check_plain($text)) . '</a>';
  }
  
  //Add active trail by path
  /*
$args = explode('/',$_GET['q']);
  if($link['title'] == 'Articles' && ($args[0] == 'articles' || $args[0] == 'article')){
      $link['localized_options']['attributes']['class'] .= ' active-trail';
  }
*/
  
  if (empty($link['localized_options'])) {
    $link['localized_options'] = array();
  }

  return l($link['title'], $link['href'], $link['localized_options']);
  
}