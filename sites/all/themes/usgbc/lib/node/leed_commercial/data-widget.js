var chart1;
var pData;
var fData;
var chart;
var dataType;
var dates = new Array();
var commercial = new Array();
var commercialReg = new Array();
var residential = new Array();
var residentialReg = new Array();
var stage1 = new Array();
var stage2 = new Array();
var stage3 = new Array();
var total = new Array();
var chartDrawn = false;

$(document).ready(function(){
    $('#data-widget .dw-nav a').click(dataWidget);

    $.ajax({
        url: '/sites/all/themes/usgbc/lib/node/leed_commercial/project-data.json',
        type: 'GET',
        dataType: 'json',
        success: function(json){
        	pData = json;
        	$('#data-widget .dw-nav li:first-child a').click();
        }
        // error: function(a,b,e){ }
    });

    $.ajax({
        url: '/sites/all/themes/usgbc/lib/node/leed_commercial/sqft-data.json',
        type: 'GET',
        dataType: 'json',
        success: function(json){ fData = json; }
        // error: function(a,b,e){ }
    });

    $('#data-widget .day-select a').click(daySelect).hover(changeTotal);
    $('#data-widget').click(function(){ return false; });
    $(document).click(removeBubble);
    $('#data-widget .day-select').mouseleave(function(){
    	$('#data-widget .dw-mainline .dw-mainnumber').html(formatNum(total[6]));
    });
});

// Data Set Toggle
function dataWidget(event){
    event.preventDefault();
    chart = $(this).attr('href').replace('#', '').replace('-chart', '');

    removeBubble();
    $('#data-widget .dw-nav .selected').removeClass('selected');
    $(this).parent('li').addClass('selected');

    if(chart == 'project'){
        for(var i = 0; i < pData.length; i++){
            dates[i] = pData[i].date;
            commercial[i] = parseInt(pData[i].comCertified);
            commercialReg[i] = parseInt(pData[i].comRegistered);
            residential[i] = parseInt(pData[i].resCertified);
            residentialReg[i] = parseInt(pData[i].resRegistered);
            stage1[i] = pData[i].ndStage1;
            stage2[i] = pData[i].ndStage2;
            stage3[i] = pData[i].ndStage3;
            total[i] = commercial[i] + residential[i];
        };

        $('#data-widget .dw-mainline .dw-datatype').text('LEED-certified projects');

    } else if(chart == 'sqft'){
        for(var i = 0; i < fData.length; i++){
            dates[i] = fData[i].date;
            commercial[i] = total[i] = parseInt(fData[i].comCertified);
            commercialReg[i] = parseInt(fData[i].comRegistered);
            stage1[i] = fData[i].ndStage1;
            stage2[i] = fData[i].ndStage2;
            stage3[i] = fData[i].ndStage3;
        };

        $('#data-widget .dw-mainline .dw-datatype').html('ft&sup2; of LEED-certified commercial space');
    };

    dataType = chart;

    $('#data-widget .dw-mainline .dw-mainnumber').text(formatNum(total[6]));
    if(chartDrawn == true){ chart1.destroy() };
    drawChart();
};

