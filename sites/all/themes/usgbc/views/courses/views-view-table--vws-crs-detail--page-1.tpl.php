<?php
// $Id: views-view-table.tpl.php,v 1.8 2009/01/28 00:43:43 merlinofchaos Exp $
/**
 * @file views-view-table.tpl.php
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $class: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * @ingroup views_templates
 */
?>
<?php 
$path = isset($_GET['q']) ? $_GET['q'] : '<front>';
$link = url($path, array('absolute' => FALSE));
?>
<pre><?php //dsm($rows);?></pre>
<style type="text/css">
div.fivestar-widget-static {
    padding-left: 15px;
}
</style>
<table id="course-list" cellspacing="0">
<thead class="labels">
                        <tr><th scope="col" class="col-name">Name</th>
                        <th scope="col" class="col-level col-sm">Price</th>
                        <th scope="col" class="col-format col-md">When</th>
                        <th scope="col" class="col-rating col-sm">Rating</th>
                        <th scope="col" class="col-leed col-md">LEED-specific</th>
                    </tr></thead>

 <tbody class="results">
 
     <?php foreach ($rows as $count => $row): ?>
        <tr class="result block-link">
            <td class="col-name">
           
             <a href="<?php print $row['path'];?>?workshop_nid=<?php print $row['nid'];?>&return=<?php print $link;?>" class="block-link-src"><?php print $row['title']; ?></a> 
              <span class="course-id">Level <?php print $row['field_crs_level_value'];?> - ID #<?php print $row['field_wrksp_id_value)'] ;?></span>
              
            </td>
            <td class="col-price">
            <?php print $row['list_price'];?>
             </td>
            <td class="col-date">
                <?php if ($row[field_wrksp_startdate_value])  
                {?>
                <span class="date"><?php print $row['field_wrksp_startdate_value'];?></span>
                <span class="time"><?php print $row['field_wrksp_startdate_value_1'];?></span>
                <?php 
                }else{
                    print $row['field_crs_fmt_value'];
                }
                ?>
             </td>
            <td class="col-rating"><?php print $row['value'];?></td>
            <td class="col-leed"><?php print $row['field_crs_leed_value'];?></td>
         </tr>
    <?php endforeach; ?>            
 </tbody>

</table>


