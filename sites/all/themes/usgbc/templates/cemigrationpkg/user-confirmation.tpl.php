<?php 
global $user;
if($user->uid > 0){
	$profile = content_profile_load('person', $user->uid);
}
$pkg = $_SESSION['pkg'];
?>

<div>
	<?php if($pkg != "CE"){?>
		<!--   <h3>Thank you for registering for Principles of LEED. You will be contacted with sign in information when the series goes live on November 12, 2012.</h3> -->
		  <h3>Thank you for registering for Principles of LEED. You can access your webinars <a href="http://usgbc.peachnewmedia.com/store/streaming/index.php?loginToken=<?php print $profile->field_per_id[0]['value'];?>" target="_blank">here</a>.</h3>
	<?php }else {?>
		<h3>Thank you for your interest. Please use the following links to register: </h3>
		<a href="http://usgbc.peachnewmedia.com/store/seminar/seminar.php?seminar=15403&loginToken=<?php print $profile->field_per_id[0]['value'];?>" class="more-link" target="_blank" style="font-family: 'helvetica neue', arial; ">Principles250 Series: Principles of LEED for BD+C and ID+C</a><br/>
		<a href="http://usgbc.peachnewmedia.com/store/seminar/seminar.php?seminar=15404&loginToken=<?php print $profile->field_per_id[0]['value'];?>" class="more-link" target="_blank" style="font-family: 'helvetica neue', arial; ">Principles252 Series: Principles of LEED for O+M</a>
	<?php }?> 
</div>