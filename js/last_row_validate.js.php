$('#submit').on('click', function (event)  {
    for (let i = rowCount; i >= 0; i--) {
        let lastRow = document.getElementById('row' + i);
        let fields = lastRow.getElementsByClassName('validate');
        let fieldCount = 0;
        for (let n = 0; n < fields.length; n++) {
            if (fields[n].value === '') {
                fieldCount++;
            }
            if (fields[n].type === 'checkbox' && fields[n].checked === false) {
                fieldCount++;
            }
        }

        if (fieldCount < fields.length) {
        } else if (i === 0) {
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
            let lastFormRowDiv = '#row' + i;
            $(lastFormRowDiv).remove();
        }
    }
});