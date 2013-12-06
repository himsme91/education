<?php
//$Id: views-views-json-style-simple.tpl.php,v 1.1.2.4 2010/07/15 07:34:48 allisterbeharry Exp $
/**
 * @file views-views-json-style-simple.tpl.php
 * Default template for the Views JSON style plugin using the simple format
 *
 * Variables:
 * - $view: The View object.
 * - $rows: Hierachial array of key=>value pairs to convert to JSON
 * - $options: Array of options for this style 
 *
 * @ingroup views_templates
 */

$jsonp_prefix = $options['jsonp_prefix'];

if ($view->override_path) {
	// We're inside a live preview where the JSON is pretty-printed.
	$json = _views_json_encode_formatted($rows);
	if ($jsonp_prefix) $json = "$jsonp_prefix($json)";	
	print "<code>$json</code>";
}
else {

	$credit_row = $rows['credits'][0]['credit'];
	$current_nid = $credit_row['nid'];
	$current_node = node_load ($current_nid);
	$parent_id = $current_node->field_credit_parent[0]['nid'];
	$credit_row['parent'] = $parent_id;

	$parent = node_load($parent_id);

	if ($parent) {
		$grandparent = node_load ($parent->field_credit_parent[0]['nid']);
	}

	$children        = array();
	$grandchildren   = array();
	$grandchildrenof = array();
	$dupIndex = 0;
	
	foreach($current_node->field_credit_options as $option){
		$option_nid = $option['nid'];
		$child_node = node_load ($option_nid);
		if($children[$child_node->nid]){
			$dupIndex++;
			$index = $child_node->nid."".$dupIndex;
			$children[$index] = $child_node;
		} else {
			$children[$child_node->nid] = $child_node;
		}
		if($child_node) $grandchildren = null;
		if($child_node->field_credit_options[0]){
			foreach($child_node->field_credit_options as $gcid=>$grandchild){
				$grandchild_node = node_load($grandchild['nid']);
				if($grandchild_node)
					$grandchildren[$grandchild_node->nid] = $grandchild_node;
			}
			$grandchildrenof[$child_node->nid] = $grandchildren;
		}
	}

	$options_array = array();
	$options_array = $parent->field_credit_options;
	$step_children = array();
	foreach ((array)$options_array as $o) {
		if ($o['nid'] != $fields['nid']->raw) {
			$child_node = node_load ($o['nid']);
			$step_children[$child_node->field_credit_short_id[0]['value']] = $child_node;
		}
		$i++;
	}
	
	$intent                     = get_field_value ($credit_row, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'intent', 'field_credit_intent');
	$requirements               = get_field_value ($credit_row, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof,'requirements', 'field_credit_requirements');
	$credit_row['intent']       = $intent;
	$credit_row['requirements'] = $requirements;	
	$rows['credits'][0]['credit'] = $credit_row;
	
  $json = json_encode($rows);
  if ($jsonp_prefix) $json = "$jsonp_prefix($json)";
  if ($options['using_views_api_mode']) {
    // We're in Views API mode.
    print $json;
  }
  else {
    // We want to send the JSON as a server response so switch the content
    // type and stop further processing of the page.
    $content_type = ($options['content_type'] == 'default') ? 'application/json' : $options['content_type'];
    drupal_set_header("Content-Type: $content_type; charset=utf-8");
    print $json;
    //Don't think this is needed in .tpl.php files: module_invoke_all('exit');
    exit;
  }
}


function get_field_value_reference ($fields, $parent, $grandparent, $step_children, $children, $field_name) {
  $value = NULL;
  if ($parent) {
    $f = $parent->$field_name;
    if (!empty($f[0]['nid'])) {
      foreach ($f as $ref) {
        $value[$ref['nid']] = $ref;
      }
    }
  }
  $c = $current_node->$field_name;
  if (!empty($c[0]['nid'])) {
    foreach ($c as $ref) {
      $value[$ref['nid']] = $ref;
    }
  }

}

function get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, $row_field_name, $field_name) {
  $value = NULL;
  if ($grandparent) {
    $f = $grandparent->$field_name;
    if (!empty($f[0]['value'])) {
      $value .= content_format ($field_name, $f[0]);
    }
  }
  if ($parent) {
    $f = $parent->$field_name;
    if (!empty($f[0]['value'])) {
      $value .= content_format ($field_name, $f[0]);
    }
  }


  if (!empty($fields[$row_field_name])) {
    $value .= $fields[$row_field_name];
  }

  foreach ($step_children as $stepchild_id => $stepchild) {
    $f = $stepchild->$field_name;
    if (!empty($f[0]['value'])) {
      if ($children[$stepchild_id]) {
        $f = $children[$stepchild_id]->$field_name;
/*        if (!empty($f[0]['value'])) {
          if ($fields['credit_type'] == 'Credit (rating system dependent)' && $parent) {
            $value .= '<h6>Specific to ' . $fields['field_credit_rating_system_value']->content . '</h6>';
          }
        }*/
        $value .= content_format ($field_name, $f[0]);
      }
    }
  }

	foreach ($children as $child_id => $child) {
		if (!$step_children[$child_id]) {
			$f  = $child->$field_name;
			if (!empty($f[0]['value'])) {
				$value .= content_format ($field_name, $f[0]);
			}
			if($grandchildrenof[$child_id]){
				$grandchildren = $grandchildrenof[$child_id];
				foreach ($grandchildren as $grandchild_id => $grandchild){
					$f = $grandchild->$field_name;
					if (!empty($f[0]['value'])) {
						$value .= content_format ($field_name, $f[0]);
					}
				}
			}
		}
	}
  return $value;
}
