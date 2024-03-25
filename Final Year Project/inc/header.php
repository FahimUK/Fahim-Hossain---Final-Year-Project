<?php
    session_start(); #header is in all webpages, having the session start here ensure the session is accessable in all pages
    $current_page = basename($_SERVER['SCRIPT_NAME']); #determine what the current file is
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="author" content=" Fahim Hossain ">
    
    <!-- Place your icon here -->
    <!--- <link rel="icon" href="home-favicon.ico"> -->

    <title> 
        <?php #Depending on what the current file is, the title on the browser changes
            if($current_page == 'view-results.php'){ echo 'Results Page';}
            else if($current_page == 'view-class-results.php'){ echo 'Class Results Page';}
            else if($current_page == 'teacher-profile.php'){ echo 'Your Profile';}
            else if($current_page == 'student-profile.php'){ echo 'Student Profile';}
            else if($current_page == 'registration.php'){ echo 'Registration Page';}
            else if($current_page == 'login.php'){ echo 'Login Page';}
            else if($current_page == 'give-assignment.php'){ echo 'Assignment Page';}
            else if($current_page == 'dashboard.php'){ echo 'Dashboard';}
            else if($current_page == 'add-student.php'){ echo 'Student Registration Page';}
            else if($current_page == 'activity-page.php'){ echo 'Activity Page';}
            else if($current_page == 'index.php'){ echo 'Home';}
        ?>
    </title>

    <!--fonts, stylesheet, bootstrap and awesomefont-->
    <link href="https://fonts.googleapis.com/css?family=Coming+Soon|Chewy|Karla|Alfa+Slab+One|Orbitron&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="css/styles.css" type="text/css">

</head>

<body>
