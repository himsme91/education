$(document).ready(function () {
  $('#feedback-container #close-feedback').click(function () {
    hideFeedback();
    return false;
  });

  $('textarea[name=comments]').focus(function () {
    if ($(this).val() == 'Additional comments') $(this).val('');
  });
  $('textarea[name=comments]').blur(function () {
    if ($(this).val() == '') $(this).val('Additional comments');
  });

  var informative_content = '';
  var well_organized = '';
  var performance_speed = '';
  var summary = '';
  var description = '';
  var url = '';
  var name = '';
  var uid = '';
  var email = '';
  var form = '';

  $("input:radio[name=content-feelings]").click(function () {
    informative_content = $(this).val();
  });
  $("input:radio[name=design-feelings]").click(function () {
    well_organized = $(this).val();
  });
  $("input:radio[name=technical-feelings]").click(function () {
    performance_speed = $(this).val();
  });

  $('#feedback-container .button').click(function () {
    form = $('input[name=form]').val();
    summary = $('input[name=page_title]').val();
    description = $('textarea[name=comments]').val();
    if (description == 'Additional comments') description = '';
    url = $('input[name=url]').val();
    name = $('input[name=name]').val(); 
    uid = $('input[name=uid]').val(); 
    email = $('input[name=email]').val(); 
    var dataString = 'form=' + encodeURI(form) + '&informative_content=' + encodeURI(informative_content) + '&well_organized=' + encodeURI(well_organized) + '&performance_speed=' + encodeURI(performance_speed) + '&summary=' + encodeURI(summary) + '&description=' + encodeURI(description) + "&url=" + encodeURI(url) + "&name=" + encodeURI(name) + "&uid=" + encodeURI(uid) + "&email=" + encodeURI(email);

    $.ajax({
      type:"POST",
      url:"/feedback.php",
      data:dataString,
      success:function (data) {
        $('#feedback-bar .sub-form-element').find('*').fadeOut();
        $('#feedback-bar .sub-form-element').append('<p class="thanks">Thanks for your feedback!</p>');
        setTimeout(function () {
          hideFeedback();
        }, 1200);
        setTimeout(function () {
          $('#feedback-bar .sub-form-element').find('*').delay(3500).show();
          reset_form($('#feedback-container'));
        }, 2500);
      }
    });
    return false;

  });

  $('#feedback-container #feedback-button').click(function () {
    $('#feedback-bar, #feedback-container #feedback-nav').addClass('bar-active')
    return false;
  });

  function hideFeedback() {
    $('#feedback-bar, #feedback-container #feedback-nav').removeClass('bar-active');
  }


});

function reset_form(form) {
  $('.thanks', form).remove();
  $("input:radio[name=content-feelings]", form).attr('checked', false);
  $("input:radio[name=design-feelings]", form).attr('checked', false);
  $("input:radio[name=technical-feelings]", form).attr('checked', false);
  $("div.radio span").removeClass('checked');
  $('textarea[name=comments]').val('Additional comments');
}