
<?php 
	$currenturl = explode("?", $_SERVER['HTTP_REFERER']);
	//print_r($currenturl[0]);
	if(stristr($currenturl[0], "refund") || stristr($currenturl[0], "cancel") 
	|| stristr($currenturl[0], "pay") || stristr($currenturl[0], "bill") 
	|| stristr($currenturl[0], "return")){
		$customtext = "For expedited processing, please provide your [Order Number] and any other details related to your question.";
		$refund = "refund";
	}else {
		$customtext = "Describe your question";
		$refund = "";
	}
?>

<!--Category-->

<input id="subject" name="subject" type="hidden"/>
<!--Aready signed in Name-->
<input type="hidden"  id="name"  name="name" />
<!--Aready signed in Email-->
<input id="email" name="email" type="hidden" /> 
<input id="debug" name="debug" type="hidden" /> 
<input type="hidden" name="orgid" value="00D400000009UeD"/>
<!--Aready signed in Phone-->
<input type="hidden"  id="phone" name="phone"  />
<!--Signed in name to reach-->
<input type="hidden"  id="00N40000001oJmN"  name="00N40000001oJmN" />
<!--Signed in email to reach-->
<input type="hidden"  id="00N40000001oJmS" name="00N40000001oJmS"  />
<!--Signed in phone to reach-->
<input type="hidden"  id="00N40000001oJmX" name="00N40000001oJmX"  />
<!--Anonymous Name-->
<input type="hidden"  id="00N40000001oJmc"  name="00N40000001oJmc" />
<!--Anonymous Email-->
<input type="hidden"  id="00N40000001oJmh" name="00N40000001oJmh"  />
<!--Anonymous Phone-->
<input type="hidden"  id="00N40000001oJmr" name="00N40000001oJmr"  />
<!--Description-->
<input type="hidden"  id="description" name="description" />
<!--Title-->
<input type="hidden"  id="00N40000001oJnz" name="00N40000001oJnz" /> 
 
    <a class="modal-close jqm-close" href="">Close</a>
 
  <div class="modal-content" id="ask-q-question" style="display: block;">
        <h3 class="modal-title modal-state-question">Ask a question</h3>
	    <div class="element">
            <textarea class="field xlg modal-state-quest"><?php print $customtext;?></textarea>
            <span class="question-validation-label invalid"></span>
        </div>
        
        <div class="element">
            <input class="field modal-state-title" name="" value="Sum it up in a short title (optional)" />
        </div>
        <input id="refundqueue" value="<?php print $refund;?>" type="hidden"/>
        <div class="button-group">
            <a class="button nested-modal" id="ask-q-question-form" href="#">Continue</a>
        </div>
    </div>
    
    
    <!-- ASK QUESTION CONTACT INFO -->
    <div class="modal-content" id="ask-q-contact-form" style="display: none;">
    
        <h3 class="modal-title">Contact information</h3>
        
        <div class="tabs tabbed-box">
            <ul class="tabNavigation">
            	<li class="selected"><a href="#tab-signIn">Sign In</a></li>
            	<li><a href="#tab-postAnon">Post anonymously</a></li>
            </ul>
            
            <div id="tab-signIn" class="aside padded panel displayed">

                <p>Sign in to submit.</p>
                <div id="error-message" style="display:none;">
        			<p class="notification negative">Sorry, unrecognized username or password.</p>
    			</div>
                
                
                <div class="element">
                    <label for="">Email</label>
                    <input class="field sign-in-email" type="text" name="" value="" />
                    <span class="email-val validation-label invalid"></span>
                </div>
                
                <div class="element">
                    <label for="">Password</label>
                    <input class="field sign-in-pass" type="password" name="" value="" />
                    <span class="pass-val validation-label invalid"></span>
                </div>
                
                <div class="button-group">
                    <a href="#" id="ask-q-sign-in" class="button nested-modal ">Sign in &amp; Submit</a>
                </div>
            </div><!-- tab -->    
            <div id="tab-postAnon" class="aside panel hidethis" style="display:none;">
                <p>Please provide the following information so we can reach you.</p>
                
                <div class="element">
                    <label for="">Name</label>
                    <input class="field anonymous-name" type="text" name="" value="" />
                    <span class="name-val validation-label invalid"></span>
                </div>
                
                <div class="element">
                    <label for="">Email</label>
                    <input class="field anonymous-email" type="text" name="" value="" />
                    <span class="mail-val validation-label invalid"></span>
                </div>
                
                <div class="element">
                    <label for="">Confirm email</label>
                    <input class="field anonymous-confirm-email" type="text" name="" value="" />
                    <span class="conf-mail-val validation-label invalid"></span>
                </div>
                
                <div class="element">
                    <label for="">Phone (optional)</label>
                    <input class="field anonymous-phone" type="text" name="" value="" />
                </div>
                
                <div class="wireframe-block hidden" style="height: 40px; background: #eee; border: 1px solid #ccc; margin-bottom: 13px; padding: 10px">captcha</div>
                
                <div class="button-group">
                    <a href="#" id="ask-q-contact-info" class="button nested-modal">Submit</a>
                </div>
            </div><!-- tab -->    
                
        
        
        
        </div><!-- tabs -->
    </div>
    
    <!-- SUCCESS -->
    <div id="ask-q-success" class="modal-content" style="display: none;">
        <h1>Success!</h1>
        <p>We will be in touch with a response.</p>
    </div>   
    
    
    
    
    
    <div class="hidden">
	<?php print drupal_render($form); ?>
	</div>