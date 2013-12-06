<pre><?php //dsm($rows)?></pre>


<!-- 
<div class="selector" id="uniform-undefined">
<span><?php //print strip_tags($rows[0]);?></span>
 -->

<?php if (count($rows)>1):?>

<select id="dateSelector" >
                           
<?php foreach ($rows as $id => $row):  
        print $row; 
      endforeach; ?>

</select>
<?php else:
        print strip_tags($rows[0]);
      endif;?>


