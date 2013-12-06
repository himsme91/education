<?php
global $user;

$AE=92;$EA=91;$IE=90;$ID=89;$LL=88;$MR=87;$SS=85;$WE=86;$SL=88;$GI=1212;$NP=1211;

$project_id = str_pad ($view->args[0], 10, '0', STR_PAD_LEFT);


$system = db_result(db_query("select distinct map_rating_system from insight.project_credits_clib where project_id = '%s' ", $project_id ));
$system_v = db_result(db_query("select distinct map_version from insight.project_credits_clib where project_id = '%s' ", $project_id ));

$query = "SELECT cl.credit_nid AS credit_nid, cl.credit_short_id AS clib_shortid, cl.credit_name AS name, 
SUM(pc.points_awarded) AS points_awarded, MAX(cl.points_possible) AS points_possible, 
MAX(pc.rpc_awarded) AS rpc_awarded,  MAX(pc.flag_rpc) AS flag_rpc 
 FROM 
(select distinct credit_nid, credit_short_id,credit_rating_system, credit_version, 
	points_possible,credit_name,credit_required from insight.credit_library where 
	credit_rating_system =".$system."  AND credit_version = ".$system_v."
	AND (credit_pilot_flag <> 1 OR credit_pilot_flag IS NULL)) cl
	LEFT OUTER JOIN (SELECT distinct * FROM insight.project_credits_clib  WHERE project_id = '".$project_id."') pc
		ON cl.credit_short_id = pc.credit_id
WHERE cl.credit_rating_system = ". $system ." AND cl.credit_version =". $system_v ."

AND cl.credit_required <> 'Required'
GROUP BY  cl.credit_short_id, pc.credit_nid, pc.name
ORDER BY cl.credit_required DESC , 	cl.credit_short_id	 ";

$result = db_query($query);

$rows_categories = array();
$total_possible = 0;
$total_awarded 	= 0;
$total_rows = $result->num_rows; 

while ($row = db_fetch_array($result)){

	$shortid  = $row['clib_shortid'];
	$name     = $row['name'];
	if(strlen($name) > 70)
	     $name = substr($name,0,70) . "...";	
	$nodeid   = $row['credit_nid'];
	$possible = floatval($row['points_possible']);
	$awarded  = floatval($row['points_awarded']);
	$rpc      = $row['flag_rpc'];
	$rpc_awarded = $row['rpc_awarded']=='X';
	
	//Credit Category Mapping
	$category         = substr($row['clib_shortid'],0,2);
	if($category == "IE" || $category == "EQ") $credit_category = $IE;
	else if($category == "EA") $credit_category = $EA;
	else if($category == "AE") $credit_category = $AE;
	else if($category == "LL") $credit_category = $LL;
	else if($category == "MR") $credit_category = $MR;
	else if($category == "WE") $credit_category = $WE;
	else if($category == "MR") $credit_category = $MR;
	else if($category == "SS") $credit_category = $SS;
	else if($category == "GI") $credit_category = $GI;
	else if($category == "NP") $credit_category = $NP;
	else if($category == "SL") $credit_category = $SL;	
	
	else if($category == "ID" || $category == "IO") $credit_category = $ID;	
	
	$catname  = taxonomy_get_term($credit_category);
	$catname  = $catname->name;
	
	$shortcat = strtolower(substr($shortid,0,2));
	$shortcat2 = strtolower(substr($shortid,0,3));	
	if($shortcat == 'ie') $shortcat = 'iq';
	if($shortcat == 'eq') $shortcat = 'iq';
	if($shortcat == 'io') $shortcat = "id";
	if(!$shortcat2 == 'int') if($shortcat == 'in') $shortcat = 'id';	
	
	if($shortcat != 'pc' && $shortcat != 'mp' && $shortcat != 'rp' && strtolower($catname) != 'innovation catalog' && $shortcat2 != 'int'){
		$categories[$shortcat]['id']                            = $shortcat;
		$categories[$shortcat]['name']                          = $catname;
		$categories[$shortcat]['credits'][$shortid]['shortid']  = $shortid;
		$categories[$shortcat]['credits'][$shortid]['nid']  	= $nodeid;
		$categories[$shortcat]['credits'][$shortid]['name']     = $name;
		$categories[$shortcat]['credits'][$shortid]['possible'] = $possible;

		$categories[$shortcat]['credits'][$shortid]['awarded']  = $awarded;
		
		$categories[$shortcat]['possible'] = floatval($categories[$shortcat]['possible']) + $possible;
		$categories[$shortcat]['awarded'] = floatval($categories[$shortcat]['awarded']) + $awarded;
		
		$total_possible = $total_possible + $possible;
		$total_awarded  = $total_awarded + $awarded;
		
		if($rpc == 'X'){
			$credit = $categories[$shortcat]['credits'][$shortid];
			if($credit['awarded'] && $rpc_awarded){
				// deduct points
				$credit['awarded'] = floatval($credit['awarded']) - 1;
			
				$categories[$shortcat]['awarded'] = floatval($categories[$shortcat]['awarded']) - 1;
				$categories[$shortcat]['credits'][$shortid] = $credit;
			
				// deduct points
				//$credit['awarded'] = floatval($credit['awarded']) - 1;
			}
		}
		if($rpc == 'X' && $rpc_awarded){

			
			// add a 'rp' category
			if($categories['rp']==null){
				$categories['rp']            = array();
				$categories['rp']['credits'] = array();
				$categories['rp']['credits'][$credit['shortid']]            = array();
				$categories['rp']['awarded'] = 0;
				$categories['rp']['name']    = 'Regional priority credits';
				$categories['rp']['possible'] = 4;
				$total_possible += 4;
			}
			

			$categories['rp']['credits'][$credit['shortid']]['name'] = $credit['name'];
			$categories['rp']['credits'][$credit['shortid']]['shortid'] = $credit['shortid'];
			if($rpc_awarded){
				$categories['rp']['awarded'] 	+= 1;
				$categories['rp']['credits'][$credit['shortid']]['awarded'] = 1;
			}
			
			//	$total_possible += 1;
		}
		
	}
}

