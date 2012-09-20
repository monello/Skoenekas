root.myNamespace.create('DnaGifts.report', {
    chartContainer: {},
	chartSVG: {},
	svgDisplayOrder: [],
    getSVG: function(divID)
	{
        var ns = DnaGifts.report;
		var chartArea = ns.chartContainer[divID].getElementsByTagName('iframe')[0].
			contentDocument.getElementById('chartArea');
		ns.chartSVG[divID] = ns.htmlEncode(chartArea.innerHTML);
		ns.svgDisplayOrder.push(divID);
		if (dnaChartCount == ns.svgDisplayOrder.length) {
			ns.dispatchReport();
		}
	},
	dispatchReport: function()
	{
		var ns = DnaGifts.report;
		var url='index.php?option=com_dnagifts&format=json&task=report.dispatchReport';
        jQuery.ajax({
            type: "POST",
            url: url,
            data: {
				userTestID: 1,
                svgData: ns.chartSVG,
				svgDisplayOrder: ns.svgDisplayOrder
            },
			success: function(json) {
				if (json.success) {
					jQuery("#notificationtab").html(json.message);
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
    jQuery.metadata.setType('attr','data');
    
});


/** This Google Chart API code must run as non-namespaced code, cannot get it to work inside the namespace */
google.load("visualization", "1", {packages:["corechart", "gauge"]});
google.setOnLoadCallback(drawCharts);

function drawCharts(){
	var ns = DnaGifts.report;
	
	var scores = {
		perceiver: 23,
		servant: 18,
		teacher: 16,
		exhorter: 49,
		giver: 35,
		ruler: 40,
		mercy: 19
	};
	
	// - GAUGES
	/*
	var gaugedata = google.visualization.arrayToDataTable([
		['Label', 'Value'],
		['Perceiver', Math.round(scores.perceiver/60*100)],
		['Servant', Math.round(scores.servant/60*100)],
		['Teacher', Math.round(scores.teacher/60*100)],
		['Exhorter', Math.round(scores.exhorter/60*100)],
		['Giver', Math.round(scores.giver/60*100)],
		['Ruler', Math.round(scores.ruler/60*100)],
		['Mercy', Math.round(scores.mercy/60*100)]
	]);

	var gaugeoptions = {
		width: 800, height: 120,
		redFrom: 90, redTo: 100,
		yellowFrom:75, yellowTo: 90,
		minorTicks: 5
	};
	var gaugedivID = 'gaugechart_div';
	ns.chartContainer[gaugedivID] = document.getElementById(gaugedivID);
	var gaugechart = new google.visualization.Gauge(ns.chartContainer[gaugedivID]);
	gaugechart.draw(gaugedata, gaugeoptions);
	*/
	var gauge1data = google.visualization.arrayToDataTable([
		['Label', 'Value'],
		['Exhorter', Math.round(scores.exhorter/60*100)]
	]);

	var gauge1options = {
		width: 130,
		height: 130,
		redFrom: 66,
		redTo: 100,
		redColor: '00B050',
		yellowFrom:33,
		yellowTo: 66,
		yellowColor: '99CC99',
		greenFrom: 0,
		greenTo: 33,
		greenColor: 'BFFFBF',
		minorTicks: 5
	};
	var gauge1divID = 'gauge1chart_div';
	ns.chartContainer[gauge1divID] = document.getElementById(gauge1divID);
	var gauge1chart = new google.visualization.Gauge(ns.chartContainer[gauge1divID]);
	gauge1chart.draw(gauge1data, gauge1options);
	
	// - LINE CHART
	var linedata = google.visualization.arrayToDataTable([
		['Gift', 'Motivational Flow Level'],
		['Exhorter', scores.exhorter],
		['Ruler', scores.ruler],
		['Giver', scores.giver],
		['Perceiver', scores.perceiver],
		['Mercy', scores.mercy],
		['Servant', scores.servant],
		['Teacher', scores.teacher]
    ]);

    var lineoptions = {
        title: 'Your Motivational Flow',
		series: {0:{color: '000000', visibleInLegend: false}},
		pointSize: 3,
		height: 300,
		width: 500,
		hAxis: {slantedText: true, slantedTextAngle: 90, gridlines: {color: '#333', count: 4}}
	};

	var linedivID = 'linechart_div';
	ns.chartContainer[linedivID] = document.getElementById(linedivID);
    var linechart = new google.visualization.LineChart(ns.chartContainer[linedivID]);
    linechart.draw(linedata, lineoptions);
	
	// - PIE CHART
	var piedata = google.visualization.arrayToDataTable([
		['Gifting', 'Score'],
		['Perceiver', scores.perceiver],
		['Servant', scores.servant],
		['Teacher', scores.teacher],
		['Exhorter', scores.exhorter],
		['Giver', scores.giver],
		['Ruler', scores.ruler],
		['Mercy', scores.mercy]
	]);
	var pieoptions = {
		is3D: true,
		slices: {
			0:{color: 'FF0000'},
			1:{color: 'FFC000', textStyle: {color: 'black'}},
			2:{color: 'FFFF00', textStyle: {color: 'black'}},
			3:{color: '00B050'},
			4:{color: '538ED5'},
			5:{color: '333391'},
			6:{color: '990099'}
		}
	};
	var piedivID = 'piechart_div';
	ns.chartContainer[piedivID] = document.getElementById(piedivID);
	var piechart = new google.visualization.PieChart(document.getElementById(piedivID));
	google.visualization.events.addListener(piechart, 'ready', function(){ns.getSVG(piedivID)});
	piechart.draw(piedata, pieoptions);

}
/*********************************************************/
