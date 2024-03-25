<?php
#when logging out, delete all session variables, close the session and send user to the home page
session_start();
session_unset();
session_destroy();
header('Location: ../index.php?success');
exit();