$rows_categories = $categories;
$total_awarded = 0;
foreach($rows_categories as $total_cat){
	$total_awarded = $total_awarded + $total_cat['awarded'];
}

$query = "SELECT nid FROM {content_type_project} WHERE field_prjt_id_value=".$project_id;
$nid = db_result(db_query($query));
$project = node_load($nid);
$certification_level_term = taxonomy_get_term($project->field_prjt_certification_level[0]['value']);
$certification_level = $certification_level_term->name;

$rating_system_term = taxonomy_get_term($project->field_prjt_rating_system[0]['value']);
$rating_system = ($rating_system_term->description != '') ? $rating_system_term->description : $rating_system_term->name;  //Made change to display description of rating system - JM 11/12/2013

$rating_system_version_term = taxonomy_get_term($project->field_prjt_rating_system_version[0]['value']);
$rating_system_version = $rating_system_version_term->name;

if(inStr($rating_system_version, 'v2009')){		
	$total_possible = 110;
}


$prjt_status_query = "SELECT status FROM insight.projects WHERE id=".$project_id;
$prjt_status = db_result(db_query($prjt_status_query));
$show_scorecard = TRUE;
if(strpos(strtolower($prjt_status),"review") === false){
	$show_scorecard = TRUE;
}else{
	$show_scorecard = FALSE;
}

?>
<?php if(floatval($project_id!=10042815)){?>
<script type="text/javascript">
$(document).ready(function(){
	$(".sh-content").hide();
	$('.sh-trigger').click(function(e){
	e.preventDefault();
	var parentDiv = $(this).parents('.criteria').find('.sh-content');
	parentDiv.css("height", parentDiv.height() +"px");
	parentDiv.slideToggle(600);
	$(this).parents('.criteria-head').toggleClass("expanded")
	});
	});
</script>
<?php }?>
<style>
#mini-scorecard *{
	text-transform:none;
}
</style>
<div id="mainCol">
	<?php if($show_scorecard):?>
		<?php if($total_rows > 0 && $total_awarded != 0):?>
		<div id="scorecard">
			<div class="sc-header">
			<?php if(floatval($project_id=='10020308')){?>
				<h2>LEED Scorecard (CS)</h2>
			<?php } else if (floatval($project_id=='10042815')){?>
				<h2>LEED Scorecard (CI)</h2>
			<?php }else{ ?>
				<h2>LEED Scorecard</h2>
			<?php }?>
				<p class="total"><?php print $certification_level;?> <span class="total-num"><?php print $total_awarded;?>/<?php print $total_possible;?></span></p>
			</div>
	
			<?php
			$categories_string = "sl,np,gi,ss,we,ea,mr,iq,ll,ae,id,rp";
			$categories = explode(",",$categories_string);
	 		foreach($categories as $catclass){
				$image = "http://rmtool.usgbc.name/reviewreport/images/credit_category_icons/$catclass-border.png";
				if($rows_categories[$catclass]){
			?>
			<div class="criteria <?php print $catclass;?>">
				<div class="criteria-head">
					<a class="sh-trigger" href="#"><?php print $rows_categories[$catclass]['name'];?>
						<span class="criteria-score"><?php print $rows_categories[$catclass]['awarded'];?>
						     <?php //if($catclass!='rp'){
							 print " of ".$rows_categories[$catclass]['possible'];
						    //}?>
						    
						</span>
					</a>
					<img src="<?php print $image;?>"/>
				</div>
				<ul class="sh-content plainlist">
					<?php foreach($rows_categories[$catclass]['credits'] as $credit){?>
						<li>
						<strong>
							<a href="/node/<?php print $credit['nid'];?>" ><?php print $credit['shortid']; ?></a>
							
							<a href="/node/<?php print $credit['nid'];?>" class="view-leed-online">
	  						
	  						<p class="view-leed-online"></p>
	  						
	  						</a>
						</strong> <?php print $credit['name']; ?>
						<span class="num">
						<?php if($catclass=='rp' || $catclass=='id'){ ?>
							+
						<?php }?>
						<?php print $credit['awarded'] ;?>
						<?php 
						if($catclass!='rp' && $catclass!='id'){
							print  '/ ' . $credit['possible'] ;
						}
						?>
						</span>
	
						</li>
					<?php }?>
				</ul>
			</div>
			<?php }}?>
		</div>
		<?php else:?>
			<?php $points_awarded_query = "select points_awarded from insight.project_details where id =".$project_id;
				$points_awarded = db_result(db_query($points_awarded_query)); ?>
				<h2>We currently do not have credit level data available for this project</h2>
				<?php if($project->field_prjt_certification_date[0]['value']):?>
					<p>This project achieved certification at <?php print $certification_level;?> level in <?php print date("M Y", strtotime(substr($project->field_prjt_certification_date[0]['value'],0,10))); ?> <?php echo ($points_awarded != 0 || is_null($points_awarded)) ? 'and achieved '.$points_awarded.' points':''?></p>
				<?php endif;?>
				
		<?php endif;?>
	<?php else:?>
		<h2>Certification in progress</h2>
	<?php endif;?>
