<?php
  // $Id: views-view.tpl.php 11705 2012-01-02 04:48:28Z pkhanna $
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
  //dsm($rows);
?>


<?php if ($admin_links):

  ?>

<div class="<?php print $classes; ?>">
<?php endif; ?>

<?php if ($admin_links): ?>
  <div class="views-admin-links views-hide">
    <?php print $admin_links; ?>
  </div>
  <?php endif; ?>

<?php if ($header) print $header; ?>


  <div id="mainCol">

    <?php if ($exposed): ?>
  <div id="events-search" class="jumbo-search">
                    <div class="jumbo-search-container">
                      <form action="/help/search-results" method="get">
                        <input type="text" class="jumbo-search-field default" name="name" value="Search help" defaultvalue="Search help">
              	        <input type="submit" class="jumbo-search-button" name="" value="Search" src="/themes/usgbc/lib/img/search-icon-button.gif">            
            	        </form>	                    	                    	    
                    </div>
                </div>
    <?php //print $exposed; ?>
    <?php endif; ?>
    <?php if ($attachment_before) print $attachment_before; ?>
    <div class="subCol-wrapper threeCol">
      <?php
      if ($rows) {
        print $rows;
      } else {
        print 'test'; //$empty;
      }
      ?>
    </div>
    <p class="button-group"><br/>
      <a href="/help/all-topics" class="button">View all topics</a>
    </p>

    <div class="tabs tabbed-box">
      <ul class="tabNavigation">
 <!--        <li><a href="#tab-topQuestions">TOP QUESTIONS</a></li>  -->
        <li  class="selected"><a href="#tab-recentlyAdded">RECENTLY ADDED</a></li>
      </ul>
<!--       <div id="tab-topQuestions" class="aside padded displayed">
        <h5></h5>
        <ul class="linelist">
          <?php /* $pviewname = 'Help_questions';
          $pdisplay_id = 'page_1'; // or any other display
          $pview = views_get_view ($pviewname);
          $pview->set_display ($pdisplay_id);
          print $pview->preview ();*/
          ?>
        </ul>
      </div>
 -->
      <div id="tab-recentlyAdded" class="aside padded displayed">
        <h5></h5>
        <ul class="linelist">
          <?php  $pviewname = 'Help_questions';
          $pdisplay_id = 'page_1'; // or any other display
          $pview = views_get_view ($pviewname);
          $pview->set_display ($pdisplay_id);
          print $pview->preview ();
          ?>
        </ul>
      </div>

    </div>

  </div>
<?php if ($pager) print $pager; ?>
<?php if ($attachment_after) print $attachment_after; ?>
<?php if ($more) print $more; ?>
<?php if ($footer) print $footer; ?>
<?php if ($feed_icon) print $feed_icon; ?>

<?php if ($admin_links): ?>
</div> <?php /* class view */ ?>
<?php endif; ?>


