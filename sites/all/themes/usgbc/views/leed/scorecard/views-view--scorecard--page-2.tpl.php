<?php
global $user;
$project_id = str_pad ($view->args[0], 10, '0', STR_PAD_LEFT);

$query = "SELECT a.RELTYP,b.* FROM extracts.BUT051 a left outer join drupal.content_type_person b
on a.partner1 = b.field_per_id_value where partner2 = $project_id and (RELTYP = 'ZRPO04' OR RELTYP = 'ZRPO03' OR RELTYP = 'ZRPO34');"; 

$result = db_query($query);
?>
<div id="article-list-view">
	<div class="view-content"> 
		<div id="mainCol">
			<div class="ag-body">  
			<?php while ($row = db_fetch_array($result)){ 
				if($row['RELTYP'] == 'ZRPO03') $project_role = 'Project administrator';
				if($row['RELTYP'] == 'ZRPO04') $project_role = 'Team member';
				if($row['RELTYP'] == 'ZRPO34') $project_role = 'Project team manager';
				$person_node = node_load($row['nid']);
				if($person_node->field_per_profileimg[0]['fid']){
					$filename = $person_node->field_per_profileimg[0]['filename'];
					$imgsrc = "/sites/default/files/imagecache/fixed_060-060/".$filename;					
				} else {
					$imgsrc = "/sites/default/files/imagecache/fixed_060-060/imagefield_default_images/person_placeholder.png";
				}
				
			  	?>
      			<div title="<?php print $row['field_per_fname_value'].' '.$row['field_per_lname_value'];?>" class="ag-item ag-item-with-visual block-link" style="cursor: pointer;">
  					<img width="60" border="0" height="60" src="<?php print $imgsrc;?>" class="ag-item-visual">
  					<div class="ag-data left">
    					<ul class="ag-item-credentials"></ul>
    					<h3 class="ag-item-title">
      						<a href="/node/<?php print $row['nid'];?>" class="block-link-src"><?php print $row['field_per_fname_value'].' '.$row['field_per_lname_value'];?></a>
    					</h3>
						<span class="ag-item-detail">
							<strong><?php print $row['field_per_job_title_value'];?></strong>
						</span>
						<span class="ag-item-detail">
							<strong><?php print $project_role;?></strong>
						</span>
    					<span class="ag-item-detail"><?php print $row['field_per_orgname_value'];?></span>
  					</div>
  					<div style="border:none;" class="ag-item-footer">  </div>
				</div>
			<?php }?>
			</div>
		</div>
	</div>
</div>