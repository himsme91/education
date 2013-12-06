<?php if ($is_front) {

    $country_code = $_SERVER["HTTP_CF_IPCOUNTRY"];
    if ($country_code == 'CN') {
        header('Location: http://www.usgbc.org/international/chinese');
    }

    $scripts .= '<script type="text/javascript" src="/sites/all/assets/section/home/js/panel-list.js"></script>';
    $scripts .= '<script type="text/javascript" src="/sites/all/assets/section/home/js/scripts-compiled.js"></script>';
    $styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/assets/section/home/css/styles.css" />';
}
?>

<?php
// $Id: page-panel.tpl.php 62997 2013-10-01 15:24:46Z jmehta $
    /**
     * @file
     * USGBC theme
     * Displays a panel page.
     */


    include('page_inc/page_top.php'); ?>


<?php if ($is_front): ?>

<div id="billboard">

    <div class="inner">
      <!--   <div class="homepage-button-group">
            <a href="#home" id="billboard-home">
                <span></span>
                <span></span>
                <span></span>
            </a>

            <a href="#panel-join-us" class="">Join us</a>
       		<a href="#panel-pursue-leed" class="">Pursue LEED</a>  
            <a href="#panel-get-educated" class="">Get educated</a>
            <a href="#panel-take-action" class="">Take action</a>
        </div> --> 
    </div>

</div>

<?php endif; ?>

<?php if ($is_landing_pg): ?>

    <?php print $content; ?>

<?php else: ?>

<div id="content" class="twoColRight">

    <div id='navCol' class='clearfix'>
        <?php if (!empty($section_sub_menu)) print $section_sub_menu; ?>
    </div>

    <?php print $content; ?>

</div><!--content-->

<?php endif; ?>

<?php include('page_inc/page_bottom.php'); ?>
