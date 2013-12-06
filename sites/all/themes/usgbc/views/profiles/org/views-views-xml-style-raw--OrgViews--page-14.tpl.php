<?php
// $Id: views-views-xml-style-raw.tpl.php,v 1.1.2.6 2010/06/07 03:27:07 allisterbeharry Exp $
/**
 * @file views-views-xml-style-raw.tpl.php
 * Default template for the Views XML style plugin using the raw schema
 *
 * Variables
 * - $view: The View object.
 * - $rows: Array of row objects as rendered by _views_xml_render_fields 
 *
 * @ingroup views_templates
 * @see views_views_xml_style.theme.inc
 */	
dsm($view);
	if ($view->override_path) {       // inside live preview
    print htmlspecialchars($xml);
  }
  else if ($options['using_views_api_mode']) {     // We're in Views API mode.
    print $xml;
  }
  else {
  	drupal_set_header("Content-Type: $content_type; charset=utf-8");
    $data = new SimpleXMLElement($xml);
   /* $url = $_SERVER['REQUEST_URI'];
    $parsed_url = parse_url($url);
    $url_query = $parsed_url['query'];
	parse_str($url_query, $out);
print_r( $url);
	if($out['distance']) {
   		$lat = $out['distance']['latitude'] ;
   		$lng = $out['distance']['longitude'] ;
	}*/
 //   print $lat ;
 
// 	print_r($latlong);
	$out = $view->args[0];
 	 if($out['distance']) {
   		$lat = $out['distance']['latitude'] ;
   		$lng = $out['distance']['longitude'] ;
	}
 	$search = $data->addChild("search_coordinates");
 	$search->addAttribute("address", $lat);
 	$search->addAttribute("lat", $lat);
 	$search->addAttribute("lng", $lng);
  	print $data->asXML();	
    exit;
  }