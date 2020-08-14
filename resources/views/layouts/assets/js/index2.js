$(function() {

	/*apex-chart*/
    var dates = [15, 49, 35, 78, 29, 36,78, 90, 45, 83, 67, 29, 36,78, 90, 45, 83, 67, 29, 36,78, 90, 45, 83, 67, 29, 36,78, 90, 45, 83, 67];
	var options = {
		chart: {
			height: 230,
			stacked: false,
			type: 'area',
			zoom: {
				enabled: true
			}
		},
		plotOptions: {
			line: {
			  curve: 'smooth',

			}
		},
		dataLabels: {
			enabled: false
		},
		series: [{
			name: 'Main Project',
			data: dates
		}],
		colors: ['#0052cc'],
		markers: {
			size: 0,
			style: 'full',
		},

    }
	var chart = new ApexCharts(
		document.querySelector("#chart"),
		options
	);
	chart.render();
	/*apex-chart*/

	/*apex-chart*/
	var options = {
		chart: {
			height: 300,
			type: 'bar',
			stacked: true,
		},
		plotOptions: {
			bar: {
				horizontal: true,
			},

		},
		stroke: {
			width: 1,
			colors: ['#fff']
		},
		series: [{
			name: 'Users',
			data: [35, 45, 32, 45, 30, 53, 36]
		},{
			name: 'Page Views',
			data: [45, 56, 22, 38, 60, 59, 44]
		},{
			name: 'New Users',
			data: [36, 21, 15, 12, 15, 20, 30]
		}],
		xaxis: {
			categories: [2013, 2014, 2015, 2016, 2017, 2018, 2019],
			labels: {
				formatter: function(val) {
					return val + ""
				}
			}
		},
		yaxis: {
			title: {
				text: undefined
			},

		},
		tooltip: {
			y: {
				formatter: function(val) {
				return val + ""
			}
			}
		},
		fill: {
			opacity: 1

		},
		colors: ['#0052cc' ,'#8c8eef' ,'#b7b9ec'],
		legend: {
			position: 'top',
			horizontalAlign: 'center',
			offsetX: 10
		}
	}
	var chart = new ApexCharts(
		document.querySelector("#stacked-bar"),
		options
	);
    chart.render();
	/*apex-chart*/

	/*PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=*/
	/* Hight chart*/
	var chart;
	$(function(e) {
		var perShapeGradient = {
			x1: 0,
			y1: 0,
			x2: 0,
			y2: 1.5
		};
		var colors = Highcharts.getOptions().colors;
		colors = [{
			linearGradient: perShapeGradient,
			stops: [
				[0, '#0052cc'],
				[1, '#0052cc']
			]
		}, {
			linearGradient: perShapeGradient,
			stops: [
				[0, '#0099ff'],
				[1, '#0099ff']
			]
		}, {
			linearGradient: perShapeGradient,
			stops: [
				[0, '#ffb209'],
				[1, '#ffb209']
			]
		}, {
			linearGradient: perShapeGradient,
			stops: [
				[0, '#ff1a1a'],
				[1, '#ff1a1a']
			]
		}, {
			linearGradient: perShapeGradient,
			stops: [
				[0, '#21c44c'],
				[1, '#21c44c']
			]
		}, ]
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'container',
				type: 'column'
			},
			title: {
				text: null
			},
			xAxis: {
				categories: ['Dominica', 'Singapore', 'Maldives', 'Bahrain', 'Monaco']
			},
			plotOptions: {
				column: {
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: colors[0],
						style: {
							fontWeight: 'bold'
						},
						formatter: function() {
							return this.y + '%';
						}
					}
				},
				series: {
					pointWidth: 7
				}
			},
			series: [{
				name: name,
				data: [{
					y: 55.11,
					color: colors[0]
				}, {
					y: 43.63,
					color: colors[1]
				}, {
					y: 38.63,
					color: colors[2]
				}, {
					y: 49.63,
					color: colors[3]
				}, {
					y: 36.94,
					color: colors[4]
				}],
				color: 'white'
			}],
			legend: {
				enabled: false
			},
			yAxis: {
				min: 0,
				title: {
					text: null
				},
				stackLabels: {
					enabled: true
				}
			},
		});
	});
	/* Hight chart closed*/
});

/*PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=*/