<?php
// $Id: page-articles.tpl.php 11146 2011-12-21 05:14:11Z jmehta $
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */


$styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/blog.css" />';
$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/channelswitch.js"></script>';


include('page_inc/page_top.php'); ?>
<?php
if ($path_args[1] == "archive" || $path_args[1] == "archivelist" || $path_args[1] == "grid" || $path_args[1] == "searchlist") {
    $landing = 0;
} else {
    $landing = 1;
}
?>
<div id="content">
    <div id="blog" class="fullCol">
        <?php print views_embed_view('ArticleView', 'page_10'); ?>
        <?php if ($landing == 1): ?>
        <?php if (isset($path_args[1])) print views_embed_view('ArticleView', 'page_9', $path_args[1]); ?>
        <?php endif;?>

        <?php print $content; ?>

        <?php if ($path_args[1] != 'grid'): ?>

        <div class="secondary-column">

            <?php if ($path_args[1] != 'searchlist'): ?>
            <div class="padded">
                <div class="mini-search">
                    <div class="mini-search-container">
                        <form action="/articles/searchlist">
                            <input class="mini-search-field default" defaultvalue="Search articles" name="keys" type="text" value="Search articles"/>
                            <input class="mini-search-button" name="" src="/themes/usgbc/lib/img/search-icon-button.gif" type="submit" value="Search"/>&nbsp;
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>


            <?php /* Add additional blocks here */ ?>

            <?php if (isset($path_args[1]) && $path_args[1] == 'archive') print views_embed_view('ArticleView', 'page_7'); ?>
            <?php if (isset($path_args[1]) && $path_args[1] == 'archivelist') print views_embed_view('ArticleView', 'page_7'); ?>
            <?php if (isset($path_args[1]) && $path_args[1] == 'searchlist') print views_embed_view('ArticleView', 'page_7'); ?>

        </div>

        <?php endif; ?>


    </div>
</div><!--content-->


<?php include('page_inc/page_bottom.php'); ?>
