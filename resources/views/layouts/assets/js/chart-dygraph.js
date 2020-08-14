/*----chart dygraph1---*/
new DateGraph(document.getElementById('dygraph-chart1'), data, null, {
	colors: ["#8543f6", "#ff7e5f", "#17a2b8"]
}, );
/*----chart dygraph2---*/
new DateGraph(document.getElementById("dygraph-chart2"), NoisyData, null, {
	rollPeriod: 5,
	errorBars: true,
	labelsDivWidth: 160,
	labelsDivStyles: {
		'background-color': 'transparent',
		'top': '10px',
		'color': '#000'
	},
	colors: ["#8543f6", "#ff7e5f", "#17a2b8"],
	padding: {
		left: 40,
		top: 0,
		right: 10,
		bottom: 10
	}
});

/*PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=*/


/*----chart dygraph3---*/
new DateGraph(document.getElementById("dygraph-chart3"), NoisyData, null, {
	rollPeriod: 15,
	errorBars: true,
	gridLineColor: MochiKit.Color.Color.purpleColor(),
	highlightCircleSize: 15,
	colors: ["#8543f6", "#ff7e5f", "#17a2b8"],
	strokeWidth: 5,
	padding: {
		left: 40,
		top: 0,
		right: 10,
		bottom: 10
	}
});

/*PMboYSIqMee+p4uAjskftSrErYaF9PDNDn+EGSzR9N2BspYI8=
feCz66HNQhyoUIndT6pXQpWta+PA3e1h3yExMyH1EsOo6f8PXnNPyHGLRfchOSF9WSX7exs=*/