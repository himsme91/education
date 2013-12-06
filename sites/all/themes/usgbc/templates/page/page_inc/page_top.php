<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

$country_code = $_SERVER["HTTP_CF_IPCOUNTRY"];

$title          = $node->title;
$share_text     = "Worth checking out: $title on www.usgbc.org";
$head_title     = str_replace('&amp;', '&',$head_title);
$pageurl        = $_SERVER["REQUEST_URI"];
$destinationurl = substr($_SERVER['REQUEST_URI'],1);
if (strlen($destinationurl) == 0){
	$url = "/";
} elseif ($destinationurl == 'registration/create-user' || $destinationurl == 'user/login' || $destinationurl == 'user/password'){
	$url = "account";
} else {
	$url = $destinationurl;
}

$protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'];
/*
if($_SERVER['HTTP_X_FORWARDED_PROTO'] != 'https' && strtok($_SERVER["REQUEST_URI"],'?') != "/user/login") {
	if(strtolower($country_code) == 'in' && $_SERVER['HTTP_HOST'] != 'in.usgbc.org'){
		$newlocation = $protocol.'://in.usgbc.org'.$pageurl;
		header('Location: '.$newlocation);
	} else if(strtolower($country_code) == 'ch' && $_SERVER['HTTP_HOST'] != 'ch.usgbc.org'){
		$newlocation = $protocol.'://ch.usgbc.org'.$pageurl;
		header('Location: '.$newlocation);
	} 
}
*/
?>
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
	<script type="text/javascript" src="/sites/all/themes/usgbc/lib/node/international/js/scripts.js"></script>
	<script type="text/javascript" src="/assets/cache.js"></script>	
	<style>
		/*#edit-remember-settings-wrapper,
		#resultoptions-fieldset,
		#summaryoptions-fieldset,
		#availability-fieldset,
		#taking-fieldset,
		#no-questions,
		#mq-fieldset fieldset{
			display:none !important;
		}*/
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
		
	/*	.wf-loading p,.wf-loading h1,.wf-loading h2,.wf-loading h3,.wf-loading h4,.wf-loading ul {
			visibility:hidden !important;
		} */
		
		.mini-search-cover{
		position:relative;
		}
		
		#flag-list {
	margin-bottom: 15px;
}

#flag-list:after {
    content: ".";
    display: block;
    height: 0;
    clear: both;
    visibility: hidden;
}

	#flag-list li {
		float: left;
		list-style: none;
		margin: 0 8px 18px 0;
		position: relative;
		margin-right: 20px;
	}
	
	#flag-list li a {
		position: relative;
		z-index: 1;
		display: block;
	}
	
	#int-language-dropdown{
		display:none;
	}
	
	/*#flag-list:hover li a:not(:hover) .flag-image {
		opacity: .85;
	}*/
	
			
		#flag-list .flag-image {
			display: block;
			float: left;   
			
/*			-webkit-transition: all .5s ease-in-out;
			-moz-transition: all .5s ease-in-out;
			-o-transition: all .5s ease-in-out;
			transition: all .5s ease-in-out; */

			width: 70px;
			-webkit-box-shadow: 
				0 1px 0 rgba(0,0,0,.2) inset,
				0 -1px 0 rgba(0,0,0,.2) inset,
				1px 0 0 rgba(0,0,0,.2) inset,
				-1px 0 0 rgba(0,0,0,.2) inset,
				0 2px 0 rgba(255,255,255,.3) inset,
				0 1px 2px rgba(0,0,0,.25);
			-moz-box-shadow: 
				0 1px 0 rgba(0,0,0,.2) inset,
				0 -1px 0 rgba(0,0,0,.2) inset,
				1px 0 0 rgba(0,0,0,.2) inset,
				-1px 0 0 rgba(0,0,0,.2) inset,
				0 2px 0 rgba(255,255,255,.3) inset,
				0 1px 2px rgba(0,0,0,.25);
			box-shadow: 
				0 1px 0 rgba(0,0,0,.2) inset,
				0 -1px 0 rgba(0,0,0,.2) inset,
				1px 0 0 rgba(0,0,0,.2) inset,
				-1px 0 0 rgba(0,0,0,.2) inset,
				0 2px 0 rgba(255,255,255,.3) inset,
				0 1px 3px rgba(0,0,0,.25);
			-moz-border-radius: 2px;
			border-radius: 2px;
		}

		#flag-list li .flag-image img {
			width: 70px;
			display: block;
			z-index: -1;
			position: relative;
			-moz-border-radius: 2px;
			border-radius: 2px;
		}
		
		#flag-list li .flag-text {
			display: block;
			position: absolute;
			background: rgba(255,255,255,.9);
			*background: white;
			padding: 8px;
			width: 180px;
			font-size: 11px;
			text-align: center;
			top: 10px;
			left: 50%;
			margin-left: -98px;
			border: 1px solid rgba(0,0,0,.2);
			*border: 1px solid #ccc;
			-moz-border-radius: 4px;
			border-radius: 4px;
			-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
			-moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
			box-shadow: 0 1px 2px rgba(0,0,0,.2);
		
			-moz-background-clip: padding;     /* Firefox 3.6 */
			-webkit-background-clip: padding;  /* Safari 4? Chrome 6? */
			background-clip: padding-box;      /* Firefox 4, Safari 5, Opera 10, IE 9 */
					
			opacity: 0;
			transform: scale(.1);
			-ms-transform: scale(.1);
			-webkit-transform: scale(.1);
			-o-transform: scale(.1);
			-moz-transform: scale(.1);
			
			-webkit-transition: all .2s ease-in-out;
			-moz-transition: all .2s ease-in-out;
			-o-transition: all .2s ease-in-out;
			transition: all .2s ease-in-out;
			
			*display:none;
		}
		
		#flag-list li .flag-text:after {
			content: " ";
			display: block;
			position: absolute;
			bottom: -8px;
			left: 50%;
			margin-left: -10px;
			width: 20px;
			height: 8px;
			background: url(/themes/usgbc/lib/img/int-flag-arrow.png) bottom center;
		}
		
		#flag-list li a:hover .flag-text {
			display: block;
			top: -35px;
			opacity: 1;
			transform: scale(1);
			-ms-transform: scale(1);
			-webkit-transform: scale(1);
			-o-transform: scale(1);
			-moz-transform: scale(1);
			*display:block;
		}
		
