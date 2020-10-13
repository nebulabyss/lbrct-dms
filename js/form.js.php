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
        let mod = triggerID + (rowCount - 1);
        $(this).attr('id', mod);
        $(this).focus();
    }
});

$('#removeRow').click(function() {
    let lastFormDiv = '#row' + rowCount;
    if (rowCount === 0){
        $(lastFormDiv).remove();
        formInstance();
    }
    if (rowCount > 0) {
        $(lastFormDiv).fadeOut();
        rowCount--;
        lineNum--;
        let mod = '#' + triggerID + (rowCount);
        $(mod).attr('id', triggerID);
    }
});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});