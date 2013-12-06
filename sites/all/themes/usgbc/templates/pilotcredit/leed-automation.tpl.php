<script type="text/javascript">

$(document).ready(function () {
    // Initialize validation on the entire ASP.NET form
	$('#textarea').autoclear();

	$('#emess').hide();
	$('#smess').hide();
   
	$("#leed-automation-form").validate({
		onsubmit: false
	});
	

	$(".tryagain").click(function (e) {
		$('#emess').hide();
		$('#smess').hide();
		$('.kicker').show();
	});
      
	$("#btnSubmit").click(function (evt) {
		var control = document.getElementById("textarea")
		if(control.value == 'Describe your product and how it relates to LEED'){
			control.value ='';
			$('.error-region').fadeIn();
		}
                  
		var isValid = $("#leed-automation-form").valid();
		
        if (!isValid)
       		evt.preventDefault();
        else{
            $('.error-region').fadeOut();

           	var controlT = document.getElementById("textarea")
            if(controlT.value == 'Describe your product and how it relates to LEED'){
            	$('.error-region').fadeIn();
              	return false;
            }
           	$('html, body').animate({scrollTop:0}, 700);
            $.ajax({
				type: 'POST',
			    url: '/postLeedautomationdata',
			    data: $("#leed-automation-form").serialize(),
			    complete:  function(xmlHttpRequest, textStatus) {
			    	 //If status is not 2XX
				     if (parseInt(xmlHttpRequest.status) != 0 && parseInt(xmlHttpRequest.status / 100) != 2) {
				    	 $("#emess").show();
				    	 $("#smess").hide();
				    	 $('.kicker').hide();
				        return;
				     }
				
				     var responseText = null;
				     var calculateDiscountResponse = null;
				     try {
				    	 $("#smess").show();
				    	 $("#emess").hide();
				    	 $('.kicker').hide();
				    	 $('#textarea').val('Describe your product and how it relates to LEED');
				    	 $('#contactname').val('');
				    	 $('#contacttitle').val('');
				    	 $('#email').val('');
				    	 $('#phone').val('');
				    	 $('#companyname').val('');
				    	 return;
				     }
				     catch (err) {
				    	 $("#emess").show();
				    	 $("#smess").hide();
				    	 $('.kicker').hide();
				        return;
				     }
			    	 
			    }
			}); 
        }

        });
    });
  </script>
<div class="grid">
	<div class="graphic"></div>
	<div class="row">
		<h1 class="slot-0-1-2-3-4">
			LEED Automation partners are connected to over <strong>5&nbsp;terabytes</strong>
			of green building data.
		</h1>
	</div>
	<div class="row">
		<div class="slot-6-7-8-9">
			<div class="success-message" id="smess">
				<p><strong>Thanks for your interest.</strong> We'll be in touch with you shortly. <a href="#" class="tryagain">Request again</a></p>
			</div>
			<div class="error-message" id="emess">
				<p><strong>Thanks for your interest.</strong> There was an issue submitting your request. Please try again in some time. <a href="#" class="tryagain">Request again</a></p>
			</div>
			<div class="kicker">
				<div class="form-section">
					<div class="top">
						<p>Interested in becoming a LEED Automation partner? Tell us about
							your product and we'll contact you with more information about
							the program.</p>
					</div>
					<div class="bottom">
						<label> Contact name</label> <input name="contactname" type="text"
							id="contactname" class="required" /> <label> Contact title</label>
						<input name="contacttitle" type="text" id="contacttitle"
							class="required" /> <label> Email</label> <input name="email"
							type="text" id="email" class="required email" /> <label> Phone</label>
						<input name="phone" type="text" id="phone" class="required" /> <label>
							Company</label> <input name="companyname" type="text"
							id="companyname" class="required" /> <label> Product description</label>
						<textarea name="textarea" rows="2" cols="20" id="textarea"
							class="required">Describe your product and how it relates to LEED</textarea>
						<div class="error-region">
							<p>Please fix your errors</p>
						</div>
						<a href="#" id="btnSubmit" class="button">Submit</a>
						<div class="clear"></div>
					</div>
				</div>
				<div class="info">
					<h2>USGBC's LEED Automation program connects leading technology
						companies to the robust data platform that powers LEED Online and
						a diverse suite of third party applications.</h2>
					<ul>
						<li class="heading">LEED Automation partners* receive</li>
						<li>API authorization</li>
						<li>App Lab presence</li>
						<li>Greenbuild presence</li>
						<li>Roadshow presence</li>
						<li>PR support</li>
					</ul>
					<p class="small">*Partners pay an annual connection fee</p>
				</div>
			</div>
		</div>
	</div>

	<div class="row partners">
		<h2>Current partners</h2>
		<div class="slot-6">
			<a href="http://greengrade.com">Greengrade</a>
			<p>End-to-end LEED process workflow management and collaboration</p>
		</div>
		<div class="slot-7">
			<a href="http://greenwizard.com">GreenWizard</a>
			<p>Product identification, selection, management, modeling and
				documentation</p>
		</div>
		<div class="slot-8">
			<a href="http://comnet.org">New Buildings Institute</a>
			<p>Automated energy model QA and submission</p>
		</div>
		<div class="slot-9">
			<a href="http://sage4buildings.com">ZIA for Buildings</a>
			<p>Web-based, interactive tool for managing sustainability practices</p>
		</div>
	</div>

	<div class="row partners">
		<div class="slot-6">
			<a href="http://iesve.com">IES</a>
			<p>Online LEED project management, automated LEED credit checks,
				sophisticated LEED energy modeling</p>
		</div>
		<div class="slot-7">
			<a href="http://gbig.org">GBIG</a>
			<p>The Green Building Information Gateway (GBIG) is a global
				innovation platform that provides access to data and insights about
				the green dimensions of the built environment.</p>
		</div>
		<div class="slot-8">
			<a href="http://iliv.com">iLiv</a>
			<p>iLiv All-In is the world's first Integrative Process Platform,
				delivering productivity to project participants, know-how
				distribution and process efficiency to domain experts, and project
				success to owners.</p>
		</div>
		<div class="slot-9"></div>
	</div>


	<div class="row partners">
		<div class="slot-6"></div>
		<div class="slot-7"></div>
		<div class="slot-8"></div>
		<div class="slot-9"></div>
	</div>
</div>
<div id="footer" class="container">
	<div class="grid">
		<div class="row footer-wrap">
			<div class="slot-0-1-2-3">
				<h3>About USGBC</h3>
				<p>The U.S. Green Building Council is a 501(c)(3) nonprofit
					community of members, chapters, advocates and practitioners that
					give voice to our commitment to improve human health, support
					economies and protect the environment through green buildings.</p>
				<ul class="plainlist">
					<li><a href="/about">About</a></li>
					<li><a href="/press">Press</a>
					</li>
					<li><a href="contact">Contact</a></li>
					<li><a href="/terms#privacy">Privacy</a>
					</li>
					<li><a href="/terms">Terms</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
