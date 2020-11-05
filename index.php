<?php
include './includes/auth.php';
include 'pdo.php';
include 'classes/FormProcessor.php';
include 'classes/DatabaseController.php';

if (isset($_SESSION['TEMP'])) {
    unset($_SESSION['TEMP']);
}

if (!isset($_SESSION['USER_ID'])) {
    header('Location: login.php');
    exit;
}

include './includes/header.php';
$database_controller = new DatabaseController($pdo);
$boat_trans = $database_controller->CheckForTransgressions();
?>
    <body>
<div class="container-fluid">
    <?php include './includes/nav.php'; ?>
    <?php if ($boat_trans): ?>
        <div>
            <h4 class="text-danger mt-5 text-center">There are transgressions to be processed</h4>
        </div>
    <?php endif; ?>
</div>
<div id="landing" style="color: #E5E4E2; margin-left: 16px; bottom: 0;position: fixed; font-size: small;">
    <div id="heading" class="">Version: </div>
    <div id="release-date">Released: </div>
    <div>
        <ul id="release-notes" style="padding-left: 16px;">
        </ul>
    </div>
</div>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "https://api.github.com/repos/nebulabyss/lbrct-dms/releases/latest"
        }).then(function(data) {
            $('#heading').append(data.tag_name);
            let releaseNotes = data.body;
            let releaseDate = data.published_at.substring(0, data.published_at.indexOf('T'));
            let text = '';
            let count = 0;
            let position = releaseNotes.indexOf('\r\n');
            let lastPos = releaseNotes.indexOf('- ');

            while (position !== -1) {
                count++;
                text += `<li>${releaseNotes.substring(lastPos + 2, position)}</li>`;
                    lastPos = position + 2;
                position = releaseNotes.indexOf('\r\n', position + 1);
            }
            console.log(count);
            $('#release-body').append(data.body);
            $('#release-date').append(releaseDate);
            $('#release-notes').append(text);
        });
    });
</script>
<?php include './includes/footer.php'; ?>