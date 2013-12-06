<?php 
//Remove Form Element wrapper
foreach($form as $k=>$v){
  if(!is_array($v)) continue;
  if(substr($k,0,1) != '#') $form[$k]['#wrapper'] = false;
}

$form['find-co-by-id']['#wrapper'] = false;
$form['find-co-by-name']['#wrapper'] = false;

?>

<?php //var_dump($form);
//dsm($form);
?>
<?php if($form){
//$form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
//$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');	
//print_r($form['form_array']);	
}
?> 
<div class="registration-process">
          
            <h1>Connect to <?php print $_COOKIE['member']['orgname'];?>'s membership account</h1>
            
            
            <div id="mainCol">
                <div class="form">                    
                    
                    <div class="form-section">
                    
                        <h4 class="form-section-head">Account</h4>                    
                        
                        <div class="form-column-set">
                            <div class="form-column">
                                <div class="element">	
                                	<label title="" for="fname-field">First name</label>
                                    <?php
                                    print drupal_render($form['field_per_fname']); ?>
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="element">
                                  <label title="" for="lname-field">Last name</label>
                                   <?php 
                                   print drupal_render($form['field_per_lname']); ?>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-column-set">
                            <div class="form-column">
                                <div class="element">
                                <label title="" for="email-field">Email</label>
                                   <?php 
                                   print drupal_render($form['mail']); ?>
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="element">
                                <label title="" for="email2-field">Email <span class="small">(confirm)</span></label>
                                    <?php
                                    print drupal_render($form['conf_mail']); ?>
                                  
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="form-column-set">
                            <div class="form-column">
                                <div class="element">
                                   <label title="" for="password-field">Password <span class="small">(7 character minimum)</span></label>
                                     <?php 
                                     print drupal_render($form['pass1']); ?>
                                </div>
                            </div>
                            <div class="form-column">
                                <div class="element">
                                   <label title="" for="password2-field">Password <span class="small">(confirm)</span></label>
                                     <?php  
                                     print drupal_render($form['pass2']); ?>
                                </div>
                            </div>
                        </div>
                        
                        
                      <div class="element">
                           <label>Phone</label>
                         <?php 
                            print drupal_render($form['field_per_phone']); ?>
                        </div>      
                    </div><!-- form section -->          
                               
					
                    <div class="form-section">
                        <h4 class="form-section-head">Newsletters</h4>
                        <ul class="inputlist">
                            <li>
                                <label for="">
                                   <?php print drupal_render($form['usgbcupdate']);?>
                                    <span>USGBC Update (monthly)</span>
                                </label>
                            </li>                            
                        </ul>
                    </div>
                    
                    <div class="form-section">
                        <h4 class="form-section-head">Notifications</h4>
                        <ul class="inputlist">
                            <li>
                                <label for="">
                                    <?php print drupal_render($form['fromusgbc']);?>
                                    <span>From USGBC</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="form-section">
                        <h4 class="form-section-head">Terms &amp; conditions</h4>
                        <?php print drupal_render($form['field_legal_accept']); ?>
                    </div>     
                    
                       <div class="form-controls buttons button-group">
                      <?php print drupal_render($form['register']); ?>
                        <a href="/" class="button-note">Cancel</a>
					</div>  
					
                    <div id="norender" class="hidden"><?php //$form['og_reg_key']['#required']=false;
					print drupal_render($form); ?>
					
					</div>
                
                </div>
            </div> 
            
            
            
            <div id="sideCol">
            
                            
            
            </div>
            
            
                   
        </div>
