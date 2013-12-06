<?php
// $Id: page.tpl.php 7027 2013-03-13 16:54:26Z jmehta $
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */
?>
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
$title = $node->title;
$share_text = "Worth checking out: $title on www.usgbc.org";
$head_title = str_replace('&amp;', '&',$head_title);
$pageurl = $_SERVER["REQUEST_URI"];
?>
	<?php
	            	$destinationurl = substr($_SERVER['REQUEST_URI'],1);
	            	if (strlen($destinationurl) == 0){
	            			$url = "/";
	            	}elseif ($destinationurl == 'registration/create-user' || $destinationurl == 'user/login' || $destinationurl == 'user/password'){
	            		$url = "account";
	            	}else{
	            		$url = $destinationurl;

	            	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"A
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><!--  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<!--[if lt IE 7 ]> <html class="ie ie6" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"><!--<![endif]-->

<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" >
<meta name="google-site-verification" content="2z0A9kITfB_cjJthmZmsOol8JFV1j63k2hE_GTLy_CA" />
<?php print  "<meta name='description' content='$share_text' />"?>
  <title><?php print $head_title; ?></title>
	<?php print $head; ?>

	<?php print $styles; ?>
	<?php print $scripts; ?>
	<?php if ($conditional_scripts) { print $conditional_scripts; } ?>
	<style>
		.ie7 #modal,
		.ie8 #modal{
			padding-bottom:0px;
		}
		
		div.glossary-letter{
			text-align: left !important;
			text-align: left !important;
			padding-left: 5px;
			padding-right: 5px;
			margin-top: 2em;
			border-bottom: 1px dashed #CCC;
			float: left;
			color:#646464;	
			text-transform:uppercase;					
		}

		div.glossary-links{
			display: block;
			position: fixed;
			bottom: 0;
			width: 100%;
			left: 0;
		}
		
		div.glossary-links a,
		div.glossary-links a:hover{
			color:black !important;
			font-weight:700;
		}
		
		div.glossary-list dt h4{
			font-size: 16px;
			clear: left;
			padding-top: 1em;
			color:black;
		}
		
		.wf-loading p,.wf-loading h1,.wf-loading h2,.wf-loading h3,.wf-loading h4,.wf-loading ul {
			visibility:hidden !important;
		}
		
	</style>
</head>

<body class="<?php print $body_classes; ?>">
  <?php if ($page_top): ?>
  	<?php print $page_top; ?>
  <?php endif; ?>

  <div id="body-container">
<!--	<div class="message-banner ">
		From Friday, <strong>December 14, 10 PM EST to December 15, 10 AM EST</strong>, usgbc.org will be offline for site maintenance. <br/> 
		<a href="mailto:info@usgbc.org">Email us</a> or call 1-800-795-1747 for assistance. Thanks for your patience.
	</div>-->
  <?php if (isset($_SESSION['CS_uid'])){
  
  	global $user;
  	
  	print '<div style="background-color: orange;">You are logged in as ' . $user->mail . '. Return to <a href="/admin/usgbc/return">Customer Service Admin</a> page or return to <a href="/admin/usgbc/return?destination=/admin/renewals">Customer Service Admin Renewals</a> page.</div>';
  	  	 
  }?>
  
  
	<div id="ie">
		<a href="http://windows.microsoft.com/en-US/internet-explorer/downloads/ie-8">Please upgrade your browser.</a> This site requires a newer version to work correctly.
		<a class="jqm-tip-trigger" href="#ie-incompatible">Read more</a>
	</div>
	<div id="ie-incompatible" style="display:none">
		<div class="modal-title">
			<h2><span>Incompatible browser</span></h2>
		</div>
		<p>	Internet Explorer versions 7 and older have known compatibility and security issues with modern
				web standards which affect next generation Web 2.0 websites.  In our attempt to deliver a superior
				experience, we no longer support Internet Explorer versions 7 and older.</p><p>Please upgrade to the latest 
				version of Internet Explorer, Firefox, Safari or Chrome.</p>

	</div>

    <div id="navBar">
      <div id="globalNav">

        <?php if (!empty($global_menu)): ?>
        <div id='mainNav'><?php print $global_menu; ?></div>
        <?php endif; ?>

        <?php if (!empty($utility_menu)): ?>
        <div id='utilityNav'>
         	<?php print preg_replace('/<div class="menu-block-1/','<div style="margin-right: 0;" class="left menu-block-1',$utility_menu,1); ?>
        	<ul class="left signinmenu" style="margin-right: 0;" >
        	<?php global $user;?>
			<?php if ($user->uid){?>
        		<?php $node_person_per_nav = content_profile_load ('person', $user->uid);
        			$fname = $node_person_per_nav->field_per_fname[0]['value'];
        			if($fname=='' || $fname == 'Green') $fname='Account';
        			if ($node_person_per_nav->field_per_profileimg[0]['filepath'] == '') {
						$img_path = '/sites/all/assets/section/placeholder/person_placeholder.png';
						$img = null;
				    } else {
						$img_path = '/'.$node_person_per_nav->field_per_profileimg[0]['filepath'];
						$attributes = array();
	        		  	$img = theme ('imagecache', 'fixed_024-024', $img_path, $alt, $title, $attributes);
	        			$img = str_replace('%252F', '', $img);

				    }?>
					<?php if(!$img){?>
			        	<li id="account-nav" style="margin-left:6px">
                        <a href="" style="padding:11px 18px 13px 8px">
						<span style="margin-top:2px;display:block"><?php print $fname; ?></span>
						<i class="drop-arrow" style="right:7px"></i>

					<?php }else{?>
						<li id="account-nav" style="margin-left:6px">
							<a href="" style="padding:11px 18px 10px 8px">
								<span class="inset-frame"><?php print $img;?></span>
								<i class="drop-arrow" style="right:7px"></i>
					<?php }?>
                        </a>
						<ul class="dropdown-menu">
							<li><a href="/account">Account home</a></li>
							<li><a href="/account/membership">Membership</a></li>
							<li><a href="/account/profile/personal">Personal profile</a></li>
							<li><a href="/account/purchases/access">Online access</a></li>
							<li class="divider"></li>
							<li><a href="/logout">Sign out</a></li>
						</ul>
					</li>
        		<?php }else{ ?>
       			<li id="sign-in">
					<a class="jqm-trigger button" href="/user/login?destination=<?php print $url; ?>">Sign in</a>
        		</li>
        		<?php }?>
        	</ul>
        </div>
        <?php endif; ?>

      </div>
    </div>
