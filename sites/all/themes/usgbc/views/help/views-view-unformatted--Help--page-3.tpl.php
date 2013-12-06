     <?php list($arg0, $arg1, $arg2) = split('[/]', $_GET['q']);
    //   dsm($arg0);
    // dsm($arg1);

       ?>
				<ul class="menu filterNav">
	<li class="first"><a href="/help/all-topics">View all topics</a></li>
	<?php
	
		//$arg1 = str_replace('-', ' ', $arg1);
		$terms = taxonomy_get_term_by_name(str_replace('-', ' ', $arg1));
		
		if($terms == ''){
			$terms = taxonomy_get_term_by_name($arg1);
		}
		
		foreach($terms as $id => $term):
			if ($term->vid == '55'): break; endif;
		endforeach;
		$parents = taxonomy_get_parents($term->tid);

		$parent = array_shift($parents);
		$children = taxonomy_get_tree('55',$parent->tid);
		foreach($children as $id => $child):
	?>
	<li class="<?php print $child->tid == $term->tid ? 'active-trail active' : "" ?>"><a class="<?php print $child->tid == $term->tid ? 'active-trail active' : "" ?>" href="/help-topic/<?php print str_replace('&','%26',usgbc_dashencode($child->name));?>"><?php print $child->name;?></a></li>
	<?php endforeach;?>
</ul>
</ul>
</div>
            <div id="mainCol">
                <div class="intro padded">

                <?php foreach ($rows as $id => $row): ?>
            	<?php print $row; ?>
            <?php endforeach; ?>

                </div>

                <div class="aside padded">
                	<h5 class="all-caps">Top questions</h5>
                    <ul class="linelist">
                    <?php  $pviewname = 'Help_questions';
					      $pargs = array();
					      $pargs [0] = $term->tid;
					      $pdisplay_id = 'page_1'; // or any other display
					      $pview = views_get_view ($pviewname);
					      $pview->set_display ($pdisplay_id);
					      $pview->set_arguments ($pargs);
					      print $pview->preview ();?>
                    </ul>
                </div>

                 	<?php $related = taxonomy_get_related($term->tid);?>
                 	<?php if($related) {?>
                 	   <div class="padded">
                	<h3>Also see</h3>
                    <ul class="linelist">
                    	<?php foreach($related as $id => $also):?>
                    	<li>
                    	    <a><?php print $also->name;?></a>
                    	    <div>
                                <p><?php print $also->description;?></p>
                            </div>
                        </li>
                      <?php endforeach;?>
                    </ul>
                </div>
                <?php }?>

                <div class="cta-bar">
                    <h3>Can't find what you're looking for?</h3>
                     <a href="/ask-a-question" class="alt-button jqm-form-trigger" data-js-callback="init_ask_question"><span>Ask a Question</span></a>
                </div>
            </div>
