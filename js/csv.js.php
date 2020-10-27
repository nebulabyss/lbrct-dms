$('#csv').on('click', function () {
    window.setTimeout(function () {
        var csvData = ToCSV();
        // console.log(csvData);
        var blob = new Blob([csvData], {type: 'text/csv'});
        var a = window.document.createElement('a');
        a.href = window.URL.createObjectURL(blob);
        var filename = 'report.';
        a.download = filename + 'csv';
        // Append anchor to body.
        document.body.appendChild(a);
        a.click();
        // Remove anchor from body
        document.body.removeChild(a);
    }, 10);
});

function ToCSV() {
    var newLine = "\r\n";
    var quote = "\"";
    var csv = "";
    var delimiter = ",";
    var dataTable = document.getElementById("data-table");
    var rows = dataTable.rows;
    for (var rowIndex = 0; rowIndex < rows.length; rowIndex++) {
        var row = rows[rowIndex];
        var cells = row.cells;
        for (var cellIndex = 0; cellIndex < cells.length; cellIndex++) {
            var cell = cells[cellIndex];
            if (cell.previousElementSibling != null)
                csv += delimiter;

            csv += quote + sanitize(cell.innerText) + quote;
        }
        csv += newLine
    }
<?php if ($csv_columns) {
    echo ('csv = csv.substr(0, 47) + \'\r\n"string","number","number"\' + csv.substr(47);');
}?>
    return csv;
}

// NOTE: CSV quote escaping and whitespace cleanup
function sanitize(strValue) {
    return strValue
        .replace(/"/g, "\"\"")
        .replace(/\n/g, " ")
        .replace(/\r/g, " ")
        .replace(/\t/g, " ")
        .trim();
}