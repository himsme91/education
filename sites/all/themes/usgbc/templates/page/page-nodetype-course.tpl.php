<?php 
$styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/courses.css" />';
$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/jquery.submitwkshpdate.js"></script>';

include('page_inc/page_top.php');

global $user;

if ($_GET['workshop_nid']) {
    $workshop_id = $_GET['workshop_nid'];
}
else {
    $view = views_get_view ('vws_crs_detail');
    $view->set_arguments (array($node->nid));
    $view->set_display ('page_6');
    $view->execute ();
    $workshop_id = $view->result[0]->nid;
}

$workshop_node = node_load ($workshop_id);

$workshop_SKU = $workshop_node->model; 

$product = new stdClass;
$product->nid = $workshop_id;
$product->price = $workshop_node->list_price;

$price = $product->price;
$member_price = usgbc_store_get_member_price ($product);

if ($node->field_crs_pvd[0][nid] != null){
	$provider = node_load($node->field_crs_pvd[0][nid]);
}
$feature_img_src = '/' . $node->field_art_feature_image[0]['filepath'];
$est_time_completion = 0;
$result = db_query('SELECT field_cs_content_time_value FROM
		drupal.content_type_course_module WHERE field_cs_parent_course_nid = %d', $workshop_id );
while ($temp = db_fetch_object($result)) {
	$est_time_completion += $temp->field_cs_content_time_value;
}

$node_est_completion_time_hours = gmdate("h:i:s", $est_time_completion);

$subscription = og_subscriber_count_link($workshop_node);

$user_access = false;
if($subscription[1] == "active") $user_access = true;
 
 ?>
<style type="text/css">
#comments .box{
    border: 0px none #DDDDDD;
    box-shadow: 0;
    margin-bottom: 0px;
    padding: 0px;
}
</style>
<?php $type = $node->field_crs_type[0]['view'];
if(strtolower($type) == 'webinar'):?>

<style type="text/css">
#comments{
    clear: both;
    float: left;
    width: 100%;
}
div.fivestar-widget {
    padding-bottom: 5px;
}
.fivestar-widget .description{
    display:none;
}
#navBar, #header, .footer-menu, .social, #nav, #console {
    display: none; 
}
#footer #copyright {
    float: none;
    text-align: center;
}
</style>
<div class="container_12 geometric-type" id="course-detail-page">

	<!-- Begin Opener -->
	<div id="course-opener" class="standalone clearfix">
 	<div style="float: right;margin-top: -20px;position: relative;z-index: 5;"><a class="goback back-link" href="/webinars">All webinars</a></div>
		<div id="thing"></div>
		<div class="grid_4">
			<div class="frame-container">
				<div class="frame">
					<?php if($feature_img_src){?>
					<img class="fluid" alt="" src="<?php echo $feature_img_src;?>"></img>
					<?php }?>
					<span class="lower-thirds"> Estimated completion time <strong><?php echo $node_est_completion_time_hours; ?>
					</strong>
					</span>
				</div>
			</div>
		</div>	
			
		<div class="grid_8">
			<h1>
				<?php echo $node->title; ?>
			</h1>
			<h2>
				Provided by 
				<?php if ($node->field_crs_pvd[0][view] != null): ?>
					<a href="/node/<?php print $provider->nid;?>">
				    <?php print $provider->title?></a>
				<?php else :?>
				  	<?php print $node->field_crs_pvd_name[0][value];?>
				<?php  endif;?>
				<?php print $node->content['fivestar_widget']['#value'] ?>
			</h2>
			<p>
				<?php 
				$course_pills = array();
				$leed_cert_array = $node->field_crs_leed;
				$temp_size = sizeof($leed_cert_array);
				
				for($i = 0; $i < $temp_size; $i++){
					$value = $leed_cert_array[$i]['value'];
					if($value != null){
						$current_term = taxonomy_get_term($value);
						switch($current_term->name){
							case 'LEED AP BD+C':
								$course_pills[] = '<span class="leed-certificate-bdc pill">BD+C</span>'; break;
							case 'LEED AP Homes':
								$course_pills[] = '<span class="leed-certificate-homes pill">Homes</span>'; break;
							case 'LEED AP ID+C':
								$course_pills[] = '<span class="leed-certificate-idc pill">ID+C</span>'; break;
							case 'LEED AP ND':
								$course_pills[] = '<span class="leed-certificate-nd pill">ND</span>'; break;
							case 'LEED AP O+M':
								$course_pills[] = '<span class="leed-certificate-om pill">O+M</span>'; break;
						}
					}
				}?>
				<?php foreach($course_pills as $pill_html){
					echo $pill_html;
				}?>
			</p>
			<div>
				<span class="meta-item"> <strong>ID</strong> <?php echo $node->field_crs_id[0]['value']; ?>
				</span> <span class="meta-item"> <strong>Level</strong> <?php echo $node->field_crs_level[0][view]; ?>
				</span>
			</div>
			<div class="box" id="sub-here">
				<?php if( !$user_access ):?>
				<h4><?php print uc_currency_format ($price);?> per year
				</h4>
				<?php else:?>
					<h4><span class="reg">Subscribed</span></h4>
				<?php endif;?>
				<?php
				if( !$user_access ){
				      $viewname = 'vws_crs_detail';
				      $display_id = 'page_10';
				      $args = array();
				      $args[0] = $workshop_id;
				
				      $view = views_get_view ($viewname);
				      $view->set_display ($display_id);
				      $view->set_arguments ($args);
				
				      if (!empty($view)) {
				        $output = $view->execute_display ($display_id, $args);
				        
				        if ($view->result) {
				          print $output;
				        }
				      }
				      
				    }else{?>
				    <a id="btn_register" class="jumbo-button-dark" href="/sessions/<?php echo $workshop_node->nid;?>/1">Watch lessons</a>
				    <?php }?>
			</div>
			<?php if($user_access ):?>
				<?php 
					$expiredate = db_result (db_query ("SELECT FROM_UNIXTIME(expire) FROM {og_expire} WHERE uid = %d AND nid = %d", $user->uid, $workshop_node->nid));
					if(date("Y-m-d") <= date("Y-m-d", strtotime ( $expiredate))){
						$expiredate = date("n/j/Y", strtotime ( $expiredate));
						$days = round(abs(strtotime($expiredate)-strtotime(date("Y-m-d")))/86400);
					}
				?>
				<span class="left thin caps">Expires in <?php print $days;?> days</span>
			<?php endif;?>
			<?php if(!$user->uid):?>
			<?php $destinationurl = substr($_SERVER['REQUEST_URI'], 1);?>
				<span class="center thin caps"><a class="jqm-form-trigger" href="/user/login?destination=/<?php echo $destinationurl;?>">Save with membership</a></span>
			<?php endif;?>
		</div>
		
	</div>
	<!-- End Opener -->
	
	<!-- Begin Course Body -->
	<?php print $content; ?>
	<!-- End Course Body -->
	
