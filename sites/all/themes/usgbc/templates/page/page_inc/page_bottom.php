<div id="footer">
        
        <div class="footer-menu">
        
            <div id="quickLinksNav">
              <?php if (!empty($footer_menu))  print $footer_menu; ?>
            </div>
            
            <div id="legal">
              <?php if (!empty($legal_menu))  print $legal_menu; ?>
            </div>
            
        </div>
            
        <?php if ($footer || $footer_message): ?>
          <?php print $footer_message; ?>
        	<?php print $footer; ?>
        <?php endif; ?>
          
      </div><!-- end footer -->
        
        
      
    </div><!-- end wrapper -->

  </div><!--body-container-->

  <?php print $closure; ?>
 
 <?php // include ($_SERVER['DOCUMENT_ROOT'].'/sites/all/themes/usgbc/templates/page/page_inc/feedback.php'); ?>
 
 <?php include ($_SERVER['DOCUMENT_ROOT'].'/sites/all/assets/section/private-beta/feedback.php'); ?>

<div id="alerts-container"></div>
<script type="text/javascript" src="/assets/cache.js"></script>	 
</body>
</html>