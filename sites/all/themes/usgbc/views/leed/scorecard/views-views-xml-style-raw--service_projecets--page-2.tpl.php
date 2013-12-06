<?php
$AE=92;$EA=91;$IE=90;$ID=89;$LL=88;$MR=87;$SS=85;$WE=86;
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
	if ($view->override_path) {       // inside live preview
    print htmlspecialchars($xml);
  }
  else if ($options['using_views_api_mode']) {     // We're in Views API mode.
    print $xml;
  }
  else {
  	drupal_set_header("Content-Type: $content_type; charset=utf-8");
    //print $xml;


    $xmlobject = simplexml_load_string($xml);
    $project_node = $xmlobject->project;
    $project_id_node = $project_node->id;
    $project_id = (string)$project_id_node;
    
    $project_id = str_pad ($view->args[0], 10, '0', STR_PAD_LEFT);

    $query = "select * from insight.project_credits_clib where project_id = $project_id"; 
    $result = db_query($query);

    $credits_node = $project_node->addChild('credits');

    while ($row = db_fetch_array($result)){
      $project_name = $row['project_name'];
      $city = $row['city'];
      $state = $row['state']; 
      $level = $row['level'];
      $date_certified = $row['date_certified']; 
      $shortid  = $row['clib_shortid'];
      $name     = $row['name'];
      $nodeid   = $row['credit_nid'];

      $possible = floatval($row['points_possible']);
      $awarded  = floatval($row['points_awarded']); 

      $rpc      = $row['flag_rpc'];
      $rpc_awarded = $row['rpc_awarded']=='X';
      if($rpc_awarded && $awarded){ $awarded = $awarded - 1;}
  //Credit Category Mapping
      $category         = substr($row['clib_shortid'],0,2);
      if($category == "IE" || $category == "EQ") $credit_category = $IE;
      else if($category == "EA") $credit_category = $EA;
      else if($category == "AE") $credit_category = $AE;
      else if($category == "LL") $credit_category = $LL;
      else if($category == "MR") $credit_category = $MR;
      else if($category == "WE") $credit_category = $WE;
      else if($category == "MR") $credit_category = $MR;
      else if($category == "SS") $credit_category = $SS;
      else if($category == "ID" || $category == "IO") $credit_category = $ID; 

      $catname  = taxonomy_get_term($credit_category);
      $catname  = $catname->name;

      $shortcat = strtolower(substr($shortid,0,2));
      if($shortcat == 'ie') $shortcat = 'iq';
      if($shortcat == 'io') $shortcat = 'id'; 
      if($shortcat == 'eq') $shortcat = 'iq'; 
      if($shortcat != 'pc' && $shortcat != 'rp'){
        $categories[$shortcat]['id']                            = $shortcat;
        $categories[$shortcat]['name']                          = $catname;
        $categories[$shortcat]['credits'][$shortid]['shortid']  = $shortid;
        $categories[$shortcat]['credits'][$shortid]['nid']    = $nodeid;    
        $categories[$shortcat]['credits'][$shortid]['name']     = $name;    
        $categories[$shortcat]['credits'][$shortid]['possible'] = $possible;
        $categories[$shortcat]['credits'][$shortid]['awarded']  = $awarded;   
        $categories[$shortcat]['possible'] = $categories[$shortcat]['possible'] + $possible;
        $categories[$shortcat]['awarded'] = $categories[$shortcat]['awarded'] + $awarded;   
        $total_awarded = $total_awarded  + $awarded;
        $total_possible = $total_possible + $possible;
      }
      if($rpc){
        $shortcat = 'rp';
        $catname = 'Regional priority';
        
        $categories[$shortcat]['id']                            = $shortcat;
        $categories[$shortcat]['name']                          = $catname;
        $categories[$shortcat]['credits'][$shortid]['shortid']  = $shortid;
        $categories[$shortcat]['credits'][$shortid]['name']     = $name;
        $categories[$shortcat]['credits'][$shortid]['possible'] = 1;
        if($rpc_awarded){     
          $categories[$shortcat]['credits'][$shortid]['awarded']  = 1;
          $categories[$shortcat]['awarded'] = $categories[$shortcat]['awarded'] + 1;    
          $total_awarded = $total_awarded + 1;
        }
        if(!$categories[$shortcat]['credits'][$shortid]['awarded']) $categories[$shortcat]['credits'][$shortid]['awarded'] = 0;
        if(!$categories[$shortcat]['awarded']) $categories[$shortcat]['awarded'] = 0;
        $categories[$shortcat]['possible'] = 4;
      } 
    }
    if($categories['rp']) $total_possible = $total_possible + 4;
    $rows_categories = $categories;

    foreach($categories as $category){
      $category_node = $credits_node->addChild('category');
      $category_node->addAttribute('name',$category['name']);
      $category_node->addAttribute('awarded',$category['awarded']);
      $category_node->addAttribute('possible',$category['possible']);
      foreach($category['credits'] as $credit){
        $credit_node = $category_node->addChild('credit');
        $credit_node->addAttribute('id',$credit['shortid']);
        $credit_node->addAttribute('name',$credit['name']);
        $credit_node->addAttribute('awarded',$credit['awarded']);
        $credit_node->addAttribute('possible',$credit['possible']);
      }
    }
    $xml = $xmlobject->asXML();


    print $xml;
    //print 'Hello world';
    exit;
  }