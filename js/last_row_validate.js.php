$('#submit').on('click', function (event) {
    let lastRow = document.getElementById('row' + rowCount);
    let fields = lastRow.getElementsByClassName('validate');
    let fieldCount = 0;
    for (let i = 0; i < fields.length; i++) {
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
        let message = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>ERROR:</strong> Form fields are empty.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>`;
        $('h3').before(message);
    } else {
        let lastFormDiv = '#row' + rowCount;
        $(lastFormDiv).remove();
        rowCount--;
        lineNum--;
        let mod = '#' + triggerID + (rowCount);
        $(mod).attr('id', triggerID);
    }
})