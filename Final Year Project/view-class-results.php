<?php 
    require './inc/dbh.inc.php';
    require './inc/header.php'; 
    require './inc/navbar-teacher.php';
    include './inc/banner.php';

    if (!isset($_SESSION['usertype'])){ #if the user isn't logged in then they are redirected to the loggin page
        header('Location: login.php');
        exit();
    } else {
        if($_SESSION['usertype'] == 1){ #if a admin or student account tried accessing then they get redirected
            header('Location: registration.php');
            exit();
        } else if($_SESSION['usertype'] == 3){
            header('Location: index.php');
            exit();
        }
    }
?>

<div class="main-container">
    <div class="view-results-page">
        <div class="content">
            <!--If no results found, user is told. Message changes depending on type of error-->
            <div id="class-message">
                No Records Stored
            </div>
            <!--visualisation container-->
            <div id="class-visualisation" class="hide">
                <div class="results-overview">
                    <div class="row">
                        <div class="col-md-6">
                            <div id="class-attempts"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="class-average-time-taken"></div>
                        </div>
                    </div>
                </div>
                <div id="class-pie-chart-container" class="quiz-information">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="class-pie-chart-correct"> 
                                <canvas id="class-piechart-good"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div id="class-pie-chart-incorrect"> 
                                <canvas id="class-piechart-bad"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="class-bar-chart-container" class="quiz-information">
                    <div id="class-bar-chart"> 
                        <canvas id="class-barchart"></canvas>
                    </div>
                </div>
                <!--smaller screens can't view charts well, so they get shown this message instead-->
                <div id="class-chart-message" class="hide">
                    Please move to a larger device to see more data on this student.
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './inc/footer.php'; ?>