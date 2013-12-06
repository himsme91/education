$(window).load(function(){
	if(!$('html').hasClass('ie')){
		$('#banner').addClass('animate').append('<div class="mask" />');
		$('#banner .face').each(function(){
			var url = $('img', this).attr('src');
			$(this).css('background', 'url(' + url + ') no-repeat center');
		});
		
		setFloats();
		timer();
	}
});

function getRandom(){
	return Math.floor(Math.random() * (42 - 1 + 1) + 1);
}

function setFloats(){
	var base = getRandom();
	var mid = getRandom() + 13;
	var back = getRandom() + 21;
	
	$('#banner .face:nth-child(13n + ' + back + ')').addClass('floater').addClass('background');
	$('#banner .face:nth-child(48n + ' + mid + ')').addClass('floater').addClass('midground');
	$('#banner .face:nth-child(27n + ' + base + ')').addClass('floater').addClass('foreground');
}

function clearFloats(){
	$('.background').removeClass('background');
	$('.midground').removeClass('midground');
	$('.foreground').removeClass('foreground');
	$('.floater').removeClass('floater');
}

function resetFloaters(){
	clearFloats();
	setFloats();
}

function timer(){
	var time = setInterval('resetFloaters()', 6800);
}