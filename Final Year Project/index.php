<?php 

    require './inc/header.php'; 
    require './inc/navbar-default.php';
    include './inc/banner.php';
    
    if (isset($_SESSION['usertype'])){
        if($_SESSION['usertype'] == 1){ #if logged in teacher or admin accounts tried accessing the page they are redirected
            header('Location: registration.php');
            exit();
        } else if($_SESSION['usertype'] == 2){
            header('Location: dashboard.php');
            exit();
        }
    }
?>

<div class="main-container">

    <div class="content">
        <div class="activity-container">
            <div class="row">
                <div class="col-sm-12 activities">
                    <div id="english" class="row">
                        <div class="col-sm-6 thumbnail">
                            <a href="activity-page.php?activityID=1">
                                <img src="./img/placeholders/placeholder_1.png">
                            </a>
                        </div>
                        <div class="col-sm-6 thumbnail">
                            <a href="activity-page.php?activityID=1">
                                <img src="./img/placeholders/placeholder_2.png">
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div id="maths" class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6 thumbnail">
                                    <a href="activity-page.php?activityID=1">
                                        <img src="./img/placeholders/placeholder_3.png">
                                    </a>
                                </div>
                                <div class="col-sm-6 thumbnail">
                                    <a href="activity-page.php?activityID=1">
                                        <img src="./img/placeholders/placeholder_4.png">
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 thumbnail">
                                    <a href="activity-page.php?activityID=1">
                                        <img src="./img/placeholders/placeholder_5.png">
                                    </a>
                                </div>
                                <div class="col-sm-4 thumbnail">
                                    <a href="activity-page.php?activityID=1">
                                        <img src="./img/placeholders/placeholder_6.png">
                                    </a>
                                </div>
                                <div class="col-sm-4 thumbnail">
                                    <a href="activity-page.php?activityID=1">
                                        <img src="./img/placeholders/placeholder_7.png">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="science" class="col-sm-4 thumbnail">
                            <a href="activity-page.php?activityID=1">
                                <img src="./img/placeholders/placeholder_8.png">
                            </a>
                        </div>
                    </div>
                    <div id="other" class="row">
                        <div class="col-sm-4 thumbnail">
                            <a href="activity-page.php?activityID=1">
                                <img src="./img/placeholders/placeholder_9.png">
                            </a>
                        </div>
                        <div class="col-sm-4 thumbnail">
                            <a href="activity-page.php?activityID=1">
                                <img src="./img/placeholders/placeholder_10.png">
                            </a>
                        </div>
                        <div class="col-sm-4 thumbnail">
                            <a href="activity-page.php?activityID=1">
                                <img src="./img/placeholders/placeholder_11.png">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-content">
            <div class="row">
                <div class="col-xl-6">
                    <div class="panel-text-container">
                        <div class="panel-text">
                            <h1>Our Mission</h1>
                            <p>
                                The primary role of a teacher in a classroom is to impart knowledge to their students. Teachers are given a curriculum that they must follow and ensure every child placed in their care understands the content to a satisfactory degree. To test this, standardised exams are taken to assess students’ progress throughout their years in education. This, however, has fallen under scrutiny in recent years on whether this is the best approach. Standardised exams put unneeded stress onto students and recent developments show that teacher assessments are just as accurate at predicting future success as standardised test anyway and is much less detrimental to students’ mental health. This has prompted me to create a tool that helps teachers in their assessment practises, with the hope that, with advancement in teacher assessment technologies, we can move away from these standardised tests which in turn will increase student mental wellbeing, increase accuracy of assessment and increase quality of teaching.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="carousel-container">
                        <div class="my-carousel">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="./img/education.png">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="./img/education2.png">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require './inc/footer.php'; ?>