</div>
<?php else:?>
<style type="text/css">
.sbx-print{
	display:none;
}
</style>

  <?php 

	$sections = explode ('/', $_GET['return'], 4);
	if ($sections[3] != ''){
		$links[] .= l(t(ucfirst(str_replace('-',' ',str_replace('%26','&',$sections[3])))), $base_url.$_GET['return']);
	}

  	if (strtolower($node->field_crs_fmt[0]['view']) == 'live' || strtolower($node->field_crs_fmt[0]['view']) == 'on demand'){
  		$type = "Online";
  	}else{
  		$type = "Near you";
  	}

  	$links = array();
	global $base_url;
	if ($type == "Online"){
		$links[] = l($type,$base_url.'/courses/online');
		if ($sections[3] != ''){
			$links[] .= l(str_replace('-',' ',$node->field_crs_fmt[0]['view']), $base_url.'/courses/online/'.str_replace(' ','-',strtolower($node->field_crs_fmt[0]['view'])));
		}
	}else{
		$links[] = l($type,$base_url.'/courses/in-person');	
		if ($sections[3] != ''){
			$links[] .= l(str_replace('-',' ',$node->field_crs_fmt[0]['view']), $base_url.'/courses/in-person/'.str_replace(' ','-',strtolower($node->field_crs_fmt[0]['view'])));
		}
	}
	
	//drupal_set_breadcrumb($links);
  
?>

<div class="breadcrumb hidden" >
<?php foreach($links as $l){
	print $l;
 }?>
</div>

<div id="content">

  <div id="navCol">
    <div class="course-badge">
	                    <span class="course-id">ID #
                        <?php  
		//				$workshop_node = node_load($workship_id);	
		//				dsm($workshop_node);
		//				watchdog("course", $workshop_node->field_wrksp_id[0]['view']);			
						print $node->field_crs_id[0]['value'];
