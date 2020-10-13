$(document).on( 'keydown', '#species', function() {
    $(this).autocomplete({
        source: 'bird_c_name.php'
    });
});
$('#addSpecies').submit(function(event) {
    event.preventDefault();
    let request = $.ajax({
        type: "POST",
        url: 'add_species.php',
        data: $(this).serialize()
    })

    request.done(function () {
        $('#addSpeciesModal').modal('toggle');
        $('input[name="species_name"').val('');
        $('#inputState').prop("selectedIndex", 0);
    });
})