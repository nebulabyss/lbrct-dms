let start_date_picker = $('.start_datepicker');
start_date_picker.datepicker({
    dateFormat: "yy-mm-dd",
    showOtherMonths: true,
    selectOtherMonths: true,
    firstDay: 1,
    changeMonth: true,
    changeYear: true,
    onChangeMonthYear: function (year, month) {
        $(this).datepicker("setDate", year + '-' + month + '-01');
    }
});

let end_date_picker = $('.datepicker');
end_date_picker.datepicker({
    dateFormat: "yy-mm-dd",
    showOtherMonths: true,
    selectOtherMonths: true,
    firstDay: 1,
    changeMonth: true,
    changeYear: true,
    onChangeMonthYear: function (year, month) {
        var date = new Date(parseInt(year), parseInt(month), 0).getDate();
        $(this).datepicker("setDate", year + '-' + month + '-' + date);
    }
});

$('#start').click(function () {
    $('#start_date').datepicker('show');
});

$('#end').click(function () {
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

let currentDate = new Date();
let currentYear = currentDate.getFullYear();
let currentMonth = currentDate.getMonth() + 1;
let previousYear = currentYear - 1;
let firstQuarter = ["-07-01", "-09-30"];
let secondQuarter = ["-10-01", "-12-31"];
let thirdQuarter = ["-01-01", "-03-31"];
let fourthQuarter = ["-04-01", "-06-30"];
let currentFinYearStart = 0;
let currentFinYearEnd = 0;
let previousFinYearStart = 0;
let previousFinYearEnd = 0;

dateRanges = function () {
    if (currentMonth >= 7) {
        currentFinYearStart = currentYear;
        currentFinYearEnd = currentYear + 1;
        previousFinYearStart = currentYear - 1;
        previousFinYearEnd = currentYear;
    }

    if (currentMonth <= 6) {
        currentFinYearStart = currentYear - 1;
        currentFinYearEnd = currentYear;
        previousFinYearStart = currentYear - 2;
        previousFinYearEnd = currentYear - 1;
    }

    let rangeSelector = /** @lang HTML */
        `
            <option selected value="">Select date range</option>
            <option value="0">Q1: July to September ${currentFinYearStart}</option>
            <option value="1">Q2: October to December ${currentFinYearStart}</option>
            <option value="2">Q3: January to March ${currentFinYearEnd}</option>
            <option value="3">Q4: April to July ${currentFinYearEnd}</option>
            <option value="4">Current Financial Year: ${currentFinYearStart} - ${currentFinYearEnd}</option>
            <option value="5">Previous Financial Year: ${previousFinYearStart} - ${previousFinYearEnd}</option>

        `;

    $('#range-options').append(rangeSelector);
}
dateRanges();

rangeOptions = $('#range-options');
$(rangeOptions).on('change', function () {
    if (rangeOptions.val() === "0") {
        start_date_picker.val(currentFinYearStart + firstQuarter[0]);
        end_date_picker.val(currentFinYearStart + firstQuarter[1]);
    }

    if (rangeOptions.val() === "1") {
        start_date_picker.val(currentFinYearStart + secondQuarter[0]);
        end_date_picker.val(currentFinYearStart + secondQuarter[1]);
    }

    if (rangeOptions.val() === "2") {
        start_date_picker.val(currentFinYearEnd + thirdQuarter[0]);
        end_date_picker.val(currentFinYearEnd + thirdQuarter[1]);
    }

    if (rangeOptions.val() === "3") {
        start_date_picker.val(currentFinYearEnd + fourthQuarter[0]);
        end_date_picker.val(currentFinYearEnd + fourthQuarter[1]);
    }

    if (rangeOptions.val() === "4") {
        start_date_picker.val(currentFinYearStart + firstQuarter[0]);
        end_date_picker.val(currentFinYearEnd + fourthQuarter[1]);
    }

    if (rangeOptions.val() === "5") {
        start_date_picker.val(previousFinYearStart + firstQuarter[0]);
        end_date_picker.val(previousFinYearEnd + fourthQuarter[1]);
    }
});

