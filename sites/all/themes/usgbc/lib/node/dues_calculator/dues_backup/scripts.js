(function( $ ) {
  $.fn.membership_dues = function(options) {
    
    var settings = {
      'layout' : 'panel',
      'service_url' : '/sites/all/themes/usgbc/lib/node/dues_calculator/dues.json',
      'header': 'What does membership cost?',
      'intro': "Please indicate your company's professional industry category.",
      'hidden_fields' : {
        'cat' : 'hiddenmemcat',
        'subcat' : 'hiddensubcat',
        'size' : 'hiddenrevenue' 
      }
    }
    
    var categories;
    var duesCalc_wrapper;
    var duesCalc;
    
    var status = {
        'current_step' : 0
                
    };
    
    return this.each(function() {
        
        if ( options ) { 
          $.extend( settings, options );
        }
              
        $(this).attr('id','dues-calculator-wrapper');
        duesCalc_wrapper = $(this);
                
        $.ajax({
      
            url: settings.service_url,
            dataType: 'json',
            success: function(data){
              categories = data;
              if(settings.layout == 'panel')  panel_layout();
              if(settings.layout == 'form')  form_layout();
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(errorThrown);  
            }
          
        });
        
        
        
        
        /*************************************
        * PANEL LAYOUT
        **************************************/
        
        function panel_layout(){
          duesCalc_wrapper.append( add_panel_header() );
          duesCalc_wrapper.append('<div id="dues-calculator"></div>');
          duesCalc = $('#dues-calculator');
          duesCalc.append( add_panel(status.current_step) );
          
          $('.nav-head .selected-category a').live('click', function(){
          	 status.cat = null;
          	 status.subcat = null;
          	 status.size = null;
          	 status.current_step = 0;
          	 goto_next_panel();
          	 return false;
          });
          $('.nav-head .selected-subcategory a').live('click', function(){
          	 status.subcat = null;
          	 status.size = null;
          	 status.current_step = 1;
          	 goto_next_panel();
          	 return false;
          });
          $('.nav-head .selected-size a').live('click', function(){
          	 status.size = null;
          	 status.current_step = 2;
    //      	 goto_next_panel();
          	 return false;
          });
          
        }
          
        function add_panel_header(){
            var output = '<div>'
              + '<h3>'+settings.header+'</h3>'
              + '<p>'+settings.intro+'</p>'
              + '</div>';
              
            return output;
        }
            
        function add_panel(panel_id){
          	
          	if (panel_id == 0){
          	
                var catList = $('<ul class="cat-list" />');
                for(var i = 0; i < categories.length; i++){
                	var desc;
                	if(categories[i].description){ desc = ' <small>' + categories[i].description + '</small>' } else { desc = '' };
                	var row = $('<li class="'+i+'"><a href="javascript:;" class="'+categories[i].value+'" rel="'+categories[i].name+'">' + categories[i].name + desc + '</a></li>');
                	$('a',row).click(function(){
                  	 status.cat = {
                  	   'key' : $(this).parent('li').attr('class'),
                  	   'name': $(this).attr('rel'),
                  	   'value': $(this).attr('class')
                  	 }
                  	 status.current_step = 1;
                  	 goto_next_panel();
                  	 return false;
                	});
                  catList.append(row);
                  
                };
                                
                var newPanel = $('<div class="panel" id="cat" />');
                newPanel.append('<div class="calc-head"><p class="instructions"><strong>Step 1:</strong> Select your industry category</p></div>');
                newPanel.append(catList);
                
                return newPanel;
                
          	} else if (panel_id == 1){
                
                var catList = $('<ul class="subcat-list" />');
                
                var subcategories = categories[status.cat.key].subcategories;
                
                for(var i = 0; i < subcategories.length; i++){
                	var desc;
                	if(subcategories[i].description){ desc = ' <small>' + subcategories[i].description + '</small>' } else { desc = '' };
                	var row = $('<li class="'+i+'"><a href="javascript:;" class="'+subcategories[i].value+'" rel="'+subcategories[i].name+'">' + subcategories[i].name + desc + '</a></li>');
                  $('a',row).click(function(){
                  	 status.subcat = {
                  	   'key' : $(this).parent('li').attr('class'),
                  	   'name': $(this).attr('rel'),
                  	   'value': $(this).attr('class')
                  	 }
                  	 status.current_step = 2;
                  	 goto_next_panel();
                  	 return false;
                	});
                  catList.append(row);
                };
                                
                var newPanel = $('<div class="panel" id="subcat" />');
                newPanel.append('<div class="calc-head"><ol class="nav-head"><li class="selected-category"><a href="#cat"><span>Category: </span>' + status.cat.name + '</a></li></ol><p class="instructions"><strong>Step 2:</strong> Select your industry sub-category</p></div>');
                newPanel.append(catList);
                
              	return newPanel;
            
            } else if (panel_id == 2){
                
                var catList = $('<ul class="size-list" />');
                
                var size = categories[status.cat.key].size;
                
                for(var i = 0; i < size.length; i++){
                	var desc;
                	if(size[i].description){ desc = ' <small>' + size[i].description + '</small>' } else { desc = '' };
                	var row = $('<li class="'+i+'"><a href="javascript:;" class="'+size[i].value+'" rel="'+size[i].name+'">' + size[i].name + desc + '</a></li>');
                  $('a',row).click(function(){
                  	 status.size = {
                  	   'key' : $(this).parent('li').attr('class'),
                  	   'name': $(this).attr('rel'),
                  	   'value': $(this).attr('class')
                  	 }
                  	 status.current_step = 3;
    //              	 goto_next_panel();
                  	 return false;
                	});
                  catList.append(row);
                };
                                
                var newPanel = $('<div class="panel" id="size" />');
                newPanel.append('<div class="calc-head"><ol class="nav-head"><li class="selected-category"><a href="#cat"><span>Category: </span>' + status.cat.name + '</a></li><li class="selected-subcategory"><a href="#subcat"><span>Sub-category: </span>' + status.subcat.name + '</a></li></ol><p class="instructions"><strong>Step 3:</strong> Select your Revenue Range</p></div>');
                newPanel.append(catList);
                         
              	return newPanel;
            
            } /*else if(panel_id == 3){
            
                var newPanel = $('<div class="panel" id="val" />');
                newPanel.append('<div class="calc-head"><ol class="nav-head"><li class="selected-category"><a href="#cat"><span>Category: </span>' + status.cat.name + '</a></li><li class="selected-subcategory"><a href="#subcat"><span>Sub-category: </span>' + status.subcat.name + '</a></li><li class="selected-size"><a href="#size"><span>Range: </span>' + status.size.name + '</a></li></ol></div><label for="" class="panel-title">Annual dues</label><h1 class="total-annual-dues">' + categories[status.cat.key].size[status.size.key].dues + '</h1>');
                newPanel.append('<a href="/join-center/member'+build_query_str()+'" class="jumbo-action-button"><span class="arrow">Join Now</span></a>');
                newPanel.append(catList);
                
              	return newPanel;
            
            }*/
               
            
        }
        
        function goto_next_panel(){
          $('.panel', duesCalc).css('position', 'relative').fadeOut(300, function(){ 
        			duesCalc.empty().append( add_panel(status.current_step) );
        			$('.panel', duesCalc).fadeIn(300);
        		});
          
        }
        
        function build_query_str(){
          var output = '?cat='+status.cat.value+'&subcat='+status.subcat.value+'&size='+status.size.value;
          return output;
        }
        
        /*************************************
        * FORM LAYOUT
        **************************************/
        
        
        function form_layout(){
          duesCalc_wrapper.parent('div').prepend( add_form_header() );
          duesCalc_wrapper.append('<div id="dues-calculator"><div class="radio-triplets">');
          duesCalc = $('#dues-calculator .radio-triplets');
          
          
          //pull values from hidden fields          
          status.cat = { 'value' : $('#edit-'+settings.hidden_fields.cat).attr('value') };
          status.subcat = { 'value' : $('#edit-'+settings.hidden_fields.subcat).attr('value') };
          status.size = { 'value' : $('#edit-'+settings.hidden_fields.size).attr('value') };
          status.dues = $('#edit-'+settings.hidden_fields.dues).attr('value');
          if(status.cat.value != '' && status.subcat.value != '' && status.size.value != ''){
          
            status.current_step =2;
            duesCalc.append( add_form_element(0) );
            duesCalc.append( add_form_element(1) );
            duesCalc.append( add_form_element(2) );
            duesCalc.append( add_form_element(3) );
            goto_form_element(status.current_step);
			$("[name=sizeradio]").filter("[value="+status.size.value+"]").attr("checked","checked");
			$("[name=sizeradio]").filter("[value="+status.size.value+"]").uniform();
			
          } else {
            
            duesCalc.append( add_form_element(status.current_step) );
            
          } 
          
          
          $('.nav-head .selected-category a').live('click', function(){
          	 status.cat = null;
          	 status.subcat = null;
          	 status.size = null;
          	 status.current_step = 0;
          	 clear_fields();
          	 $('#subcategory-slide').remove();
          	 $('#size-slide').remove();
          	 $('#dues-result').remove();
          	 $("#category-slide select").val("default").keyup();
          	 goto_form_element(status.current_step);
          	 return false;
          });
          $('.nav-head .selected-subcategory a').live('click', function(){
          	 status.subcat = null;
          	 status.size = null;
          	 status.current_step = 1;
          	 clear_fields();
          	 $('#size-slide').remove();
          	 $('#dues-result').remove();
          	 $("#subcategory-slide select").val("default").keyup();
          	 goto_form_element(status.current_step);
          	 return false;
          });
          $('.nav-head .selected-size a').live('click', function(){
          	 status.size = null;
          	 status.current_step = 2;
          	 clear_fields();
          	 $('#dues-result').remove();
  //        	 goto_form_element(status.current_step);
          	 return false;
          });
          
        }

         
        function add_form_header(){
            var output = ''
              + '<h4 class="label">'+settings.header+'</h4>'
              + '<p class="clears">'+settings.intro+'</p>'
              + '';
              
            return output;
        }
        
        function add_form_element(element_id){
          	
          	if (element_id == 0){
          	
                var elementList = $('<select id="cat" name="cat"><option value="default">Select a category</option></select>');
                                
                for(var i = 0; i < categories.length; i++){
                	var option = $('<option class="'+i+'" value="'+categories[i].value+'">'+categories[i].name+'</option>');
                	elementList.append(option);
                  
                  if(status.cat != null && categories[i].value == status.cat.value){
                    status.cat = {
                      'key' : i,
                      'name': categories[i].name,
                      'value': status.cat.value
                    }
                  }
                  
                };
                                
                elementList.change(function(){
                    status.cat = {
                      'key' : $('option:selected',this).attr('class'),
                      'name': $('option:selected',this).text(),
                      'value': $(this).val()
                    }
                    status.current_step = 1;
                    duesCalc.append( add_form_element(status.current_step) );
                    goto_form_element(status.current_step);
                    return false;
              	    
              	});
                                
                var newPanel = $('<div id="category-slide" class="element conditional-item triplet-panel">');
                newPanel.append('<label class="panel-title" id="industry-category">Category</label>');
                newPanel.append(elementList);
                $('.uniform, .checkbox, .radio, select, input[type="radio"], input[type="checkbox"], input[type="file"]', newPanel).uniform();
                
                return newPanel;
                
          	} else if (element_id == 1){
                
                var elementList = $('<select id="subcat" name="subcat"><option value="default">Select a sub-category</option></select>');
                
                var subcategories = categories[status.cat.key].subcategories;
                                
                for(var i = 0; i < subcategories.length; i++){
                	var option = $('<option class="'+i+'" value="'+subcategories[i].value+'">'+subcategories[i].name+'</option>');
                	elementList.append(option);
                	
                	if(status.subcat != null && subcategories[i].value == status.subcat.value){
                    status.subcat = {
                      'key' : i,
                      'name': subcategories[i].name,
                      'value': status.subcat.value
                    }
                  }
                  
                  
                };
                          
                elementList.change(function(){
                    status.subcat = {
                      'key' : $('option:selected',this).attr('class'),
                      'name': $('option:selected',this).text(),
                      'value': $(this).val()
                    }
                    status.current_step = 2;
                    duesCalc.append( add_form_element(status.current_step) );
                    goto_form_element(status.current_step);
                    return false;
              	    
              	});     
                                
                var newPanel = $('<div id="subcategory-slide" class="element conditional-item triplet-panel" />');
                newPanel.append('<ol class="nav-head"><li class="selected-category"><a href="#category-slide">Category:</a> <span style="margin-right:5px;">' + status.cat.name + '</span></li></ol>');
                newPanel.append(elementList);
                $('.uniform, .checkbox, .radio, select, input[type="radio"], input[type="checkbox"], input[type="file"]', newPanel).uniform();
                
                return newPanel;
            
            } else if (element_id == 2){
                
                var elementList = $('<ul class="inputlist radiolist columnlist">');
                
                var size = categories[status.cat.key].size;
                var changedName = "Size";
                for(var i = 0; i < size.length; i++){
                	var str=size[i].name;
                	if(changedName == "Size"){
                	if(str.indexOf("$") !== -1) {
                		   //alert(str);
                		   changedName = "Revenue";
                		}
                	else
                		{
                		changedName="Size";
                		}
                	}
                	var option = $('<li class="'+i+'"><label><input class="radio" type="radio" name="sizeradio" value="'+size[i].value+'" /><span class="label-text">'+size[i].name+'</span></label></li>');
                  $('input', option).click(function(){
                  	 status.size = {
                  	   'key' : $(this).parents('li').attr('class'),
                  	   'name': $(this).attr('name'),
                  	   'value': $(this).attr('value')
                  	 }
                  	 status.current_step = 9;
                  	 duesCalc.append( add_form_element(status.current_step) );                  	 
       //           	 goto_form_element(status.current_step);
                  	 return false;
                	});
                  elementList.append(option);
                  
                  if(status.size != null && size[i].value == status.size.value){
                    status.size = {
                      'key' : i,
                      'name': size[i].name,
                      'value': status.size.value
                    }
                  }
                  
                };
                                
                var newPanel = $('<div id="size-slide" class="element triplet-panel" />');
                newPanel.append('<ol class="nav-head"><li class="selected-category"><a href="#category-slide">Category:</a> <span style="margin-right:5px;">' + status.cat.name + '</span></li><li class="selected-subcategory"><a href="#subcategory-slide">Sub-category:</a> <span style="margin-right:5px;">' + status.subcat.name + '</span></li></ol>');
                newPanel.append('<label class="panel-title" for="">'+changedName+'</label>');
                newPanel.append(elementList);
                $('.uniform, .checkbox, .radio, select, input[type="radio"], input[type="checkbox"], input[type="file"]', newPanel).uniform();
                         
                  	return newPanel;
            
            } else if(element_id == 3){
                
                status.dues = categories[status.cat.key].size[status.size.key].dues;
                
                var newPanel = $('<div id="dues-result" class="element triplet-panel triplet-panel-slim">');
                newPanel.append('<ol class="nav-head"><li class="selected-category"><a href="#category-slide">Category:</a> <span style="margin-right:5px;">' + status.cat.name + '</span></li><li class="selected-subcategory"><a href="#subcategory-slide">Sub-category:</a> <span style="margin-right:5px;">' + status.subcat.name + '</span></li><li class="selected-size"><a href="#size">Range: </a> <span style="margin-right:5px;">' + status.size.name + '</span></li></ol><label for="" class="panel-title">Annual dues</label><h1 class="total-annual-dues">' + status.dues + '</h1>');
                newPanel.append(elementList);
                
                $('#edit-'+settings.hidden_fields.cat).val(status.cat.value);
                $('#edit-'+settings.hidden_fields.subcat).val(status.subcat.value);
                $('#edit-'+settings.hidden_fields.size).val(status.size.value);
     
              	return newPanel;
            
            }
               
            
        }
        
        function goto_form_element(n){
        
            duesCalc.animate({marginLeft: (-594 * n)}, 200);         
          
        }
        
        function clear_fields(){
          $('#edit-'+settings.hidden_fields.cat).val('');
          $('#edit-'+settings.hidden_fields.subcat).val('');
          $('#edit-'+settings.hidden_fields.size).val('');
//          $('#edit-'+settings.hidden_fields.dues).val('');
//          $('#payment-total').empty();
//          $('#edit-discountcode').val('');
        }
         
         
         
      
    });
    
    
  }
    

})( jQuery );


$(document).ready(function(){
  $('.section-community #dues-calculator').membership_dues();
  $('.form-element #dues-calculator').membership_dues({
        'layout':'form',
        'header':'Industry category'
      });
});