<div id="wrapper">
      <div id="header">

		<div id="personalNav">
 		<!--	<?php if (!empty($personal_menu)): ?>
	          	<?php global $user;
      				if ($user->uid):?>
	            	<?php print $personal_menu; ?>
	            <?php else:?>
	            	<ul class="menu">
                  <li class="leaf first">
                      <a  class="jqm-form-trigger" href="/user/login?destination=account">My account</a>
                  </li>
                  <li class="leaf last">
                      <a class="jqm-form-trigger" href="/user/login?destination=<?php print $url; ?>">Sign in</a>
                  </li>
                </ul>
	            <?php endif;?>
            <?php endif;?>-->
              	<div class="mini-search">
              		<div class="mini-search-container">
              			<?php if (!empty($search_box)) print $search_box; ?>
              		</div>
              	</div>
            </div>

          <?php if (!empty($page_header)) print $page_header; ?>

      </div>

      <div id="nav">
	       <?php if (!empty($section_menu)) print $section_menu; ?>

		       <?php if(strstr($pageurl,'store') || strstr($pageurl,'publications')):?>
		       <?php

		       usgbc_store_cart_cleanup();

		       $cartitem = uc_cart_get_contents(NULL, 'rebuild');
		       ?>
		        <ul>
		        	<?php if($pageurl == '/store/cart'):?>
		        		<li class="cart selected"><a href="/store/cart">Your cart (<?php echo count($cartitem);?>)</a></li>
		        	<?php else:?>
		        		<li class="cart "><a href="/store/cart">Your cart (<?php echo count($cartitem);?>)</a></li>
		        	<?php endif;?>
	    		</ul>
	    	   <?php endif;?>
	    	<?php if($user->uid):?>
	    	   <?php if(strstr($pageurl,'/resources')):?>
	    	   <?php
	    	    $view = views_get_view( 'Resources' );
				$view->get_total_rows = TRUE;
				$view->set_display('page_6');
				$view->execute();
				$favcount =  $view->total_rows;
	    	   ?>
	    	   <ul>
	    	   		<?php if(inStr($pageurl,'/resources/grid/favorites')):?>
		        		<li class="favorites selected"><a href="/resources/grid/favorites">Favorites (<?php echo $favcount;?>)</a></li>
		        	<?php else:?>
		        		<li class="favorites "><a href="/resources/grid/favorites">Favorites (<?php echo $favcount;?>)</a></li>
		        	<?php endif;?>

	    	   </ul>
	    	   <?php endif;?>

		<?php endif;?>
	  </div>

      <?php if (!empty($tabs)): ?>
		  <?php if(!strstr($pageurl,'/search')):?>      
		      <div id="local_tasks">
		        <div class="tabs"><?php print $tabs; ?></div>
		        <?php if ($tabs2): ?><div class='secondary-tabs clear-block'><?php print $tabs2 ?></div><?php endif; ?>
		      </div>
	      <?php endif; ?>
      <?php endif; ?>

      <?php if (!empty($messages) || !empty($help)): ?>
      <div id='console'><div class='limiter clearfix'>
        <?php if (!empty($messages)): print $messages; endif; ?>
        <?php if (!empty($help)): print $help; endif; ?>
      </div></div>
      <?php endif; ?>
</div>
 
 <?php print $content; ?>
 

<div id="wrapper">
<div id="footer">
        
        <div class="footer-menu">
        
            <div id="quickLinksNav">
              <?php if (!empty($footer_menu))  print $footer_menu; ?>
            </div>
            
            <div id="legal">
              <?php if (!empty($legal_menu))  print $legal_menu; ?>
            </div>
            
        </div>
            
        <?php if ($footer || $footer_message): ?>
          <?php print $footer_message; ?>
        	<?php print $footer; ?>
        <?php endif; ?>
          
      </div><!-- end footer -->
        
        
      
    </div><!-- end wrapper -->

  </div><!--body-container-->

  <?php print $closure; ?>
 <?php include ($_SERVER['DOCUMENT_ROOT'].'/sites/all/assets/section/private-beta/feedback.php'); ?>
 
 
<div id="alerts-container"></div>
 
</body>
</html>
