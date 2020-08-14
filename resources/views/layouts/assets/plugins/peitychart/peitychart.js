	/* Updating chart */
    $("span.graph").peity("pie")
    var updatingChart = $(".updating-chart1").peity("line", { width: "100%",height:50 })

    setInterval(function() {

        var random = Math.round(Math.random() * 30)
        var values = updatingChart.text().split(",")
        values.shift()
        values.push(random)

        updatingChart
            .text(values.join(","))
            .change()
    }, 2500)
	/* Updating chart closed */