let date_picker = $('#datepicker');
date_picker.datepicker({
    dateFormat:  "yy-mm-dd"
});

date_picker.change(function() {
    $('fieldset').prop('disabled', false);
    $('#zone').focus();
});