// Data Breakdown
function daySelect(event){

    if($(this).parent('li').hasClass('has-bubble')){
        $(this).parent('li').removeClass('has-bubble');
        $('#data-widget .bubble').remove();
    } else {

        event.preventDefault();
        var i = $(this).parent('li').index();
        var dayselect = $(this).parents('.day-select');
        var dotPosition = chart1.series[0].data[i].plotY;
        var d = dates[i];
        var change = 'Unavailable';
        var residentialdata;
        var bubTotal;
        var bubCC;
        var bubCR;
        var bubS1;
        var bubS2;
        var bubS3;
        var RC;
        var RR;

        if(i > 0){ change = '+ ' + formatNum((total[i] - total[(i-1)])) };

        d = d.replace('MON', 'Monday');
        d = d.replace('TUE', 'Tuesday');
        d = d.replace('WED', 'Wednesday');
        d = d.replace('THU', 'Thursday');
        d = d.replace('FRI', 'Friday');
        d = d.replace('SAT', 'Saturday');
        d = d.replace('SUN', 'Sunday');

        if(dataType == 'project'){
            bubTotal = formatNum(total[i]);
            bubCC = formatNum(commercial[i]);
            bubCR = formatNum(commercialReg[i]);
            bubRC = formatNum(residential[i]);
            bubRR = formatNum(residentialReg[i]);
            bubS1 = formatNum(stage1[i]);
            bubS2 = formatNum(stage2[i]);
            bubS3 = formatNum(stage3[i]);

            residentialdata = '<div class="section residential"><dl><dt><strong>Residential homes</strong></dt><dd><strong>&nbsp;</strong></dd><dt>Certified</dt><dd>' + bubRC + '</dd><dt class="registered">Registered</dt><dd class="registered">' + bubRR + '</dd></dl></div>';
        } else if(dataType == 'sqft'){
            bubTotal = (Math.round(total[i] / 1000000) / 1000) + ' bil ft&sup2;';
            bubCC = (Math.round(commercial[i] / 1000000) / 1000) + ' bil ft&sup2;';
            bubCR = (Math.round(commercialReg[i] / 1000000) / 1000) + ' bil ft&sup2;';
            bubRC = (Math.round(residential[i] / 1000000) / 1000) + ' bil ft&sup2;';
            bubRR = (Math.round(residentialReg[i] / 1000000) / 1000) + ' bil ft&sup2;';
            bubS1 = (Math.round(stage1[i] / 1000000) / 1000) + ' bil ft&sup2;';
            bubS2 = (Math.round(stage2[i] / 1000000) / 1000) + ' bil ft&sup2;';
            bubS3 = (Math.round(stage3[i] / 1000000) / 1000) + ' bil ft&sup2;';

            residentialdata = '<div class="section residential"><dl><dt><strong>Residential homes</strong></dt><dd><strong>&nbsp;</strong></dd><dt style="width:100%" class="registered">Total square feet not measured under LEED for Homes</dt><dd></dd></dl></div>';
        };

        var bubble = '<div class="bubble" style="top: ' + dotPosition + 'px;"><div class="bubble-wrapper"><div class="section date">' + d + '</div><div class="section totals"><dl><dt><strong>Total LEED-certified projects</strong></dt><dd><strong>' + bubTotal + '</strong></dd><dt>Daily change</dt><dd>' + change + '</dd></dl></div><div class="section commercial"><dl><dt><strong>Commercial projects</strong></dt><dd><strong>&nbsp;</strong></dd><dt>Certified</dt><dd>' + bubCC + '</dd><dt class="registered">Registered</dt><dd class="registered">' + bubCR + '</dd></dl></div><div class="section neighborhood"><dl><dt><strong>Neighborhood development</strong></dt><dd><strong>&nbsp;</strong></dd><dt>Stage 3 certified</dt><dd>' + bubS3 + '</dd><dt>Stage 2 certified</dt><dd>' + bubS2 + '</dd><dt>Stage 1 certified</dt><dd>' + bubS1 + '</dd></dl></div>' + residentialdata + '<img src="/themes/usgbc/lib/node/leed_commercial/img/bubble-anchor.png" alt="" class="bubble-anchor" /></div></div>';

        removeBubble();
        $('#data-widget .dw-mainline .dw-mainnumber').text(formatNum(total[i]));
        $(this).parent('li').addClass('has-bubble').append(bubble);

        if(i <= 3){
            $('.bubble', dayselect).css({
                'left': '50%',
                'margin-left': '7px',
                'margin-right': 0
            });

            $('.bubble img.bubble-anchor').css('left', '-18px').attr('src', '/themes/usgbc/lib/node/leed_commercial/img/bubble-anchor-r.png');
        };
    };
};

function changeTotal(){
    var i = $(this).parent('li').index();
    $('#data-widget .dw-mainline .dw-mainnumber').text(formatNum(total[i]));
};

function removeBubble(){
    $('#data-widget li.has-bubble').removeClass('has-bubble');
    $('#data-widget .bubble').remove();
};

var formatNum = function(value){
    if (!value) return '';
    value = String(value).split('.')[0];
    value = value == null ? '' : value;
    value = String(parseInt(value, 10));
    var regex = /(\d+)(\d{3})/;
    while(regex.test(value)) {
        value = value.replace(regex, '$1,$2');
    }
    return value;
};

function drawChart(){
	if(chart == 'project'){
	    chart1 = new Highcharts.Chart({
	         chart: { renderTo: 'dw-chart' },
	         title: { text: '' },
	         xAxis: { categories: dates },
	         yAxis: {
	         	title: { text: '' },
	         	min: total[0] - 10
	         },
	         tooltip: {
	             shared: true,
	             formatter: function(){ return  '' }
	         },
	         series: [{
	             type: 'areaspline',
	             name: 'Total Projects',
	             data: total
	         }],
	         plotOptions: {
	         	areaspline: {
	         		color: '#8cc544'
	         	}
	         }
	    });
	} else if(chart == 'sqft'){
		chart1 = new Highcharts.Chart({
		     chart: { renderTo: 'dw-chart' },
		     title: { text: '' },
		     xAxis: { categories: dates },
		     yAxis: {
		     	title: { text: '' },
		     	min: commercial[0] - 1000
		     },
		     tooltip: {
		         shared: true,
		         formatter: function(){ return  '' }
		     },
		     series: [{
		         type: 'areaspline',
		         name: 'Total Projects',
		         data: commercial
		     }],
		     plotOptions: {
		     	areaspline: {
		     		color: '#199cc9'
		     	}
		     }
		});
	};
};
