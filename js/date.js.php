let date_picker = $('#datepicker');
date_picker.datepicker({
    dateFormat: "yy-mm-dd",
    showOtherMonths: true,
    selectOtherMonths: true,
    firstDay: 1,
    changeMonth: true,
    changeYear: true,
    numberOfMonths: 2,
    maxDate: "+0M"
});

date_picker.change(function () {
    $('fieldset').prop('disabled', false);
    $('#next').focus();
});

$('#cal-btn').click(function () {
    date_picker.datepicker('show');
});