?></span>
      <dl class="level">
        <dt><?php print $node->field_crs_level[0][view]?></dt>
        <dd><?php print $node->taxonomy[$node->field_crs_level[0][value]]->description; //$node->field_crs_level[0][view]?></dd>
      </dl>
    </div>
    <?php
    $viewname = 'vws_crs_detail';
    $display_id = 'page_7';
    $args = array();
    $args[0] = $node->nid;
    $args[1] = $workshop_id;

    $view = views_get_view ($viewname);
    $view->set_display ($display_id);
    $view->set_arguments ($args);

    if (!empty($view)) {
      print $view->execute_display ($display_id, $args);
    }

    ?>

  </div>
  <div class="subcontent-wrapper">
    <div id="mainCol">
      <?php print $content; ?>
    </div>

    <div id="sideCol">
      <?php
      $viewname = 'vws_crs_detail';
      $display_id = 'page_10';
      $args = array();
      $args[0] = $workshop_id;

      $view = views_get_view ($viewname);
      $view->set_display ($display_id);
      $view->set_arguments ($args);

      if (!empty($view)) {
        $output = $view->execute_display ($display_id, $args);

        if ($view->result) {
          print $output;
        }
      }?>

      <div class="sbx">
        <?php

        $viewname = 'servicelinks';
        $args = array();
        $args[0] = $node->nid;
        $display_id = 'page_1';
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?>

      </div>


	<?php if ( (count ($node->field_crs_leed_ap_hours) > 0)
			|| 		($node->field_crs_uia_cpd_hours[0][view]!=null)
			||		($node->field_crs_ifma_hours[0][view]!=null)
			||		($node->field_crs_aia_ces_hours[0][view]!=null)
			||		($node->field_crs_csi_ceu_hours[0][view]!=null)
			||		($node->field_crs_idcec_ceu_hours[0][view]!=null)
			||		($node->field_crs_bomi_cpd_hours[0][view]!=null)
			||		($node->field_crs_corenet_hours[0][view]!=null)
			
		)	: ?>

      <div class="section">
        <table cellspacing="0" class="details">
          <tbody>

          <?php if (strlen ($node->field_crs_leed_ap_hours[0][view]) > 0): ?>

		 <?php if($node->field_crs_leed[0]['value']):?>
          <tr>
            <th>LEED-specific
              <?php foreach ($node->field_crs_leed as $id => $row): ?>
                <span class="specialty"><?php print $row[view];?></span>
                <?php endforeach; ?>
            </th>
            <td>
              <?php print $node->field_crs_leed_ap_hours[0][view]?></td>
          </tr>           
		 <?php else : ?>
		 <tr>
            <th>CE Hours
            </th>
            <td>
              <?php print $node->field_crs_leed_ap_hours[0][view]?></td>
          </tr>
		 <?php endif; ?>
		 <?php endif;?>
          <?php if (strlen ($node->field_crs_uia_cpd_hours[0][view]) > 0): ?>
          <tr>
            <th>
              UIA CPD (ILU)
            </th>
            <td>
              <?php print $node->field_crs_uia_cpd_hours[0][view];?></td>
          </tr>
            <?php endif;?>

          <?php if (strlen ($node->field_crs_ifma_hours[0][view]) > 0): ?>
          <tr>
            <th>IFMA (CFM/FMP)</th>
            <td>
              <?php print $node->field_crs_ifma_hours[0][view];?>
            </td>
          </tr>
            <?php endif;?>
          <?php if (strlen ($node->field_crs_aia_ces_hours[0][view]) > 0): ?>
          <tr>
            <th>AIA/CES (LU)</th>
            <td>
              <?php print $node->field_crs_aia_ces_hours[0][view];?></td>
          </tr>
            <?php endif;?>
          <?php if (strlen ($node->field_crs_csi_ceu_hours[0][view]) > 0): ?>
          <tr>
            <th>CSI (CEU)</th>
            <td>
              <?php print $node->field_crs_csi_ceu_hours[0][view];?></td>
          </tr>
            <?php endif;?>
		<?php if (strlen ($node->field_crs_idcec_ceu_hours[0][view]) > 0): ?>
          <tr>
            <th>IDCEC (CEU)</th>
            <td>
              <?php print $node->field_crs_idcec_ceu_hours[0][view];?></td>
          </tr>
            <?php endif;?>
			<?php if (strlen ($node->field_crs_bomi_cpd_hours[0][view]) > 0): ?>
          <tr>
            <th>BOMI (CPD)</th>
            <td>
              <?php print $node->field_crs_bomi_cpd_hours[0][view];?></td>
          </tr>
            <?php endif;?>
            <?php if (strlen ($node->field_crs_corenet_hours[0][view]) > 0): ?>
          <tr>
            <th>Corenet (CPD)</th>
            <td>
              <?php print $node->field_crs_corenet_hours[0][view];?></td>
          </tr>
            <?php endif;?>
          </tbody>
        </table>
      </div>
	<?php endif; ?>

      <?php
  /*    $viewname = 'vws_crs_detail';
      $display_id = 'page_9';
      $args = array();
      $args[0] = $node->nid;

      $view = views_get_view ($viewname);
      $view->set_display ($display_id);
      $view->set_arguments ($args);

      if (!empty($view)) {
        $output = $view->execute_display ($display_id, $args);
        if ($view->result) {
          print $output;
        }
      }*/
      ?>
    </div>
  </div>


</div><!--content-->

<?php endif;?>
<?php include('page_inc/page_bottom.php'); ?>
