$(document).ready(function(){
    modalAttach();
    
    $(window).resize(modalAttach);
    
    $(function(){ $(".jqm-wrapper .uniform,.jqm-wrapper .checkbox,.jqm-wrapper .radio,.jqm-wrapper select,.jqm-wrapper input[type='radio'],.jqm-wrapper input[type='checkbox'],.jqm-wrapper input[type='file']").uniform(); });
    
    $('a.nested-modal').click(function(event){
        
        event.preventDefault();
        var src = $(this).attr('href');
        var parent = $(this).parents('.modal-content').attr('id');
        
        $(this).parents('.modal-content').hide();
        $('div' + src).fadeIn();
    });
    
    $('.modal-state-comment, .modal-state-problem').hide();
    
    $('input[name=security]').change(function(){
        var state = $(this).val();
        
        $('.modal-title, textarea.field').hide();
        $('.modal-state-' + state).show();
    });
    
    $('a.widen-panel').click(function(){
        var modal = $('#modal');
        
        modal.css({
            'margin-left': '-500px',
            'width': '1000px'
        });
        
        $('a', modal).click(function(){
            modal.css({
                'width': '500px',
                'margin-left': '-250px'
            });
        });
    });
    
    $('.field').not(".no-ph").each(placeholder);
    
    
    
    
    
    
});

function modalAttach(){
    
    var viewportHeight = $(window).height();
    var contentBottom = $('.jqmWindow').offset().top + $('.jqmWindow').height();
    
    if(viewportHeight > contentBottom){
        $('.jqmWindow').css('position', 'fixed');
    };
    
    if(viewportHeight < contentBottom){
        $('.jqmWindow').css('position', 'absolute');
    };
};


function placeholder(){
    var field = $(this);
    var preset = $(this).val();
    
    field.focus(function(){
        if(field.val() == preset){
            field.val('');
        };
    }).blur(function(){
        if(field.val() == ''){
            field.val(preset);
        };
    });
};