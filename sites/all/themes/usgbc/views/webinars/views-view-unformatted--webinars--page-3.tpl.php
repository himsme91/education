<ul id="second-carousel" class="second-carousel jcarousel-skin-tango">	
<?php foreach ($rows as $id => $row): ?>
			<li>
			    <?php print $row; ?>
			</li>
			<?php $i += 1;?>
		<?php endforeach; ?>
			<li style="display: inline-block;background-color:#F4F4F4;border:none;"><span class="boxShotDivider"></span></li>
</ul>