.flag-sm {
    background-size: 100% auto;
    display: inline-block;
    height: 11px;
    width: 16px;
}
.flag-usa {
    background-image: url("/sites/all/themes/usgbc/lib/node/international/img/flag-usa.png");
}
.flag-portugal {
    background-image: url("/sites/all/themes/usgbc/lib/node/international/img/flag-portugal.png");
}
.flag-china {
    background-image: url("/sites/all/themes/usgbc/lib/node/international/img/flag-china.png");
}
.flag-spain {
    background-image: url("/sites/all/themes/usgbc/lib/node/international/img/flag-spain.png");
}
#int-language-dropdown {
    bottom: auto;
    left: 5px;
    margin-top: -23px;
    position: fixed;
    right: auto;
    top: 25px;
    width: 150px;
    z-index: 1;
}
#int-language-dropdown a {
    color: white;
    display: block;
    font-size: 14px;
    font-weight: 700;
    line-height: 14px;
    padding: 12px 16px;
    vertical-align: middle;
}
#int-language-dropdown a .flag {
    margin-right: 3px;
}
#int-language-dropdown .dropdown-trigger {
    background-color: #0E272E;
    background-image: -moz-linear-gradient(center top , #102B33, #0C2126);
    background-repeat: repeat-x;
    border: 1px solid #0C2126;
    border-radius: 8px 8px 8px 8px;
    bottom: auto;
    box-shadow: 0 1px 3px rgba(255, 255, 255, 0.1) inset;
    left: auto;
    position: relative;
    right: auto;
    top: auto;
    z-index: 1;
}
#int-language-dropdown .dropdown-trigger:hover {
    background-color: #112E36;
    background-image: -moz-linear-gradient(center top , #12323B, #0E282E);
    background-repeat: repeat-x;
    border-color: #12323B;
    color: white;
    text-decoration: none;
}
#int-language-dropdown .dropdown-trigger:active {
    background: none repeat scroll 0 0 #0C2126;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4) inset;
    color: rgba(255, 255, 255, 0.8);
}
#int-language-dropdown .dropdown-trigger .caret {
    background: url("/sites/all/themes/usgbc/lib/node/international/img/caret.png") no-repeat scroll center center transparent;
    display: inline-block;
    float: right;
    height: 14px;
    line-height: 14px;
    width: 9px;
}
#int-language-dropdown .dropdown-menu {
    background: none repeat scroll 0 0 rgba(12, 33, 38, 0.65);
    border: 1px solid #0C2126;
    border-radius: 0 0 8px 8px;
    bottom: auto;
    display: none;
    left: auto;
    padding-top: 8px;
    position: relative;
    right: auto;
    top: -8px;
    z-index: 0;
}
#int-language-dropdown .dropdown-menu li {
    border-bottom: 1px solid #0C2126;
    list-style: none outside none;
    margin: 0;
}
#int-language-dropdown .dropdown-menu li:last-child {
    border-bottom: medium none;
}
#int-language-dropdown .dropdown-menu a {
    font-size: 14px;
}
#int-language-dropdown .dropdown-menu a:hover {
    background: none repeat scroll 0 0 rgba(12, 33, 38, 0.3);
    color: white;
    text-decoration: none;
}
#int-language-dropdown .dropdown-menu .active a {
    background: none repeat scroll 0 0 rgba(22, 100, 116, 0.6);
}
		
	</style>
</head>

