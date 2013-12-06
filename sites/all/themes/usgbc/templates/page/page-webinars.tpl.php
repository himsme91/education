<?php 
//general courses
$styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/css/section/courses.css" />';

//jCarousel
$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/node/jcarousel/lib/jquery.jcarousel.min.js"></script>';
$styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/node/jcarousel/jcarousel.css" />';
$styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/node/jcarousel/skins/tango/skin.css" />';
$styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/node/jcarousel/skins/ie7/skin.css" />';

//bxslider
$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/node/jquery.bxslider/jquery.bxslider.min.js"></script>';
$styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/node/jquery.bxslider/jquery.bxslider.css" />';

//tooltip
$styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/node/tool-tip/css/tooltips.css" />';
$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/node/tool-tip/js/tooltip.js"></script>';

//webinar related js and css
$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/node/webinar/js/webinar.js"></script>';
$styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/node/webinar/css/webinar.css" />';

?>
<?php include('page_inc/page_top.php'); ?>

<div id="banner-wrapper">
	<div>
		<div class="show-extra-header gradient" id="banner" style="opacity:1;">
			<div id="global-message-banner"></div>
			<div class="banner-bg-wrapper" style="">
				<div class="banner-background">
					<div class="semitransparent-bg"></div>
					<div class="gradient-bg" style="cursor: pointer;"></div>
				</div>
			</div>
			<div class="page-width">
				<div class="header">
					<div class="header-left">
						<a href="/"><img src="/sites/all/themes/usgbc/lib/img/leaf.png" width="85px" height="86px" /></a>
					</div>
					<div id="user-menu">
						<?php global $user;?>
						<?php if($user->uid):?>
							<div class="toggle nav-link"> 
								<a class="text upgrade" href="/account">My account</a>
							</div>
							<div class="toggle nav-link"> 
								<a class="text upgrade" href="/logout?destination=webinars">Sign out</a>
							</div>
						<?php else:?>
							<div class="toggle nav-link"> 
								<a class="jqm-form-trigger text upgrade" href="/user/login?destination=webinars">Sign in</a>
								
							</div>						
						<?php endif;?>
					</div>
					<div id="search-container">
					<!--	<div class="mini-search-cover">
              				<?php if (!empty($search_box)) print $search_box; ?>
           					<div class="facet-filter-small"><ul><li><a class="facet-link" href"#"></a></li></ul></div>
              			</div>
              		 -->
					</div>
				</div>
			</div>
			<div class="extra-header-wrapper">
				<div class="search-bar"></div>
				<div class="filter-bar page-width">
					<div class="left-side"></div>
					<div class="option-filter"></div>
					<div class="filter-ad" id="filter-ad"></div>
				</div>
			</div>
			<div class="shadow">
				<div class="gradient"></div>
				<div class="filter"></div>
			</div>
		</div>
	</div>
</div>

<?php print $content; ?>

<?php include('page_inc/page_bottom.php'); ?>