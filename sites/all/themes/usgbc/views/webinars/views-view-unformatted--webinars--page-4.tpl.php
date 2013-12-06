<script type="text/javascript">
$(document).ready(function(){
	$('.inner-overlay', this).hide();

	$('.bxslider li').hover(function(){
		$('.inner-overlay', this).show();
	}, function() {
		$('.inner-overlay', this).hide();
	});

});
</script>

<style type="text/css">

.bxslider .inner-overlay {
    background-color: gray;
    opacity: 0.75;
    position: relative;
    top: -35%;
    z-index: 10;
    width:100%;
    height:150px;
    cursor:pointer;
}
.bxslider .inner {
    height:100%;
}

.inner-overlay .title{
	color:#FFF;
	font-size:20px;
	margin-left: 15px;
}  

.inner-overlay h4{
	margin-bottom:10px;
}  
.inner-overlay a.tooltip_link {
    padding-top: 0px;
    position: relative !important;
}  
.inner-overlay .left{
margin-left: 15px;
}
 .inner-overlay .leed-badge{
 margin-left: 85px;
    position: relative;
    margin-bottom: 10px;
 } 

.inner-overlay .meta-item {
    color: #FFFFFF;
    display: block;
    float: left;
    margin-right: 0px;
    text-transform: uppercase;
    width: 125px;
    font-size:13px;
    margin-left: 15px;
}
.inner-overlay .id{
width:125px;
float:left;
}
.inner-overlay .summary{
margin-top: 40px;
margin-left: 15px;
}
.inner-overlay .summary p{
 color: #FFFFFF;
}
.inner-overlay h2 {
    float: left;
    margin-bottom: 15px;
    width: 100px;
    margin-top:0px;
    font-size: 16px;
    color: #FFFFFF;
}
.inner-overlay .provider a {
	font-size:16px;
	color: #A0E8FF;
}
.inner-overlay .summary a {
	color: #A0E8FF;
}
.inner-overlay .provider {
	margin-left:15px;
}
</style>


<ul class="bxslider"> 
<?php foreach ($rows as $id => $row): ?>
	<li><?php print $row; ?></li>
<?php endforeach; ?>
</ul>
