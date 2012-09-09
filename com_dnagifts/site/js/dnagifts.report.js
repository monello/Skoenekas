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
			ns.generatePDF();
		}
	},
	generatePDF: function()
	{
		var ns = DnaGifts.report;
		var url='index.php?option=com_dnagifts&format=json&task=report.emailReportPDF';
        jQuery.ajax({
            type: "POST",
            url: url,
            data: {
                svgData: ns.chartSVG,
				svgDisplayOrder: ns.svgDisplayOrder
            },
			success: function(json) {
				if (json.success) {
					alert(json.message);
				} else {
					alert("There was an error generating your report PDF.\nPlease use the Email button to try again");
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
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawCharts);

function drawCharts(){
	var ns = DnaGifts.report;
	
	// - LINE CHART
	var data = google.visualization.arrayToDataTable([
		['Year', 'Sales', 'Expenses'],
		['2004',  1000,      400],
		['2005',  1170,      460],
		['2006',  660,       1120],
		['2007',  1030,      540]
	]);
	var options = {
	  title: 'Company Performance'
	};
	var divID = 'chart_div';
	ns.chartContainer[divID] = document.getElementById(divID);
	var chart = new google.visualization.LineChart(ns.chartContainer[divID]);
	google.visualization.events.addListener(chart, 'ready', function(){ns.getSVG(divID)});
	chart.draw(data, options);
	
	// - PIE CHART
	var piedata = google.visualization.arrayToDataTable([
		['Task', 'Hours per Day'],
		['Work',     11],
		['Eat',      2],
		['Commute',  2],
		['Watch TV', 2],
		['Sleep',    7]
	]);
	var pieoptions = {
	  title: 'My Daily Activities'
	};
	var piedivID = 'piechart_div';
	ns.chartContainer[piedivID] = document.getElementById(piedivID);
	var piechart = new google.visualization.PieChart(document.getElementById(piedivID));
	google.visualization.events.addListener(piechart, 'ready', function(){ns.getSVG(piedivID)});
	piechart.draw(piedata, pieoptions);

}
/*********************************************************/
