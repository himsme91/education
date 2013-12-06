<?php
// $Id: views-view.tpl.php,v 1.13.2.2 2010/03/25 20:25:28 merlinofchaos Exp $
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
list($a0, $a1, $a2, $a3) = split('[/]', $_GET['q']);
$search_value = ($_GET['keys'] != '') ? $_GET['keys'] : 'Search articles';

$currenturl = explode("?", $_SERVER['REQUEST_URI']);

//<?php echo $currenturl[0];
?>

<?php if ($admin_links): ?>
<div class="<?php print $classes; ?>">
<?php endif; ?>

  <?php if ($admin_links): ?>
    <div class="views-admin-links views-hide">
      <?php print $admin_links; ?>
    </div>
  <?php endif; ?>

<div class="bg-list">  
  <?php if ($header) print $header; ?>

  <?php if ($exposed): ?>
   <div id="events-search" class="jumbo-search">
    	<div class="jumbo-search-container">
    	<?php if (!empty($a2)): ?>
        	<form action="/articles/searchlist/<?php print $a2;?>" method="get">
        <?php else:?>
        	<form action="/articles/searchlist" method="get">
        <?php endif;?>
                <input id="edit-title" type="text" class="jumbo-search-field default" name="keys" value="<?php echo $search_value ; ?>" defaultvalue="Search articles">
                <input type="submit" class="jumbo-search-button" name="" value="Search articles" src="/themes/usgbc/lib/img/search-icon-button.gif">   
            </form>
         </div>
    </div>
    <?php // print $exposed; ?>
    
  <?php endif; ?>

  <?php if ($attachment_before) print $attachment_before; ?>

<div class="search-report aside" >
	<span>

    	<?php echo '<strong>'.number_format($view->total_rows).' </strong>';?>
		<?php echo (intval($view->total_rows) == 1) ? ' result' : ' results'?>
		<?php if ($search_value != 'Search articles') : ?>
			<?php print 'for ';?>
				<strong>
					<?php print $search_value;?>
				</strong>
		<?php endif; ?>
 		in
		<strong><?php 
		//$page_view = views_get_page_view(); // for a page display
		//$arg0 = $page_view->view->args[0];
		if (!empty($a2))
		{
		print_r($a2);
		print(".");
		}
		else 
		{
     		 print_r("All channels.");
		}
		?></strong>
	</span>
</div>


  <?php
  if ($rows){
    print $rows;
  } else {
    print $empty;
  }
  ?>

  <?php if ($pager) print $pager; ?>
  <?php if ($attachment_after) print $attachment_after; ?>
  <?php if ($more) print $more; ?>
  <?php if ($footer) print $footer; ?>
  <?php if ($feed_icon) print $feed_icon; ?>
</div>  

<?php if ($admin_links): ?>
</div> <?php /* class view */ ?>
<?php endif; ?>
