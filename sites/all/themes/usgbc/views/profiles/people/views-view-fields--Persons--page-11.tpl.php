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
?>
<?php //print_r($fields) ?>
<?php //dsm($fields);?>
<?php
$type = "chapter";
$getchp = db_result(db_query("SELECT n.title FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s')", $fields['uid']->content, 1, $type));
$otype = "organization";
$getorg = db_result(db_query("SELECT n.title FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s')", $fields['uid']->content, 1, $otype));

$account = user_load(array('uid' =>$fields['uid']->content));
//dsm($account); 
 
?>

<?php if($fields['field_per_electioncandidate_value']->raw == 1){
	$electioncandidate = 'candidate';
}else{
	$electioncandidate = '';
}?>
<div class="ag-item ag-item-with-visual ag-item-no-footer block-link <?php print $electioncandidate;?>"
	title="<?php print trim($fields['field_per_fname_value']->content);?>&nbsp;<?php print trim($fields['field_per_lname_value']->content);?>">

	<?php print $fields['field_per_profileimg_fid']->content;?>
	<div class="ag-data left">
		<ul class="ag-item-credentials">
			<?php

			$args = array();
			$viewname = 'PersonActivity';
			$args [0] = $fields['uid']->content;
			$display_id = 'page_1'; // or any other display
			$view = views_get_view($viewname);
			$view->set_display($display_id);
			$view->set_arguments($args);
			$view->get_total_rows = TRUE;
			$view->execute();
			// results are now stored as an array in $view->result
			$count =  count($view->result);
			?>
			<?php if($count > 0) {?>
			<li class="documents hoverTip"><span> <span><?php print $count;?> </span>
			</span>
				<div class="tip">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					has made
					<?php print $count;?>
					<?php echo ($count == 1) ? ' contribution' : ' contributions'?>
				</div>
			</li>
			<?php }?>
			<?php $associations = $fields['field_per_associations_value']->content;
			
			?>
			<?php $pos = strpos($associations, 'friends');?>
			<?php if($pos !== false)
			{?>
			<li class='usgbc hoverTip'>USGBC
				<div class="tip" style="display: none;">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					is a friend of USGBC
				</div>
			</li>
			<?php }?>

			<?php $creds = $fields['field_per_leedcred_value']->content; 
				$pos1 = strpos($creds, 'LEED Fellow');
				if($pos1!== false) { 
					$creds = str_replace('LEED Fellow','',$creds);	?>
			<li class="cert-lf hoverTip">certification
				<div class="tip">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					is a LEED Fellow
				</div>
			</li>
			<?php }
				$pos2 = strpos($creds, 'LEED AP Homes');
				if($pos2!== false) { 
					$creds = str_replace('LEED AP Homes','',$creds); ?>
			<li class="cert-ap-homes hoverTip">certification
				<div class="tip">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					is a LEED Accredited Professional with Homes speciality (LEED AP
					Homes)
				</div>
			</li>
			<?php }
				$pos3 = strpos($creds, 'LEED AP ID+C');
				if($pos3!== false) { 
					$creds = str_replace('LEED AP ID+C','',$creds); ?>
			<li class="cert-ap-idc hoverTip">certification
				<div class="tip">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					is a LEED Accredited Professional with Interior Design &amp;
					Construction specialty (LEED AP ID&amp;C)
				</div>
			</li>
			<?php }
				$pos4 = strpos($creds, 'LEED AP ND');
				if($pos4!== false) { 
					$creds = str_replace('LEED AP ND','',$creds); ?>
			<li class="cert-ap-nd hoverTip">certification
				<div class="tip">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					is a LEED Accredited Professional with Neighborhood Development
					specialty (LEED AP ND)
				</div>
			</li>
			<?php }
				$pos5 = strpos($creds, 'LEED AP O+M');
				if($pos5!== false) { 
					$creds = str_replace('LEED AP O+M','',$creds); ?>
			<li class="cert-ap-om hoverTip">certification
				<div class="tip">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					is a LEED Accredited Professional with Operations &amp; Maintenance
					specialty (LEED AP O&amp;M)
				</div>
			</li>
			<?php }
				$pos6 = strpos($creds, 'LEED Green Associate');
				if($pos6!== false) { 
					$creds = str_replace('LEED Green Associate','',$creds); ?>
			<li class="cert-ga hoverTip">certification
				<div class="tip">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					is a LEED Green Associate
				</div>
			</li>
			<?php }
				$pos7 = strpos($creds, 'LEED AP BD+C');
				if($pos7!== false) { 
					$creds = str_replace('LEED AP BD+C','',$creds); ?>
			<li class="cert-ap-bdc hoverTip">certification
				<div class="tip">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					is a LEED Accredited Professional with Building Design &amp; Construction
					specialty (LEED AP BD&amp;C)
				</div>
			</li>
			<?php }
				$pos8 = strpos($creds, 'LEED AP');
				if($pos8!== false) { 
					$creds = str_replace('LEED AP','',$creds); ?>
			<li class="cert-ap hoverTip">certification
				<div class="tip">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					is a LEED Accredited Professional without Specialty.
				</div>
			</li>
			<?php }?>

			<?php $new_rel = strpos($fields['field_relationship_value']->content, 'LEED Fellow');?>
			<?php if($new_rel!== false) { ?>
			<li class="cert-lf hoverTip">certification
				<div class="tip" style="display: none;">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					is a LEED Fellow as of
					<?php print $fields['field_from_date_value']->content;?>
				</div>
			</li>
			<?php }?>

			<?php $pos = strpos($associations, 'Chapter');?>
			<?php if($pos !== false)
			{?>
			<li class='usgbc hoverTip'>USGBC
				<div class="tip" style="display: none;">
					<?php print $fields['field_per_fname_value']->content;?>
					<?php print $fields['field_per_lname_value']->content;?>
					is a member of
					<?php print $getchp;?>
				</div>
			</li>
			<?php }?>
		</ul>

		<h3 class="ag-item-title">
			<a class="block-link-src"
				href="<?php print $fields['path']->content;?>"><?php print trim($fields['field_per_fname_value']->content);?> <?php print trim($fields['field_per_lname_value']->content);?> </a>
		</h3>

		<span class="ag-item-detail"> <strong><?php print $fields['field_per_job_title_value']->content;?>
		</strong>
		</span> <span class="ag-item-detail"> <?php if(!$getorg){
			$getorg = $fields['field_per_orgname_value']->content;
		}?> <?php print $getorg;?>
		</span>
		<?php 
		$prov = explode('[',$fields['field_state_name_value']->content);
		$prov = str_replace(']','',$prov[1]);
		$country = explode('[',$fields['field_country_name_value']->content);
		$country = str_replace(']','',$country[1]);
		?>
		<span class="ag-item-detail"><?php print $fields['field_city_name_value']->content;?>,
			<?php print strtoupper($prov);?> <?php if(!$prov){
				print strtoupper($country);
			}?> </span>

	</div>
	<div class="ag-item-footer" style="border: none;">
		<?php
		//print preg_replace('/<\/div><div[^>]+>/i', ', ', $fields['field_per_associations_value']->content);
		?>
	</div>
</div>