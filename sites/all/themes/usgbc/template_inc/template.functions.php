<?php
  // $Id: template.functions.php 49416 2013-06-01 07:01:31Z jmehta $
  /**
   * @file
   * general functions for usgbc theme
   */

  //Load TypeKit
//  drupal_set_html_head ('<script type="text/javascript" src="http://use.typekit.com/rsm7gxu.js"></script>');
//  drupal_set_html_head ('<script type="text/javascript">try{Typekit.load();}catch(e){}</script>');

  //drupal_set_html_head ('<script data-cfasync="false" type="text/javascript" src="https://use.typekit.com/dip8onb.js"></script>');
  //drupal_set_html_head ('<script data-cfasync="false" type="text/javascript">try{Typekit.load();}catch(e){}</script>');
	
 /* drupal_set_html_head('<script type="text/javascript">
	  (function() {
	    var config = {
	      kitId: \'dip8onb\',
	      scriptTimeout: 3000
	    };
	    var h=document.getElementsByTagName("html")[0];h.className+=" wf-loading";var t=setTimeout(function(){h.className=h.className.replace(/( |^)wf-loading( |$)/g,"");h.className+=" wf-inactive"},config.scriptTimeout);var tk=document.createElement("script");tk.src=\'//use.typekit.net/\'+config.kitId+\'.js\';tk.type="text/javascript";tk.async="true";tk.onload=tk.onreadystatechange=function(){var a=this.readyState;if(a&&a!="complete"&&a!="loaded")return;clearTimeout(t);try{Typekit.load(config)}catch(b){}};var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(tk,s)
	  })();
	</script>');*/

  /*
  //Update search result snippet
 function usgbc_preprocess_search_result(&$variables) {

  if ($variables['result']['node']->nid) {
    $node = node_load($variables['result']['node']->nid);
    $variables['snippet'] = $node->title;//substr($node->body,0,250) . '...'; //node_view($node, TRUE, TRUE, FALSE); // node_view($node, $teaser = FALSE, $page = FALSE, $links = TRUE)
  }
}
*/

  //Breadcrumb theme
  function usgbc_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">' . implode(' ', $breadcrumb) . '</div>';
  }
}

  // Reset mini search box
  function usgbc_search_theme_form ($form) {
    unset($form['search_theme_form']['#title']);
    unset($form['search_theme_form']['#attributes']['title']);
    $form['search_theme_form']['#attributes']['class'] = 'mini-search-field apachesolr-autocomplete unprocessed';
    $form['search_theme_form']['#value'] = 'Search the site';

    $output = drupal_render ($form);
    return $output;
  }
  
  //JM: ApacheSolr Facet block theme
	function usgbc_apachesolr_facet_link($facet_text, $path, $options = array(), $count, $active = FALSE, $num_found = NULL) {
	  $options['attributes']['class'][] = '';
	  if ($active) {
	    $options['attributes']['class'][] = 'active';
	  }
	  $options['attributes']['class'] = implode(' ', $options['attributes']['class']);
	  $options['html'] = TRUE;
	  $text = usgbc_facet_type_name($facet_text).' <span class="count">('.$count.')</span>';
	  return apachesolr_l($text,  $path, $options);
	}
	
	function usgbc_apachesolr_unclick_link($facet_text, $path, $options = array()) {
  if (empty($options['html'])) {
    $facet_text = check_plain(html_entity_decode($facet_text));
  }
  else {
    // Don't pass this option as TRUE into apachesolr_l().
    unset($options['html']);
  }
  $options['attributes']['class'] = 'apachesolr-unclick';
  $options['html'] = TRUE;
  return apachesolr_l("&nbsp;&nbsp;&nbsp;&nbsp;", $path, $options) . ' '. $facet_text;
}

function usgbc_apachesolr_sort_link($text, $path, $options = array(), $active = FALSE, $direction = '') {
  $icon = '';
  if ($direction) {
    $icon = ' '. theme('tablesort_indicator', $direction);
  }
  if ($active) {
    if (isset($options['attributes']['class'])) {
      $options['attributes']['class'] .= ' active';
    }
    else {
      $options['attributes']['class'] = 'active';
    }
  }
  return apachesolr_l($text, $path, $options) . $icon;
}

