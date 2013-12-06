<?php 
$currenturl = explode("?", $_SERVER['REQUEST_URI']);
if( strstr($currenturl[1], 'clearfilter') ){
	echo "<form id='smartform' action='".$currenturl[0]."' method='post'>";
} else {
	echo "<form id='smartform' action='".$_SERVER['REQUEST_URI']."' method='post'>";
}?>

<div id="project-filter">
	
	<input type="hidden" id="smartf" name="smartf"></input>
	<input type="hidden" id="smartfiltername" name="smartfiltername"></input>
	<input type="hidden" id="smartfid" name="smartfid"></input>
	<div id="filter-set-small">
	</div>
	<div class="">
		<a id="smartsubmit" class="small-alt-button" onclick="smart_submit();" href="#">Apply</a>
	</div>
	<div class="">
		<a class="add left" style="margin-right: 5px;padding-top: 4px;" href="#" ><span>Add filter</span></a>
	</div>
	<div class="">
		<a class="right" style="margin-right: 5px;padding-top: 4px;" onclick="clear_submit();" href="#">Clear filters</a>
	</div>
</div>
