<link href="http://vjs.zencdn.net/4.1/video-js.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" media="screen" href="/sites/all/themes/campaign/lib/css/courses.css">
<link rel="stylesheet" type="text/css" media="screen" href="/sites/all/themes/usgbc/lib/css/section/usgbc-courses.css">
<link href="/sites/all/libraries/videojs/video-js/style-progress.css" rel="stylesheet" type="text/css">
<!-- <script src="http://vjs.zencdn.net/4.1/video.js"></script>
<script src="/sites/all/themes/usgbc/lib/js/section/usgbc-course.js"></script>
 -->
 <script>
$(document).ready(function(){
	$('.progressbar').each(function(){
		var t = $(this),
		dataperc = calculate_perc();
		barperc = Math.round(dataperc*5.56);
		t.find('.bar').animate({width:barperc}, dataperc*25);
	
		function perc() {
			var length = t.find('.bar').css('width'),
			perc = Math.round(parseInt(length)/5.56),
			labelpos = (parseInt(length)-2);
			//alert(Math.round(perc));

			t.find('.label').css('left', labelpos);
			t.find('.label-text').text(perc+'%');
		}
		perc();
		setInterval(perc, 0); 
		
	});

	function calculate_perc(){
		var total = 0;
		var completed = 0;
		$("input[name='quiz\\[\\]']").each(function(){
			total++;
			if(parseInt($(this).val()) == 1){
				completed++;
			}
		});

		$("input[name='progress\\[\\]']").each(function(){
			total++;
			if(parseInt($(this).val()) == 1){
				completed++;
			}
		});
		perc = (completed/total)*100;
		return perc;
	}
});
</script>
<?php 
	global $user;
	if(!$user->uid || $user->uid==0 ) {
		$destination =  $_SERVER['REQUEST_URI'];
		header("Location: /user/login?destination=$destination");
	}
	$uid = $user->uid;
	//dsm($node);
	$user_access = true;
	$is_owner = false;
	$is_subscribed = false;
	
	
	//check if the user is owner
	
	if($node->uid == $uid){
		$user_access = true;
		$is_owner = true;
	}
	else{
		$es_node_id = variable_get('education_subscription',"");
		$es_node = node_load($es_node_id);
		if($node->field_usgbc_course_kind[0]['value'] == "Parent"){
			//use is_child & is_parent variables to check type of course
			$is_parent = true;
			$is_child  = false;
			//checking if the node is subscribed
			$node_subscription = og_subscriber_count_link($node);
			//checking if education subscription is ssubscribed
			$education_subscription = og_subscriber_count_link($es_node);
			//if any one is subscribed, change user access to true
			if($node_subscription[1] == "active" || $education_subscription[1] == "active"){
				//use user_access to check user access throughout the page
				$user_access = true;
				$is_subscribed = true;
				$passed = false;
				$passed_tests = 0;
				$total_tests = 0;
				$child_nodes = array();
				foreach($node->field_usgbc_course_children as $child){
					$child_node = node_load($child['nid']);
					array_push($child_nodes, $child_node);
					$related_test = $child_node->field_usgbc_course_quiz[0]['nid'];
					$test_node = node_load($related_test);
					if($test_node){
						$total_tests++;
						$availability = quiz_availability($test_node);
						$takes = $test_node->takes;
						$qresults = _quiz_get_results($related_test, $user->uid);
						$taken = count($qresults);
						if($takes > $taken || $takes == 0) $cantake = true; else $cantake = false;
						foreach($qresults as $qresult){
							$pass_rate = $qresult['pass_rate'];
							$score = $qresult['score'];
							$scaled_score = usgbc_scaled_score($score);
							$result_id = $qresult['result_id'];
							$pass_date = date('F d, Y', $qresult['time_end']);
							if($score > $pass_rate)
							{
								$passed_tests++;
								break;
							}
						}
					}	
				}
				if($total_tests == $passed_tests && $total_tests != 0){
					$passed = true;
				}
			}
		}
	}
	
	$course_SKU = $node->model;
	
	$product = new stdClass;
	$product->nid = $node->nid;
	$product->price = $node->list_price;
	$price = $product->price;
	$member_price = usgbc_store_get_member_price ($product);
	
?>

<style>


