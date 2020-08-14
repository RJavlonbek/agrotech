$(function(e) {

	/*----AreaChart1----*/
	var ctx = document.getElementById( "AreaChart1" );
	var myChart = new Chart( ctx, {
		type: 'line',
		data: {
			labels: ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'],
			type: 'line',
			datasets: [ {
				data: [10, 45, 32, 67, 89, 72, 200],
				label: 'Sessions',
				backgroundColor: 'transparent',
				backgroundColor: 'rgb(42, 46, 210,0.05)',
				borderColor: 'rgba(42, 46, 210,0.1)',
				borderWidth: '3',
				pointBorderColor: 'transparent',
				pointBackgroundColor: 'transparent',
			}
			]
		},
		options: {

			maintainAspectRatio: false,
			legend: {
				display: false
			},
			responsive: true,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#7886a0',
				bodyFontColor: '#7886a0',
				backgroundColor: '#fff',
				titleFontFamily: 'Montserrat',
				bodyFontFamily: 'Montserrat',
				cornerRadius: 3,
				intersect: false,
			},
			scales: {
				xAxes: [ {
					gridLines: {
						color: 'transparent',
						zeroLineColor: 'transparent'
					},
					ticks: {
						fontSize: 2,
						fontColor: 'transparent'
					}
				} ],
				yAxes: [ {
					display:false,
					ticks: {
						display: false,
					}
				} ]
			},
			title: {
				display: false,
			},
			elements: {
				line: {
					borderWidth: 1
				},
				point: {
					radius: 4,
					hitRadius: 10,
					hoverRadius: 4
				}
			}
		}
	} );
	/*----End AreaChart1----*/

	/*----AreaChart2----*/
	var ctx = document.getElementById( "AreaChart2" );
	var myChart = new Chart( ctx, {
		type: 'line',
		data: {
			labels: ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'],
			type: 'line',
			datasets: [ {
				data: [10, 45, 32, 67, 89, 72, 200],
				label: 'Sessions',
				backgroundColor: 'transparent',
				backgroundColor: 'rgb(0, 153, 255,0.05)',
				borderColor: 'rgba(0, 153, 255,0.1)',
				borderWidth: '3',
				pointBorderColor: 'transparent',
				pointBackgroundColor: 'transparent',
			}
			]
		},
		options: {

			maintainAspectRatio: false,
			legend: {
				display: false
			},
			responsive: true,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#7886a0',
				bodyFontColor: '#7886a0',
				backgroundColor: '#fff',
				titleFontFamily: 'Montserrat',
				bodyFontFamily: 'Montserrat',
				cornerRadius: 3,
				intersect: false,
			},
			scales: {
				xAxes: [ {
					gridLines: {
						color: 'transparent',
						zeroLineColor: 'transparent'
					},
					ticks: {
						fontSize: 2,
						fontColor: 'transparent'
					}
				} ],
				yAxes: [ {
					display:false,
					ticks: {
						display: false,
					}
				} ]
			},
			title: {
				display: false,
			},
			elements: {
				line: {
					borderWidth: 1
				},
				point: {
					radius: 4,
					hitRadius: 10,
					hoverRadius: 4
				}
			}
		}
	} );
	/*----End AreaChart2----*/

	/*----AreaChart3----*/
	var ctx = document.getElementById( "AreaChart3" );
	var myChart = new Chart( ctx, {
		type: 'line',
		data: {
			labels: ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'],
			type: 'line',
			datasets: [ {
				data: [10, 45, 32, 67, 89, 72, 200],
				label: 'Sessions',
				backgroundColor: 'transparent',
				backgroundColor: 'rgb(237, 49, 76,0.05)',
				borderColor: 'rgba(237, 49, 76,0.1)',
				borderWidth: '3',
				pointBorderColor: 'transparent',
				pointBackgroundColor: 'transparent',
			}
			]
		},
		options: {

			maintainAspectRatio: false,
			legend: {
				display: false
			},
			responsive: true,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#7886a0',
				bodyFontColor: '#7886a0',
				backgroundColor: '#fff',
				titleFontFamily: 'Montserrat',
				bodyFontFamily: 'Montserrat',
				cornerRadius: 3,
				intersect: false,
			},
			scales: {
				xAxes: [ {
					gridLines: {
						color: 'transparent',
						zeroLineColor: 'transparent'
					},
					ticks: {
						fontSize: 2,
						fontColor: 'transparent'
					}
				} ],
				yAxes: [ {
					display:false,
					ticks: {
						display: false,
					}
				} ]
			},
			title: {
				display: false,
			},
			elements: {
				line: {
					borderWidth: 1
				},
				point: {
					radius: 4,
					hitRadius: 10,
					hoverRadius: 4
				}
			}
		}
	} );
	/*----End AreaChart3----*/

	/*----AreaChart4----*/
	var ctx = document.getElementById( "AreaChart4" );
	var myChart = new Chart( ctx, {
		type: 'line',
		data: {
			labels: ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'],
			type: 'line',
			datasets: [ {
				data: [10, 45, 32, 67, 89, 72, 200],
				label: 'Sessions',
				backgroundColor: 'transparent',
				backgroundColor: 'rgb(42, 169, 36,0.05)',
				borderColor: 'rgba(42, 169, 36,0.1)',
				borderWidth: '3',
				pointBorderColor: 'transparent',
				pointBackgroundColor: 'transparent',
			}
			]
		},
		options: {

			maintainAspectRatio: false,
			legend: {
				display: false
			},
			responsive: true,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#7886a0',
				bodyFontColor: '#7886a0',
				backgroundColor: '#fff',
				titleFontFamily: 'Montserrat',
				bodyFontFamily: 'Montserrat',
				cornerRadius: 3,
				intersect: false,
			},
			scales: {
				xAxes: [ {
					gridLines: {
						color: 'transparent',
						zeroLineColor: 'transparent'
					},
					ticks: {
						fontSize: 2,
						fontColor: 'transparent'
					}
				} ],
				yAxes: [ {
					display:false,
					ticks: {
						display: false,
					}
				} ]
			},
			title: {
				display: false,
			},
			elements: {
				line: {
					borderWidth: 1
				},
				point: {
					radius: 4,
					hitRadius: 10,
					hoverRadius: 4
				}
			}
		}
	} );
	/*----End AreaChart4----*/

	/* sparkline_bar1 */
	$(".sparkline_bar1").sparkline([3, 4, 3, 4, 5, 4,5,3,4,5,2,6,4], {
		type: 'bar',
		height: 70,
		width:270,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#7577e0'
	});
	/* sparkline_bar1 end */

	/* sparkline_bar1 */
	$(".sparkline_bar2").sparkline([3, 4, 3, 4, 5, 4,5,3,4,5,2,6,3], {
		type: 'bar',
		height: 70,
		width:270,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#90d5ec'
	});
	/* sparkline_bar1 end */

	/* sparkline_bar1 */
	$(".sparkline_bar3").sparkline([3, 4, 3, 4, 3, 4,2,3,4,5,2], {
		type: 'bar',
		height: 70,
		width:270,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#f38181'
	});
	/* sparkline_bar1 end */

	/* sparkline_bar1 end */

	/*---ChartJS (#barChart)---*/
	var ctx = document.getElementById("barChart");
	ctx.height = "260";
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
			datasets: [{
				label: "Total Orders",
				data: [65, 59, 80, 81, 56, 55, 40],
				borderColor: "##0052cc",
				borderWidth: "0",
				barWidth: "1",
				backgroundColor: "#0052cc"
			},{
				label: "Total Sales",
				data: [54, 78, 60, 58, 78, 65, 80],
				borderColor: "#8c8eef",
				borderWidth: "0",
				barWidth: "1",
				backgroundColor: "#8c8eef"
			}, {
				label: "Total Profits",
				data: [28, 48, 40, 19, 66, 27, 50],
				borderColor: "#b7b9ec",
				borderWidth: "0",
				barWidth: "1",
				backgroundColor: "#b7b9ec"
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				xAxes: [{
					ticks: {
						fontColor: "#000",
					 },
					gridLines: {
						display: false,
					}
				}],
				yAxes: [{
					ticks: {
						beginAtZero: true,
						fontColor: "#000",
					},
					gridLines: {
						display: false
					},
				}]
			},
			legend: {
				labels: {
					fontColor: "#000"
				},
			},
		}
	});
	/*---ChartJS (#barChart) closed---*/

	/*-----WidgetChart1 CHARTJS-----*/
	var ctx = document.getElementById("widgetChart1");
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ['Mon', 'Tues', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'],
			type: 'line',
			datasets: [{
				label: "New Customers",
				backgroundColor: "rgb(0, 153, 255,0.6)",
				data: [2, 7, 3, 9, 4, 5, 2, 8, 4, 6, 5, 2, 8, 4, 7, 2, 4, 6, 4, 8, 4]
			}, {
				label: "Existing Customers",
				backgroundColor: "rgb(42, 46, 210,0.9)",
				data: [5, 3, 9, 6, 5, 9, 7, 3, 5, 2, 5, 3, 9, 6, 5, 9, 7, 3, 5, 2]
			}]
		},
		options: {
			maintainAspectRatio: false,
			legend: {
				display: false
			},
			responsive: true,
			tooltips: {
				mode: 'index',
				titleFontSize: 12,
				titleFontColor: '#000',
				bodyFontColor: '#000',
				backgroundColor: '#fff',
				cornerRadius: 0,
				intersect: false,
			},
			scales: {
				xAxes: [{
					gridLines: {
						color: 'transparent',
						zeroLineColor: 'transparent'
					},
					ticks: {
						fontSize: 2,
						fontColor: 'transparent'
					}
				}],
				yAxes: [{
					display: false,
					ticks: {
						display: false,
					}
				}]
			},
			title: {
				display: false,
			},
			elements: {
				line: {
					borderWidth: 2
				},
				point: {
					radius: 0,
					hitRadius: 10,
					hoverRadius: 4
				}
			}
		}
	});

 });