function custom_apachesolr_do_query($caller, $current_query, &$params = array('rows' => 10), $page = 0) {

  // Allow modules to alter the query prior to statically caching it.
  // This can e.g. be used to add available sorts.
  foreach (module_implements('apachesolr_prepare_query') as $module) {
    $function_name = $module . '_apachesolr_prepare_query';
    $function_name($current_query, $params, $caller);
  }

  // Cache the original query. Since all the built queries go through
  // this process, all the hook_invocations will happen later
  $custom_query = apachesolr_current_query($current_query, $caller);

  // This hook allows modules to modify the query and params objects.
  apachesolr_modify_query($custom_query, $params, $caller);
  $params['start'] = $page * $params['rows'];

  if (!$custom_query) {
    return array(NULL, array());
  }
  // Final chance for the caller to modify the query and params. The signature
  // is: CALLER_finalize_query(&$query, &$params);
  $function = $caller . '_finalize_query';
  if (function_exists($function)) {
    $function($custom_query, $params);
  }

  $keys = $custom_query->get_query_basic();
  if ($keys == '' && isset($params['fq'])) {
    // Move the fq params to q.alt for better performance.
    $qalt = array();
    foreach ($params['fq'] as $delta => $value) {
      // Move the fq param if it has no local params and is not negative.
      if (!preg_match('/^(?:\{!|-)/', $value)) {
        $qalt[] = '(' . $value . ')';
        unset($params['fq'][$delta]);
      }
    }
    if ($qalt) {
      $params['q.alt'] = implode(' ', $qalt);
    }
  }
  // This is the object that does the communication with the solr server.
  $solr = apachesolr_get_solr();
  // We must run htmlspecialchars() here since converted entities are in the index
  // and thus bare entities &, > or < won't match. Single quotes are converted
  // too, but not double quotes since the dismax parser looks at them for
  // phrase queries.
  $keys = htmlspecialchars($keys, ENT_NOQUOTES, 'UTF-8');
  $keys = str_replace("'", '&#039;', $keys);
  $custom_response = $solr->search($keys, $params['start'], $params['rows'], $params);
  // The response is cached so that it is accessible to the blocks and anything
  // else that needs it beyond the initial search.
  apachesolr_static_response_cache($custom_response, $caller);
  return array($custom_query, $custom_response);
}

function facet_pulldown($keys, $filterstring, $solrsort, $base_path = '', $page = 0, $caller = 'apachesolr_search') {

  $params = array();
  // This is the object that knows about the query coming from the user.
  $query = apachesolr_drupal_query($keys, $filterstring, $solrsort, $base_path);
  
  if (empty($query)) {
    throw new Exception(t('Could not construct a Solr query in function apachesolr_search_search()'));
  }

  $params += apachesolr_search_basic_params($query);
  if ($keys) {
    $params += apachesolr_search_highlighting_params($query);
    $params += apachesolr_search_spellcheck_params($query);
  }
  else {
    // No highlighting, use the teaser as a snippet.
    $params['fl'] .= ',teaser';
  }
  if (module_exists('upload')) {
    $params['fl'] .= ',is_upload_count';
  }

  apachesolr_search_add_facet_params($params, $query);
  apachesolr_search_add_boost_params($params, $query, apachesolr_get_solr());

  list($final_custom_query, $custom_response) = custom_apachesolr_do_query($caller, $query, $params, $page);
  apachesolr_has_searched(TRUE);
  // Add search terms and filters onto the breadcrumb.
  // We use the original $query to avoid exposing, for example, nodeaccess
  // filters in the breadcrumb.  ->facet_counts->facet_fields
  //return $custom_response;
 return apachesolr_process_response($custom_response, $final_custom_query, $params);
}

