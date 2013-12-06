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
//dsm($fields);
?>

<?php 

switch ($fields['field_res_type_value']->content) {
    case "Books":
        $imgformat = "book";
        break;
    case "Studies":
        $imgformat = "study";
        break;
    case "Documents":
        $imgformat = "document";
        break;
	case "Reports":
		$imgformat = "document";
	    break;
    case "Presentations":
        $imgformat = "presentation";
        break; 
    case "Standards":
        $imgformat = "website";
        break; 
 	case "Websites":
        $imgformat = "website";
        break;  
 	case "Podcasts":
        $imgformat = "audio";
        break; 
 	case "Videos":
        $imgformat = "video";
        break;      
	    default:
			$imgformat = "document";
			break;   
}



?>
 

<div class="ag-item resource <?php echo $imgformat;?> block-link" >
      <div class="ag-data">                            
        <h2>
		<?php
			if(!$fields['field_all_custom_title_value']->content
			|| empty($fields['field_all_custom_title_value']->raw) 
			|| $fields['field_all_custom_title_value']->content==""){
				$fields['field_all_custom_title_value']->content = $fields['title']->content;
			}
		?>
			 <?php if($fields['nid']->content == '1732462' || $fields['nid']->content == '2632663' || $fields['nid']->content == '4386317'):?>
			 	<?php print str_replace('LEED','LEED<sup>&reg;</sup> ',$fields['field_all_custom_title_value']->content);?>
			 <?php else:?>
			 	<?php print $fields['field_all_custom_title_value']->content;?>
			 <?php endif;?>

                            
                            
                            
                            <?php 
  if(($fields['field_res_type_value']->content) == "Book")
 {
 	if(!empty($fields['field_res_type_value']->content))
 	{
 		$filesize = " | " . $fields['field_res_pages_value']->content . " pgs";
 	}
 }
  elseif($fields['field_res_type_value']->content != "Website" || $fields['field_res_type_value']->content != "Video" )
 {
 	
 if (!empty($fields['field_res_file_fid']->content))
 {
 	//dsm($fields['field_res_file_fid']->content);
 	//$filesize = " | " . filesize($fields['field_res_file_fid']->content);

 }
 }
 ?>
  
   <?php 
 $prefix = '';
 if (!empty($fields['field_res_id_value']->content)){
 	$prefix =  $fields['field_res_id_value']->content . " | " ;
 }elseif (!empty($fields['field_res_edition_value']->content)){
 	$prefix =  $fields['field_res_edition_value']->content . " | " ;
 }
  ?>                          
                            
                            
                            
                             <small><?php print $prefix; ?><?php print $fields['field_res_type_value']->content;?><?php echo $filesize;?></small></h2>
                        </div>

                        <?php if($fields['sell_price']->content):?>
						<p class="price"><?php print uc_currency_format($fields['sell_price']->content);?></p>
						<?php endif;?>
                 
                        <p><?php print $fields['field_all_description_short_value']->content;?></p>
                        <?php if (($fields['field_res_memberonly_value']->raw) == "1" ) :?> 
						<p><span class="member-only">Members Only</span> </p>
						<?php endif?>  
                    
                    </div>