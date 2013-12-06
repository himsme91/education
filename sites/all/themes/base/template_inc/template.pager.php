<?php
// $Id: template.pager.php 56526 2013-08-13 16:46:38Z jmehta $

/**
 * Overwrite both themed mini and full pager.
 */

function base_pager($tags = array(), $limit = 10, $element = 0, $parameters = array(), $quantity = 9) {
   	return pager($tags, $limit, $element, $parameters, $quantity);
}

function base_views_mini_pager($tags = array(), $limit = 10, $element = 0, $parameters = array(), $quantity = 9) {
   return pager($tags, $limit, $element, $parameters, $quantity);
}

function pager($tags, $limit, $element, $parameters, $quantity) {
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.


  $li_start = theme('pager_first', (isset($tags[1]) ? $tags[1] : t('')), $limit, $element, 1, $parameters);
  $li_start_class = 'btn first';
  if (empty($li_start)) {
    $li_start = "&nbsp;";
    $li_start_class .= ' disabled';
  }

  $li_previous = theme('pager_previous', (isset($tags[1]) ? $tags[1] : t('')), $limit, $element, 1, $parameters);
  $li_previous_class = 'btn prev';
  if (empty($li_previous)) {
    $li_previous = "&nbsp;";
    $li_previous_class .= ' disabled';
  }

  $li_next = theme('pager_next', (isset($tags[3]) ? $tags[3] : t('')), $limit, $element, 1, $parameters);
  $li_next_class = 'btn next';
  if (empty($li_next)) {
    $li_next = "&nbsp;";
    $li_next_class .= ' disabled';
  }

  if ($pager_total[$element] > 1) {
    $items[] = array(
      'class' => $li_start_class,
      'data' => $li_start,
    );

    $items[] = array(
      'class' => $li_previous_class,
      'data' => $li_previous,
    );

    $items[] = array(
      'class' => 'input',
      'data' => '<input type="text" class="long" name="page" value="'.$pager_current.'">',
    );

    $items[] = array(
      'class' => 'of',
      'data' => t('of'),
    );

    $items[] = array(
      'class' => 'total',
      'data' => t('@max', array('@max' => $pager_max)),
    );

    $items[] = array(
      'class' => $li_next_class,
      'data' => $li_next,
    );
    return pager_list($items);
  }
}

//Custom adaptation of theme_item_list
function pager_list($items = array()) {

  $output = '';

  if (!empty($items)) {

    $output .= '<ul class="mini-pager ag-pagination">';

    foreach ($items as $item) {
      $attributes = array();
      $children = array();
      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $data = $item;
      }
      if (count($children) > 0) {
        $data .= theme_item_list($children, NULL, $type, $attributes); // Render nested list
      }
      $output .= '<li' . drupal_attributes($attributes) . '>' . $data . '</li>';
    }
    $output .= '</ul>';
  }

  return $output;
}


/**
 * 'infinite' pager, replaces Views' mini_pager, use for ajax views
 * adapted from Views' theme_views_mini_pager()
 */
function base_views_infinite_pager($tags = array(), $limit = 10, $element = 0, $parameters = array(), $quantity = 9) {

  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // no previous or current or last, just More/next
  $path = drupal_get_path_alias($_GET['q']);
  list($section, ) = explode('/', $path, 2);
    $title = 'Load more';
    if($section == '<front>' || $section == 'articles') $title .= ' articles';

   $more_text = t($title);
   $attributes = array('class'=>'load-more-entries jumbo-button');
   $li_next = theme('infinite_pager_more', $more_text, $limit, $element, 1, $parameters, $attributes);
   if (empty($li_next)) {
       return '';
   } else {
       return $li_next;
   }
  
}

/**
 * Modified theme_pager_next()
 */
function base_infinite_pager_more($text, $limit, $element = 0, $interval = 1, $parameters = array(), $attributes = array()) {
  global $pager_page_array, $pager_total;
  $output = '';

  // If we are anywhere but the last page
  if ($pager_page_array[$element] < ($pager_total[$element] - 1)) {
    $page_new = pager_load_array($pager_page_array[$element] + $interval, $element, $pager_page_array);

    // dsm(array('for'=>'infinite_pager_more', 'page_new'=>$page_new, 'args'=>func_get_args()));

    // // If the next page is the last page, mark the link as such.
    // if ($page_new[$element] == ($pager_total[$element] - 1)) {
    //   $output = theme('pager_last', $text, $limit, $element, $parameters);
    // }
    // // The next page is not the last page.
    // else {
      $output = theme('pager_link', $text, $page_new, $element, $parameters, $attributes);

    //*** not differentiating next from last, just 'More' ***//
    // }
  }

  return $output;
}
/* checking not applicable when ajax is enabled
 if (isset($_GET['page']) && intval($_GET['page'], 10)) {
$_SESSION['your_custom_pager_index'] = $_GET['page'];
} else {
$_SESSION['your_custom_pager_index'] = 1;
}
*/


/*
<?php
// Remember pager per view (only for ajax views)
function base_views_pre_execute(&$view)
    {
		$view_name = $view->name .'_'. $view->current_display .'_'. $view->args[0];
		if(!isset($_GET['page']) && !isset($_GET['pager_element']) && $_SESSION[$view_name] > 0)
			{
				$view->pager['current_page'] = $_SESSION[$view_name];
			}
	else if(isset($_GET['page']) && $_GET['view_name'] == $view->name && $_GET['view_display_id'] == $view->current_display)
	 {
		$_SESSION[$view_name] = $_GET['page'];
	 }
	else{
		$_SESSION[$view_name] = 0;
	    }
	}
?>
*/