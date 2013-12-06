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
if(arg(0) === 'credits'){
	unset($_SESSION['pilot-credit']);
}
$path = isset($_GET['q']) ? $_GET['q'] : '<front>';
$link = url($path, array('absolute' => FALSE));
$shortid = $fields['field_credit_short_id_value']->content;
$catid  = substr($shortid,0,2);
$catid = strtolower($catid);
if($catid == 'lt') $catid = 'll';
if($catid == 'sl') $catid = 'll';
if($catid == 'gi') $catid = 'gib';
if($catid == 'in') $catid = 'id';

$alt_image_path = "/sites/default/files/$catid-blank.png";
if($catid == 'ip'){
	$alt_image_path = "/sites/default/files/ipc.png";
}

$current_node = node_load($fields['nid']->content);
$current_nid  = $current_node->nid;
$parent_field = $fields['field_credit_parent_nid']->handler->field_values[$current_nid];
$parent_id = $parent_field[0]['nid'];
$parent = node_load($parent_id);

$parent_nid = $current_node->field_credit_parent[0]['nid'];
if($parent_nid){
	$parent_node = node_load($parent_nid);
	$parent_image = $parent_node->field_credit_icon[0]['filepath'];
}

if($parent_image)
	$credit_icon_path = $parent_image;
if($current_node->field_credit_icon[0]['filepath'])
	$credit_icon_path = $current_node->field_credit_icon[0]['filepath'];
?>

<style>
.member-perk{
float:right;
padding: 3px;
background: #9BCD60;
color: white;
font-size: 9px;
text-transform: uppercase;
font-weight: bold;
margin-top: 5px;
text-align: center;
-moz-border-radius: 2px;
border-radius: 2px;
}
</style>
<li>
                      
	<div class="views-field-field-category-logo-fid">
		<?php if($credit_icon_path){?>
	    	<img width="40" height="40" alt="" src="<?php print file_create_url($credit_icon_path);?>" class="left">	
		<?php } else {?>
	    	<img width="40" height="40" alt="" src="<?php print $alt_image_path;?>" class="left">				
		<?php }?>
	</div>
<!--	      	                        
	<dl class="count Strategies">
		<dt>Strategies</dt>
		<dd><a href="<?php print $fields['path']->content;?>?view=strategies"><?php print $fields['field_credit_strategy_count_value']->content;?></a></dd>
	</dl>
	<dl class="count rulings">
		<dt>Addenda</dt>
		<dd><a href="<?php print $fields['path']->content;?>?view=addenda"><?php print $fields['field_credit_addenda_count_value']->content;?></a></dd>
	</dl>

	<dl class="count projects">
	    <dt>Projects</dt>
		<dd><?php print $fields['field_credit_project_count_value']->content;?></dd>
	</dl>
-->     
<?php if($fields['field_open_for_comments_value']->content == 'Open for Comments'){?>
	<div class="member-perk">Open for comments</div>
<?php }?>
                  
	<h2>

		<?php 
			$node_title = $fields['title']->content;
			print "<a href='/node/$current_nid?return=$link'>$node_title</a>" ?>
	</h2>
	
	<?php $points = '';
	$low = $fields['field_credit_points_possible_low_value']->content;
	$upp = $fields['field_credit_points_possible_upp_value']->content;
	if($fields['field_credit_required_flag_value']->content == "Required"){
		$points = "Required";
	}else if ($low == $upp){
		if (intval($low) > 1){
			$points = $low.' points';
		}else{
			$points = $low.' point';
		}
	}else{
		if (intval($upp) > 1){
			$points = 'Up to '.$upp.' points';
		}else{
			$points = 'Up to '.$upp.' point';
		}
		
	}
	
	?>
	<?php if ($_SESSION['pilot-credit'] == 'pilot-credits'):
		$ratings = array();
			foreach($current_node->field_credit_rating_system as $rat)
					{
						if(!in_array($rat['value'],$ratings))
								{
									array_push($ratings, $rat['value']);
									$term = taxonomy_get_term($rat['value']);
									if($term->name != "")
										{
										$ratDescription = ($term->description != '') ? $term->description : $term->name;	
										if($ratsys == ''):
										$ratsys = '<small>'.$ratDescription;
										else:
										$ratsys .= ', '.$ratDescription;
										endif;
										}
								}
							}
		?>
		<p class="credit-id"><?php print $ratsys;?></p>
	<?php endif;?>
	<?php //Hide Credit Short Id for v4 version tid=1223 ?>
	<?php if($current_node->field_credit_rating_sys_version[0]['value'] == '1223'):?> 
		<p class="credit-id"><?php echo $points;?></p>
	<?php else:?>
		<p class="credit-id"><?php print $fields['field_credit_short_id_value']->content;?> | <?php echo $points;?></p>
	<?php endif;?>
	
</li>