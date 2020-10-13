// Name of the file appears on select
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
});

$('#site').change( function () {
    $('#customFile').focus();
});