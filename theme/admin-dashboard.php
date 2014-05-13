<?php include(dirname(__FILE__) . '/admin.php'); ?>

<div class="container">


	<div class="col-md-6">
		<div id="graph-bets"></div>
	</div>
	
	
	
	<div class="col-md-6">
		<div id="graph-users"></div>
	</div>
	
	
	
	
	
	<div class="col-md-6">
		<div id="graph-persons"></div>
	</div>
	
	
	<div class="col-md-6">
		<div id="graph-competitions"></div>
	</div>
	
	
	
	<script>
		
		
		$(function () {
			$('#graph-bets').highcharts({
				chart: {
					type: 'areaspline'
				},
				title: {
					text: 'Latest Bets'
				},
				xAxis: {
					categories: [
						'Monday',
						'Tuesday',
						'Wednesday',
						'Thursday',
						'Friday',
						'Saturday',
						'Sunday'
					],
				},
				yAxis: {
					title: {
						text: 'Bets'
					}
				},
				tooltip: {
					shared: true,
					valueSuffix: ' units'
				},
				credits: {
					enabled: false
				},
				plotOptions: {
					areaspline: {
						fillOpacity: 0.5
					}
				},
				series: [{
					name: 'Bets',
					data: [3, 4, 3, 5, 4, 10, 12]
				}]
			});
		});
		
		
		
		
		
		
		$(function () {
			$('#graph-users').highcharts({
				chart: {
					type: 'areaspline'
				},
				title: {
					text: 'Registered Users'
				},
				xAxis: {
					categories: [
						'November',
						'December',
						'January',
						'February',
						'March',
						'April',
						'May'
					],
				},
				yAxis: {
					title: {
						text: 'Users'
					}
				},
				tooltip: {
					shared: true,
					valueSuffix: ' units'
				},
				credits: {
					enabled: false
				},
				plotOptions: {
					areaspline: {
						fillOpacity: 0.5
					}
				},
				series: [{
					name: 'Users',
					data: [500, 600, 690, 730, 812, 964, 1024],
				}, {
					name: 'Groups',
					data: [50, 48, 53, 90, 91, 101, 123]
				}]
			});
		});
	
		
		
		
		
		
		$(function () {
			$('#graph-persons').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Teams & People'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.y}</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.y}',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						}
					}
				},
				series: [{
					type: 'pie',
					name: 'Browser share',
					data: [
						['Players',   49785],
						['Coaches',       1231],
						['Referees',    1244],
						['Teams',     1519],
					]
				}]
			});
		});
		
		
		
		$(function () {
		
			$('#graph-competitions').highcharts({
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Teams & People'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.y}</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.y}',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						}
					}
				},
				series: [{
					type: 'pie',
					name: 'Browser share',
					data: [
						['Competitions',   22],
						['Tournament',       463],
						['Matches',    6136]
					]
				}]
			});
			
		});
		
	</script>
	
	
	
</div>