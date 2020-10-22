function formInstance() {
    $( '.form-body' ).append(
        generateForm(rowCount, lineNum)
    );
}

$(document).ready(function() {
    formInstance();
});

$(document).on( 'keydown', ('#' + triggerID), function( event ) {
    let keyCode = event.keyCode || event.which;
    if (keyCode === 9) {
        rowCount++;
        lineNum++;
        formInstance();
        let rowId = triggerID + (rowCount - 1);
        $(this).attr('id', rowId);
        $(this).focus();
    }
});

$('#removeRow').click(function() {
    let lastFormRowDiv = '#row' + rowCount;
    if (rowCount === 0){
        $(lastFormRowDiv).remove();
        formInstance();
    }
    if (rowCount > 0) {
        $(lastFormRowDiv).fadeOut();
        rowCount--;
        lineNum--;
        let rowId = '#' + triggerID + (rowCount);
        $(rowId).attr('id', triggerID);
    }
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});