<body>
<div class="container-fluid">
    <?php require_once "./includes/nav.php"; ?>
    <div>
        <h3 class="text-muted mt-2">Bird count</h3>
        <form action="./bird_count.php" method="post">
            <div class="form-row mb-2">
                <?php include './includes/date_picker.php' ?>
                <fieldset class="form-row" disabled>
                    <div class="col">
                        <label for="next" class="ui-helper-hidden"></label>
                        <select class="form-control bg-warning custom-select" id="next" name="zone" required>
                            <option selected value="">Zone</option>
                            <?php
                            if (isset($zones)) {
                                foreach ($zones as $k => $v):
                                    echo('<option value="' . $k . '">' . $v . '</option>');
                                endforeach;
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="start_time" class="col-form-label">Start Time:</label>
                    </div>
                    <div class="col">
                        <input type="time" class="form-control bg-warning" id="start_time" name="start_time" required>
                    </div>
                    <div>
                        <label for="end_time" class="col-form-label">End Time:</label>
                    </div>
                    <div class="col">
                        <input type="time" class="form-control bg-warning" id="end_time" name="end_time" required>
                    </div>
                </fieldset>
            </div>
            <fieldset disabled>
                <div class="form-body" id="form-body">

                </div>
            </fieldset>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addSpeciesModal">Add species
            </button>
            <?php include './includes/remove_row_botton.php' ?>
            <div class="float-right">
                <?php include './includes/cancel_button.php' ?>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal Start -->
<div class="modal fade" id="addSpeciesModal" tabindex="-1" role="dialog" aria-labelledby="addSpeciesModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-muted" id="addSpeciesModalTitle">Add bird species</h5>
            </div>
            <div class="modal-body">
                <form id="addSpecies" method="post">
                    <div class="form-row">
                        <div class="col">
                            <label>
                                <input type="text" class="form-control" name="species_name" placeholder="Common Name">
                            </label>
                        </div>
                        <div class="form-group col">
                            <label for="inputState" class="ui-helper-hidden"></label>
                            <select id="inputState" name="species_type" class="form-control">
                                <option value="1" selected>Water-associated</option>
                                <option value="2">Terrestrial</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal End -->
<script>
    <?php include './js/form_variables.js.php'?>
    function generateFormRow(rc, ln) {
        formHtml = '<div class="form-row mb-2" id="row' + rowCount + '"> \
                   <label class="col-form-label d-inline-block text-center" style="width: 30px;">' + ln + '</label> \
                      <div class="col-3"> \
                        <input id="species" type="text" class="form-control" placeholder="Species Name" name="row[' + rc + '][species]" required> \
                  </div> \
                  <div class="col"> \
                    <input type="text" class="form-control" placeholder="Count" name="row[' + rc + '][count]" required> \
                  </div> \
                  <div class="col"> \
                    <select class="form-control custom-select" name="row[' + rc + '][behaviour]"><option selected value="">Behaviour</option> \ <?php
            if (isset($behavior_codes)) {
                foreach ($behavior_codes as $k => $v):
                    echo('<option value="' . $k . '">' . $v . '</option>');
                endforeach;
            }
            ?>
                    </select> \
                  </div> \
                  <div class="col"> \
                    <select class="form-control custom-select" name="row[' + rc + '][habitat]"><option selected value="">Habitat</option> \ <?php
            if (isset($habitat_codes)) {
                foreach ($habitat_codes as $k => $v):
                    echo('<option value="' . $k . '">' . $v . '</option>');
                endforeach;
            }
            ?>
                  </select> \
                  </div> \
                  <div class="col"> \
                    <input type="text" class="form-control" placeholder="Latitude" name="row[' + rc + '][lat]"> \
                  </div> \
                  <div class="col"> \
                    <input type="text" id="final" class="form-control" placeholder="Longitude" name="row[' + rc + '][longt]"> \
                  </div> \
        </div>'
        return formHtml;
    }
    <?php include './js/form.js.php'?>
    <?php include './js/date.js.php'?>
    <?php include './js/bird_species.js.php'?>
</script>