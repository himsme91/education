<?php
  // $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
  /**
   * @file views-view-fields.tpl.php
   * Default simple view template to all the fields as a row.
   *
   * - $view: The view in use.
   * - $fields: an array of $field objects. Each one contains:
   *   - $field->content: The output of the field.
   *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
   *   - $field->class: The safe class id to use.
   *   - $field->handler: The Views field handler object controlling this field. Do not use
   *     var_export to dump this object, as it can't handle the recursion.
   *   - $field->inline: Whether or not the field should be inline.
   *   - $field->inline_html: either div or span based on the above flag.
   *   - $field->separator: an optional separator that may appear before a field.
   * - $row: The raw result object from the query, with all data it fetched.
   *
   * @ingroup views_templates
   */
  $current_node = node_load ($fields['nid']->content);
  $current_nid = $current_node->nid;


  //dsm($fields['field_credit_parent_nid']->handler->field_values);
  $parent_field = $fields['field_credit_parent_nid']->handler->field_values[$current_nid];

  $parent_id = $parent_field[0]['nid'];
  $parent = node_load ($parent_id);
  if ($parent) {
    $grandparent = node_load ($parent->field_credit_parent[0]['nid']);
  }

  $children = array();
  $grandchildren = array();
  $grandchildrenof = array();
	$dupIndex = 0;
	foreach ($fields['field_credit_options_nid']->handler->field_values as $oid => $oids) {
		foreach ($oids as $option_id => $option) {
			$child_node = node_load ($option['nid']);
			if($children[$child_node->nid]){
				$dupIndex++;
				$index = $child_node->nid."".$dupIndex;
				$children[$index] = $child_node;
			}else{
				$children[$child_node->nid] = $child_node;
			}
			if($child_node)
			$grandchildren = null;
			if($child_node->field_credit_options[0]){
				foreach($child_node->field_credit_options as $gcid=>$grandchild){
					$grandchild_node = node_load($grandchild['nid']);
					if($grandchild_node)
						$grandchildren[$grandchild_node->nid] = $grandchild_node;
				}
				$grandchildrenof[$child_node->nid] = $grandchildren;
			}

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

$intent              = get_field_value ($fields, $parent, $grandparent, $step_children, $children,  $grandchildren,   $grandchildrenof,'field_credit_intent');
$requirements        = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof,'field_credit_requirements');
/*
$benefits            = get_field_value ($fields, $parent, $grandparent, $step_children, $children,  $grandchildren, $grandchildrenof,'field_credit_benefits_issu');
$standards           = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_credit_summary_standards');
$timeline            = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_credit_timeline_team');
$documentation       = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_credit_doc_guidance');
$examples            = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_credit_examples');
$exemplary           = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_credit_exemp_performance');
$calculations        = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_credit_calculations');
$regional            = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_credit_regional_variations');
$omconsider          = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_credit_om_considerations');
$implement           = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, 'field_credit_implement');
$standards_a         = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_all_reference_standards');
$behind_intent       = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_behind_the_intent');
$guidance            = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_step_by_step_guidance');
$further_explanation = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_further_explanation');
$related_tips        = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_related_credit_tips');
$changes             = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_changes_from_previous_ver');
$team                = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_team_members');
$exemplary           = get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren,  $grandchildrenof,'field_exemplary_performance');
*/

  $standards_a = $current_node->field_all_reference_resources;
  $resources_a = $current_node->field_all_reference_resources;

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

  function get_field_value ($fields, $parent, $grandparent, $step_children, $children, $grandchildren, $grandchildrenof, $field_name) {
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


    if (!empty($fields[$field_name . '_value']->content)) {
      $value .= $fields[$field_name . '_value']->content;
    }

    foreach ($step_children as $stepchild_id => $stepchild) {
      $f = $stepchild->$field_name;
      if (!empty($f[0]['value'])) {
        if ($children[$stepchild_id]) {
          $f = $children[$stepchild_id]->$field_name;
          if (!empty($f[0]['value'])) {
            if ($fields['field_credit_type_value']->raw == 1 && $parent) {
              $value .= '<h6>Specific to ' . $fields['field_credit_rating_system_value']->content . '</h6>';
            }
          }
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

?>

<div class="twoColLeft" id="content">
  <div id="mainCol">
    <div class="aside">
      <ul class="visual-helpers">
        <li class="glossary">
          <a class="trigger" href="">
            <span class="text">Glossary</span>
          </a>
        </li>
      </ul>
    </div>

    <div class="contributed-content">
      <?php if ($intent) { ?>
      <h3>Intent</h3>
      <?php print $intent; ?>
      <?php }?>

      <?php if ($requirements) { ?>
      <h3>Requirements</h3>
      <?php print $requirements; ?>
      <?php }?>

      <?php if (!empty($fields['field_credit_technologies_value']->content)) { ?>
      <h3>Technologies &amp; strategies</h3>
      <?php print $fields['field_credit_technologies_value']->content; ?>
      <?php }?>

      <?php if ($benefits) { ?>
      <h3>Benefits &amp; issues</h3>
      <?php print $benefits; ?>
      <?php }?>

      <?php if ($calculations) { ?>
      <h3>Calculations</h3>
      <?php print $calculations; ?>
      <?php }?>

      <?php if ($standards_a[0]['nid']) { ?>
      <?php
      $count = 0;
      foreach ($standards_a as $standard) {
        $standard_node = node_load ($standard['nid']);
        $resource_type_term = taxonomy_get_term ($standard_node->field_res_type[0]['value']);
        $resource_type = $resource_type_term->name;
        $standard_id = $standard_node->field_res_id[0]['value'];
        if ($standard_id) {
          $standard_id = ' [' . $standard_id . ']';
        }
        if ($resource_type == "Standards") {
          $count++;
          if ($count == 1) {
          //  print "<h3>Summary of referenced standards</h3>";
          }
         // print "<h5><a target='_blank' href='/node/" . $standard_node->nid . "'>" . $standard_node->title . $standard_id . "</a></h5>";
         // print "</a>";
         // print '<p>' . $standard_node->field_all_description_short[0]['value'] . '</p>';
        }

      }
      ?>

      <?php }?>

      <?php if ($implement) { ?>
      <h3>Implementation</h3>
      <?php print $implement; ?>
      <?php }?>

      <?php if ($timeline) { ?>
      <h3>Timeline & team</h3>
      <?php print $timeline; ?>
      <?php }?>

      <?php if ($documentation) { ?>
      <h3>Documentation</h3>
      <?php print $documentation; ?>
      <?php }?>

      <?php if ($examples) { ?>
      <h3>Examples</h3>
      <?php print $examples; ?>
      <?php }?>

      <?php if ($exemplary) { ?>
      <h3>Exemplary performance</h3>
      <?php print $exemplary; ?>
      <?php }?>

      <?php if ($regional) { ?>
      <h3>Regional variations</h3>
      <?php print $regional; ?>
      <?php }?>

      <?php if ($omconsider) { ?>
      <h3>Operations &amp; maintenance considerations </h3>
      <?php print $omconsider; ?>
      <?php }?>

      <?php if ($behind_intent) { ?>
      <h3>Behind the intent </h3>
      <?php print $behind_intent; ?>
      <?php }?>


      <?php if ($guidance) { ?>
      <h3>Step by step guidance </h3>
      <?php print $guidance; ?>
      <?php }?>


      <?php if ($further_explanation) { ?>
      <h3>Further explanation </h3>
      <?php print $further_explanation; ?>
      <?php }?>


      <?php if ($related_tips) { ?>
      <h3>Related tips </h3>
      <?php print $related_tips; ?>
      <?php }?>


      <?php if ($changes) { ?>
      <h3>Changes from previous versions </h3>
      <?php print $changes; ?>
      <?php }?>


      <?php if ($team) { ?>
      <h3>Team members </h3>
      <?php print $team; ?>
      <?php }?>


      <?php if ($exemplary) { ?>
      <h3>Exemplary performance </h3>
      <?php print $exemplary; ?>
      <?php }?>

</div>
    <?php
    $viewname = 'leed_credits';
    $args = array();
    $args [0] = $fields['nid']->content;
    $display_id = 'page_7'; // or any other display
    $view = views_get_view ($viewname);
    $view->set_display ($display_id);
    $view->set_arguments ($args);
    print $view->preview ();
    ?>
  </div>


  <div id="sideCol">
    <?php global $user;?>
    <?php if ($user->uid): ?>
    <?php if(is_array($user->roles) && (in_array('admin', $user->roles) || in_array('content admin', $user->roles))):?>
    <div class="emphasized-box">
      <div class="container">
        <h5>Credit family</h5>

        <div style="font-size:10px">
          <?php
          $parents = $current_node->field_credit_parent;
          $children = $current_node->field_credit_options;

          if (!$parents[0]['nid'] && !$children[0]['nid']) {
            print "No family associated with this credit.";
          }

          if ($parents[0]['nid']) {
            print "<strong>Parents</strong><br/>";
            foreach ($parents as $parent) {
              print content_format ('field_credit_parent', $parent);
              print "<br/>";
            }
          }

          if ($children[0]['nid']) {
            print "<br/><strong>Children</strong><br/>";
            foreach ($children as $child) {
              print content_format ('field_credit_options', $child);
              $child_node = node_load ($child['nid']);
              $rating_system = content_format ('field_credit_rating_system', $child_node->field_credit_rating_system[0]);
              if ($rating_system) {
                print " ($rating_system)";
              }

              print "<br/>";
            }
          }
          ?>
        </div>
      </div>
    </div>
    <?php endif;?>
    <?php endif;?>
   <div id="-involved-box" class="emphasized-box">
		<div class="container">
			<h5>Join LEEDuser</h5>
	        <p>Ask questions, share tips, and get notified of new forum posts by joining LEEDuser, a tool developed by BuildingGreen and supported by USGBC!</p>
	     	<div class="">
				<a href="https://www.leeduser.com/user/register-USGBC" target="_blank" class="button">Create free account</a>
			</div>
		</div>
	</div>
	  <div class="sbx">
      <?php
      $viewname = 'servicelinks';
      $args = array();
      $args[0] = $current_node->nid;
      $display_id = 'page_1'; // or any other display
      $view = views_get_view ($viewname);
      $view->set_display ($display_id);
      $view->set_arguments ($args);
      print $view->preview ();
      ?>
    </div>

	<?php 
		$tid_rsystem 	= $current_node->field_credit_rating_system[0]['value'];
		$tid_rversion	= $current_node->field_credit_rating_sys_version[0]['value'];
		$shortid 		= $current_node->field_credit_short_id[0]['value'];
		
	//	if($tid_rversion != '1223') {  //exclude LEED v4 
		
			
			
	?>
	<div id="-involved-box" class="emphasized-box">
	
      <div class="container">
        <h5>Sample forms</h5>
	      	<?php
			if($tid_rversion == '81' || $tid_rversion == '1223'){
				
				$viewname = 'get_sample_forms';
				$args = array();
				$args [0] = $tid_rsystem;
				$args [1] = $tid_rversion;
				$args [2] = $shortid;
				$display_id = 'page_1'; // or any other display
				$view = views_get_view ($viewname);
				$view->set_display ($display_id);
				$view->set_arguments ($args);
				print $view->preview ();
				
	      	?>
			   <a href="/sampleforms" style="margin-top: 1.7em;" class="button">View all sample forms</a>
	      	<?php 
	      
	      	}else{
	      	?>
				<a href="/sampleforms/v2">View sample forms</a>
	      	<?php 
	      	}
	      
	     
	       
	      
	      ?>
      </div>
    </div>
	<?php //}?>

  </div>
</div>
