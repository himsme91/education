<?php
  // $Id: views-view-table.tpl.php,v 1.8 2009/01/28 00:43:43 merlinofchaos Exp $
  /**
   * @file views-view-table.tpl.php
   * Template to display a view as a table.
   *
   * - $title : The title of this group of rows.  May be empty.
   * - $header: An array of header labels keyed by field id.
   * - $fields: An array of CSS IDs to use for each field id.
   * - $class: A class or classes to apply to the table, based on settings.
   * - $row_classes: An array of classes to apply to each row, indexed by row
   *   number. This matches the index in $rows.
   * - $rows: An array of row items. Each row is an array of content.
   *   $rows are keyed by row number, fields within rows are keyed by field ID.
   * @ingroup views_templates
   */
?>
<?php 
$path = isset($_GET['q']) ? $_GET['q'] : '<front>';
$link = url($path, array('absolute' => FALSE));
?>
<pre><?php //dsm($rows);?></pre>
<div id="mainCol">
<ul class="course-list">
  <?php foreach ($rows as $count => $row): ?>
  <li class="block-link" style="cursor: pointer;" title="<?php print $row['title']; ?>">
                		<div class="info-primary">
		                	<p class="course-id">ID #<?php print $row['field_wrksp_id_value'];?> Level <?php print $row['field_crs_level_value'];?></p>
		                	
		                	<h3><a href="<?php print $row['path'];?>?workshop_nid=<?php print $row['nid'];?>&return=<?php print $link;?>" class="block-link-src"><?php print $row['title']; ?></a></h3>
		                	
		                	<?php if($row['field_crs_pvd_nid']){?>
		                	<p class="course-provider">Provided by <?php print $row['field_crs_pvd_nid'];?></p>
		                	<?php }?>
                		</div>
                		<div class="info-secondary">
		                	<p class="course-type"><?php print $row['field_crs_fmt_value'];?></p>
		                	<div class="course-specialties">
			                	<?php print $row['field_crs_leed_value'];?>
		                	</div>
                		</div>
	                	
	                	<div class="info-poi">
	                		<span class="course-price"><?php print $row['list_price'];?></span>
	                		<?php if($row['field_crs_leed_ap_hours_value'] > 0) {?>
	                		<span class="course-ce"><?php print $row['field_crs_leed_ap_hours_value'];?> CE hrs</span>
	                		<?php }?>
	                	</div>
	                	
	                	<div class="info-tertiary">
	                	<?php
	                		if($row['country'] && $row['field_wrksp_startdate_value']){?>
	                		<p class="course-time"><?php print date('l F j, Y',strtotime($row['field_wrksp_startdate_value']));?></p>
	                		<?php }else {
	                				if($row['field_crs_fmt_value'] == 'On demand'){
	                					$format = 'On demand - always available!';
	                				}else {
	                					$format = $row['field_crs_fmt_value'];
	                				}
	                			?>
	                			 <p class="course-time"><?php print $format;?></p>
	                	<?php 	}?>
					         <p class="course-location"> <?php
				            if (strlen($row['city'])>0){
				                print $row['city'];
				            }
				            if(strlen($row['province'])>0)
				            {
				             	print ', '. $row['province'];
				            }
				            if(strlen($row['country'])>0 && $row['country']!='US')            
				            {     
				            	print ', '. $row['country'];
				            }?> 
	                	</div>
   </li>
    <?php endforeach; ?>
</ul>
</div>