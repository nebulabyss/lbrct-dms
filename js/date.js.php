let date_picker = $('#datepicker');
date_picker.datepicker({
    dateFormat:  "yy-mm-dd",
    showOtherMonths: true,
    selectOtherMonths: true,
    firstDay: 1,
    changeMonth: true,
    changeYear: true,
    onChangeMonthYear: function(year, month){
        $(this).datepicker( "setDate", year + '-' + month + '-01' );
    }
});

date_picker.change(function() {
    $('fieldset').prop('disabled', false);
    $('#next').focus();
});

$('#cal-btn').click(function (){
    date_picker.datepicker('show');
});