  <?php if(count($rows) > 0) :?> 
  
  <h3>Also see</h3>
  <?php endif;?>
    <ul class="linelist">
<?php foreach ($rows as $id => $row): ?>
     <li>
    <?php print $row; ?>
	</li>
 <?php endforeach; ?>
</ul>