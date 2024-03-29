function addFormRow() {
    $( '.form-body' ).append(
        generateFormRow(rowCount, lineNum)
    );
}

$(document).ready(function() {
    addFormRow();
});

$(document).on( 'keydown', ('#' + triggerID), function( event ) {
    let keyCode = event.keyCode || event.which;
    if (keyCode === 9) {
        rowCount++;
        lineNum++;
        addFormRow();
        let rowId = triggerID + (rowCount - 1);
        $(this).attr('id', rowId); // rename previous rowId to not execute on keydown
        $(this).focus();
    }
});

$('#removeRow').click(function() {
    let lastFormRowDiv = '#row' + rowCount;
    if (rowCount === 0){
        $(lastFormRowDiv).remove();
        addFormRow();
    }
    if (rowCount > 0) {
        $(lastFormRowDiv).remove();
        rowCount--;
        lineNum--;
        let rowId = '#' + triggerID + (rowCount);
        $(rowId).attr('id', rowId); // set current last row to triggerID to execute on keydown
    }
});

$('#addRow').click(function() {
    rowCount++;
    lineNum++;
    addFormRow();
    });

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});