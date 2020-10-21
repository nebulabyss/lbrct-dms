$('#submit').on('click', function(event) {
    var fields = document.getElementsByClassName('validate');
    console.log(fields);
    console.log(fields.length);
    var fieldCount = 0;
    for (var i = 0; i < fields.length; i++) {
        if (fields[i].textLength === 0) {
            fieldCount++;
        }
    }
    if (fieldCount < fields.length) {
    } else {
        event.preventDefault();
        $('.alert').remove();
        var message = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>ERROR:</strong> Form fields are empty.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>`;
        $('h3').before(message);
    }
})