/* CSS for Header sectio to be shown if user is subscribed to a course
*********************************************************************** */

			.main-header{
				margin:30px 20px 0px 20px;
				padding:5px 15px;
			}
			
			.header-box{
				background: linear-gradient(#f5f5f5, #dddddd);
				box-shadow: 0 1px #ffffff inset, 0px 2px 4px rgba(0, 0, 0, 0.2);
				border-radius: 3px;
				padding: 15px;
				position: relative;
				border: 1px solid #999;
				overflow:hidden;
			}
			
			.left-col{
				float: left;
				width: 100%;
			}
			
			.course-image{
				background-image: url('webinar.jpg');
				float: left;
				width: 110px;
				height: 60px;
				border-radius: 3px;
				background-position: center;
				background-size: cover;
				border: 1px solid #282828;
				margin-right: 10px;
				overflow:hidden;
			}
			
			.course-info{
				margin-right: 275px;
				font-family:"Helvetica Neue",arial,helvetica,san-serif !important;
			}
			
			.course-info h1{
				font-size: 18px !important;
				text-shadow: 0 1px #fff;
				line-height: 1.2;
				margin-top: 5px;
				color: #5d951f;
			}
			
			.course-info h2{
				font-size: 15px !important;
				text-shadow: 0 1px #fff;
				color: #5d951f;
				font-style: italic;
				font-weight: normal;
				line-height: 1.2;
				margin-top: 5px;
			}
			
			.right-col {
				position: absolute;
				right: 0px;
				top: 50%;
				margin-top: -17px;
				width: 300px;
			}
			
			.right-col .jumbo-action-button{
				display: inline-block;
				float: left;
				margin-right: 15px;
				font-size:14px;
				padding:8px;
			}
			
/* ********************************************************
			Header CSS ends here */
#body-container{
	background-color:#F4F4F4;
}

#wrapper{
	width:95%;
}

.page-container{
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	font-size: 14px;
	line-height: 20px;
	color: #555555;
	width:100%;
}

