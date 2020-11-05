let start_date_picker = $('.start_datepicker');
start_date_picker.datepicker({
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

let date_picker = $('.datepicker');
date_picker.datepicker({
    dateFormat:  "yy-mm-dd",
    showOtherMonths: true,
    selectOtherMonths: true,
    firstDay: 1,
    changeMonth: true,
    changeYear: true,
    onChangeMonthYear: function(year, month){
        var date = new Date(parseInt(year), parseInt(month) , 0).getDate();
        $(this).datepicker( "setDate", year + '-' + month + '-' + date );
    }
});

$('#start').click(function (){
   $('#start_date').datepicker('show');
});

$('#end').click(function (){
   $('#end_date').datepicker('show');
});

$('#submit').on('click', function (e) {
    var startId = $('#start_date');
    var endId = $('#end_date');
    var startDate = startId.val();
    var endDate = endId.val();
    if (startDate > endDate) {
        e.preventDefault();
        $('.alert').remove();
        let message = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>ERROR:</strong> <u>From</u> date is greater than <u>To</u> date.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>`;
        $('h3').before(message);
    }
});

$('#copy').on('click', function () {
    $(this).attr('title', 'Copied!');
    let toggle = $('[data-toggle="tooltip"]');
    toggle.tooltip('enable');
    toggle.tooltip('show');
    toggle.tooltip('disable');
    $(this).attr('title', '');
});

new ClipboardJS('#copy');