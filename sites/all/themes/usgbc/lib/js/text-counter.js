(function ($) {

$.fn.charCount = function(options) {

         var settings = {
            'limitUnit' : 'characters',
            'textMax' : 1000,
            'textMin' : 0,
            'limitAlert' : 100,
            'barSize' : 250
          }


          return this.each(function() {

              if ( options ) {
                  $.extend( settings, options );
              }


              $(this).wrap("<div class='textblock element' />").parents(".textblock").append('<div class="meter"><span class="meter_bar"></span><span class="meter_label">characters remaining</span></div>').prepend('<p class="notification negative small" />');

               $(this).keyup(function(){

                   // ----------------------------------------------------------------------------------------
                   // fixed variables. Do not change for default functionality
                   if ( settings.limitUnit == "words" ) { var length = $.trim($( this ).val()).split(/[\s]+/).length; }
                   else { var length = $( this ).val().length; }


                   var textValue    = $(this).val();
                   var placeHolder  = $(this).attr("placeholder");

                   var textLeft     = settings.textMax - length;
                   var new_textLeft = settings.textMax - length;

                   var percentFull  = length * 100 / settings.textMax;
                   var negBarSize   = 0 - settings.barSize;
                   var barPosition  = negBarSize + settings.barSize / 100 * percentFull;
                   var unitsOver    = length - settings.textMax;

                   var textNeeded   = settings.textMin - length;

                   $( this ).parents(".textblock").find('.meter_bar').css("background-position", "-" + settings.barSize + "px 0px");

                   // Reporting:

                   // determine whether the value of the item is just it's placeholder
                   if ( textValue == placeHolder && textValue != "" ) {
                      $( this ).parents(".textblock").find(".meter, .notification").hide();
                   }

                   // TOO SHORT
                   else if ( length < settings.textMin ) {
                       $("#helper").html("too short");
                        $( this ).parents(".textblock").find(".notification").hide();
                        $( this ).parents(".textblock").find(".meter").show();
                        $( this ).parent().find('.meter_label').show().html('<strong class="negative">Your entry is too short. Add ' + textNeeded + ' ' + settings.limitUnit + '</strong>' );
                        $( this ).parent().find('.meter_bar').css("background-position", Math.floor(barPosition) + "px -16px");
                   }

                   // JUUUUUST RIGHT
                   else if( length >= settings.textMin && length <= settings.textMax && new_textLeft >= settings.limitAlert || textValue == placeHolder ) {
                       $("#helper").html("perfect");
                       $( this ).parents('.textblock').find('.notification').hide();
                       $( this ).parents(".textblock").find(".meter").show();
                       $( this ).parent().find('.meter_label').hide();
                       $( this ).parent().find('.meter_bar').css("background-position", Math.floor(barPosition) + "px 0");
                   }

                   // JUUUUUST RIGHT, BUT CLOSE TO LIMIT
                   else if( length >= settings.textMin && length <= settings.textMax && new_textLeft <= settings.limitAlert ) {
                       $("#helper").html("perfect, but close");
                       $( this ).parents('.textblock').find('.notification').hide();
                       $( this ).parents(".textblock").find(".meter").show();
                       $( this ).parent().find('.meter_label').show().html( settings.limitUnit + ' remaining: <strong class="negative">' + new_textLeft + '</strong>' );
                       $( this ).parent().find('.meter_bar').css("background-position", Math.floor(barPosition) + "px 0");
                   }

                   // TOO LONG
                   else {
                       $("#helper").html("too long");
                       $( this ).parents('.textblock').find('.meter').show();
                       $( this ).parents(".textblock").find(".notification").show().html('You have exceeded the limit of <strong>' + settings.textMax + '</strong> ' + settings.limitUnit + '.<br/>Please reduce your biography by <strong>' + unitsOver + '</strong> ' + settings.limitUnit + ' before submitting.');
                       $( this ).parent().find('.meter_bar').css("background-position","0 -16px");
                       $( this ).parent().find('.meter_label').html( '<strong class=\"negative\">Word limit exceeded</strong>' );
                   }

               }).keyup();//end keyup


          }); //end each()

    } //end plugin


})(jQuery);