</div>

<div id="sideCol">
	<div class="sbx" >
		<?php
		$viewname = 'servicelinks';
  		$display_id = 'page_2';
  		$args[0] = $nid;
  		$view = views_get_view($viewname);
  		$view->set_display($display_id);
  		$view->set_arguments ($args);
  		print $view->preview();
		?>
	</div>
	<?php if($show_scorecard):?>
		<?php if($project->field_prjt_certification_date[0]['value'] && $total_rows > 0  && $total_awarded != 0){?>
			<div class="button-group">
				<a href="/dopdf.php?q=projectscorecard/<?php print $project_id;?>" class="jumbo-button-dark">Download Scorecard</a>
			</div>
		<?}?>
	<?php endif;?>
	<div id="mini-scorecard">
    	<h2>LEED Facts</h2>
    	<p class="cert">for <?php print $rating_system;?> (<?php print $rating_system_version;?>)</p>
<?php if($project->field_prjt_certification_date[0]['value']){?>
    	<p class="recert">Certification awarded <?php print date("M Y", strtotime(substr($project->field_prjt_certification_date[0]['value'],0,10))); ?></p>
<?}else{?>
    	<p class="recert">Certification in progress</p>
<?}?>
<?php if($show_scorecard):?>
    	<dl class="points total">
    		<dt><?php print $certification_level;?></dt>
    		<?php if ($total_rows > 0 && $total_awarded != 0):?>
    		<dd><?php print $total_awarded;?><dd>
    		<?php else:?>
    		<dd><?php print $points_awarded;?></dd>
    		<?php endif;?>
    	</dl>
		<?php foreach($categories as $catclass){
			if($rows_categories[$catclass]){
			?>
    	<dl class="points <?php print $catclass?>">
    		<dt><?php 
				$catclassname = $rows_categories[$catclass]['name'];
				$catclassname = str_replace("Neighborhood pattern & design","ND pattern & design", $catclassname);
				$catclassname = str_replace("Green infrastructure & buildings","Green Infrastructure & bldgs", $catclassname);
				print $catclassname; ?></dt>
    		<dd><span><?php print $rows_categories[$catclass]['awarded']; 
    		//if($catclass!='rp'){
    			print "/".$rows_categories[$catclass]['possible'];
			 // }?>
			 </span> </dd>
    	</dl>
		<?php }}?>
<?php endif;?>
	
    </div>
</div>
<div class="clear-block"></div>
<?php

if(floatval($project_id)==10020308){
	print '<div>';
	$viewname = 'scorecard';
	$args = array();
	$args[0]='10042815';
	$display_id = 'page_1'; // or any other display
	$view = views_get_view($viewname);
	$view->set_display($display_id);
	$view->set_arguments($args);
	print $view->preview();
	print '</div>';
}
?>
<?php print "<pre>";?>
