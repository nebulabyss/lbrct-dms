$('input[type=checkbox').on('click', function (){
    if ($(this).closest('tr').hasClass('bg-warning')) {
        $(this).closest('tr').removeClass('text-black bg-warning');
    }
    $(this).closest('tr').toggleClass('text-white bg-success');
});