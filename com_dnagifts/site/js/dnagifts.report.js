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

	// - COLUMN CHART
	var columndata = google.visualization.arrayToDataTable([
        ['Gift', 'Perceiver', 'Servant', 'Teacher', 'Exhorter', 'Giver', 'Ruler', 'Mercy'],
        ['Giftings', scores.perceiver, scores.servant, scores.teacher, scores.exhorter, scores.giver, scores.ruler, scores.mercy]
    ]);

    var columnoptions = {
        title: 'Your DNA Gifts',
		series: {
			0:{color: 'FF0000', visibleInLegend: true},
			1:{color: 'FFC000', visibleInLegend: true},
			2:{color: 'FFFF00', visibleInLegend: true},
			3:{color: '00B050', visibleInLegend: true},
			4:{color: '538ED5', visibleInLegend: true},
			5:{color: '333391', visibleInLegend: true},
			6:{color: '990099', visibleInLegend: true}
		}
	};

	var columndivID = 'columnchart_div';
	ns.chartContainer[columndivID] = document.getElementById(columndivID);
    var columnchart = new google.visualization.ColumnChart(ns.chartContainer[columndivID]);
    columnchart.draw(columndata, columnoptions);
	
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
		title: 'Your DNA Gifts',
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
