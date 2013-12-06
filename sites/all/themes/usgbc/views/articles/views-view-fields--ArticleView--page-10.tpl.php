<?php $blank_field = '<div class="field-content">empty</div>'?>
<?php 
//$node = node_load($row->nid);
//dsm($fields);       
$tree= taxonomy_get_tree(2,0,-1,NULL);
// dsm(count($tree)); 

$arg = explode('/', $_GET['q']);
$channel = $view->args[0];

if($arg[1]=="archive" || $arg[1]=="archivelist" || $arg[1]=="grid" || $arg[1]=="searchlist"){
	$landing = 0;
}else{
	$landing = 1;
}

if($arg[1]=="archivelist"){
	$archivelist = 1;
}else{
	$archivelist = 0;
}

?>

<?php if($arg[1]=="archivelist" || !empty($channel) ): ?>

	<h3><?php if($arg[3] != NULL){
                	 print str_replace('-',' ',ucwords($arg[3]));
            	} elseif ($channel != null){
            	    print str_replace('-',' ',ucwords($channel));
            	} else {
            	    print 'All channels';
            	} ?></h3>	
<?php else:?>
  <div id="channel-selector" class="channel-selector">
    <div class="uniform-mini uniform-dark">
    <?php if ($landing == 1):?>
    	<?php if ($arg[1] == NULL){
    		$rsschannel = "all";
    	}else{
    		$rsschannel = usgbc_dashencode($arg[1]);
    	} ?>
        <select id="channel-selector-menu" class="url-menu" >
              <option value="/articles"<?php if ($arg[1] == NULL) echo ' selected="selected"'; ?>>All channels</option>
            <?php
              foreach($tree as $item){
              ?>
              <option value="/articles/<?php echo drupal_urlencode(usgbc_dashencode(strtolower($item->name))); ?>"<?php if ($arg[1] == usgbc_dashencode((string)$item->name)) echo ' selected="selected"'; ?>><?php echo $item->name; ?></option>
              <?
              }
            ?>
        </select>
     <?php else:?>
     	<?php if ($arg[2] == NULL){
    		$rsschannel = "all";
    	}else{
    		$rsschannel = usgbc_dashencode($arg[2]);
    	} ?>
      	<select id="channel-selector-menu" class="url-menu" >
              <option value="/articles/<?php echo drupal_urlencode(usgbc_dashencode($arg[1])); ?>"<?php if ($arg[2] == NULL) echo ' selected="selected"'; ?>>All channels</option>
            <?php
              foreach($tree as $item){
              ?>
              <option value="/articles/<?php echo drupal_urlencode(usgbc_dashencode($arg[1])); ?>/<?php echo drupal_urlencode(usgbc_dashencode(strtolower($item->name))); ?>"<?php if ($arg[2] == usgbc_dashencode((string)$item->name)) echo ' selected="selected"'; ?>><?php echo $item->name; ?></option>
              <?
              }
            ?>
        </select>
     <?php endif;?>
    </div><!-- uniform mini dark -->
  </div><!-- channel-selector -->
<?php endif;?>
   <?php if($arg[1]=="archivelist" || !empty($channel) ): ?>
   <?php else:?>
   		<a target="_blank" title="Subscribe to <?php echo $rsschannel;?>" href="/articles/<?php echo $rsschannel;?>/rss.xml" class="rss-link">Subscribe to this channel</a>
   <?php endif;?>	
<ul class="sort-layout">
  <li<?php if($arg[1]=="archive" || $arg[1]=="archivelist") print ' class="selected"'; ?>>
  <?php if ($landing == 1):?>
      <a title="archive" href="/articles/archive<?php if ($arg[1] != NULL) echo '/'.drupal_urlencode(usgbc_dashencode($arg[1])); ?>">
  <?php else:?>
  
  <?php if($archivelist == 1):?>
  <a title="archive" href="/articles/archive<?php if ($arg[2] != NULL) echo '/'.drupal_urlencode(usgbc_dashencode($arg[3])); ?>">
  <?php else:?>
  <a title="archive" href="/articles/archive<?php if ($arg[2] != NULL) echo '/'.drupal_urlencode(usgbc_dashencode($arg[2])); ?>">
  <?php endif;?>
    
   	 <?php endif;?>
          <strong class="archive">Archive</strong>
      </a>
  </li>
  
  <li<?php if($arg[1]=="grid") print ' class="selected"'; ?>>
   <?php if ($landing == 1):?>
      <a title="grid view" href="/articles/grid<?php if ($arg[1] != NULL) echo '/'.drupal_urlencode(usgbc_dashencode($arg[1])); ?>">
   <?php else:?>
   
     <?php if($archivelist == 1):?>
  <a title="grid view" href="/articles/grid<?php if ($arg[2] != NULL) echo '/'.drupal_urlencode(usgbc_dashencode($arg[3])); ?>">
  <?php else:?>
  <a title="grid view" href="/articles/grid<?php if ($arg[2] != NULL) echo '/'.drupal_urlencode(usgbc_dashencode($arg[2])); ?>">
  <?php endif;?>
  	  
   <?php endif;?>
          <strong class="grid">Grid</strong>
      </a>
  </li>
  <li<?php if($arg[1]!="grid" && $arg[1]!="archivelist" && $arg[1]!="archive") print ' class="selected"'; ?>>
     <?php if ($landing == 1):?>
      <a title="list view" href="/articles<?php if ($arg[1] != NULL) echo '/'.drupal_urlencode(usgbc_dashencode($arg[1])); ?>">
     <?php else:?>
     
       <?php if($archivelist == 1):?>
    <a title="list view" href="/articles<?php if ($arg[2] != NULL) echo '/'.drupal_urlencode(usgbc_dashencode($arg[3])); ?>">
  <?php else:?>
    <a title="list view" href="/articles<?php if ($arg[2] != NULL) echo '/'.drupal_urlencode(usgbc_dashencode($arg[2])); ?>">
  <?php endif;?>
  	
     <?php endif;?> 
    
          <strong class="list">List</strong>
      </a>
  </li>
</ul>


    