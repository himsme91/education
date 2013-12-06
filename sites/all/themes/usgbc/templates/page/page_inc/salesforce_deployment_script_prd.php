<?php global $user;
	$email = $user->mail;
?>

<!-- TODO: Add logic to return script based on box -->

<!-- SCRIPT GENERATED FOR WWW.USGBC.NAME -->
<!-- START Salesforce Live Agent Deployment Code: MUST BE PLACED DIRECTLY ABOVE THE CLOSING </BODY> TAG and AFTER/OUTSIDE ALL HTML -->
<script type="text/javascript">
var __ALC_Deployment = 10118;
document.write(unescape("%3Cscript src='"+document.location.protocol+"//depot.liveagentforsalesforce.com/app/js/lt.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<!-- END Salesforce Live Agent Deployment Code -->
<!-- START Salesforce Live Agent Custom Information JavaScript -->
<script type="text/javascript">

/* Replace "Your Value Here" with a hard-coded value or code that will generate a dynamic value */
	_alc.addDetail("Customer Email", "<?php print $email?>", 858);

</script>
<!-- END Salesforce Live Agent Custom Information JavaScript -->