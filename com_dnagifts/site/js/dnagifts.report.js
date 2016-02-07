root.myNamespace.create('DnaGifts.report', {
    chartContainer: {},
	chartSVG: {},
	chartLog: [],
	intervals: {},
	extractSVG: function(divID)
	{
		//if (jQuery.browser.msie) {
		if (navigator.sayswho.match(/^IE/) ) {
			return false;
		}
		var ns = DnaGifts.report;
		ns.intervals[divID] = setInterval(function(){ns._extractSVG(divID)},1000);
		return true;
	},
    _extractSVG: function(divID)
	{
		var ns = DnaGifts.report;
		var svg = undefined;
		if (jQuery("#"+divID+" iframe:first")){
			svg = jQuery("#"+divID+" iframe:first").contents().find('#chartArea').html();
		}
		if (!svg && jQuery("#"+divID+" svg:first")) {
			svg = jQuery("#"+divID+" svg:first").parent().html();
		}

		if (!svg)
			return false;
		clearInterval(ns.intervals[divID]);
		
		ns.chartSVG[divID] = ns.htmlEncode(svg);
		
		// When all the chart svg code has been extracted, dispatch the report
		// 	- dnaChartCount: The number of SVG charts expected
		//	- svgDataOrder: is a list of the order that
		var howmany = ns.countSVGExtracted();
		if (dnaChartCount == howmany) {
			ns.dispatchReport();
		}
		return true;
	},
	countSVGExtracted: function ()
	{
		var ns = DnaGifts.report;
		var howmany = 0;
		jQuery.each(ns.chartSVG, function(k,v) {
			howmany++;
		});
		return howmany;
	},
	resendReport: function()
	{
		var goahead = confirm("Are you sure you want to re-send this report to the user?");
		if (!goahead) {
			return false;
		}
		
		var ns = DnaGifts.report;
		var url=juri+'/index.php?option=com_dnagifts&format=json&task=report.emailReportPDF';
		jQuery.ajax({
		  type: "POST",
		  url: url,
		  data: {
				uid: uid,
				userTestID: userTestID,
			},
			success: function(json) {
				if (json.success) {
					alert("Report was successfully sent");
				}
			}
		});
	},
	dispatchReport: function()
	{
		var ns = DnaGifts.report;
		var url=juri+'/index.php?option=com_dnagifts&format=json&task=report.dispatchReport';
		jQuery.ajax({
		  type: "POST",
		  url: url,
		  data: {
				uid: uid,
				israw: israw,
				userTestID: userTestID,
				svgData: ns.chartSVG,
				imgChartSRC: jQuery("table#tblDNAChart img:first").attr("src")
			},
			success: function(json) {
				if (json.success) {
					//jQuery(".actionsbar").show();
					jQuery("#notificationspinner").hide();
					jQuery("#notificationtext").html(json.message);
					jQuery("#notificationtab").css('backgroundColor', '#9fff9f').show();
					setInterval(function(){jQuery("#notificationtab").fadeOut()}, 3000);
				}
			}
		});
	},
	dispatchMSIEReport: function()
	{
		var ns = DnaGifts.report;
		
		var url=juri+'/index.php?option=com_dnagifts&format=json&task=report.dispatchMSIEReport';
        jQuery.ajax({
            type: "POST",
            url: url,
            data: {
				uid: uid,
				israw: israw,
				userTestID: userTestID
            },
			success: function(json) {
				if (json.success) {
					jQuery("#notificationspinner").hide();
					jQuery("#notificationtext").html(json.message);
					jQuery("#notificationtab").css('backgroundColor', '#9fff9f').show();
					setInterval(function(){jQuery("#notificationtab").fadeOut()}, 3000);
				}
			}
        });
	},
	htmlEncode: function(value){
		return jQuery('<div/>').text(value).html();
	}

});

/**
* Queue the functions below into the load_array, to be called from the init function
*/
Base.Helpers.bind_load(function () {
	var ns = DnaGifts.report;
	jQuery("#resendReportBtn").live("click",ns.resendReport);
    jQuery.metadata.setType('attr','data');
	setInterval(function(){jQuery("#notificationtab").fadeOut()}, 6000);
	if (navigator.sayswho.match(/^IE/) ) {
		ns.dispatchMSIEReport();
	}
});


/** This Google Chart API code must run as non-namespaced code, cannot get it to work inside the namespace */
google.load("visualization", "1", {packages:["corechart", "gauge"]});
google.setOnLoadCallback(drawCharts);

