<?php include(dirname(__FILE__) . '/admin.php'); 

if(isAdmin()){
?>

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
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false
				},
				title: {
					text: 'Users'
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
						['Users',   <?php echo $this->users ?>],
						['Groups',       <?php echo $this->groups ?>],
						['Total Bets',    <?php echo $this->bets ?>]
					]
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
						['Players',   <?php echo $this->players ?>],
						['Coaches',       <?php echo $this->coaches ?>],
						['Referees',    <?php echo $this->referees ?>],
						['Teams',     <?php echo $this->teams ?>],
					]
				}]
			});
		});
		
		
		
		
		
		
		
		$(function () {
		
			$('#graph-competitions').highcharts({
				chart: {
					type: 'pyramid',
					marginRight: 100
				},
				title: {
					text: 'Competitions',
					x: -50
				},
				plotOptions: {
					series: {
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b> ({point.y:,.0f})',
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
							softConnector: true
						}
					}
				},
				legend: {
					enabled: false
				},
				series: [{
					name: 'Total',
					data: [
						['Matches',    <?php echo $this->matches ?>],
						['Tournaments',   <?php echo $this->tournaments ?>],
						['Competitions',   <?php echo $this->competitions ?>],
					]
				}]
			});
		});
		
		
		
	</script>
	
	
	
</div>

<?php } ?>