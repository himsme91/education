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
<li class="user">
  	<h4>
  		<span>
  			<a title="View profile" href="/user/<?php print $fields['uid']->content?>" class="view-profile-link"><?php print $fields['field_per_fname_value']->content?>  <?php print $fields['field_per_lname_value']->content?></a>
  		</span>
  		    <a href="" class="delete-user">Remove employee</a>  	
  	</h4>
  	<div>
  		<ul class="inputlist">
  			<li>
  			 <?php $checkeditid = "checkedit".$fields['uid']->content; ?>
  		    	<label>
    		    	<span>
    		           <div class="checker" id="uniform-undefined">
    		           		<span class="">
    		           			<input id=<?php print $checkedit;?> type="checkbox" value="<?php print $fields['uid']->content;?>" name="checkeditprofile" checked="" class="checkbox">
    		           				</span></div><span>This person can edit the profile</span></span>
    		    </label>
  			</li>
  			<li>
  			  <?php $checkempid = "checkemp".$fields['uid']->content; ?>
                      <label>
    		           		<span>
    		           		<div class="checker" id="uniform-undefined">
    		           			<span class="">
    		           				<input id=<?php print $checkempid;?> type="checkbox" value="<?php print $fields['uid']->content;?>" name="checkemployees" checked="" class="checkbox">
    		           			</span>
    		           		</div><span>This person can manage employees</span></span>
    		           </label>
    		   </li>
    		   <li>
                <label>
    		       <span><a><?php print $fields['mail']->content;?></a></span>
    		    </label>
    		   </li>
    		    </ul>
                 </div>
          
</li>