<?php
$node = node_load($fields['nid']->content);
$text = $node->field_all_description_share[0]['value'];
?>

<ul>
			<li>
				<script>function twt_click() {u=location.href;t="<?php print $text.' ';?>";window.open('http://twitter.com/share?url='+encodeURIComponent(u)+'&text='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script>
				<a href="#" onclick="twt_click()" class="sbx-twitter">Share on Twitter</a>
			</li>
			<li>
				<script>function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+u,'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script>
				<a class="sbx-facebook" href="http://www.facebook.com/sharer.php?u=http://www.usgbc.name<?php print $_SERVER['REQUEST_URI'];?>">Share on Facebook</a>
			</li>
			<li>
				<script>function lnk_click() {u=location.href;t=document.title;window.open('http://www.linkedin.com/shareArticle?mini=true&url='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script>
				<a href="http://www.linkedin.com/shareArticle?u=<url>" onclick="return lnk_click()" class="sbx-linkedin" target="_blank">Share on LinkedIn</a>
			</li>
			<li class="hidden">
				<a href="#comments" class="sbx-comments">Comments</a>
				<span class="count"><?php
					print $fields['comment_count']->content;
			?></span>
			</li>
			<li>
			<a class="sbx-email jqm-form-trigger" href="/send-friend/<?php print $fields['nid']->content;?>" class="sbx-email">Send to a friend</a>
			</li>
			<li>
				<a class="sbx-print" href="/dopdf.php?q=/node/<?php print $node->nid;?>&title=<?php print $node->title;?>">Print to PDF</a>
			</li>
			
		</ul>

			
			