<body class="<?php print $body_classes; ?>">
  <?php if ($page_top): ?>
  	<?php print $page_top; ?>
  <?php endif; ?>

  <div id="body-container">
  	<?php $message_display = variable_get('message_banner',array());
  		if($message_display['display'] == "1"){
			$message = $message_display['message']; ?>
			<div class="message-banner ">
				<?php print $message; ?>
			</div>
	  <?php } ?>
 
<!-- <div class="message-banner ">
		From Friday, <strong>July 26, 10 PM EST to July 27, 2 PM EST</strong>, usgbc.org will be offline for site maintenance. <br/>
		gbci.org and LEED Online will also be down at this time. <br/>
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
    	<div id="int-language-dropdown">
    	<?php $languages = language_list('enabled');
        $lang_domain = 'http://'.$_SERVER['SERVER_NAME'];?>
    		<a class="dropdown-trigger" href="">
    		<?php foreach ($languages[1] as $language) {
		    	   	if($language->domain == $lang_domain){
		    			echo '<span class="active-val"><span class="flag flag-sm flag-'.getFlagClasses($language->name).'"></span> '.$language->name.'</span>';
				    }else{
				    	if($language->domain == '' && $_SERVER['SERVER_NAME'] == 'www.usgbc.name')
							echo '<span class="active-val"><span class="flag flag-sm flag-'.getFlagClasses($language->name).'"></span> '.$language->name.'</span>';
					}
			    } ?>
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
    <?php

	    foreach ($languages[1] as $language) {
	    	//if($language->domain == '') $language->domain = 'www.usgbc.name';
	    	if($language->domain == $lang_domain){
	    		echo '<li class="active"><a href="'.$language->domain.'"><span class="flag flag-sm flag-'.getFlagClasses($language->name).'"></span> '.$language->name.'</a></li>';
	    	}else{
	    		if($language->domain == '' && $_SERVER['SERVER_NAME'] == 'www.usgbc.name')
					echo '<li class="active"><a href="http://www.usgbc.name"><span class="flag flag-sm flag-'.getFlagClasses($language->name).'"></span> '.$language->name.'</a></li>';
				elseif($language->domain == '')
					echo '<li><a href="http://www.usgbc.name"><span class="flag flag-sm flag-'.getFlagClasses($language->name).'"></span> '.$language->name.'</a></li>';
				else 
					echo '<li><a href="'.$language->domain.'"><span class="flag flag-sm flag-'.getFlagClasses($language->name).'"></span> '.$language->name.'</a></li>';
	    	}
	    } 
     ?>
    		</ul>	
		</div>
				
      <div id="globalNav">

        <?php if (!empty($global_menu)): ?>
        <div id='mainNav'><?php print $global_menu; ?></div>
        <?php endif; ?>

        <?php if (!empty($utility_menu)): ?>
        <div id='utilityNav'>
         	<?php print preg_replace('/<div class="menu-block-1/','<div style="margin-right: 0;" class="left menu-block-1',$utility_menu,1); ?>
        	<ul class="left signinmenu" style="margin-right: 0;" >
				<li><a href="#"><img src="/assets/loader.gif"></img></a></li>
        	</ul>
        </div>
        	<?php if ($node->type == "resource" && $node->sell_price > 0):?>
	        	<script type="text/javascript">
	        	$(document).ready(function () {
	        		 $(".menu-mlid-1784").removeClass("active-trail");
	        		 $(".menu-mlid-1784 a").removeClass("active-trail");
	        		 $(".menu-mlid-5862").addClass("active-trail");
	        		 $(".menu-mlid-5862 a").addClass("active-trail");
	        	});
	        	</script>
	        <?php endif;?>
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
            <script type="text/javascript">
$(document).ready(function(){

	$("#edit-search-theme-form-1").attr("autocomplete","off");

	$("a.facet-link").mouseover(function () {
		$(this).parent().addClass("active");
	});
	$("a.facet-link").mouseleave(function () {
		$(this).parent().removeClass("active");
	});
		
	$("#edit-search-theme-form-1").live('keyup', function(e){
		console.log($(this).val().length);
		if ($(this).val().length == 0 && e.keyCode != 13){ $(".facet-filter-small").hide(); return;}
		$(".facet-filter-small").show();
		load_facet_pulldown($(this).val());
	});
});

function load_facet_pulldown($term){
	$(".facet-filter-small").load("/facets/pulldown/"+$term.replace(' ','%20'), 
		function (responseText, textStatus, XMLHttpRequest) {
		if (textStatus == "success") {	}
		if (textStatus == "error") {   }
	});
}
</script>
				<div class="mini-search-cover">
              	<div class="mini-search">
              		<div class="mini-search-container">
              			<?php if (!empty($search_box)) print $search_box; ?>
              		</div>
              	</div>
              	<div class="facet-filter-small"><ul><li><a class="facet-link" href"#"></a></li></ul></div>
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
