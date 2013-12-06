<?php 
 global $user; 
 if ($user->uid){
	$person_node = content_profile_load('person', $user->uid);
}

?>

<style type="text/css">
.form-section .control-group > label {
    padding-top: 5px;
  /*   float: left;
    text-align: right;
    width: 140px; */
}

.button-group{
    padding: 14px 0px 15px;
}

.small {
    float: left;
}

.form-section .controls {
   /* margin-left: 200px; */
   margin-top:5px;
}

.form-section .control-group {
    margin-bottom: 11px;
}

.form-section .control-group:after {
    clear: both;
}
.form-section .control-group:before, .form-section .control-group:after {
    content: "";
    display: table;
}
</style>
<SCRIPT type=text/javascript> 

$(document).ready(function() {
	$('.show-registration-form').click(function (e) {
   		$("#success-mess").hide();
	 	$("#error-mess").hide();
	 	$("#txtProjectID").val('');
		$("#txtProjectName").val('');
	 	$("#registration-form").show();		
	});
			
	$('#submit-registration').click(function (e) {
		if(validateRequiredFields()){
			$.ajax({
				type: 'POST',
			    url: '/postSalesforcedata',
			    data: $("#pilot-credit-registration-form").serialize(),
			    complete:  function(xmlHttpRequest, textStatus) {
			    	 //If status is not 2XX
				     if (parseInt(xmlHttpRequest.status) != 0 && parseInt(xmlHttpRequest.status / 100) != 2) {
				    	 $("#error-mess").show();
				    	 $("#success-mess").hide();
				        return;
				     }
				
				     var responseText = null;
				     var calculateDiscountResponse = null;
				     try {
				    	 $("#success-mess").show();
				    	 $("#error-mess").hide();
				    	 $("#registration-form").hide();
				    	 return;
				     }
				     catch (err) {
				    	 $("#error-mess").show();
				    	 $("#success-mess").hide();
				        return;
				     }
			    	 
			    }
			}); 
		}	
		else {
			return false;
		}
	});

});

