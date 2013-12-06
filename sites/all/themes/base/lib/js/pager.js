(function( $ ) {

    $.fn.mini_pager = function(){
        
        return this.each(function() {
                    
            var pager = this;
            var max = parseInt( $('.total', pager).text() );
            var url = document.URL.split('?',1);
            var urlParams = get_querystring();
            
            $('.input input', pager).each(function(){
                $(this).keyup(throttle(changePage,500));
            });
            
            function changePage (){

                var num = parseInt( $(this).val() )-1;
                if(num != 'NaN' && num >= 0 && num < max){
                    
                    console.log(urlParams);
                    urlParams.page = num;
                    var querystring = build_querystring(urlParams);
                    window.location = url + querystring;
                }
                else{
                	alert("Please enter valid page number.");
                }

            }
            
        
        });

       
        //Throttle: delay function call
        function throttle(f, delay){
            var timer = null;
            return function(){
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = window.setTimeout(function(){
                    f.apply(context, args);
                },
                delay || 500);
            };
        }
        
        //Get URL querystring
        function get_querystring() {
            var output = {};
            var e,
                a = /\+/g,  // Regex for replacing addition symbol with a space
                r = /([^&=]+)=?([^&]*)/g,
                d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
                q = window.location.search.substring(1);
                
            while (e = r.exec(q))
               output[d(e[1])] = d(e[2]);
               
            return output;
        }
        
        //Build URL querystring
        function build_querystring(urlParams) {
          var output = '';
          var params = new Array();
          for (key in urlParams){
            params.push( key+'='+urlParams[key] );
          }
          
          if (params.length > 0) output = '?'+params.join('&');
          
          return output;
        }
        
        
                
    };

})( jQuery );

$(document).ready(function(){
    $('.mini-pager').mini_pager();
    
});