.top{
	background-position: center top;
	background: linear-gradient(#f5f5f5, #dddddd);
	box-shadow: 0 1px #ffffff inset, 0px 2px 4px rgba(0, 0, 0, 0.2);
	border-radius: 5px;
	border: 1px solid #999;position: relative;
	z-index: 20;
	margin:10px 30px;
}

.course-display{
	margin: 0 auto;
}

.col-division{
	height: 382px;
	display: table;
	width: 100%;
	margin: 0;
}

.right-col{
	max-width:500px;
}

.left-col{
	padding: 0px 10px;
}

.col{
	display: table-cell;
	vertical-align: middle;
	float: none!important;
}

.main-container{
	font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
	font-size: 14px;
	line-height: 20px;
	color: #555555;
}

.course-image img{
	border: 2px solid #788878;
	border-radius: 5px;
	box-shadow: 0 4px 8px #333333;
	outline: none;
}

.course-title h1{
	color: #ffffff;
	font-weight: bold;
	line-height: 1;
	text-shadow: 0 2px 3px #000000;
	font-size: 38px;
	max-height: 140px;
}

.course-summary{
	font-weight: normal;
	text-align: center;
	color: #000;
	margin-top: 5px;
	text-shadow: 1px 1px 3px #fff;
	font-size: 14px;
	line-height: 1.4;
	max-height: 90px;
}

.course-summary h4{
	font-size:22px !important;
}

.summary{
	margin-top:25px;
}

.course-title, .course-summary{
	text-align: center;
	margin-top: 10px;
	margin-bottom: 10px;
}

.subscribe{
	margin-top:25px;
	text-align:center;
}

.main-content{
	margin: 10px 20px 10px 20px;
	overflow:hidden
}

.left-main{
	float:left;
	width:52%;
	padding:10px 15px;
}

.right-main{
	float:left;
	width:42%;
	padding:10px 15px;
}

.left-item, .right-item{
	overflow: hidden;
	position: relative;
	background: #f2f7ed;
	background: -webkit-linear-gradient(#fcfdfb, #f2f7ed);
	background: -o-linear-gradient(#fcfdfb, #f2f7ed);
	background: -ms-linear-gradient(#fcfdfb, #f2f7ed);
	background: linear-gradient(#fcfdfb, #f2f7ed);
	border-radius: 5px;
	border: 1px solid #999;
	box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
	margin-top: 40px;
}


.left-item .para-head h4, .right-item .para-head h4{
	font-family: 'proxima_nova_rgregular','Montserrat',sans-serif !important;
	border-bottom: 1px solid #c9c9c9;
	margin: 0px;
	background: #e0e0e0;
	background: -webkit-linear-gradient(#ffffff, #e0e0e0);
	background: -o-linear-gradient(#ffffff, #e0e0e0);
	background: -ms-linear-gradient(#ffffff, #e0e0e0);
	background: linear-gradient(#ffffff, #e0e0e0);
	border-radius: 4px 4px 0 0;
	color: #555;
	text-transform: uppercase;
	padding: 10px 15px;
	font-size: 15px;
}

.box#sub-here{
	width:300px;
	margin:15px auto;
}

.course-about{
	padding: 15px 25px;
	line-height: 1.6;
	font-size: 18px;
}

.five-star-title{
	float: left;
	padding: 20px;
}

.five-star{
	float: left;
	margin-left: 30px;
}

.five-star-title .title{
	font-size: 22px;
	font-weight: 600;
	color: #555;
	text-transform: uppercase;
	color: #555;
	font-weight: 600;
}

.leed-credentials{
	text-align:center;
}

.leed-credentials .para-head{
	text-align:left;
}

.leed-credentials .credentials{
	overflow: hidden;
	padding: 10px;
	display: inline-block;
}
	
</style>

<div id="wrapper" class="course-wrapper">
<div class="page-container">
	<div class="main-container">
		
		
		<!-- If the user is not subscribed or not the owner, show POSTER HEAD 
		**********************************************************************-->
	<?php if(!$user_access){?>	
		<div class="top">
			<div class="course-display">
				<div class="col-division">
					<div class="left-col col">
						<div class="course-image">
							<img src="/<?php print $node->field_usgbc_course_feature_image[0]['filepath'];?>" width="480" height="270" />
						</div>
					</div>
					<div class="right-col col">
						<div class="course-info">
							<div class="course-title">
								<h1><?php print $node->title; ?></h1>	
							</div>
							<div class="course-summary">
								<?php print $node->field_usgbc_course_summary[0]['value']; ?>
							</div>
						</div>
						<div class="subscribe">
							<div class="box" id="sub-here">
								<h4><?php print uc_currency_format ($price);?> per year
								</h4>
							   	<form name="add_to_cart" action="/education-subscription/payment" method="post" >
									<a href="" class="jumbo-button-dark" id="btn_register" onclick="document.forms.add_to_cart.submit();return false;">
										Subscribe now
									</a>
									<input type="hidden" name="workshopSKU" value="<?php print $node->nid;?>"/>
								</form>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
	<?php }else{
		
		//else condition to go here ************************************************
		?>
		
		
		<div class="main-header">
			<div class="header-box">
				<div class="left-col">
					<div class="course-image">
						<img alt="" width="108" height="56" src="/<?php print $node->field_usgbc_course_feature_image[0]['filepath'];?>" />
					</div>
					<div class="course-info">
						<h1 class="heading">
							<?php print $node->title;?>
						</h1>
						<?php 
							$owner_node = node_load($node->uid);
							//dsm($owner_node);
						?>
						<h2>by <b>Himanshu Bansal</b></h2>
					</div>
				</div>
				<div class="right-col">
					<?php //if($is_owner){ ?>
						<form name="add_session" action="/node/add/usgbc-course" method="post">
							<input type="hidden" value="Session" name="course_type"/>
							<input type="hidden" value="<?php print $node->nid; ?>" name="parent_nid"/>
						</form>
					
						<a href="/<?php print $node->path;?>/edit" class="jumbo-action-button">Manage</a>
						<a onclick="document.forms.add_session.submit();return false;" class="jumbo-action-button">Add Session</a>
					<?php //} ?>	
				</div>
			</div>	
		</div>
	
		<?php }?>	

		<div class="main-content">
			<div class="left-main">
				<div class="about-section left-item">
						<span class="para-head"><h4>About</h4></span>
					<div class="left-item-content">
						<div class="course-about"><?php print $node->field_usgbc_course_description[0]['value']; ?></div>
					</div>
				</div>
				
				<div class="about-section left-item">
						<span class="para-head"><h4>Sessions</h4></span>
					<div class="left-item-content">
						<?php 
							foreach($child_nodes as $child_node){
						?>		<div class="session-group">
									<div class="session-title">
										<a href="/<?php print $child_node->path?>"><?php print $child_node->title; ?></a>
									</div>
									<div class="session-resources">
						<?php 			?>			
									</div>									
								</div>
						<?php 			
							}							
						?>
					</div>
				</div>
				
			</div>
			<div class="right-main">
				<div class="five-star-widget right-item">
					<div class="five-star-title"><span class="title">Rate This Course:</span></div>
					<div class="five-star">
						<?php print $node->content['fivestar_widget']['#value']; ?>	
					</div>
				</div>
				<div class="leed-credentials right-item">
					<span class="para-head"><h4>LEED Credentials</h4></span>
					<div class="credentials">
						<ul class="crs_certification-list">
							<li class="crs_cert-ap-bdc" title="">LEED AP BD+C</li>
							<li class="crs_cert-ap-idc" title="">LEED AP BD+C</li>						
							<li class="crs_cert-ga" title="">LEED Green Associate</li>
						</ul>	
					</div>
				</div>
				<div class="instructor-block right-item">
					<span class="para-head"><h4>Instructors</h4></span>
					<div class="instructor">
						<?php $leaders = array();
							foreach($child_nodes as $child_node){
								foreach($child_node->field_usgbc_course_leaders as $leader){
									if(! in_array($leader['nid'], $leaders)){
										array_push($leaders, $leader['nid']);
									}
								}
							}	
							foreach($leaders as $person){
								$people_arguments = $people_arguments.$person."+";
							}
							$people_arguments = $people_arguments.";";
							$people_arguments = str_replace("+;","",$people_arguments);
							$view = views_get_view ('Persons');
							$view->set_arguments (array('all','all',$people_arguments));
							$view->set_display ('page_5');
							$view->execute();
							print $view->preview ();
						?>	
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>	
</div>

<div class="course-comment">
	<?php print $rendered_field['body']; ?>
</div>