function validateRequiredFields(){
	var projectnum = document.getElementById("txtProjectID");
	var projectname = document.getElementById("txtProjectName");
	var projectcity = document.getElementById("txtProjectCity");
	var projectstate = document.getElementById("ddlState").options[document.getElementById("ddlState").selectedIndex].value;
	var projectcountry = document.getElementById("ddlCountry").options[document.getElementById("ddlCountry").selectedIndex].value;
	var leedrating = document.getElementById("ddlLEEDRating").options[document.getElementById("ddlLEEDRating").selectedIndex].value;
	var projecttype = document.getElementById("ddlProjectType").options[document.getElementById("ddlProjectType").selectedIndex].value;
	var certlevel = document.getElementById("ddlCertLevel").options[document.getElementById("ddlCertLevel").selectedIndex].value;
	var projectdate = document.getElementById("txtProjectDate");
	var isconf = document.getElementById("chkIsConfidential");
	var plastname = document.getElementById("txtLastName");
	var pfirstname = document.getElementById("txtFirstName");
	var pcompany = document.getElementById("txtOrganization");
	var pphone = document.getElementById("txtPhoneNumber");
	var pemail = document.getElementById("txtEmailAddress");
	var pcredit = "";
    var subject =  document.getElementById("subject");
	
	//var chkCredit1 = document.getElementById("chkCredit1");
	//var chkCredit2 = document.getElementById("chkCredit2");
	var chkCredit3 = document.getElementById("chkCredit3");
	//var chkCredit4 = document.getElementById("chkCredit4");
	var chkCredit7 = document.getElementById("chkCredit7");
	var chkCredit8 = document.getElementById("chkCredit8");
	var chkCredit9 = document.getElementById("chkCredit9");
	var chkCredit10 = document.getElementById("chkCredit10");
	
	//var chkCredit11 = document.getElementById("chkCredit11");
	//var chkCredit12 = document.getElementById("chkCredit12");
	var chkCredit14 = document.getElementById("chkCredit14");
	//var chkCredit15 = document.getElementById("chkCredit15");
	var chkCredit16 = document.getElementById("chkCredit16");
	var chkCredit17 = document.getElementById("chkCredit17");
	var chkCredit18 = document.getElementById("chkCredit18");
	//var chkCredit19 = document.getElementById("chkCredit19");
	var chkCredit21 = document.getElementById("chkCredit21");
	var chkCredit22 = document.getElementById("chkCredit22");
	var chkCredit24 = document.getElementById("chkCredit24");
	//var chkCredit25 = document.getElementById("chkCredit25");
	//var chkCredit26 = document.getElementById("chkCredit26");
	var chkCredit27 = document.getElementById("chkCredit27");
	var chkCredit28 = document.getElementById("chkCredit28");
	//var chkCredit29 = document.getElementById("chkCredit29");
	var chkCredit30 = document.getElementById("chkCredit30");

	//var chkCredit31 = document.getElementById("chkCredit31");
	var chkCredit32 = document.getElementById("chkCredit32");
	//var chkCredit33 = document.getElementById("chkCredit33");
	var chkCredit34 = document.getElementById("chkCredit34");
	//var chkCredit35 = document.getElementById("chkCredit35");
	//var chkCredit36 = document.getElementById("chkCredit36");
	//var chkCredit37 = document.getElementById("chkCredit37");
	var chkCredit38 = document.getElementById("chkCredit38");
	//var chkCredit39 = document.getElementById("chkCredit39");
	//var chkCredit40 = document.getElementById("chkCredit40");
	
	//var chkCredit41 = document.getElementById("chkCredit41");
	//var chkCredit43 = document.getElementById("chkCredit43");
	
	var chkCredit44 = document.getElementById("chkCredit44");
	var chkCredit45 = document.getElementById("chkCredit45");
	//var chkCredit46 = document.getElementById("chkCredit46");
	var chkCredit47 = document.getElementById("chkCredit47");
	//var chkCredit48 = document.getElementById("chkCredit48");
	//var chkCredit49 = document.getElementById("chkCredit49");
	var chkCredit52 = document.getElementById("chkCredit52");
	var chkCredit53 = document.getElementById("chkCredit53");
	//var chkCredit54 = document.getElementById("chkCredit54");
	
	var chkCredit55 = document.getElementById("chkCredit55");
	var chkCredit56 = document.getElementById("chkCredit56");
	var chkCredit57 = document.getElementById("chkCredit57");
	var chkCredit59 = document.getElementById("chkCredit59");
	var chkCredit60 = document.getElementById("chkCredit60");
	var chkCredit61 = document.getElementById("chkCredit61");
	//var chkCredit62 = document.getElementById("chkCredit62");
	var chkCredit63 = document.getElementById("chkCredit63");
	var chkCredit64 = document.getElementById("chkCredit64");
	var chkCredit65 = document.getElementById("chkCredit65");
	var chkCredit66 = document.getElementById("chkCredit66");
	var chkCredit67 = document.getElementById("chkCredit67");
	var chkCredit68 = document.getElementById("chkCredit68");
	var chkCredit69 = document.getElementById("chkCredit69");
	var chkCredit70 = document.getElementById("chkCredit70");
	var chkCredit71 = document.getElementById("chkCredit71");
	var chkCredit72 = document.getElementById("chkCredit72");
	var chkCredit73 = document.getElementById("chkCredit73");
	var chkCredit74 = document.getElementById("chkCredit74");
	var chkCredit75 = document.getElementById("chkCredit75");
	var chkCredit76 = document.getElementById("chkCredit76");
	var chkCredit77 = document.getElementById("chkCredit77");
	var chkCredit78 = document.getElementById("chkCredit78");
	//var chkCredit79 = document.getElementById("chkCredit79");
	var chkCredit80 = document.getElementById("chkCredit80");
	var chkCredit81 = document.getElementById("chkCredit81");
	var chkCredit82 = document.getElementById("chkCredit82");
	var chkCredit83 = document.getElementById("chkCredit83");

	var hprojectnum=document.getElementById("00N40000001n9L0");
	var hprojectname=  document.getElementById("00N40000001n9Lt");
	var hleedrating=document.getElementById("00N40000001nz2o");
	var hprojecttype=  document.getElementById("00N40000001nz2j");
	var hcertlevel=document.getElementById("00N40000001nz20");
	var hprojectdate=  document.getElementById("00N40000001nz25");
	var hisconf =  document.getElementById("00N40000001nz2A");
	var hplastname=  document.getElementById("00N40000001nz2P");
	var hpfirstname = document.getElementById("00N40000001nz2U");
	var hpcompany =  document.getElementById("00N40000001nz2Z");
	var hpphone =  document.getElementById("00N40000001nz2e");
	var hpemail = document.getElementById("00N40000001nz2K");
	var hpcredit = document.getElementById("00N40000001nz2F");
	var email = document.getElementById("email");
		
	var hprojectcity = document.getElementById("00N40000001olvI");
	var hprojectstate = document.getElementById("00N40000001olvN");
	var hprojectcountry = document.getElementById("00N40000001olvS");

    if(!checkNonNull(projectnum)) {
		alert("Please input Project ID.");
		return false;
	}
	        
    if(!isNumeric(projectnum.value)) {
		alert("Invalid Project ID.");
		return false;
    }

	hprojectnum.value = projectnum.value;

    $.ajax({
    	async:false, 
        type: 'POST',
        url: '/getProjectInfo/' + projectnum.value, // Which url should be handle the ajax request. This is the url defined in the <a> html tag
        dataType: 'json', //define the type of data that is going to get back from the server
        data: "js=1",
        complete : function(xmlHttpRequest, textStatus) {
      	  var responseText = null;
  	      var $projectdetails = null;
  	      responseText = xmlHttpRequest.responseText;
  	      $projectdetails = Drupal.parseJson(responseText);
  	      hprojectstate.value = $projectdetails['state'];
  		  hprojectcity.value = $projectdetails['city'];
  		  hprojectcountry.value = $projectdetails['country'];
  		  hleedrating.value = $projectdetails['ratingsystem'];
     
        }
      });

	hprojectname.value = projectname.value;
		
	//hprojectcity.value = projectcity.value;
	//hprojectstate.value = "";//projectstate;
	//hprojectcountry.value = "";//projectcountry;
		
	//hleedrating.value = "";//leedrating;
	hprojecttype.value = "";//projecttype;
	hcertlevel.value = "";//certlevel;
	hprojectdate.value = "";//projectdate.value;
	    
	if (isconf.checked)
		hisconf.value = "";// "Yes";
	else
	    hisconf.value = "";//"No";
        
    hplastname.value = "<?php print $person_node->field_per_lname[0]['value']; ?>" ; //plastname.value;
    hpfirstname.value = "<?php print $person_node->field_per_fname[0]['value']; ?>" ; //pfirstname.value;
    hpcompany.value = "<?php print $person_node->field_per_orgname[0]['value'];?>"; //pcompany.value;
    hpphone.value = "<?php print $person_node->field_per_phone[0]['value'];?>"; //pphone.value;
    hpemail.value = "<?php print $user->mail; ?>" ; //pemail.value;

	if (chkCredit3.checked)
		pcredit = chkCredit3.value;
      
	/*if (chkCredit2.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit2.value;
		else
			pcredit += chkCredit2.value;
	}
				
	if (chkCredit3.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit3.value;
		else
			pcredit += chkCredit3.value;
	}
				
	if (chkCredit4.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit4.value;
		else
			pcredit += chkCredit4.value;
	}*/
					
	if (chkCredit7.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit7.value;
		else
			pcredit += chkCredit7.value;
	}
				
	if (chkCredit8.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit8.value;
		else
			pcredit += chkCredit8.value;
	}
	
	if (chkCredit9.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit9.value;
		else
			pcredit += chkCredit9.value;
	}
				
	if (chkCredit10.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit10.value;
		else
			pcredit += chkCredit10.value;
	}
				
	/*if (chkCredit11.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit11.value;
		else
			pcredit += chkCredit11.value;
	}
			
	if (chkCredit12.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit12.value;
		else
			pcredit += chkCredit12.value;
	}
				
	if (chkCredit13.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit13.value;
		else
			pcredit += chkCredit13.value;
	}*/
				
	if (chkCredit14.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit14.value;
		else
			pcredit += chkCredit14.value;
	}
				
	/*if (chkCredit15.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit15.value;
		else
			pcredit += chkCredit15.value;
	}*/
				
	if (chkCredit16.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit16.value;
		else
			pcredit += chkCredit16.value;
	}
				
	if (chkCredit17.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit17.value;
		else
			pcredit += chkCredit17.value;
	}
				
	if (chkCredit18.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit18.value;
		else
			pcredit += chkCredit18.value;
	}
				
	/*if (chkCredit19.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit19.value;
		else
			pcredit += chkCredit19.value;
	}*/
				
	if (chkCredit21.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit21.value;
		else
			pcredit += chkCredit21.value;
	}
				
	if (chkCredit22.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit22.value;
		else
			pcredit += chkCredit22.value;
	}
				
				
	if (chkCredit24.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit24.value;
		else
			pcredit += chkCredit24.value;
	}
				
	/*if (chkCredit25.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit25.value;
		else
			pcredit += chkCredit25.value;
	}
				
	if (chkCredit26.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit26.value;
		else
			pcredit += chkCredit26.value;
	}*/
				
	if (chkCredit27.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit27.value;
		else
			pcredit += chkCredit27.value;
	}
				
	if (chkCredit28.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit28.value;
		else
			pcredit += chkCredit28.value;
	}
				
	/*if (chkCredit29.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit29.value;
		else
			pcredit += chkCredit29.value;
	}*/
				
	if (chkCredit30.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit30.value;
		else
			pcredit += chkCredit30.value;
	}
				
	/*if (chkCredit31.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit31.value;
		else
			pcredit += chkCredit31.value;
	}*/
				
	if (chkCredit32.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit32.value;
		else
			pcredit += chkCredit32.value;
	}
				
	/*if (chkCredit33.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit33.value;
		else
			pcredit += chkCredit33.value;
	}*/
				
	if (chkCredit34.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit34.value;
		else
			pcredit += chkCredit34.value;
	}
				
	/*if (chkCredit35.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit35.value;
		else
			pcredit += chkCredit35.value;
	}	
	
	if (chkCredit36.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit36.value;
		else
			pcredit += chkCredit36.value;
	}	

	if (chkCredit37.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit37.value;
		else
			pcredit += chkCredit37.value;
	}*/
				
	if (chkCredit38.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit38.value;
		else
			pcredit += chkCredit38.value;
	}
				
	/*if (chkCredit39.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit39.value;
		else
			pcredit += chkCredit39.value;
	}*/
				
	/*if (chkCredit40.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit40.value;
		else
			pcredit += chkCredit40.value;
	}
				
	if (chkCredit41.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit41.value;
		else
			pcredit += chkCredit41.value;
	}*/
				
				
	/*if (chkCredit43.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit43.value;
		else
			pcredit += chkCredit43.value;
	}*/
				
	if (chkCredit44.checked)
	{
	    if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit44.value;
		else
			pcredit += chkCredit44.value;
	}		
				
	if (chkCredit45.checked)
	{
	    if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit45.value;
		else
			pcredit += chkCredit45.value;
	}				
				
	/*if (chkCredit46.checked)
	{
	    if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit46.value;
		else
			pcredit += chkCredit46.value;
	}*/
				
	if (chkCredit47.checked)
	{
	    if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit47.value;
		else
			pcredit += chkCredit47.value;
	}	
				
	/*if (chkCredit48.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit48.value;
		else
			pcredit += chkCredit48.value;
	}	
				
	if (chkCredit49.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit49.value;
		else
			pcredit += chkCredit49.value;
	}*/
				
	if (chkCredit52.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit52.value;
		else
			pcredit += chkCredit52.value;
	}	
				
	if (chkCredit53.checked)
	{
	    if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit53.value;
		else
			pcredit += chkCredit53.value;
	}	
	/*			
	if (chkCredit54.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit54.value;
		else
			pcredit += chkCredit54.value;
	} */
				
	if (chkCredit55.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit55.value;
		else
			pcredit += chkCredit55.value;
	}
				
	if (chkCredit56.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit56.value;
		else
			pcredit += chkCredit56.value;
	}																																																									
        
	if (chkCredit57.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit57.value;
		else
			pcredit += chkCredit57.value;
	}
				   
	if (chkCredit59.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit59.value;
		else
			pcredit += chkCredit59.value;
	}     
				
	if (chkCredit60.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit60.value;
		else
			pcredit += chkCredit60.value;
	}
				
	if (chkCredit61.checked)
	{
	    if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit61.value;
		else
			pcredit += chkCredit61.value;
	}
	/*			
	if (chkCredit62.checked)
	{
	   	if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit62.value;
		else
			pcredit += chkCredit62.value;
	} */
				
	if (chkCredit63.checked)
	{
	   	if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit63.value;
		else
			pcredit += chkCredit63.value;
	}
				
	if (chkCredit64.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit64.value;
		else
			pcredit += chkCredit64.value;
	}
				
	if (chkCredit65.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit65.value;
		else
			pcredit += chkCredit65.value;
	}
				
	if (chkCredit66.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit66.value;
		else
			pcredit += chkCredit66.value;
	}
				
	if (chkCredit67.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit67.value;
		else
			pcredit += chkCredit67.value;
	}

	if (chkCredit68.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit68.value;
		else
			pcredit += chkCredit68.value;
	}
	if (chkCredit69.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit69.value;
		else
			pcredit += chkCredit69.value;
	}
	if (chkCredit70.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit70.value;
		else
			pcredit += chkCredit70.value;
	}
	if (chkCredit71.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit71.value;
		else
			pcredit += chkCredit71.value;
	}
	if (chkCredit72.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit72.value;
		else
			pcredit += chkCredit72.value;
	}
	if (chkCredit73.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit73.value;
		else
			pcredit += chkCredit73.value;
	}
	if (chkCredit74.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit74.value;
		else
			pcredit += chkCredit74.value;
	}
	if (chkCredit75.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit75.value;
		else
			pcredit += chkCredit75.value;
	}
	if (chkCredit76.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit76.value;
		else
			pcredit += chkCredit76.value;
	}
	if (chkCredit77.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit77.value;
		else
			pcredit += chkCredit77.value;
	}
	if (chkCredit78.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit78.value;
		else
			pcredit += chkCredit78.value;
	}
/*	if (chkCredit79.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit79.value;
		else
			pcredit += chkCredit79.value;
	} */
	if (chkCredit80.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit80.value;
		else
			pcredit += chkCredit80.value;
	}
	if (chkCredit81.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit81.value;
		else
			pcredit += chkCredit81.value;
	}
	if (chkCredit82.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit82.value;
		else
			pcredit += chkCredit82.value;
	}
	if (chkCredit83.checked)
	{
		if (pcredit.length > 0)
			pcredit = pcredit + ", " + chkCredit83.value;
		else
			pcredit += chkCredit83.value;
	}
/*
	$('input[type=checkbox]').each(function () {
		
		if(this.attr("id").indexOf("chkCredit") != -1){
			if(this.checked) 
	       		pcredit += (pcredit=="" ? this.val() : "," + this.val());
		}
	});
*/

    hpcredit.value = pcredit;
    email.value = hpemail.value;
        
    subject.value = "Pilot Credit Library Project Registration";
        
	
	if(!checkNonNull(projectname)) {
		alert("Please input Project Name.");
		return false;
	}
        
   /* if(checkNonNull(projectdate) && !validateDate(projectdate)){
		alert("Anticipated Project Completion Date is invalid.");
		return false;
	} 
						
						
	if(!checkNonNull(plastname)) {
		alert("Please input Project Administrator Last Name.");
		return false;
	}
	
	if(!isAlpha(plastname)) {
		alert("Invalid Project Administrator Last Name.");
		return false;
	}
	
	if(!checkNonNull(pfirstname)) {
		alert("Please input Project Administrator First Name.");
		return false;
	}
	
	if(!isAlpha(pfirstname)) {
		alert("Invalid Project Administrator First Name.");
		return false;
	}
	
	if(!checkNonNull(pcompany)) {
		alert("Please input Project Administrator Organization.");
		return false;
	}
	
	if(!isAlpha(pcompany)) {
		alert("Invalid Project Administrator Organization.");
		return false;
	}
	
	if(!checkNonNull(pphone)) {
		alert("Please input Project Administrator Phone Number.");
		return false;
	}
	
	if(!checkNonNull(pemail)) {
		alert("Please input Project Administrator Email Address.");
		return false;
	}
							
	if(!echeck(pemail.value)){
		alert("Invalid Project Administrator Email Address.");
		return false;
	}	*/					
        
    return true;        
}		

