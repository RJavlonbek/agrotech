$(function(e) {

	/* Apexchart*/
	var options = {
		chart: {
			height: 241,
			type: 'area',
			stacked: true,
			events: {
			  selection: function(chart, e) {
				console.log(new Date(e.xaxis.min) )
			  }
			},
		},
		colors: ['#0052cc', '#8c8eef', '#b7b9ec'],
		dataLabels: {
		  enabled: false
		},
		stroke: {
			curve: 'smooth'
		},
		series: [{
                name: 'Customer Retention',
                data: [34, 24, 44, 36, 56, 48, 67, 46, 78, 56]
            },{
                name: 'Resolved Complaints',
                data: [29, 18, 37, 26, 45, 34, 53, 32, 61, 70]
            }, {
                name: 'Unresolved Complaints',
                data: [40, 31, 52, 43, 64, 55, 76, 57, 88, 69]
		}],
		fill: {
			gradient: {
			  enabled: true,
			  opacityFrom: 0.6,
			  opacityTo: 0.8,
			}
		},
			legend: {
			position: 'top',
			horizontalAlign: 'left',
			colors: '#000'
		},
    }
    var chart = new ApexCharts(
      document.querySelector("#chart"),
      options
    );
    chart.render();
    function generateDayWiseTimeSeries(baseval, count, yrange) {
		var i = 0;
		var series = [];
		while (i < count) {
			var x = baseval;
			var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

			series.push([x, y]);
			baseval += 86400000;
			i++;
		}
		return series;
    }

	/*--echart-1---*/

	var myChart2 = echarts.init(document.getElementById('echart-1'));
	var option2 = {
		title: {
			text: '',
			subtext: '',
			x: 'center'
		},
		tooltip: {
			trigger: 'item',
			formatter: "{a} {b} : {c} ({d}%)"
		},
		legend: {
			x: 'center',
			y: 'bottom',
			data: ['Very Excellent', 'Excellent',  'Good', 'Average',  'Bad'],
			textStyle: {
				color: '#000'
			}
		},
		toolbox: {
			show: true,
			feature: {
				mark: {
					show: true
				},
				dataView: {
					show: true,
					readOnly: false
				},
				magicType: {
					show: true,
					type: ['pie']
				},
				restore: {
					show: true
				},
				saveAsImage: {
					show: true
				}
			}
		},
		calculable: true,
		series: [{
			name: '',
			type: 'pie',
			radius: [20, 110],
			center: ['50%', '50%'],
			roseType: 'radius',
			label: {
				normal: {
					show: false
				},
				emphasis: {
					show: true
				}
			},
			lableLine: {
				normal: {
					show: false
				},
				emphasis: {
					show: true
				}
			},
			data: [{
				value: 56,
				name: 'Very Excellent'
			}, {
				value: 53,
				name: 'Excellent'
			}, {
				value: 46,
				name: 'Good'
			}, {
				value: 30,
				name: 'Average'
			},{
				value: 15,
				name: 'Bad'
			}]
		}, ],
		color: ['#0052cc', '#0099ff', '#21c44c', '#ffb209 ', '#f5334f']
	};
	myChart2.setOption(option2);
	/*--echart-1---*/

	/* Chartjs (#revenue) */
	var myCanvas = document.getElementById("revenue");
	myCanvas.height="280";
	var myCanvasContext = myCanvas.getContext("2d");
	var gradientStroke1 = myCanvasContext.createLinearGradient(0, 0, 0, 380);
	gradientStroke1.addColorStop(0, '#0052cc');
	gradientStroke1.addColorStop(1, '#0052cc');

	var gradientStroke2 = myCanvasContext.createLinearGradient(0, 0, 0, 300);
	gradientStroke2.addColorStop(0, '#8c8eef');
	gradientStroke2.addColorStop(1, '#8c8eef');

	var myChart = new Chart(myCanvas, {
		type: 'bar',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "July", "Aug", "Sep", "Oct", "Nov", "Dec"],
			datasets: [{
				label: 'Revenue',
				data: [15, 18, 12, 14, 10, 15, 7, 14, 10, 15, 7, 14],
							backgroundColor: gradientStroke1,
							hoverBackgroundColor: gradientStroke1,
							hoverBorderWidth: 2,
							hoverBorderColor: 'gradientStroke1'
			}, {

			    label: 'Support cost',
				data: [10, 14, 10, 15, 9, 14, 15, 20, 10, 15, 7, 14],
							backgroundColor: gradientStroke2,
							hoverBackgroundColor: gradientStroke2,
							hoverBorderWidth: 2,
							hoverBorderColor: 'gradientStroke2'

			}
		  ]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#000',
				bodyFontColor: '#000',
				backgroundColor: '#fff',
				cornerRadius: 3,
				intersect: false,
			},
			legend: {
				display: false,
				labels: {
					usePointStyle: true,
					fontFamily: 'Montserrat',
				},
			},
			scales: {
				xAxes: [{
					barPercentage:0.5,
					ticks: {
						fontColor: "#000",

					 },
					display: true,
					gridLines: {
						display: true,
						color: '#eaeaea',
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'Month',
						fontColor: 'rgba(0,0,0,0.8)'
					}
				}],
				yAxes: [{
					ticks: {
						fontColor: "rgba(0,0,0,0.8)",
					 },
					display: true,
					gridLines: {
						display: true,
						color: '#eaf2f9',
						drawBorder: false
					},
					scaleLabel: {
						display: false,
						labelString: 'sales',
						fontColor: 'rgba(0,0,0,0.81)'
					}
				}]
			},
			title: {
				display: false,
				text: 'Normal Legend'
			}
		}
	});
	/* Chartjs (#revenue) closed */
});


