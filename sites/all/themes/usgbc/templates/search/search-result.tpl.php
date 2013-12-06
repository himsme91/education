<?php
//echo '<pre>';print_r($result); echo '</pre>';

$search_node = $result['node'];
$node = node_load($search_node->nid);
//global $user;
//$admin = FALSE;
//foreach($user->roles as $role){
//	if($role == 'Admin without conditional') $admin = TRUE;
//}
//if ($admin) echo '<pre>';print_r($node); echo '</pre>';
if($search_node->nid){

$panel_query = 'SELECT max(c.path) FROM drupal.panels_pane a 

					left outer join page_manager_handlers b on b.conf like CONCAT(\'%"did"%"\' , a.did , \'"%\') 					
					left outer join page_manager_pages c on b.subtask = c.name 
					where configuration like \'%'.$search_node->nid.'%\'';
//					left outer join page_manager_handlers b on b.conf like CONCAT(\'%"did";s:2:"\' , a.did , \'"%\') 						
$path = db_result(db_query($panel_query));

}
if($path){
	$server_url = USGBCHOST;
	$url = $server_url . '/' . $path;
	$title = ucwords($path);
} else {
	if(inStr($search_node->type,'content_')){
		$url = null;
	}
}
/**
 * @file search-result.tpl.php
 * Default theme implementation for displaying a single search result.
 *
 * This template renders a single search result and is collected into
 * search-results.tpl.php. This and the parent template are
 * dependent to one another sharing the markup for definition lists.
 *
 * Available variables:
 * - $url: URL of the result.
 * - $title: Title of the result.
 * - $snippet: A small preview of the result. Does not apply to user searches.
 * - $info: String of all the meta information ready for print. Does not apply
 *   to user searches.
 * - $info_split: Contains same data as $info, split into a keyed array.
 * - $type: The type of search, e.g., "node" or "user".
 *
 * Default keys within $info_split:
 * - $info_split['type']: Node type.
 * - $info_split['user']: Author of the node linked to users profile. Depends
 *   on permission.
 * - $info_split['date']: Last update of the node. Short formatted.
 * - $info_split['comment']: Number of comments output as "% comments", %
 *   being the count. Depends on comment.module.
 * - $info_split['upload']: Number of attachments output as "% attachments", %
 *   being the count. Depends on upload.module.
 *
 * Since $info_split is keyed, a direct print of the item is possible.
 * This array does not apply to user searches so it is recommended to check
 * for their existance before printing. The default keys of 'type', 'user' and
 * 'date' always exist for node searches. Modules may provide other data.
 *
 *   <?php if (isset($info_split['comment'])) : ?>
 *     <span class="info-comment">
 *       <?php print $info_split['comment']; ?>
 *     </span>
 *   <?php endif; ?>
 *
 * To check for all available data within $info_split, use the code below.
 *
 *   <?php print '<pre>'. check_plain(print_r($info_split, 1)) .'</pre>'; ?>
 *
 * @see template_preprocess_search_result()
 */
//dsm($node);
?>
<!-- 
<dt class="title">
  <a href="<?php print $url; ?>"><?php print $title; ?></a>
</dt>
<dd>
  <?php if ($snippet) : ?>
    <p class="search-snippet"><?php print $snippet; ?></p>
  <?php endif; ?>
  <?php if ($info) : ?>
  <p class="search-info"><?php print $info; ?></p>
  <?php endif; ?>
</dd>
 -->

 <?php $img_path = '';
 
 if($info_split['type'] == 'Credit Definition'){
 	 $cat = '<span class="tag">LEED Credits</span>';
 	 $parent_nid = $node->field_credit_parent[0]['nid'];
	  if ($parent_nid) {
	    $parent_node = node_load ($parent_nid);
	    $parent_image = $parent_node->field_credit_icon[0]['filepath'];
	  }
	
	  if ($parent_image)
	    $img_path = $parent_image;

	  if ($node->field_credit_icon[0]['filepath'])
	    $img_path = $node->field_credit_icon[0]['filepath'];

 }
 	elseif($info_split['type'] == 'Apps'){
 		 $cat = '<span class="tag">App Lab</span>';
 	 	 if ($node->field_app_image[0]['filepath'] != '') {
		    $img_path = $node->field_app_image[0]['filepath'];
		 }
 }
 elseif($info_split['type'] == 'Article'){
 		 $cat = '<span class="tag">Article</span>';
 }
 elseif($info_split['type'] == 'Chapter'){
 		 $cat = '<span class="tag">Profiles</span>';
  	 	 $img_path = '/sites/default/files/logos/gray/usgbc-chapter-logo.png';
 }
 elseif($info_split['type'] == 'Course'){
 		 $cat = '<span class="tag">Course Catalog</span>';
 }
 elseif($info_split['type'] == 'Organization'){
 		 $cat = '<span class="tag">Profiles</span>';
 		 $shownameinlisting = taxonomy_get_term ($search_node->field_org_show_name_in_dir);
  	 	 if ($node->field_org_profileimg[0]['filepath'] == '') {
		 	$img_path = '/sites/all/assets/section/placeholder/company_placeholder.png';
		 } else {
		    $img_path = $node->field_org_profileimg[0]['filepath'];
		 }
 }
 elseif($info_split['type'] == 'Person'){
 		 $cat = '<span class="tag">Profiles</span>';
 		 $shownameinlisting = taxonomy_get_term ($search_node->field_per_show_name_in_dir);
  	 	 if ($node->field_per_profileimg[0]['filepath'] == '') {
		 	$img_path = '/sites/all/assets/section/placeholder/person_placeholder.png';
		 } else {
		    $img_path = $node->field_per_profileimg[0]['filepath'];
		 }
 }
 elseif($info_split['type'] == 'Project'){
 		 $cat = '<span class="tag">Project Profiles</span>';
  		 if ($node->field_prjt_profile_image[0]['filepath'] == '') {
		 	$img_path = '/sites/all/assets/section/placeholder/project_placeholder.png';
		 } else {
		    $img_path = $node->field_prjt_profile_image[0]['filepath'];
		 }
 }
 elseif($info_split['type'] == 'Publication'){
 		 $cat = '<span class="tag">Store</span>';
 }
  elseif($info_split['type'] == 'Resources'){
 		 $cat = '<span class="tag">Resource</span>';
   	 	 if ($node->field_res_profileimage[0]['filepath'] == '') {
		 	$img_path = '/sites/all/themes/usgbc/lib/img/resource-icons/placeholder-document.gif';
		 } else {
		    $img_path = $node->field_res_profileimage[0]['filepath'];
		 }
 }
 
?>
<?php
	$attributes = array(
		'class'=> 'left avatar',
		'id'   => 'img-search'
	);
				
	$img = theme ('imagecache', 'fixed_060-060', $img_path, $alt, $title, $attributes);
	$img = str_replace('%252F', '', $img);
?>

<?php if($node->type == 'leed_interpretation'):?>
<div class="result search-result block-link" style="cursor: pointer;">
	<h4><a class="block-link-src"  href="/leed-interpretations?clearsmartf=true&keys=<?php print $node->field_li_id[0]['value']; ?>"><span class="mark"><?php print $title; ?></span></a></h4>
	<p class="url"></p>
	<span class="result-type"><?php print '<span class="tag">Addenda and Interpretation</span>'; ?></span>
	<p class="excerpt"><?php print $snippet; ?></p>
</div>
<?php else:?>
<?php if($info_split['type'] == 'Resources' || $info_split['type'] == 'Publication' || $info_split['type'] == 'Project' || $info_split['type'] == 'Person' || $info_split['type'] == 'Organization' || $info_split['type'] == 'Course' || $info_split['type'] == 'Chapter' || $info_split['type'] == 'Article' || $info_split['type'] == 'Apps' || $info_split['type'] == 'Credit Definition'):?>
<div class="result result-extended result-organization block-link" style="cursor: pointer;" title="<?php print $title; ?>">
                    	<?php if($img_path != ''):?>
							<?php print $img; ?>
						<?php endif;?>
                        <h4><a class="block-link-src" href="<?php print $url; ?>"><?php print $title; ?></a></h4>
                        <p class="url"><?php print $url; ?></p>
                        <span class="result-type"><?php print $cat; ?></span>
                        <p class="excerpt"><?php print $snippet; ?></p>
                    </div>
<?php else:?>
<div class="result result-basic result-site-content block-link" style="cursor: pointer;" title="">
                    	<h4><a class="block-link-src" href="<?php print $url; ?>"><?php print $title; ?></a></h4>
                    	<p class="url"><?php print $url; ?></p>
                    	<span class="result-type">Site content</span>
                    	<p class="excerpt"><?php print $snippet; ?></p>
                    </div>
<?php endif;?>
<!-- 
<div class="search-result">
	<?php if($img_path != ''):?>
		<?php print $img; ?>
	<?php endif;?>
	<h4><a href="<?php print $url; ?>"><span class="mark"><?php print $title; ?></span></a></h4>
	<a class="lightweight small" href="<?php print $url; ?>"><?php print $cat; ?> <?php print $url; ?></a>
	<p><?php print $snippet; ?></p>
</div>  -->
<?php endif;?>	