function checkNonNull(field){
	if(field==null || field.value=="" || field.value=="--None--"){
		return false;
	}
	return true;
}

function echeck(email) {
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   var address = email;
   if(reg.test(address) == false) {
      //alert('Invalid Email Address');
      return false;
   }
   return true;
}	

function isNumeric(str){
	var re = /[\D]/g
  	if (re.test(str)) return false;
  	return true;
}

// returns true if the string only contains characters A-Z or a-z
function isAlpha(str){
  	var re = /[^a-zA-Z]/g
  	if (re.test(str)) return true;
  	return true;
}
	
</Script>
<?php 
  //Remove Form Element wrapper
  foreach ($form as $k => $v) {
  	if (!is_array($v)) continue;
    if (substr($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
  }
  
  $render_form['country'] = drupal_render($form['country']);
  $render_form['state'] = drupal_render($form['state']);
  $render_form['projecttype'] = drupal_render($form['projecttype']);
  $render_form['ratingsystem'] = drupal_render($form['ratingsystem']);
  $render_form['certificationlevel'] = drupal_render($form['certificationlevel']);
  $render_form['chkconfidential'] = drupal_render($form['chkconfidential']);
  $render_form['chkPilotCreditList'] = drupal_render($form['chkPilotCreditList']);

?>

<?php  if (!$user->uid): ?>
	<h1>Pilot Credit Registration</h1>
	<p><a class="jqm-trigger" href="/user/login?destination=pilot-credit-registration">Sign in</a> to register pilot credits to your LEED project.</p>
<?php else:?>
<div id="error-mess" class="hidden">
<h1 style="color:red;">Error!</h1>
	<p>There was an error while submiting your request. Please try again in sometime. Thank you. <a href="#" class="show-registration-form">Try again</a>.</p>
</div>
<div id="success-mess" class="hidden">
<h1>Success!</h1>
	<p><a href="#" class="show-registration-form">Register more pilot credits</a>. Please look for an email from pilot@usgbc.org confirming your project's pilot credit registration. If you do not receive an email, please contact customer service through <a href="/help">usgbc.org/help</a></p>
</div>
<div id="registration-form">
<h1>Pilot Credit Registration</h1>
<p>Projects may pursue an unlimited number of pilot credits. However points awarded is 
limited by the number of ID/IO credits available (up to 5 for LEED 2009 projects).</p>
		<div class="form-section">
			<h4 class="form-section-head">Your LEED registered project</h4>
				<div class="control-group">
					<label>Project ID</label>
					<div class="controls">
						<input name="txtProjectID" type="text" maxlength="10" id="txtProjectID" class="field"/>
					</div>
				</div>
				<div class="control-group">
					<label>Project name</label>
					<div class="controls">
						<input name="txtProjectName" type="text" id="txtProjectName" class="field"/>
					</div>
				</div>
				<div class="control-group hidden">
					<label title="">Project city</label>
					<div class="controls">
						<input name="txtProjectCity" type="text" id="txtProjectCity" class="field"/>
					</div>
				</div>
				<div class="control-group hidden">
					<label title="">Project state</label>
					<div class="controls">
						<select name="ddlState" id="ddlState">
							<option value="00">Not Available</option>
							<option value="Alabama">Alabama</option>
							<option value="Alaska">Alaska</option>
							<option value="Arizona">Arizona</option>
							<option value="Arkansas">Arkansas</option>
							<option value="California">California</option>
							<option value="Colorado">Colorado</option>
							<option value="Connecticut">Connecticut</option>
							<option value="Delaware">Delaware</option>
							<option value="District Of Columbia">District Of Columbia</option>
							<option value="Florida">Florida</option>
							<option value="Georgia">Georgia</option>
							<option value="Hawaii">Hawaii</option>
							<option value="Idaho">Idaho</option>
							<option value="Illinois">Illinois</option>
							<option value="Indiana">Indiana</option>
							<option value="Iowa">Iowa</option>
							<option value="Kansas">Kansas</option>
							<option value="Kentucky">Kentucky</option>
							<option value="Louisiana">Louisiana</option>
							<option value="Maine">Maine</option>
							<option value="Maryland">Maryland</option>
							<option value="Massachusetts">Massachusetts</option>
							<option value="Michigan">Michigan</option>
							<option value="Minnesota">Minnesota</option>
							<option value="Mississippi">Mississippi</option>
							<option value="Missouri">Missouri</option>
							<option value="Montana">Montana</option>
							<option value="Nebraska">Nebraska</option>
							<option value="Nevada">Nevada</option>
							<option value="New Hampshire">New Hampshire</option>
							<option value="New Jersey">New Jersey</option>
							<option value="New Mexico">New Mexico</option>
							<option value="New York">New York</option>
							<option value="North Carolina">North Carolina</option>
							<option value="North Dakota">North Dakota</option>
							<option value="Ohio">Ohio</option>
							<option value="Oklahoma">Oklahoma</option>
							<option value="Oregon">Oregon</option>
							<option value="Pennsylvania">Pennsylvania</option>
							<option value="Rhode Island">Rhode Island</option>
							<option value="South Carolina">South Carolina</option>
							<option value="South Dakota">South Dakota</option>
							<option value="Tennessee">Tennessee</option>
							<option value="Texas">Texas</option>
							<option value="Utah">Utah</option>
							<option value="Vermont">Vermont</option>
							<option value="Virginia">Virginia</option>
							<option value="Washington">Washington</option>
							<option value="West Virginia">West Virginia</option>
							<option value="Wisconsin">Wisconsin</option>
							<option value="Wyoming">Wyoming</option>
							<option value="American Samoa">American Samoa</option>
							<option value="Guam">Guam</option>
							<option value="Northern Mariana Islands">Northern Mariana Islands</option>
							<option value="Puerto Rico">Puerto Rico</option>
							<option value="U.S. Virgin Islands">U.S. Virgin Islands</option>
							<option value="Alberta">Alberta</option>
							<option value="British Columbia">British Columbia</option>
							<option value="Manitoba">Manitoba</option>
							<option value="New Brunswick">New Brunswick</option>
							<option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
							<option value="Northwest Territories">Northwest Territories</option>
							<option value="Nova Scotia">Nova Scotia</option>
							<option value="Nunavut">Nunavut</option>
							<option value="Ontario">Ontario</option>
							<option value="Prince Edward Island">Prince Edward Island</option>
							<option value="Quebec">Quebec</option>
							<option value="Saskatchewan">Saskatchewan</option>
							<option value="Yukon">Yukon</option>
						</select>
						<?php //print $render_form['state'];?>
					</div>
				</div>
				<div class="control-group hidden">
					<label title="">Project country</label>
					<div class="controls">
						<select name="ddlCountry" id="ddlCountry">
							<option value="USA">USA</option>
							<option value="Afghanistan">Afghanistan</option>
							<option value="Albania">Albania</option>
							<option value="Algeria">Algeria</option>
							<option value="Andorra">Andorra</option>
							<option value="Angola">Angola</option>
							<option value="Anguilla">Anguilla</option>
							<option value="Antarctica">Antarctica</option>
							<option value="Antigua/Barbuda">Antigua/Barbuda</option>
							<option value="Argentina">Argentina</option>
							<option value="Armenia">Armenia</option>
							<option value="Aruba">Aruba</option>
							<option value="Australia">Australia</option>
							<option value="Austria">Austria</option>
							<option value="Azerbaijan">Azerbaijan</option>
							<option value="Bahamas">Bahamas</option>
							<option value="Bahrain">Bahrain</option>
							<option value="Bangladesh">Bangladesh</option>
							<option value="Barbados">Barbados</option>
							<option value="Belarus">Belarus</option>
							<option value="Belgium">Belgium</option>
							<option value="Belize">Belize</option>
							<option value="Benin">Benin</option>
							<option value="Bermuda">Bermuda</option>
							<option value="Bhutan">Bhutan</option>
							<option value="Bolivia">Bolivia</option>
							<option value="Bosnia-Herz.">Bosnia-Herz.</option>
							<option value="Botswana">Botswana</option>
							<option value="Bouvet Islands">Bouvet Islands</option>
							<option value="Brazil">Brazil</option>
							<option value="Brit.Ind.Oc.Ter">Brit.Ind.Oc.Ter</option>
							<option value="Brit.Virgin Is.">Brit.Virgin Is.</option>
							<option value="Brunei Daruss.">Brunei Daruss.</option>
							<option value="Bulgaria">Bulgaria</option>
							<option value="Burkina-Faso">Burkina-Faso</option>
							<option value="Burundi">Burundi</option>
							<option value="Cambodia">Cambodia</option>
							<option value="Cameroon">Cameroon</option>
							<option value="Canada">Canada</option>
							<option value="Cape Verde">Cape Verde</option>
							<option value="Cayman Islands">Cayman Islands</option>
							<option value="Central Afr.Rep">Central Afr.Rep</option>
							<option value="Chad">Chad</option>
							<option value="Chile">Chile</option>
							<option value="China">China</option>
							<option value="Christmas Islnd">Christmas Islnd</option>
							<option value="Coconut Islands">Coconut Islands</option>
							<option value="Colombia">Colombia</option>
							<option value="Comoros">Comoros</option>
							<option value="Congo">Congo</option>
							<option value="Congo">Congo</option>
							<option value="Cook Islands">Cook Islands</option>
							<option value="Costa Rica">Costa Rica</option>
							<option value="Croatia">Croatia</option>
							<option value="Cuba">Cuba</option>
							<option value="Cyprus">Cyprus</option>
							<option value="Czech Republic">Czech Republic</option>
							<option value="Denmark">Denmark</option>
							<option value="Djibouti">Djibouti</option>
							<option value="Dominica">Dominica</option>
							<option value="Dominican Rep.">Dominican Rep.</option>
							<option value="Dutch Antilles">Dutch Antilles</option>
							<option value="East Timor">East Timor</option>
							<option value="Ecuador">Ecuador</option>
							<option value="Egypt">Egypt</option>
							<option value="El Salvador">El Salvador</option>
							<option value="Equatorial Guin">Equatorial Guin</option>
							<option value="Eritrea">Eritrea</option>
							<option value="Estonia">Estonia</option>
							<option value="Ethiopia">Ethiopia</option>
							<option value="Falkland Islnds">Falkland Islnds</option>
							<option value="Faroe Islands">Faroe Islands</option>
							<option value="Fiji">Fiji</option>
							<option value="Finland">Finland</option>
							<option value="France">France</option>
							<option value="Frenc.Polynesia">Frenc.Polynesia</option>
							<option value="French Guyana">French Guyana</option>
							<option value="French S.Territ">French S.Territ</option>
							<option value="Gabon">Gabon</option>
							<option value="Gambia">Gambia</option>
							<option value="Georgia">Georgia</option>
							<option value="Germany">Germany</option>
							<option value="Ghana">Ghana</option>
							<option value="Gibraltar">Gibraltar</option>
							<option value="Greece">Greece</option>
							<option value="Greenland">Greenland</option>
							<option value="Grenada">Grenada</option>
							<option value="Guadeloupe">Guadeloupe</option>
							<option value="Guatemala">Guatemala</option>
							<option value="Guinea">Guinea</option>
							<option value="Guinea-Bissau">Guinea-Bissau</option>
							<option value="Guyana">Guyana</option>
							<option value="Haiti">Haiti</option>
							<option value="Heard/McDon.Isl">Heard/McDon.Isl</option>
							<option value="Honduras">Honduras</option>
							<option value="Hong Kong">Hong Kong</option>
							<option value="Hungary">Hungary</option>
							<option value="Iceland">Iceland</option>
							<option value="India">India</option>
							<option value="Indonesia">Indonesia</option>
							<option value="Iran">Iran</option>
							<option value="Iraq">Iraq</option>
							<option value="Ireland">Ireland</option>
							<option value="Israel">Israel</option>
							<option value="Italy">Italy</option>
							<option value="Ivory Coast">Ivory Coast</option>
							<option value="Jamaica">Jamaica</option>
							<option value="Japan">Japan</option>
							<option value="Jordan">Jordan</option>
							<option value="Kazakhstan">Kazakhstan</option>
							<option value="Kenya">Kenya</option>
							<option value="Kiribati">Kiribati</option>
							<option value="Kosovo">Kosovo</option>
							<option value="Kuwait">Kuwait</option>
							<option value="Kyrgyzstan">Kyrgyzstan</option>
							<option value="Laos">Laos</option>
							<option value="Latvia">Latvia</option>
							<option value="Lebanon">Lebanon</option>
							<option value="Lesotho">Lesotho</option>
							<option value="Liberia">Liberia</option>
							<option value="Libya">Libya</option>
							<option value="Liechtenstein">Liechtenstein</option>
							<option value="Lithuania">Lithuania</option>
							<option value="Luxembourg">Luxembourg</option>
							<option value="Macau">Macau</option>
							<option value="Macedonia">Macedonia</option>
							<option value="Madagascar">Madagascar</option>
							<option value="Malawi">Malawi</option>
							<option value="Malaysia">Malaysia</option>
							<option value="Maldives">Maldives</option>
							<option value="Mali">Mali</option>
							<option value="Malta">Malta</option>
							<option value="Marshall Islnds">Marshall Islnds</option>
							<option value="Martinique">Martinique</option>
							<option value="Mauretania">Mauretania</option>
							<option value="Mauritius">Mauritius</option>
							<option value="Mayotte">Mayotte</option>
							<option value="Mexico">Mexico</option>
							<option value="Micronesia">Micronesia</option>
							<option value="Minor Outl.Isl.">Minor Outl.Isl.</option>
							<option value="Moldavia">Moldavia</option>
							<option value="Monaco">Monaco</option>
							<option value="Mongolia">Mongolia</option>
							<option value="Montenegro">Montenegro</option>
							<option value="Montserrat">Montserrat</option>
							<option value="Morocco">Morocco</option>
							<option value="Mozambique">Mozambique</option>
							<option value="Myanmar">Myanmar</option>
							<option value="Namibia">Namibia</option>
							<option value="Nauru">Nauru</option>
							<option value="Nepal">Nepal</option>
							<option value="Netherlands">Netherlands</option>
							<option value="New Caledonia">New Caledonia</option>
							<option value="New Zealand">New Zealand</option>
							<option value="Nicaragua">Nicaragua</option>
							<option value="Niger">Niger</option>
							<option value="Nigeria">Nigeria</option>
							<option value="Niue Islands">Niue Islands</option>
							<option value="Norfolk Islands">Norfolk Islands</option>
							<option value="North Korea">North Korea</option>
							<option value="Norway">Norway</option>
							<option value="Oman">Oman</option>
							<option value="Pakistan">Pakistan</option>
							<option value="Palau">Palau</option>
							<option value="Panama">Panama</option>
							<option value="Pap. New Guinea">Pap. New Guinea</option>
							<option value="Paraguay">Paraguay</option>
							<option value="Peru">Peru</option>
							<option value="Philippines">Philippines</option>
							<option value="Pitcairn Islnds">Pitcairn Islnds</option>
							<option value="Poland">Poland</option>
							<option value="Portugal">Portugal</option>
							<option value="Qatar">Qatar</option>
							<option value="Reunion">Reunion</option>
							<option value="Romania">Romania</option>
							<option value="Ruanda">Ruanda</option>
							<option value="Russian Fed.">Russian Fed.</option>
							<option value="S. Sandwich Ins">S. Sandwich Ins</option>
							<option value="S.Tome,Principe">S.Tome,Principe</option>
							<option value="San Marino">San Marino</option>
							<option value="Saudi Arabia">Saudi Arabia</option>
							<option value="Senegal">Senegal</option>
							<option value="Serbia">Serbia</option>
							<option value="Seychelles">Seychelles</option>
							<option value="Sierra Leone">Sierra Leone</option>
							<option value="Singapore">Singapore</option>
							<option value="Slovakia">Slovakia</option>
							<option value="Slovenia">Slovenia</option>
							<option value="Solomon Islands">Solomon Islands</option>
							<option value="Somalia">Somalia</option>
							<option value="South Africa">South Africa</option>
							<option value="South Korea">South Korea</option>
							<option value="Spain">Spain</option>
							<option value="Sri Lanka">Sri Lanka</option>
							<option value="St Kitts&amp;Nevis">St Kitts&amp;Nevis</option>
							<option value="St. Helena">St. Helena</option>
							<option value="St. Lucia">St. Lucia</option>
							<option value="St. Vincent">St. Vincent</option>
							<option value="St.Pier,Miquel.">St.Pier,Miquel.</option>
							<option value="Sudan">Sudan</option>
							<option value="Suriname">Suriname</option>
							<option value="Svalbard">Svalbard</option>
							<option value="Swaziland">Swaziland</option>
							<option value="Sweden">Sweden</option>
							<option value="Switzerland">Switzerland</option>
							<option value="Syria">Syria</option>
							<option value="Taiwan">Taiwan</option>
							<option value="Tajikstan">Tajikstan</option>
							<option value="Tanzania">Tanzania</option>
							<option value="Thailand">Thailand</option>
							<option value="Togo">Togo</option>
							<option value="Tokelau Islands">Tokelau Islands</option>
							<option value="Tonga">Tonga</option>
							<option value="Trinidad,Tobago">Trinidad,Tobago</option>
							<option value="Tunisia">Tunisia</option>
							<option value="Turkey">Turkey</option>
							<option value="Turkmenistan">Turkmenistan</option>
							<option value="Turksh Caicosin">Turksh Caicosin</option>
							<option value="Tuvalu">Tuvalu</option>
							<option value="Uganda">Uganda</option>
							<option value="Ukraine">Ukraine</option>
							<option value="United Kingdom">United Kingdom</option>
							<option value="Uruguay">Uruguay</option>
							<option value="Utd.Arab Emir.">Utd.Arab Emir.</option>
							<option value="Uzbekistan">Uzbekistan</option>
							<option value="Vanuatu">Vanuatu</option>
							<option value="Vatican City">Vatican City</option>
							<option value="Venezuela">Venezuela</option>
							<option value="Vietnam">Vietnam</option>
							<option value="Wallis,Futuna">Wallis,Futuna</option>
							<option value="West Sahara">West Sahara</option>
							<option value="Western Samoa">Western Samoa</option>
							<option value="Yemen">Yemen</option>
							<option value="Yugoslavia">Yugoslavia</option>
							<option value="Zambia">Zambia</option>
							<option value="Zimbabwe">Zimbabwe</option>
						</select>
						<?php //print $render_form['country'];?>
					</div>
				</div>
				<div class="control-group hidden">
					<label title="">Rating system</label>
					<div class="controls">
						<select name="ddlLEEDRating" id="ddlLEEDRating">
							<option value="New Construction">New Construction</option>
							<option value="Core and Shell">Core and Shell</option>
							<option value="Schools (NC)">Schools (NC)</option>
							<option value="Commercial Interiors">Commercial Interiors</option>
							<option value="Existing Buildings: Operations and Maintenance">Existing Buildings: Operations and Maintenance</option>
							<option value="Retail (NC)">Retail (NC)</option>
							<option value="Retail (CI)">Retail (CI)</option>
							<option value="Retail (EB)">Retail (EB)</option>
							<option value="Schools (EB) ">Schools (EB)</option>
							<option value="Neighborhood Development">Neighborhood Development</option>
							<option value="Homes Single Family">Homes Single Family</option>
							<option value="Homes Multi-Family Low-Rise">Homes Multi-Family Low-Rise</option>
							<option value="Homes Multi-Family Mid-Rise">Homes Multi-Family Mid-Rise</option>
							<option value="Data Centers (NC)">Data Centers (NC)</option>
							<option value="Data Centers (EB)">Data Centers (EB)</option>
							<option value="Hospitality (NC)">Hospitality (NC)</option>
							<option value="Hospitality (EB)">Hospitality (EB)</option>
							<option value="Warehouses and Distribution Centers (NC)">Warehouses and Distribution Centers (NC)</option>
							<option value="Warehouses and Distribution Centers (EB)">Warehouses and Distribution Centers (EB)</option>
							<option value="Healthcare">Healthcare</option>
						</select>
						<?php //print $render_form['ratingsystem'];?>
					</div>
				</div>
				<div class="control-group hidden">
					<label title="">Project type</label>
					<div class="controls">
						<select name="ddlProjectType" id="ddlProjectType">
							<option value="Core Learning Space: College/University">Core Learning Space: College/University</option>
							<option value="Core Learning Space: K-12, Elementary/Middle School">Core Learning Space: K-12, Elementary/Middle School</option>
							<option value="Core Learning Space: K-12, High School">Core Learning Space: K-12, High School</option>
							<option value="Core Learning Space: Other classroom education">Core Learning Space: Other classroom education</option>
							<option value="Core Learning Space: Preschool/Daycare">Core Learning Space: Preschool/Daycare</option>
							<option value="Datacenter">Datacenter</option>
							<option value="Health Care: Clinic/Other Outpatient">Health Care: Clinic/Other Outpatient</option>
							<option value="Health Care: Inpatient">Health Care: Inpatient</option>
							<option value="Health Care: Nursing Home/ Assisted Living">Health Care: Nursing Home/ Assisted Living</option>
							<option value="Health Care: Outpatient, Office (Diagnostic)">Health Care: Outpatient, Office (Diagnostic)</option>
							<option value="Industrial Manufacturing">Industrial Manufacturing</option>
							<option value="Laboratory">Laboratory</option>
							<option value="Lodging: Dormitory">Lodging: Dormitory</option>
							<option value="Lodging: Hotel/Motel/Resort, Full Service">Lodging: Hotel/Motel/Resort, Full Service</option>
							<option value="Lodging: Hotel/Motel/Resort, Limited Service">Lodging: Hotel/Motel/Resort, Limited Service</option>
							<option value="Lodging: Hotel/Motel/Resort, Select Service">Lodging: Hotel/Motel/Resort, Select Service</option>
							<option value="Lodging: Inn">Lodging: Inn</option>
							<option value="Lodging: Other lodging">Lodging: Other lodging</option>
							<option value="Multi-Family Residential: Apartment">Multi-Family Residential: Apartment</option>
							<option value="Multi-Family Residential: Condominium">Multi-Family Residential: Condominium</option>
							<option value="Office: Administrative/Professional">Office: Administrative/Professional</option>
							<option value="Office: Financial">Office: Financial</option>
							<option value="Office: Government">Office: Government</option>
							<option value="Office: Medical (Non-Diagnostic)">Office: Medical (Non-Diagnostic)</option>
							<option value="Office: Mixed-Use">Office: Mixed-Use</option>
							<option value="Office: Other Office">Office: Other Office</option>
							<option value="Public Assembly: Convention Center">Public Assembly: Convention Center</option>
							<option value="Public Assembly: Entertainment">Public Assembly: Entertainment</option>
							<option value="Public Assembly: Library">Public Assembly: Library</option>
							<option value="Public Assembly: Other Assembly">Public Assembly: Other Assembly</option>
							<option value="Public Assembly: Recreation">Public Assembly: Recreation</option>
							<option value="Public Assembly: Social/Meeting">Public Assembly: Social/Meeting</option>
							<option value="Public Assembly: Stadium/Arena">Public Assembly: Stadium/Arena</option>
							<option value="Public Order and Safety: Fire/Police Station">Public Order and Safety: Fire/Police Station</option>
							<option value="Public Order and Safety: Other Public Order">Public Order and Safety: Other Public Order</option>
							<option value="Religious Worship">Religious Worship</option>
							<option value="Retail: Bank Branch">Retail: Bank Branch</option>
							<option value="Retail: Convenience Store">Retail: Convenience Store</option>
							<option value="Retail: Enclosed Mall">Retail: Enclosed Mall</option>
							<option value="Retail: Fast Food">Retail: Fast Food</option>
							<option value="Retail: Grocery Store/Food Market">Retail: Grocery Store/Food Market</option>
							<option value="Retail: Open Shopping Center">Retail: Open Shopping Center</option>
							<option value="Retail: Other Retail">Retail: Other Retail</option>
							<option value="Retail: Restaurant/Cafeteria">Retail: Restaurant/Cafeteria</option>
							<option value="Retail: Vehicle Dealership">Retail: Vehicle Dealership</option>
							<option value="Single Family Residential">Single Family Residential</option>
							<option value="Service: Other Service">Service: Other Service</option>
							<option value="Service: Post Office/Postal Center">Service: Post Office/Postal Center</option>
							<option value="Service: Repair Shop">Service: Repair Shop</option>
							<option value="Service: Vehicle Service/Repair">Service: Vehicle Service/Repair</option>
							<option value="Service: Vehicle Storage/Maintenance">Service: Vehicle Storage/Maintenance</option>
							<option value="Warehouse and Distribution Center: Non-refrigerated, Distribution/Shipping">Warehouse and Distribution Center: Non-refrigerated, Distribution/Shipping</option>
							<option value="Warehouse and Distribution Center: Refrigerated">Warehouse and Distribution Center: Refrigerated</option>
							<option value="Warehouse and Distribution Center: Self Storage Units">Warehouse and Distribution Center: Self Storage Units</option>
							<option value="Warehouse and Distribution Center: Warehouse">Warehouse and Distribution Center: Warehouse</option>
						</select>
						<?php //print $render_form['projecttype'];?>
					</div>
				</div>
				<div class="control-group hidden">
					<label title="">Certification level</label>
					<div class="controls">
						<select name="ddlCertLevel" id="ddlCertLevel">
							<option value="Certified">Certified</option>
							<option value="Silver">Silver</option>
							<option value="Gold">Gold</option>
							<option value="Platinum">Platinum</option>
						</select>
						<?php //print $render_form['certificationlevel'];?>
					</div>
				</div>	
				<div class="control-group hidden">
					<label title="">Anticipated completion date?<br/><em class="small">(mm/dd/yyyy)</em></label>
					
					<div class="controls">
						<input name="txtProjectDate" type="text" id="txtProjectDate" class="field"/>
					</div>
				</div>
				<div class="control-group hidden">
					<label title="">Is project confidential?</label>
					<div class="controls">
						<input id="chkIsConfidential" type="checkbox" name="chkIsConfidential"/>
						<?php //print $render_form['chkconfidential'];?>
					</div>
				</div>			
		</div>
		<!-- form section -->
		<div class="form-section hidden">
			<h4 class="form-section-head">Project administrator information</h4>
				<div class="control-group">
					<label title="">First name</label>
					<div class="controls">
						<input name="txtFirstName" type="text" id="txtFirstName" class="field"/>
					</div>
				</div>
				<div class="control-group">
					<label title="">Last name</label>
					<div class="controls">
						<input name="txtLastName" type="text" id="txtLastName" class="field"/>
					</div>
				</div>
				<div class="control-group">
					<label title="">Organization</label>
					<div class="controls">
						<input name="txtOrganization" type="text" id="txtOrganization" class="field"/>
					</div>
				</div>
				<div class="control-group">
					<label title="">Phone number</label>
					<div class="controls">
						<input name="txtPhoneNumber" type="text" id="txtPhoneNumber" class="field"/>
					</div>
				</div>
				<div class="control-group">
					<label title="">Email</label>
					<div class="controls">
						<input name="txtEmailAddress" type="text" id="txtEmailAddress" class="field"/>
					</div>
				</div>
			
		</div>
		<!-- form section -->
		<div class="form-section">
			<h4 class="form-section-head">Pilot credit selection</h4>
				<div class="control-group">
					<div class="controls">
						<input type=checkbox id="chkCredit3" value="Pilot Credit 3: Medical and Process Equipment Efficiency"><label style="font-weight:normal;">Pilot Credit 3: Medical and Process Equipment Efficiency</label>
						<input type=checkbox id="chkCredit7" value="Pilot Credit 7: Exterior Lighting"><label style="font-weight:normal;">Pilot Credit 7: Exterior Lighting</label>
						<input type=checkbox id="chkCredit8" value="Pilot Credit 8: EA - Demand Response"><label style="font-weight:normal;">Pilot Credit 8: EA - Demand Response</label>
						<input type=checkbox id="chkCredit9" value="Pilot Credit 9: LT - Street Network"><label style="font-weight:normal;">Pilot Credit 9: LT - Street Network</label>
						<input type=checkbox id="chkCredit10" value="Pilot Credit 10: WE - Sustainable Wastewater Management"><label style="font-weight:normal;">Pilot Credit 10: WE - Sustainable Wastewater Management</label>
						<input type=checkbox id="chkCredit14" value="Pilot Credit 14: LT - Walkable Project Site"><label style="font-weight:normal;">Pilot Credit 14: LT - Walkable Project Site</label>
						<input type=checkbox id="chkCredit16" value="Pilot Credit 16: SS Rainwater Management"><label style="font-weight:normal;">Pilot Credit 16: SS Rainwater Management</label>
						<input type=checkbox id="chkCredit17" value="Pilot Credit 17: WE - Cooling Tower Makeup Water"><label style="font-weight:normal;">Pilot Credit 17: WE - Cooling Tower Makeup Water</label>
						<input type=checkbox id="chkCredit18" value="Pilot Credit 18: WE - Appliance and Process Water Use Reduction"><label style="font-weight:normal;">Pilot Credit 18: WE - Appliance and Process Water Use Reduction</label>
						<input type=checkbox id="chkCredit21" value="Pilot Credit 21: EQ - Low Emitting Interiors"><label style="font-weight:normal;">Pilot Credit 21: EQ - Low Emitting Interiors</label>
						<input type=checkbox id="chkCredit22" value="Pilot Credit 22: EQ - Interior Lighting - Quality"><label style="font-weight:normal;">Pilot Credit 22: EQ - Interior Lighting - Quality</label>
						<input type=checkbox id="chkCredit24" value="Pilot Credit 24: EQ - Acoustic Performance"><label style="font-weight:normal;">Pilot Credit 24: EQ - Acoustic Performance</label>
						<input type=checkbox id="chkCredit27" value="Pilot Credit 27: EA - Reconcile Designed and Actual Energy Performance"><label style="font-weight:normal;">Pilot Credit 27: EA - Reconcile Designed and Actual Energy Performance</label>
						<input type=checkbox id="chkCredit28" value="Pilot Credit 28: IP - Trades Training"><label style="font-weight:normal;">Pilot Credit 28: IP - Trades Training</label>
						<input type=checkbox id="chkCredit30" value="Pilot Credit 30: LT - Alternative Transportation"><label style="font-weight:normal;">Pilot Credit 30: LT - Alternative Transportation</label>
						<input type=checkbox id="chkCredit32" value="Pilot Credit 32: WE - WaterSense for New Homes"><label style="font-weight:normal;">Pilot Credit 32: WE - WaterSense for New Homes</label>
						<input type=checkbox id="chkCredit34" value="Pilot Credit 34: MR - Design for Adaptability"><label style="font-weight:normal;">Pilot Credit 34: MR - Design for Adaptability</label>
						<input type=checkbox id="chkCredit38" value="Pilot Credit 38: EA - Advanced Utility Tracking"><label style="font-weight:normal;">Pilot Credit 38: EA - Advanced Utility Tracking</label>
						<input type=checkbox id="chkCredit44" value="Pilot Credit 44: EQ - Ergonomics Strategy"><label style="font-weight:normal;">Pilot Credit 44: EQ - Ergonomics Strategy</label>
						<input type=checkbox id="chkCredit45" value="Pilot Credit 45: SS - Site Assessment"><label style="font-weight:normal;">Pilot Credit 45: SS - Site Assessment</label>
						<input type=checkbox id="chkCredit47" value="Pilot Credit 47: EQ - Acoustic Comfort"><label style="font-weight:normal;">Pilot Credit 47: EQ - Acoustic Comfort</label>
						<input type=checkbox id="chkCredit52" value="Pilot Credit 52: MR - Material Assessment and Optimization"><label style="font-weight:normal;">Pilot Credit 52: MR - Material Assessment and Optimization</label>
						<input type=checkbox id="chkCredit53" value="Pilot Credit 53: MR - Responsible Sourcing of Raw Materials"><label style="font-weight:normal;">Pilot Credit 53: MR - Responsible Sourcing of Raw Materials</label>
					<!-- <input type=checkbox id="chkCredit54" value="Pilot Credit 54: MR - Avoidance of Chemicals of Concern in Building Materials"><label style="font-weight:normal;">Pilot Credit 54: MR - Avoidance of Chemicals of Concern in Building Materials</label>  -->
						<input type=checkbox id="chkCredit55" value="Pilot Credit 55: SS - Bird Collision Deterrence"><label style="font-weight:normal;">Pilot Credit 55: SS - Bird Collision Deterrence</label>
						<input type=checkbox id="chkCredit56" value="Pilot Credit 56: EA - Renewable Energy-Distributed Generation"><label style="font-weight:normal;">Pilot Credit 56: EA - Renewable Energy-Distributed Generation</label>
						<input type=checkbox id="chkCredit57" value="Pilot Credit 57: EQ - Exterior Noise Control"><label style="font-weight:normal;">Pilot Credit 57: EQ - Exterior Noise Control</label>
						<input type=checkbox id="chkCredit59" value="Pilot Credit 59: EQ - Occupant Engagement"><label style="font-weight:normal;">Pilot Credit 59: EQ - Occupant Engagement</label>
						<input type=checkbox id="chkCredit60" value="Pilot Credit 60: ID - Integrative Process"><label style="font-weight:normal;">Pilot Credit 60: ID - Integrative Process</label>
						<input type=checkbox id="chkCredit61" value="Pilot Credit 61: MR - Material Disclosure and Assessment"><label style="font-weight:normal;">Pilot Credit 61: MR - Material Disclosure and Assessment</label>
					<!-- <input type=checkbox id="chkCredit62" value="Pilot Credit 62: MR - Disclosure of Chemicals of Concern "><label style="font-weight:normal;">Pilot Credit 62: MR - Disclosure of Chemicals of Concern</label>  -->
						<input type=checkbox id="chkCredit63" value="Pilot Credit 63: MR - Whole Building Life Cycle Assessment "><label style="font-weight:normal;">Pilot Credit 63: MR - Whole Building Life Cycle Assessment</label>
						<input type=checkbox id="chkCredit64" value="Pilot Credit 64: SS - Site Improvement Plan "><label style="font-weight:normal;">Pilot Credit 64: SS - Site Improvement Plan</label>
						<input type=checkbox id="chkCredit65" value="Pilot Credit 65: EA - Monitoring Based Commissioning "><label style="font-weight:normal;">Pilot Credit 65: EA - Monitoring Based Commissioning</label>
						<input type=checkbox id="chkCredit66" value="Pilot Credit 66: EA - Community  Contaminant Prevention - Airborne Releases "><label style="font-weight:normal;">Pilot Credit 66: EA - Community Contaminant Prevention - Airborne Releases</label>
						<input type=checkbox id="chkCredit67" value="Pilot Credit 67: Pilot Alternative Compliance Path: EBOM EAp2"><label style="font-weight:normal;">Pilot Credit 67: Pilot Alternative Compliance Path: EBOM EAp2</label>
						<input type=checkbox id="chkCredit68" value="Pilot Credit 68: EQ - Indoor air quality procedure - alternative compliance path"><label style="font-weight:normal;">Pilot Credit 68: EQ - Indoor air quality procedure - alternative compliance path</label>
						<input type=checkbox id="chkCredit69" value="Pilot Credit 69: MR - Construction and demolition waste management"><label style="font-weight:normal;">Pilot Credit 69: MR - Construction and demolition waste management</label>
						<input type=checkbox id="chkCredit70" value="Pilot Credit 70: LT - Green vehicles"><label style="font-weight:normal;">Pilot Credit 70: LT - Green vehicles</label>
						<input type=checkbox id="chkCredit71" value="Pilot Credit 71: EA - Performance of ENERGY STAR For Homes"><label style="font-weight:normal;">Pilot Credit 71: EA - Performance of ENERGY STAR For Homes</label>
						<input type=checkbox id="chkCredit72" value="Pilot Credit 72: EA - Active Solar-Ready Design"><label style="font-weight:normal;">Pilot Credit 72: EA - Active Solar-Ready Design</label>
						<input type=checkbox id="chkCredit73" value="Pilot Credit 73: EA - HVAC Start-Up Credentialing"><label style="font-weight:normal;">Pilot Credit 73: EA - HVAC Start-Up Credentialing</label>
						<input type=checkbox id="chkCredit74" value="Pilot Credit 74: EQ - No Environmental Tobacco Smoke"><label style="font-weight:normal;">Pilot Credit 74: EQ - No Environmental Tobacco Smoke</label>
						<input type=checkbox id="chkCredit75" value="Pilot Credit 75: SS - Clean Construction"><label style="font-weight:normal;">Pilot Credit 75: SS - Clean Construction</label>
						<input type=checkbox id="chkCredit76" value="Pilot Credit 76: MR - Material ingredient reporting"><label style="font-weight:normal;">Pilot Credit 76: MR - Material ingredient reporting</label>
						<input type=checkbox id="chkCredit77" value="Pilot Credit 77: MR - Material ingredient optimization"><label style="font-weight:normal;">Pilot Credit 77: MR - Material ingredient optimization</label>
						<input type=checkbox id="chkCredit78" value="Pilot Credit 78: Design for Active Occupants"><label style="font-weight:normal;">Pilot Credit 78: Design for Active Occupants</label>
					<!-- <input type=checkbox id="chkCredit79" value="Pilot Credit 79: MR - Material ingredients product manufacturer supply chain optimization"><label style="font-weight:normal;">Pilot Credit 79: MR - Material ingredients product manufacturer supply chain optimization</label> -->
						<input type=checkbox id="chkCredit80" value="Pilot Credit 80: MR - Environmentally Preferable Interior Finishes and Furnishings"><label style="font-weight:normal;">Pilot Credit 80: MR - Environmentally Preferable Interior Finishes and Furnishings</label>
						<input type=checkbox id="chkCredit81" value="Pilot Credit 81: IP - Green Training"><label style="font-weight:normal;">Pilot Credit 81: IP - Green Training</label>
						<input type=checkbox id="chkCredit82" value="Pilot Credit 82: SS - Local food production"><label style="font-weight:normal;">Pilot Credit 82: SS - Local food production</label>
						<input type=checkbox id="chkCredit83" value="Pilot Credit 83: SS - Site development - protect or restore habitat - alternative compliance path"><label style="font-weight:normal;">Pilot Credit 83: SS - Site development - protect or restore habitat - alternative compliance path</label>
					</div>
				</div>
		</div>
		<!-- form section -->		
		<div class="form-controls buttons button-group">
			<a href="#" id="submit-registration" class="button">Submit</a>
		</div>
	</div>
<?php endif;?>
<input id="00N40000001sybt0" name="00N40000001sybt" value="Pilot Library" type="hidden">
<input id="recordType" name="recordType" value="0124000000013ir" type="hidden">
<input type="hidden" name="debugEmail" value="jmehta@usgbc.org">
<input name="orgid" type="hidden" value="00D400000009UeD">
<input id="subject" name="subject" type="hidden">
<input id="email" name="email" type="hidden">
<input name="retURL" type="hidden" value="http://www.usgbc.org/DisplayPage.aspx?CMSPageID=2268">
<input type="hidden" id="00N40000001n9L0" maxlength="80" name="00N40000001n9L0" size="20" type="text"/>
<input type="hidden" id="00N40000001n9Lt" maxlength="80" name="00N40000001n9Lt" size="20" type="text"/>
<input id="00N40000001olvI" name="00N40000001olvI" type="hidden"/>
<input id="00N40000001olvN" name="00N40000001olvN" type="hidden"/>
<input id="00N40000001olvS" name="00N40000001olvS" type="hidden"/>
<input type="hidden" id="00N40000001nz2o" maxlength="100" name="00N40000001nz2o" size="20" type="text"/>
<input type="hidden" id="00N40000001nz2j" maxlength="100" name="00N40000001nz2j" size="20" type="text"/>
<input type="hidden" id="00N40000001nz20" maxlength="50" name="00N40000001nz20" size="20" type="text"/>
<input type="hidden" id="00N40000001nz25" name="00N40000001nz25" size="12" type="text"/>
<input type="hidden" id="00N40000001nz2A" maxlength="50" name="00N40000001nz2A" size="20" type="text"/>
<input type="hidden" id="00N40000001nz2U" maxlength="100" name="00N40000001nz2U" size="20" type="text"/>
<input type="hidden" id="00N40000001nz2P" maxlength="100" name="00N40000001nz2P" size="20" type="text"/>
<input type="hidden" id="00N40000001nz2Z" maxlength="100" name="00N40000001nz2Z" size="20" type="text"/>
<input type="hidden" id="00N40000001nz2e" maxlength="50" name="00N40000001nz2e" size="20" type="text"/>
<input type="hidden" id="00N40000001nz2K" maxlength="100" name="00N40000001nz2K" size="20" type="text"/>
<input type="hidden" id="00N40000001nz2F" maxlength="100" name="00N40000001nz2F" size="20" type="text"/>
<input type="hidden" id="external" name="external" value="1"/>

<div class="hidden">
	<?php //print drupal_render($form); ?>
</div>