function drawCharts() {
	var ns = DnaGifts.report;
	
	/*************************************************************************/
	// - PIE CHART
	var piedata = google.visualization.arrayToDataTable([
		['Gifting', 'Score'],
		[dnaResults[0].label, dnaResults[0].score],
		[dnaResults[1].label, dnaResults[1].score],
		[dnaResults[2].label, dnaResults[2].score],
		[dnaResults[3].label, dnaResults[3].score],
		[dnaResults[4].label, dnaResults[4].score],
		[dnaResults[5].label, dnaResults[5].score],
		[dnaResults[6].label, dnaResults[6].score]
	]);
	var pieoptions = {
		backgroundColor: 'transparent',
		is3D: true,
		slices: {
			0:{color: dnaResults[0].redColor},
			1:{color: dnaResults[1].redColor, textStyle: {color: 'black'}},
			2:{color: dnaResults[2].redColor, textStyle: {color: 'black'}},
			3:{color: dnaResults[3].redColor},
			4:{color: dnaResults[4].redColor},
			5:{color: dnaResults[5].redColor},
			6:{color: dnaResults[6].redColor}
		},
		chartArea: {left: 50, top: 0, width: 500, height: 300},
		legend: {position: 'right', alignment: 'center'}
	};
	var piedivID = 'piechart_div';
	ns.chartContainer[piedivID] = document.getElementById(piedivID);
	var piechart = new google.visualization.PieChart(document.getElementById(piedivID));
	piechart.draw(piedata, pieoptions);
	
	piedivID = 'piechart_div_hidden';
	ns.chartContainer[piedivID] = document.getElementById(piedivID);
	var piechart = new google.visualization.PieChart(document.getElementById(piedivID));
	google.visualization.events.addListener(piechart, 'ready', function(){ns.extractSVG(piedivID)});
	piechart.draw(piedata, pieoptions);

	/*************************************************************************/
	// - LINE CHART
	var linedataData = [['Gift', 'Motivational Flow Level']];
	for (var i=0;i<7;i++) {
		var position = getResultsByPosition(i);
		linedataData.push([dnaResults[position].label,dnaResults[position].score]);
	}
	var linedata = google.visualization.arrayToDataTable(linedataData);

    var lineoptions = {
        title: dnaReportCopy.motivationalflow,
		series: {0:{color: '000000', visibleInLegend: false}},
		pointSize: 3,
		height: 255,
		width: 400,
		chartArea: { left: 20, top: 20, width: 350, height: 180},
		hAxis: {slantedText: true, slantedTextAngle: 90, gridlines: {color: '#333', count: 4}}
	};

	var linedivID = 'linechart_div';
	ns.chartContainer[linedivID] = document.getElementById(linedivID);
    var linechart = new google.visualization.LineChart(ns.chartContainer[linedivID]);
	google.visualization.events.addListener(linechart, 'ready', function(){ns.extractSVG(linedivID)});
    linechart.draw(linedata, lineoptions);
	
	/*************************************************************************/
	// - GAUGES
	/*var gaugelist = ['gauge1chart_div','gauge2chart_div','gauge3chart_div', 'gauge4chart_div', 
					'gauge5chart_div', 'gauge6chart_div', 'gauge7chart_div']*/
	var gaugelist = ['gauge1chart_div','gauge2chart_div','gauge3chart_div'];
	for (var i=0;i<gaugelist.length;i++){
		var position = getResultsByPosition(i);
		drawDnaGaugechart(
			dnaResults[position].label,
			dnaResults[position].score,
			dnaMaxScore,
			dnaResults[position].redColor,
			dnaResults[position].yellowColor,
			dnaResults[position].greenColor,
			gaugelist[i]
		);
	}
}

function drawDnaGaugechart(chartLabel, score, maxScore, redColor, yellowColor, greenColor, divID) {
	var ns = DnaGifts.report;
	var data = google.visualization.arrayToDataTable([
		['Label', 'Value'],
		[chartLabel, Math.round(score/maxScore*100)]
	]);
	var options = {
		width: 130,
		height: 130,
		redFrom: 66,
		redTo: 100,
		redColor: redColor,
		yellowFrom:33,
		yellowTo: 66,
		yellowColor: yellowColor,
		greenFrom: 0,
		greenTo: 33,
		greenColor: greenColor,
		minorTicks: 5
	};
	ns.chartContainer[divID] = document.getElementById(divID);
	var chart = new google.visualization.Gauge(ns.chartContainer[divID]);
	google.visualization.events.addListener(chart, 'ready', function(){ns.extractSVG(divID)});
	chart.draw(data, options);
}

function getResultsByPosition(position){
	for (var i=0;i<dnaResults.length;i++){
		if (dnaResults[i].position == position) {
			return i;
		}
	}
	return -1;
}

function getGiftLabelByPosition(position){
	for (var i=0;i<dnaResults.length;i++){
		if (dnaResults[i].position == position) {
			return dnaResults[i].label;
		}
	}
	return undefined;
}

