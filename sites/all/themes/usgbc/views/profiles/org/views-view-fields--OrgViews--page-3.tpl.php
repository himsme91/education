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
   if ($fields['province']->content):
   $prov = $fields['province']->content;
   else:
   $prov = $fields['country']->content;
   endif;
  // print_r($prov);
     if ($fields['city']->content):
   $city = $fields['city']->content . ',';
   else:
   $city = $fields['city']->content;
   endif;
   $level = $fields['field_org_current_duescat_value']->raw;
?>

<li>
	<div>
    <?php print $fields['field_org_profileimg_fid']->content;?>
		<p>
		<?php switch($level){
			 case TAXID_DUESCAT_SILVER: 
              ?>
              <span class="membership-badge silver" style="font-family: 'helvetica neue', arial; ">
              <img src="/sites/all/themes/usgbc/lib/img/mem-badges/silver.gif" alt="Member at Silver level" style="font-family: 'helvetica neue', arial; ">
              </span>
          <?php break;
           case TAXID_DUESCAT_GOLD: 
              ?>
              <span class="membership-badge gold" style="font-family: 'helvetica neue', arial; ">
              <img src="/sites/all/themes/usgbc/lib/img/mem-badges/gold.gif" alt="Member at Gold level" style="font-family: 'helvetica neue', arial; ">
              </span>
          <?php break;
           case TAXID_DUESCAT_PLATINUM: 
              ?>
              <span class="membership-badge platinum" style="font-family: 'helvetica neue', arial; ">
              <img src="/sites/all/themes/usgbc/lib/img/mem-badges/platinum.gif" alt="Member at Platinum level" style="font-family: 'helvetica neue', arial; ">
              </span>
          <?php break;
		}?>   	                                      	
    	<?php print $fields['title']->content;?><br><?php print $city;?> <?php print $prov;?></p>
	</div>
</li>
