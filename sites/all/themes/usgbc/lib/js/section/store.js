$(document).ready(function(){
	storeImages();
	$('.store-item-images .thumb-images a:first-child').trigger('mouseenter');
});

function storeImages(){
	var c = $('.store-item-images');
	
	c.find('.main-img').append('<div class="magnify"><span class="viewing"><span class="glare"></span></span></div>');
	
	$('.thumb-images a', c).mouseenter(function(){
    	var newImg, magnifyImg;
    	
    	$(this).siblings('.active').removeClass('active');
    	$(this).addClass('active');
    	
    	newImg = $(this).find('img').attr('src');
    	magnifyImg = $(this).attr('href');
    	
    	$('.main-img img', c).attr('src', newImg);
    	$('#full-view img', c).attr('src', magnifyImg);
    	$('.main-img .viewing', c).css('background-image', 'url(' + magnifyImg + ')');
    	
	}).click(function(e){ e.preventDefault(); });
	
	$('.main-img', c).mousemove(function(e){
		var position, percentT, percentL;
		position = rPosition($(this), e.pageX, e.pageY);
		percentT = Math.floor(position.y / $(this).height() * 100);
		percentL = Math.floor(position.x / $(this).width() * 100);
		
		$(this).find('.magnify').css({ left: position.x, top: position.y });
		$(this).find('.viewing').css('background-position', percentL + '% ' + percentT + '%');
	});
}

function rPosition(element, mouseX, mouseY){
	var offset, x, y;
	offset = element.offset();
	x = mouseX - offset.left;
	y = mouseY - offset.top;

  return {'x': x, 'y': y};
}