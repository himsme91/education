<?php global $user;  
    if ($user->uid){
	
		$query = "select * from usgbc_smart_filters where user_id = ".$user->uid." and view_id = '".$_SESSION['vid']."'";
    	
		//Get the smart filter id from the request
		$smartf_id_nav = $_REQUEST['smartfid'];
		//if id not present in the request check the session
		if (!$smartf_id_nav) $smartf_id_nav = $_SESSION[$smartfilterid];

		$menu_items = db_query($query);
		$currenturlnav = explode("?", $_SERVER['REQUEST_URI']);
		if ($menu_items->num_rows > 0) {?>
			<ul class="menu filterNav">
				<li class="last dhtml-menu <?php echo ($smartf_id_nav != "") ? 'expanded' : 'collapsed';?>">
					<a id="dhtml_menu-saved" class="nolink" rel="nofollow" name="nolink" title="Saved searches" href="#">Saved searches</a>
					<ul class="menu saved-searches" style="display: <?php echo ($smartf_id_nav != "") ? 'block' : 'none';?>;">
					<?php while ($menu_item  = db_fetch_object($menu_items)) { ?>
			    			<li class="<?php echo ($smartf_id_nav == $menu_item->filter_id) ? 'active-trail active' : '';?>">
		               			<a href="<?php print $currenturlnav[0];?>?smartfid=<?php print $menu_item->filter_id;?>" class="<?php echo ($smartf_id_nav == $menu_item->filter_id) ? 'active-trail active' : '';?>"><?php print $menu_item->filter_name;?></a>
		              		    <a href="<?php print $currenturlnav[0];?>?smartfid=<?php print $menu_item->filter_id;?>" class="edit-search">edit</a>
		               		</li>
					<?php	} ?>
					</ul>
				</li>
			</ul>	
		<?php }
    } ?>