function usgbc_glossary_search_results($keys = NULL) {
  $vids = _glossary_get_filter_vids();
  $output = '<div class="glossary-box">';

  $sql = db_rewrite_sql("SELECT t.tid FROM {term_data} t WHERE t.vid IN (". db_placeholders($vids) .") AND (t.name LIKE '%s')", 't}', 'tid');
  $vars = $vids;
  // Yes, we need this twice.
  $vars[] = $keys;
  $vars[] = $keys;
  $result = db_query($sql, $vars);
  $found = NULL;
  while ($row = db_fetch_object($result)) {
    ++$count;
    $term = taxonomy_get_term($row->tid);
    $found .= '<dl>'. theme('glossary_overview_item', $term, TRUE) .'</dl>';
  }
  if (!$found) {
  	return '';
    //$found = drupal_get_form('glossary_search_form', $keys) .'<p>'. t('Your search yielded no results') . glossary_help('glossary_search#noresults') .'</p>';
  }

  $output .= theme('box', t('Glossary search results'), $found);
  return $output .'<small style="border-top:solid 1px">For more glossary terms <a target="_blank" href="/glossary">click here</a>.</small></div>';
}


  // Next Steps box my account
  function usgbc_content_complete_profile_percent_complete ($complete_data) {
    // add CSS for theming
    drupal_add_css (drupal_get_path ('module', 'content_complete') . '/content_complete.css');

    $output .= '<div id="content-complete-wrapper" class="content-complete-complete-wrapper">';

    //we're not displaying this label right now.
    $bar_label = t ('Your account is !complete% complete<br/><br/>', array(
      '!complete' => $complete_data['percent']
    ));


    // Divide percentages in 4 regions of 25 each
    $complete_data['leq_percent'] = 0;
    while ($complete_data['leq_percent'] <= 100) {
      if ($complete_data['percent'] <= $complete_data['leq_percent']) break;
      $complete_data['leq_percent'] += 25;
    }

    if (!isset($complete_data['percent'])) {
      $complete_data['percent'] = 0; // protect against unset values
    }

    //$per = round($complete_data['leq_percent'] / 10) * 10;
    $per_str = '';
    $per_str = $complete_data['percent'] . '%';
    $output .= '<div class="mini-progbar">';
    $output .= '<div class="mini-progbar-container">';
    $output .= '<div id="content-complete-percent-bar" class="content-complete-percent-bar content-complete-percent-bar-leq-' . $complete_data['percent'] . ' mini-progbar-bar"><span>' . $per_str . '</span></div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';

    if ($complete_data['percent'] != 100) {
      $output .= '<ul class="linelist">';

      if ($complete_data['connect_link'] != '') {
        $output .= '<li><a href="' . $complete_data['connect_link'] . '">Connect to member organization</a></li>';
      }
      if ($complete_data['org_link'] != '') {
        $output .= '<li><a href="' . $complete_data['org_link'] . '">Complete organization profile</a></li>';
      }
      if ($complete_data['per_link'] != '') {
        $output .= '<li><a href="' . $complete_data['per_link'] . '">Publish personal profile</a></li>';
      }

      //if ($complete_data['tax_link'] != ''){
      //	$output .= '<li><a href="'.$complete_data['tax_link'].'">Enter tax exempt certificate</a></li>';
      //}

      if ($complete_data['logo_link'] != '') {
        $attributes = array('class'=>'left');
        $output .= '<li><a href="' . $complete_data['logo_link'] . '">'. theme('imagecache', 'fixed_040-040', 'sites/default/files/logos/gray/usgbc-member-logo.png', 'USGBC Member logo',null,$attributes) .' Download USGBC member logo</a></li>';
      }


      $output .= '</ul>';
    }

    /*
    if (isset($complete_data['edit']) && $complete_data['edit'] && isset($complete_data['nextfield']) && isset($complete_data['nextpercent'])) {
      $output .= t('<br/>Filling out <i>!nextfield</i> will bring !typename to !complete%.', array(
        '!nextfield' => l(t($complete_data['nextfield']), 'node/'. $complete_data['nid'] .'/edit', array(
          'query' => 'content_complete_fieldname='. $complete_data['nextname']
        )),
        '!typename' => $complete_data['name'],
        '!complete' => $complete_data['nextpercent']
      ));
    }*/

    return $output;
  }

  // Site header text
  function get_section_header ($section) {
    $home_url = url ('<front>');
    $home_url = '/home';
    $output = '<p id="page-title"><a href="' . $home_url . '" class="logo">USGBC Home</a>';

    $section_name = array(
      'directory'                             => array('name' => 'Directory',
                                 'path'       => '/directory'),
      'profiles'                              => array('name' => 'Directory',
                                 'path'       => '/profile'),
      'apps'                                  => array('name' => 'Apps',
                                 'path'       => '/apps'),
      'advocacy'                              => array('name' => 'Advocacy',
                                 'path'       => '/advocacy'),
      'resources'                             => array('name' => 'Resources',
                                 'path'       => '/resources'),
      'community'                             => array('name' => 'Community',
                                 'path'       => '/community'),
      'leed'                                  => array('name' => 'LEED',
                                 'path'       => '/leed'),
      'education'                             => array('name' => 'Education',
                                 'path'       => '/education'),
      'initiatives'                           => array('name' => 'Initiatives',
                                 'path'       => '/initiatives'),
      'articles'                              => array('name' => 'Articles',
                                 'path'       => '/articles'),
      'courses'                               => array('name' => 'Courses',
                                 'path'       => '/courses'),
      'store'                                 => array('name' => 'Store',
                                 'path'       => '/store'),
      'help'                                  => array('name' => 'Help Center',
                                 'path'       => '/help'),
      'glossary'                                  => array('name' => 'Glossary',
								  'path' => '/glossary'),
      'press'                                  => array('name' => 'Pressroom',
								  'path' => '/press'),


    );

    $current_section_map = array(
      'profiles'          => $section_name['directory'],
      'profile'           => $section_name['directory'],
      'directory'         => $section_name['directory'],
      'people'            => $section_name['directory'],
      'organizations'     => $section_name['directory'],
      'projects'          => $section_name['directory'],
      'apps'              => $section_name['apps'],
      'advocacy'          => $section_name['advocacy'],
      'resources'         => $section_name['resources'],
      'community'         => $section_name['community'],
      'leed'              => $section_name['leed'],
      'credits'           => $section_name['leed'],
      'education'         => $section_name['education'],
      'initiatives'       => $section_name['initiatives'],
      'articles'          => $section_name['articles'],
      'courses'           => $section_name['courses'],
      'course'            => $section_name['courses'],
      'store'             => $section_name['store'],
      'help'              => $section_name['help'],
      'publications'      => $section_name['store'],
      'glossary'      	  => $section_name['glossary'],
      'press'      	      => $section_name['press'],
    );

    if (!empty($current_section_map[$section]['name'])) {
      $output .= '<span class="section"><a href = "' . $current_section_map[$section]['path'] . '" class="section">' . $current_section_map[$section]['name'] . '</a></span>';
      ;
    } else {
      $output .= '<span class="section"><a href = "' . url ('<front>') . '" class="section">USGBC</a></span>';
    }

    $output .= '</p>';

    return $output;

  }

  // removes the #printed index from an array (recursive)
  // this is used so we can recall the drupal_render function on separate fields that are normally included within the $content var.
  function reset_printed_flag ($fields) {
    foreach ($fields as $name => $field) {
      if ($name == '#printed') {
        unset($fields[$name]);
      } elseif (substr ($name, 0, 1) == '#') {
        continue;
      } else {
        if (!is_array ($field)) continue;
        $fields[$name] = reset_printed_flag ($field);
      }

    }
    return $fields;
  }

  /**
* Override theme_breadcrumb().
*/
/*
function usgbc_breadcrumb($breadcrumb) {

  $links = array();

	global $base_url;
	$arg0 =str_replace('-',' ', str_replace('/credits/','',$_GET['return']));
	$sections = explode ('/', str_replace('&','%26',$arg0), 3);
	$url = explode('/',str_replace('&','%26',$_GET['return']),5);
	$links[] = l(ucfirst(str_replace('%26','&',$sections[0])).' '.$sections[1], $base_url.'/'.$url[1].'/'.$url[2].'/'.$url[3]);
	if (array_key_exists(2,$sections)){
		$links[] .= l(ucfirst(str_replace('%26','&',$sections[2])), $base_url.str_replace('&','%26',$_GET['return']));
	}

  // Set custom breadcrumbs
  drupal_set_breadcrumb($links);

  // Get custom breadcrumbs
  $breadcrumb = drupal_get_breadcrumb();

}

 */

  function usgbc_set_orgid(){
  	global $user;
  	if ($user->uid && !isset($_SESSION['orgnid'])){
  		$subscriptions = og_get_subscriptions($user->uid);
  		if($subscriptions){
  			foreach($subscriptions as $subscription){
  				if($subscription['type']=='organization'){
  					$_SESSION['orgnid'] =$subscription['nid'];
  				}
  			}
  		}
  	}
  }
  
  /**
* Default theme function for all RSS rows.
*/
function usgbc_preprocess_views_view_row_rss(&$vars) {
	$view = &$vars['view'];
	$options = &$vars['options'];
	$item = &$vars['row'];
	
	// Use the [id] of the returned results to determine the nid in [results]
	$result = &$vars['view']->result;
	$id = &$vars['id'];
	$node = node_load( $result[$id-1]->nid );
	//dsm($node);
	$vars['title'] = check_plain($item->title);
	$vars['link'] = check_url($item->link);
	$vars['description'] = check_plain($item->description);
	//$vars['description'] = check_plain($node->teaser);
	$vars['node'] = $node;
	$vars['item_elements'] = empty($item->elements) ? '' : format_xml_elements($item->elements);
}
