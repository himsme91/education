<?php //dsm($row);?>
<div class="subCol-row">
  <div class="subCol-cell">
    <h4><?php print $title; ?></h4>
    <ul class="styledlist" style="margin-bottom:10px;">
    	<?php $j = 0;?>
      <?php foreach ($rows as $id => $row): ?>
      	<?php if ($j <= 3):?>
      		<?php print $row; ?>
      		<?php $j = $j + 1;?>
      	<?php else:?>
      		<?php if ($j == 4):?>
      			<li class="extra-links">
                	<ul class="styledlist" style="margin-top:0px;">
      		<?php endif;?>
      		<?php print $row; ?>
      		<?php $j = $j + 1;?>
      	<?php endif;?>
      <?php endforeach; ?>
      <?php if ($j <= 4):?>
      <?php else:?>
      	</ul></li><li class="show-hide-links"><a class="show-extra-links" href="">View all</a></li>
      <?php endif;?>
    </ul>
  </div>
</div>