
$(document).on('click', '#warning', function (){
    if (document.getElementById('warning').checked) {
    $('#fine').attr('disabled', true);
    } else {
        $('#fine').attr('disabled', false);
    }
});

$(document).on('click', '#fine', function (){
    if (document.getElementById('fine').checked) {
    $('#warning').attr('disabled', true);
    } else {
        $('#warning').attr('disabled', false);
    }
});
