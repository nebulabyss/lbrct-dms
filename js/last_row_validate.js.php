$('#submit').on('click', function (event) {
    var lastRow = document.getElementById('row' + rowCount);
    var fields = lastRow.getElementsByClassName('validate');
    var fieldCount = 0;
    for (var i = 0; i < fields.length; i++) {
        if (fields[i].value === '') {
            fieldCount++;
        }
        if (fields[i].type === 'checkbox' && fields[i].checked === false) {
            fieldCount++;
        }
    }

    if (fieldCount < fields.length) {
    } else if (rowCount === 0) {
        event.preventDefault();
        $('.alert').remove();
        var message = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>ERROR:</strong> Form fields are empty.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>`;
        $('h3').before(message);
    } else {
        let lastFormDiv = '#row' + rowCount;
        if (rowCount === 0) {
            event.preventDefault();
        }
        if (rowCount > 0) {
            $(lastFormDiv).remove();
            rowCount--;
            lineNum--;
            let mod = '#' + triggerID + (rowCount);
            $(mod).attr('id', triggerID);
        }
    }
})