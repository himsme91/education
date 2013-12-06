<?php 
 $GLOBALS['conf']['cache'] = FALSE;

 global $user;
 $view_access = TRUE;
 if($node->field_res_memberonly[0]['value'] == 1){
	 if (!$user->uid){
	     $destination =  $_SERVER['REQUEST_URI'];
		 header("Location: /user/login?destination=$destination");
 	}
	 else {
		$type = "organization";
	    $getorg = db_result (db_query ("SELECT n.nid FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s')", $user->uid, 1, $type));
	    if ($getorg == '') {
			$view_access = FALSE;
	    }
	}
 }
 
 
$options = usgbc_uc_get_options();
$kindle_oid = 0;

foreach($options as $option ){
	if( strtolower(($option['name'])) == 'kindle')	{
		$kindle_oid = $option['oid'];
		break;
	}
}

?>


<?php
  // $Id: page-nodetype-resource.tpl.php 7043 2011-10-18 17:47:46Z jmehta $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */
$styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/resource.css" />';
  include('page_inc/page_top.php'); 

  $sell_price = $node->sell_price ;
  
  //Start: Updates for restricting the user to add the item to cart if 
  //already purchased or available in their online access - JM 6/13/2013
  usgbc_core_get_memberbenefits();
  // File downloads
  $files = array();
  $result = pager_query(
    "SELECT u.granted, f.filename, u.accessed, u.addresses, p.description, 
	u.file_key, f.fid, u.download_limit, u.address_limit, u.expiration 
	FROM uc_file_users as u 
	    INNER JOIN uc_files as f ON u.fid = f.fid
	    INNER JOIN uc_file_products as p ON p.pfid = u.pfid 
	INNER JOIN drupal.uc_product_features as n on n.pfid = u.pfid
	and uid = %d and n.nid = %d",
	    10,
	    0,
	    "SELECT COUNT(*) FROM {uc_file_users} WHERE uid = %d",
	    array($user->uid,$node->nid)
  );

  $row = 0;
  $addtocart = TRUE;
  while ($file = db_fetch_object($result)) {
    $download_limit = $file->download_limit;
    $onclicknew = 'uc_file_update_download('. $row .', '. $file->accessed .', '. ((empty($download_limit)) ? -1 : $download_limit) .');';
    // Expiration set to 'never'
    if ($file->expiration == FALSE) {
      $file_linknew = '/download/'. $file->fid .'/'. $file->file_key;
      $expires = 'Online access never expires.';
      $addtocart = FALSE;
    }

    // Expired.
    elseif (time() > $file->expiration) {
      $file_linknew = "#";
      $expires = 'Online access has expired.';
      $addtocart = TRUE;
    }

    // Able to be downloaded.
    else {
      $file_linknew = '/download/'. $file->fid .'/'. $file->file_key;
      $expires = t('Online access expires on @date', array('@date' => format_date($file->expiration, 'custom', variable_get('uc_date_format_default', 'm/d/Y'))));
      $addtocart = FALSE;
    }

    $files[] = array(
      'name' => $file->filename,
      'onclick' => $onclicknew,
      'href' => $file_linknew,
      'expires' => $expires,
      'granted' => $file->granted,
      'description' => $file->description,
      'accessed' => $file->accessed,
      'download_limit' => $file->download_limit,
      'addresses' => $file->address,
      'address_limit' => $file->address_limit,
    );
    $row++;
  }

  //End - JM 6/13/2013
 
?>

<div id="content">

<script type="text/javascript">
$(document).ready(function(){
	show_purchase_option();
	
	$("input[name='attributes[1]']").change(function(e){
		show_purchase_option();
	});

	function show_purchase_option(){
		var_format = $("input[@name=attributes[1]]:checked").val();
		var_ecopy_access = <?php $addtocart ? print '0' : print '1' ; ?>;
		 
		switch(var_format){
			case "1": // hard-copy
				if(var_ecopy_access == "1"){
					$('.purchase-options > .download').show();
				}else{
					$('.purchase-options > .download').hide();
				}
				$('.purchase-options > .addtocart').show();
				$('.purchase-options > .redirect').hide();					
				break;
			case "2": // e-copy
				if(var_ecopy_access == "1"){
					$('.purchase-options > .download').show();
					$('.purchase-options > .addtocart').hide();
				}else{
					$('.purchase-options > .download').hide();
					$('.purchase-options > .addtocart').show();
				}
				$('.purchase-options > .redirect').hide();
			
				break;
			case "<?php print $kindle_oid;?>": // kindle format
				$('.purchase-options > .addtocart').hide();
				$('.purchase-options > .download').hide();
				$('.purchase-options > .redirect').show();
				break;	
			default:
				break;
		}
	
	}

	
	
});
</script>


  <div id="navCol">
  <?php if ($node->field_res_profileimage[0]['filepath']) {?>
    <img class="resource-img" src="<?php print file_create_url ($node->field_res_profileimage[0]['filepath']);?>">
<?php } else {
	$res_type = strtolower($node->field_res_type[0]['view']);
	print '<img class="resource-img" src="/sites/all/themes/usgbc/lib/img/resource-icons/placeholder-document.gif"></img>';
}?>
    
    
    <?php print flag_create_link ('favorites', $node->nid); ?>

  </div>
  <?php if(!$addtocart):?>
