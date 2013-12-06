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
<style type="text/css">
#comments{
display:block;
width:720px;
}

</style>
<div class="twoColLeft" id="content">
            <div id="mainCol">
            <div id="comments">
		<div id="comment-feed">
			<h3><?php  $node = node_load(array("nid" => $fields['nid']->content));
						print $node->comment_count;?> Comments <a href="<?php print $node->links['comment_add']['href'].'#comment-form';?>" class="right">Leave a comment</a></h3>
		</div>
		<?php
         	$viewname = 'comments_in_a_view';
			$args = array();
			//$args[0]='Announcements';
			$args [0] = $fields['nid']->content; 
			$display_id = 'default'; // or any other display
  			$view = views_get_view($viewname);
  			$view->set_display($display_id);
  			$view->set_arguments($args);
  		//	print $view->preview();
		?>
		
		</div>
    	
            
            
	       </div>
            
            <div id="sideCol">
                <div id="-involved-box" class="emphasized-box">
          <div class="container">
              <h5>Get involved</h5>
              <p>Find out what other professionals in our online community are saying about this credit. Ask a question or share your expertise!</p>
              <div class="">
                  <a href="<?php print $fields['path']->content;?>?quicktabs_=sixth#quicktabs-" class="button">Join the discussion</a>
              </div>
          </div>
      </div>
       <div class="section">
                         <?php
         	$viewname = 'leed_credits';
			$args = array();
			$args [0] = $fields['nid']->content; 
			$display_id = 'page_6'; // or any other display
  			$view = views_get_view($viewname);
  			$view->set_display($display_id);
  			$view->set_arguments($args);
  			print $view->preview();
		?>
                    
                        </div>

                       </div>
        </div>
