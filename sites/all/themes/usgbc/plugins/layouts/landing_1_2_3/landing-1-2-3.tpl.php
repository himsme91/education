<?php
// $Id: landing-1-2-3.tpl.php 48477 2013-05-22 21:54:07Z pnewswanger $
/**
 * @file
 * Template for a 2 column panel layout.
 *
 * This template provides a two column panel display layout, with
 * each column roughly equal in width.
 *
 * Variables:
 * - $id: An optional CSS id to use for the layout.
 * - $content: An array of content, each item in the array is keyed to one
 *   panel of the layout. This layout supports the following sections:
 *   - $content['left']: Content in the left column.
 *   - $content['right']: Content in the right column.
 */
?>
<div id="content" class="oneCol">
    <div class="landing_1_2_3 fullCol" <?php if (!empty($css_id)) print "id=\"$css_id\""; ?>>
        <?php if (!empty($content['highlighted'])): ?>
            <div id="highlighted">
                <?php print $content['highlighted']; ?>
            </div>
        <?php endif; ?>

        <div class="landing-group-two">

            <div class="landing-two">
                <?php print $content['2-left']; ?>
            </div>

            <div class="landing-two last">
                <?php print $content['2-right']; ?>
            </div>

            <div class="clears"></div>

        </div>


        <div class="landing-group-three">

            <div class="landing-three aside">
                <?php print $content['3-left']; ?>
            </div>

            <div class="landing-three aside">
                <?php print $content['3-middle']; ?>
            </div>

            <div class="landing-three aside last">
                <?php print $content['3-right']; ?>
            </div>

            <div class="clears"></div>

        </div>

        <div class="landing-full aside clear-fix">
            <?php print $content['bottom']; ?>
        </div>

    </div>
</div><!--content-->