<script type="text/javascript">

/*

$(document).ready(function(){
	$val = $('#edit-attributes-1').find("option:first").attr("selected", true).val();
	if($val == 2) $('.addtocart').hide(); 
	
	$('#edit-attributes-1').change(function(e){
		if($(this).val() == 2)
			 $('.addtocart').hide();
		else
			$('.addtocart').show();
	});
});

	
}); */

</script>
<?php endif;?>
  <div class="subcontent-wrapper">
    <div id="mainCol">
      <?php print $content; ?>
      <br/>
      <?php if(!$view_access):?>
      	<br/>
      	<p>Whoops! This resource is exclusively available to USGBC members. Please become a <a href="/member">USGBC member</a> now. </p>
      <?php endif;?>
    </div>

    <div id="sideCol">
    
        <div class="purchase-options">
	        <?php if ($row > 0 && !$addtocart):?>
	        <?php foreach ($files as $file) {
					$output .= '<div class="download"><a class="jumbo-button-dark" href="'.$file['href'].'" onclick="'.$file['onclick'].' ">Download</a>';
					$output .= '<span>'.$file['expires'].'</span> </div>';
			  		} 
			   		echo $output; ?>  
	        <?php endif;?>
	        <div class="addtocart">
			    <?php  if ($sell_price > 0) :?>
		    	  <a class="jumbo-button-dark" href="" onclick="document.forms.add_to_cart.submit();return false;">Add to cart</a>
		    	<?php endif; ?>
	    	</div>
	    	<div class="redirect">
	    		<?php if(!empty($node->field_kindle_url[0]['url'])){ ?>
	    			<a class="jumbo-button-dark" href="<?php print $node->field_kindle_url[0]['url']; ?>">Buy at Amazon.com</a>
	    		<?php }?>
	    	</div>
    	</div>
    
    
      <?php if ($node->field_res_memberonly[0]['value'] == 1) : ?>
	
      <div id="attention-feed" style="display:none;">
        <ul class="linelist">
          <li class="alert-neutral">
            <span class="alert-msg">You must be a USGBC member to access this resource. <a href="/user/login">Sign
              in</a></span></li>
        </ul>
      </div>

      <?php endif?>
      <?php if($view_access):?>
	      <?php
	
	      if ($node->field_res_file[0]['filepath'] != ''):
	        $downloadlink = "<a target='_blank' href='";
	        $downloadlink .= "/";
	        $downloadlink .= $node->field_res_file[0]['filepath'];
	        $downloadlink .= "' class='jumbo-button-dark'>Download";
	
	        if ($node->field_res_noofdownload[0]['view'] != '') {
	          $downloadlink .= "<span class='downloads'>";
	          $downloadlink .= $node->field_res_noofdownload[0]['view'];
	          $downloadlink .= " downloads</span>";
	        }
	
	        $downloadlink .= "</a>";
	        print $downloadlink;
	      ?>
	
	      <?php elseif ($node->field_all_url_website[0]['url'] != ''):
	      $websitelink = "<a target='_blank' href='";
	      $websitelink .= $node->field_all_url_website[0]['url'];
	      $websitelink .= "' class='jumbo-button-dark'>Visit website";
	
	      $websitelink .= "</a>";
	      print $websitelink;
	    
	      ?>
      <?php endif;?>

	<?php if ($node->field_res_download_url[0]['value'] != ''):
	$websitelink = "<a target='_blank' href='";
	$websitelink .= $node->field_res_download_url[0]['value'];
	$websitelink .= "' class='jumbo-button-dark'>Download";

	$websitelink .= "</a>";
	print $websitelink;
	endif;?>

	<?php endif;?>

      <div class="section-library section-apps">
        <?php print $node->content['vud_node_widget_display']['#value']; ?>
      </div>
      <div class="sbx">
        <?php
        $viewname = 'servicelinks';
        $display_id = 'page_2';
        $args[0] = $node->nid;
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?>

      </div>
      
       <?php
        $viewname = 'Relateditems';
        $display_id = 'page_7';
        $args[0] = $node->nid;
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?>
       <?php
        $viewname = 'Relateditems';
        $display_id = 'page_1';
        $args[0] = $node->nid;
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?>
       <?php
        $viewname = 'Relateditems';
        $display_id = 'page_2';
        $args[0] = $node->nid;
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?> 
       <?php
        $viewname = 'Relateditems';
        $display_id = 'page_3';
        $args[0] = $node->nid;
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?> 
       <?php
        $viewname = 'Relateditems';
        $display_id = 'page_4';
        $args[0] = $node->nid;
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?> 
       <?php
        $viewname = 'Relateditems';
        $display_id = 'page_5';
        $args[0] = $node->nid;
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?>                                   
       <?php
        $viewname = 'Relateditems';
        $display_id = 'page_6';
        $args[0] = $node->nid;
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();
        ?>      
    </div>

  </div>

</div><!--content-->


<?php include('page_inc/page_bottom.php'); ?>
