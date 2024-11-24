<?php
require '../../config.php';
require '../../utils/database.php';
require '../../utils/authenticate.php';

$conn = initialize_database();
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/styles/date_of_birth_error.css">
    <link rel="shortcut icon" href="<?php echo BASE_URL; ?>/public/images/logo.webp" type="image/x-icon">
</head>

<body>
    <h2>Modal Example</h2>

    <button id="errorBtn">Open Modal</button>

    <div id="error-panel" class="error">
        <div class="error-content">
            <span class="close">&times;</span>
            <div class="error-message-container">
                <div class="error-message">
                    <div class="error-message-header">
                    <span class="privacy-icon material-symbols-rounded">error</span>
                    <h1>
                        Oops! You must be 18 or older to join. Please come back when you're
                        old enough to mingle!
                    </h1>
                    </div>
                    <p>
                        If you have questions, we're here to <a href="#help">help!</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
    var modal = document.getElementById("error-panel");
    var btn = document.getElementById("errorBtn");
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    };

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    };

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
    </script>
</body>

</html>