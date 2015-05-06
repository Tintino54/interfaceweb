$(function () {
$('#container').highcharts({
	chart: {
		type: 'line'
	},
	title: {
		text: 'score algorithmes'
	},
	xAxis: {
		text: 'iteration'
	},
	yAxis: {
		title: {
		text: 'score'
		}
	},
	series: ["

	"]
	});
});


	var chart1; // globally available
	$(function() {
	chart1 = new Highcharts.StockChart({
	chart: {
		renderTo: 'container'
	},
	rangeSelector: {
		selected: 1
	},
	series: [{
		name: 'USD to EUR',
		data: usdtoeur // predefined JavaScript array
	}]
	});
	});
/