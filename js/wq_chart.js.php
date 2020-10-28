var chart = false;
$('#chart_checkbox').change(function () {
    if (document.getElementById('chart_checkbox').checked) {
        $('#chart_export').attr('hidden', false);
        var chartTable = [];

        function tableToArray() {
            var dataTable = document.getElementById("data-table");
            var rows = dataTable.rows;
            for (var rowIndex = 0; rowIndex < rows.length; rowIndex++) {
                var row = rows[rowIndex];
                var cells = row.cells;
                var tempArray = [];
                for (var cellIndex = 0; cellIndex < cells.length; cellIndex++) {
                    var cell = cells[cellIndex];
                    if (rowIndex > 0 && cellIndex > 0) {
                        tempArray.push(parseFloat(cell.innerText));
                    } else {
                        tempArray.push(cell.innerText);
                    }
                }
                chartTable.push(tempArray);
            }
        }

        tableToArray();
        /**
         * @param google
         * @param google.charts
         * @param google.addColumn
         * @param google.addRows
         * @param google.visualization.DataTable
         * @param google.visualization.LineChart
         * @param google.google.charts.setOnLoadCallback
         * @param chart.draw
         */

// Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages': ['corechart']});
// Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);
// Callback that creates and populates a data table,
// instantiates the chart, passes in the data and
// draws it.
        function drawChart() {
            // Create the data table.
            var data = google.visualization.arrayToDataTable(chartTable);
            // Set chart options
            var options = {
                colors: ['#0097ef', '#d300ea'],
                hAxis: {
                    slantedText: true
                },
                chartArea: {left: 'auto', top: 30, width: '80%'},
                height: 500,
                lineWidth: 5,
                pointSize: 15,
                legend: {position: 'top'}
            };
            // Instantiate and draw chart.
            chart = new google.visualization.LineChart(document.getElementById('chart-div'));
            chart.draw(data, options);
        }
    } else {
        $('#chart_export').attr('hidden', true);
        $('#chart-div').html('');
    }
});

$('#chart_export').on('click', function () {
    var a = document.createElement('a'); //Create <a>
    a.href = chart.getImageURI(); //Image Base64
    a.download = 'chart.png'; //File name
    a.click(); //Downloaded file
});