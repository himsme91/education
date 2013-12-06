<!-- Begin course-opener -->
<div id="course-opener" class="standalone clearfix" >
	<div id="thing"></div>
	<!--// Start: Slider -->
	<?php 	$viewname = 'webinars';
			$display_id = 'page_4'; // or any other display
			$view = views_get_view ($viewname);
			$view->set_display ($display_id);
			print $view->preview ();
		?>
	<!--// End: Slider -->
</div>
<!-- End course-opener -->
<div class="container_12" >

	<!-- Begin popular -->
	<div id="popular-courses" class="standalone clearfix" style="z-index:1;">
		<div class="grid_12 hidden">
			<h2 class="left">Popular</h2>
			<ul class="linklist right" style="display:none;">
				<li><a href="">Today</a></li>
				<li><a href="">This week</a></li>
				<li><a href="">All time</a></li>
			</ul>
		</div>
		<?php 
			$viewname = 'webinars';
			$display_id = 'page_2'; // or any other display
			$view = views_get_view ($viewname);
			$view->set_display ($display_id);
			print $view->preview ();
	 	?>
	</div><!-- End popular -->
	
	<div id="courses-promo-blocks" class="standalone clearfix hidden">
		<div class="grid_6">
			<a class="course-callout-promo" id="earning-ce-hours">
				<h4>Earning CE hours has never been so easy.</h4>
				<p>SUBSCRIBE &bull; TEST &bull; WATCH &bull; EARN</p>
			</a>
		</div>
		<div class="grid_6">
			<a class="course-callout-promo" id="share-expertise">
				<h4>Share your expertise with the USGBC Community.</h4>
				<p>Learn how to develop a course</p>
			</a>
		</div>
	</div>
	
	<!-- Begin staff-picked -->
	<div id="staffpicks-courses" class="standalone clearfix" style="z-index:1;">
		<div class="grid_12 hidden">
			<h2 class="left">Staff-Picked</h2>
			<ul class="linklist right" style="display:none;">
				<li><a href="">Today</a></li>
				<li><a href="">This week</a></li>
				<li><a href="">All time</a></li>
			</ul>
		</div>
		<?php 
			$viewname = 'webinars';
			$display_id = 'page_3'; // or any other display
			$view = views_get_view ($viewname);
			$view->set_display ($display_id);
			print $view->preview ();
	 	?>
	</div><!-- end staff-picked -->
	
	<!-- Begin all webinars -->
	<?php if ($rows): ?>
	<div id="staffpicks-courses" class="standalone clearfix" style="z-index:1;">
		<div class="grid_12">
			<h2 class="left">All</h2>
		</div>
		<div id="article-grid-view" class="left">
			<?php print $rows; ?>
			
			<?php if ($pager): ?>
			    <?php print $pager; ?>
			<?php endif; ?>
		</div>
	</div>
	<?php endif; ?>
	<!-- End all webinars -->

</div><!--container-->
