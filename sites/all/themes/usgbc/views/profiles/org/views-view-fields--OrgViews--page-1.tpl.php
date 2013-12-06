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
<?php 
/*print_r("<pre>");
print_r ($fields);
print_r("</pre>");*/
?>
<?php //dsm($fields);?>
<?php //if($fields['field_org_show_in_dir_value']->content == 'Yes'):?>
	<div class="ag-item ag-item-with-visual ag-item-no-footer block-link" title="<?php print $fields['title']->content;?>">
<?php //else:?>
<!-- <div class="ag-item ag-item-with-visual ag-item-no-footer" title="<?php print $fields['title']->content;?>"> -->	
<?php //endif;?>


  <?php

 if ($fields['field_state_name_value']->content):
  	$prov = explode('[',$fields['field_state_name_value']->content);
    $prov = str_replace(']','',$prov[1]);
   endif;
   
   if($prov == ''):
  	$prov = explode('[',$fields['field_country_name_value']->content);
    $prov = str_replace(']','',$prov[1]);
   endif;

  if ($fields['field_city_name_value']->content):
    $city = $fields['field_city_name_value']->content . ',';
  else:
    $city = $fields['field_city_name_value']->content;
  endif;
  
  if(strtolower($fields['type']->content) == 'subsidiary'){
	  $parentnid = $fields['field_sub_parent_nid_value']->content;
	  $parentnode = node_load($parentnid);   
	  $level = $parentnode->field_org_current_duescat[0]['value'];
  }else{
  	  $level = $fields['field_org_current_duescat_value']->raw; 
  }
  ?>
  <?php //print $imgSrc;?>
  <?php print $fields['field_org_profileimg_fid']->content; ?>
  <div class="ag-data">
  
  <?php // if($fields['field_org_show_in_dir_value']->content == 'Yes'):?>
   
    <span class="member-level right">
    <?php switch($level){		
 			  case TAXID_DUESCAT_SILVER: 
              ?>
               <img class="right" src="/sites/all/themes/usgbc/lib/img/mem-badges/silver-large.png" alt="">
               <?php if(strtolower($fields['type']->content) == 'subsidiary'){
               	?>
               
                <span>Subsidiary of <?php print $parentnode->title;?></span>
                <?php }else{?>
                  <span>Member at Silver level</span>
                <?php }?>
              <?php break;
                case TAXID_DUESCAT_GOLD: 
              ?>
               <img class="right" src="/sites/all/themes/usgbc/lib/img/mem-badges/gold-large.png" alt="">
               <?php if(strtolower($fields['type']->content) == 'subsidiary'){
               	?>
               
                <span>Subsidiary of <?php print $parentnode->title;?></span>
                <?php }else{?>
                <span>Member at Gold level</span>
                <?php }?>
               <?php break;
               case TAXID_DUESCAT_PLATINUM: 
              ?>
               <img class="right" src="/sites/all/themes/usgbc/lib/img/mem-badges/platinum-large.png" alt="">
                 <?php if(strtolower($fields['type']->content) == 'subsidiary'){
               	?>
               
                <span>Subsidiary of <?php print $parentnode->title;?></span>
                <?php }else{?>
                <span>Member at Platinum level</span>
                <?php }?>
               <?php break;?>      
         <?php }?>
          </span>
          <h3 class="ag-item-title">
      <a class="block-link-src" href="<?php print $fields['path']->content;?>"><?php print $fields['title']->content;?></a>
    </h3>
		<span class="ag-item-detail">
		<?php //print $fields['type']->content;?>
      <strong><?php print $city;?> <?php print strtoupper($prov);?></strong>
		</span>
  </div>
  <div class="ag-item-footer empty"></div>
</div>
