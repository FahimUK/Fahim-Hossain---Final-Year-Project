<?php 
    require './inc/dbh.inc.php';
    require './inc/header.php'; 
    require './inc/navbar-default.php';

    if (!isset($_SESSION['usertype'])){ #if the user isn't logged in then they are redirected to the loggin page
        header('Location: login.php');
        exit();
    } else {
        if($_SESSION['usertype'] == 1){ #if a admin or student account tried accessing then they get redirected
            header('Location: registration.php');
            exit();
        } else if($_SESSION['usertype'] == 2){
            header('Location: dashboard.php');
            exit();
        }
    }

    if(!empty($_GET['activityID'])){ #as long as the id is in the url. if not send user back to index
        $query = "SELECT * FROM activities WHERE id=?"; #find that activty corresponding to the id in the url
        $statement = mysqli_stmt_init($connection);
        if(mysqli_stmt_prepare($statement, $query)) {
            mysqli_stmt_bind_param($statement, 'i', $_GET['activityID']);
            mysqli_stmt_execute($statement);
            $results = mysqli_stmt_get_result($statement);
            if(!($row = mysqli_fetch_assoc($results))){ #if it isn't found, send user back to index page
                header('Location: index.php');
                exit();
            }
        } else {
            header('Location: index.php'); #if error occured, send user back to index page
            exit();
        }
    } else {
        header('Location: index.php');
        exit();
    }

    include './inc/banner.php';
?>

<div class="container">
    <div class="content">
        <div class="activity-container">
            <!-- tell user that they need javascript for this part of the application -->
            <noscript>
                <p> You need javascript enabled to run this app. </p>
            </noscript>
            <div id="start-page">
                <div class="top-bar"></div>
                <div class="startpage">
                    <img class="startpage-star" src="./img/titlescreen-star.png" />
                    <!-- send this activty id to the activity script to use to store results to database -->
                    <button id="startpage-btn" onclick="titleScreen(<?php echo $_GET['activityID'] ?>)"> Start </button>
                </div>
                <div class="bottom-bar"></div>
            </div>
            <div id="title-page" class="hide">
                <div class="top-bar"></div>
                <div class="titlescreen-page">
                    <img class="titlescreen-star" src="./img/titlescreen-star.png" />
                    <div class="bear-icon-title"></div>
                    <div class="titlescreen-title">Professor Paddington: <br /> Quiz-a-Thon</div>
                </div>
                <button onmouseenter="synth.cancel(); textToSpeech('Play')" id="title-btn"> <i class="fas fa-play"></i> </button>
                <div class="bottom-bar"></div>
            </div>
            <div id="activity" class="hide">
                <div class="top-bar">
                    <button onmouseenter="synth.cancel(); textToSpeech('Exit')" id="home-btn"> <i class="fas fa-home"></i> </button>
                    <button onmouseenter="synth.cancel(); textToSpeech('Repeat')" id="repeat-btn"> <i class="fas fa-redo-alt"></i> </button>
                    <button onmouseenter="synth.cancel(); textToSpeech('Sound Off')" id="mute-btn"> <i id="mute-btn-icon" class="fas fa-volume-up"></i> </button>
                </div>
                <div id="question" class="h1"></div>
                <div id="bear-icon-activity"></div>
                <div id="choices" class="choices">
                    <button class="choice1"></button>
                    <button class="choice2"></button>
                    <button class="choice3"></button>
                    <button class="choice4"></button>
                </div>
                <div class="bottom-bar"></div>
            </div>
            <div id="transition" class="hide">
                <div class="top-bar"></div>
                <div class="transition-page">
                    <img class="transition-star" src="./img/titlescreen-star.png" />
                    <div id="bear-icon-transition"></div>
                    <div id="transition-message"></div>
                </div>
                <div class="bottom-bar">
                    <button id="nextBtn"> Next Question </button>
                </div>
            </div>
            <div id="end-page" class="hide">
                <div class="top-bar"></div>
                <div class="end-page">
                    <div id="end-message"></div>
                    <img class="end-star" src="./img/titlescreen-star.png" />
                    <div class="bear-icon-end"></div>
                    <div class="results">
                        <div id="results-container">
                            <div class="row">
                                <div class="col-xs-4 result-icon">
                                    <i class="fas fa-times-circle result-bad"></i>
                                </div>
                                <div class="col-xs-4 result-icon">
                                    <i class="fas fa-times-circle result-bad"></i>
                                </div>
                                <div class="col-xs-4 result-icon">
                                    <i class="fas fa-times-circle result-bad"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 result-icon">
                                    <i class="fas fa-check-circle result-good"></i>
                                </div>
                                <div class="col-xs-4 result-icon">
                                    <i class="fas fa-times-circle result-bad"></i>
                                </div>
                                <div class="col-xs-4 result-icon">
                                    <i class="fas fa-check-circle result-good"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4 result-icon">
                                    <i class="fas fa-check-circle result-good"></i>
                                </div>
                                <div class="col-xs-4 result-icon">
                                    <i class="fas fa-check-circle result-good"></i>
                                </div>
                                <div class="col-xs-4 result-icon">
                                    <i class="fas fa-times-circle result-bad"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 result-icon">
                                    <i class="fas fa-times-circle result-bad"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom-bar">
                    <button id="endBtn"> Return to homepage </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './inc/footer.php'; ?>
