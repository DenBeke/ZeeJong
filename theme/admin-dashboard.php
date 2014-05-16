<?php include(dirname(__FILE__) . '/admin.php'); 

if(isAdmin()){
?>

<div class="container">


	<div class="col-md-6">
		<div id="graph-goals-cards"></div>
	</div>
	
	
	
	<div class="col-md-6">
		<div id="graph-competitions"></div>
	</div>
	
	
	
	<div class="col-md-6">
		<div id="graph-users"></div>
	</div>
	
	
	
	
	
	<div class="col-md-6">
		<div id="graph-persons"></div>
	</div>
	
	
	
	<script>
		
		
		$(function () {
		
			$('#graph-goals-cards').highcharts({
				chart: {
					type: 'funnel',
					marginRight: 100
				},
				title: {
					text: 'Cards',
					x: -50
				},
				plotOptions: {
					series: {
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b> ({point.y:,.0f})',
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
							softConnector: true
						},
						neckWidth: '30%',
						neckHeight: '25%'
		
						//-- Other available options
						// height: pixels or percent
						// width: pixels or percent
					}
				},
				legend: {
					enabled: false
				},
				series: [{
					name: 'Cards',
					data: [
						['Matches',   <?php echo $this->matches ?>],
						['Cards', <?php echo $this->cards ?>],
						['Yellow Cards',    <?php echo $this->yellowCards ?>],
						['Second Yellow Cards', <?php echo $this->yellowTwoCards ?>],
						['Red Cards',    <?php echo $this->redCards ?>],
					]
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
					name: 'Total',
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
					name: 'Total',
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