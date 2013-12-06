    $(document).ready(function(){
			$('#leedv4-comment input.field').live('focus', function(){
				$(this).after('<textarea class="field left" name="comment"></textarea>');
				$(this).remove();
				$('#leedv4-comment textarea.field').focus()
			});
			
			$('#leedv4-comment textarea.field').live('blur', function(){
				if($(this).val() == ''){
					$(this).after('<input type="text" class="field left" name="comment" placeholder="Please enter you comment." />');
					$(this).remove();
				}
			}).live('keyup', function(){
				if($(this).val() == ''){
					$('#leedv4-comment .radios').slideUp();
				} else {
					$('#leedv4-comment .radios').slideDown().find('input[value="private"]').click();
				}
			});
			

	    });