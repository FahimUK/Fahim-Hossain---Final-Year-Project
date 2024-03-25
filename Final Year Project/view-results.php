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

    //GETTING STUDENTS' INFO
    if(!empty($_GET['orderby'])){ #if the ordrby variable isn't empty in the url
        $order = $_GET['orderby']; #order is this variables value
    } else {
        $order = 'firstname'; #otherwise by default it is firstname
    }
    if(!empty($_GET['sort'])){ #if the sort variable isn't empty in the url
        $sort = $_GET['sort']; #sort is this variables value
    } else {
        $sort = 'asc'; #otherwise by default it is asc
    }
    if(!empty($_GET['limit'])){ #if the limit variable isn't empty in the url
        $maxNumRows = $_GET['limit']; #limit is this variables value
    } else {
        $maxNumRows = 5; #otherwise by default it is 5
    }
    if(!empty($_GET['page'])){ #if the page variable isn't empty in the url
        $currentPage = $_GET['page']; #page is this variables value
    } else {
        $currentPage = 1; #otherwise by default it is 1
    }
    $startingRow = ($currentPage - 1) * $maxNumRows; #determine which record to begin from, determined by what page the user is currently on
    $query = "SELECT * FROM students WHERE teacherid=? ORDER BY ".$order.' '.$sort; #query that gets all the student records in the correct order
    $statement = mysqli_stmt_init($connection);
    if(mysqli_stmt_prepare($statement, $query)) {
        mysqli_stmt_bind_param($statement, 'i', $_SESSION['id']);
        mysqli_stmt_execute($statement);
        $studentResults = mysqli_stmt_get_result($statement);
        if(!($studentRow = mysqli_fetch_assoc($studentResults))){ #if no results found, then send user back to dashboard with error message
            header('Location: dashboard.php?error');
            exit();
        }
        #if results, find the number of records to determine the number of pages for pagination
        $numResults = mysqli_num_rows($studentResults);
        $numPages = ceil($numResults / $maxNumRows);
    } else {
        header('Location: dashboard.php?error'); #if an error occured, send user back to dashboard with error message
        exit();
    }

    //GETTING ACTIVITY INFO
    $query = "SELECT * FROM activities"; #get all activity information
    if(mysqli_stmt_prepare($statement, $query) ) {
        mysqli_stmt_execute($statement);
        $activityResults = mysqli_stmt_get_result($statement);
        if(!($activityRow = mysqli_fetch_assoc($activityResults))){ #if no results found, send user back to dashboard with error message
            header('Location: dashboard.php?error');
            exit();
        }
    } else {
        header('Location: dashboard.php?error'); #if an error occured, send user back to dashboard with error message
        exit();
    }

    //GETTING ASSIGNMENT INFO
    $query = "SELECT * FROM activity_assignment"; #get all assignment information
    if(mysqli_stmt_prepare($statement, $query) ) {
        mysqli_stmt_execute($statement);
        $assignmentResults = mysqli_stmt_get_result($statement);
    } else {
        header('Location: dashboard.php?error'); #if an error occured, send user back to dashboard with error message
        exit();
    }
?>

<div class="main-container">
    <div class="view-results-page">
        <div class="tabs">
            <button id="students" class="tab-selected"> Students </button>
            <button id="results" class="tab-unselected"> Results </button>
        </div>
        <div class="content">
            <div class="student-records-container">
                <div id="student-records">
                    <div class="student-records-content">
                        <?php 
                            if(mysqli_data_seek($studentResults,$startingRow)){ #if the student records can start in the stored starting row (if not send user back to dashboard with error message)
                                for($i = 0; $i < $maxNumRows; $i++){ #loop throught from the starting position to the number of rows to show
                                    if(!$studentRow = mysqli_fetch_assoc($studentResults)){ #if loop not over and results finish, break out the loop
                                        break;
                                    }
                        ?>
                        <!--form that shows each student's record-->
                        <form action="javascript:void(0)" method="post">
                            <input type="text" name="firstname" <?php echo "value='".$studentRow["firstname"]."'" ?> maxlength="255" readonly>
                            <input type="text" name="lastname" <?php echo "value='".$studentRow["lastname"]."'" ?> maxlength="255" readonly>
                            <input type="text" name="username" <?php echo "value='".$studentRow["username"]."'" ?> maxlength="255" readonly>
                            <input type="text" name="assignment" <?php 
                                    $assignment = 'No Assignments'; #by defualt system assumes no assignment
                                    mysqli_data_seek($assignmentResults,0); #start from the beginning
                                    while($assignmentRow = mysqli_fetch_assoc($assignmentResults)){ #loop through all the assignments
                                        if($assignmentRow['studentid'] == $studentRow['id']){ #if this student has that assignment
                                            mysqli_data_seek($activityResults,0); #start from the beginning
                                            while($activityRow = mysqli_fetch_assoc($activityResults)) { #find what the assignment activity name is
                                                if($assignmentRow['activityid'] == $activityRow['id']){
                                                    $assignment = $activityRow['name'];
                                                }
                                            }
                                        }
                                    }
                                    echo "value='".$assignment."'" #tell teacher what this student's assignment is
                                ?> maxlength="255" readonly>
                            <button type="submit" name="view-results"<?php if($assignment == 'No Assignments'){echo 'disabled';} ?> onclick='visualisation("<?php echo $studentRow["username"]; ?>", "individual");'> View </button>
                        </form>
                        <?php 
                                } 
                            } else {
                                header('Location: dashboard.php?error');
                                exit();
                            }
                        ?>
                    </div>
                    <div class="student-records-nav">
                        <div class="pagination">
                        <?php
                            for($i = 1; $i < $numPages + 1; $i++){ #starting from one, to the number of pages required
                                $pagination = '<a href="view-results.php?page='.$i; #build the pagination, making sure each link has the chosen order details as well
                                if(isset($_GET['orderby'])){
                                    $pagination .= '&orderby='.$_GET['orderby'];
                                }
                                if(isset($_GET['sort'])){
                                    $pagination .= '&sort='.$_GET['sort'];
                                }
                                if(isset($_GET['limit'])){
                                    $pagination .= '&limit='.$_GET['limit'];
                                }
                                if(isset($_GET['page'])){ #make the page number the user is on the crrent page
                                    if($_GET['page'] == $i){
                                        $pagination .= '" class = "current-page"';
                                    }
                                } else if($i == 1){ #defualt when user starts they're on page 1
                                    $pagination .= '" class = "current-page"';
                                }
                                $pagination .= '">'.$i.'</a>';
                                echo $pagination;
                            }
                        ?>
                        </div>
                        <form action="view-results.php" method="get">
                            <fieldset>
                                <label for="orderby">Order by</label>
                                <select name="orderby" onchange="this.form.submit()">
                                    <option value="firstname"<?php
                                        if(isset($_GET['orderby'])){ #label the selected option as what the user is currently seeing
                                            if ( $_GET['orderby'] == 'firstname' ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>First Name</option>
                                    <option value="lastname"<?php
                                        if(isset($_GET['orderby'])){
                                            if ( $_GET['orderby'] == 'lastname' ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>Last Name</option>
                                    <option value="username"<?php
                                        if(isset($_GET['orderby'])){
                                            if ( $_GET['orderby'] == 'username' ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>Username</option>
                                </select>
                            </fieldset>
                            <fieldset>
                                <label for="sort">Sort by</label>
                                <select name="sort" onchange="this.form.submit()"> 
                                    <option value="asc"<?php #label the selected option as what the user is currently seeing
                                        if(isset($_GET['sort'])){
                                            if ( $_GET['sort'] == 'asc' ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>ASC</option>
                                    <option value="desc"<?php
                                        if(isset($_GET['sort'])){
                                            if ( $_GET['sort'] == 'desc' ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>DESC</option>
                                </select>
                            </fieldset>
                            <fieldset>
                                <label for="limit">Number of rows</label>
                                <select name="limit" onchange="this.form.submit()">
                                    <option value="5"<?php #label the selected option as what the user is currently seeing
                                        if(isset($_GET['limit'])){
                                            if ( $_GET['limit'] == 5 ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>5</option>
                                    <option value="10"<?php
                                        if(isset($_GET['limit'])){
                                            if ( $_GET['limit'] == 10 ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>10</option>
                                    <option value="15"<?php
                                        if(isset($_GET['limit'])){
                                            if ( $_GET['limit'] == 15 ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>15</option>
                                    <option value="20"<?php
                                        if(isset($_GET['limit'])){
                                            if ( $_GET['limit'] == 20 ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>20</option>
                                    <option value="25"<?php
                                        if(isset($_GET['limit'])){
                                            if ( $_GET['limit'] == 25 ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>25</option>
                                    <option value="30"<?php
                                        if(isset($_GET['limit'])){
                                            if ( $_GET['limit'] == 30 ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>30</option>
                                    <option value="35"<?php
                                        if(isset($_GET['limit'])){
                                            if ( $_GET['limit'] == 35 ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>35</option>
                                    <option value="40"<?php
                                        if(isset($_GET['limit'])){
                                            if ( $_GET['limit'] == 40 ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>40</option>
                                    <option value="45"<?php
                                        if(isset($_GET['limit'])){
                                            if ( $_GET['limit'] == 45 ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>45</option>
                                    <option value="50"<?php
                                        if(isset($_GET['limit'])){
                                            if ( $_GET['limit'] == 50 ) {
                                                echo 'selected';
                                            }
                                        }
                                    ?>>50</option>
                                </select>
                            </fieldset>
                            <noscript>
                                <!--normally once the user changes the field, the page is auto updated but is javascript isn't on then the user can use this button-->
                              <button type="submit" name="order-btn">Edit Filters</button>
                            </noscript>
                        </form>
                    </div>
                </div>
                <!--inital message-->
                <div id="message" class="hide">
                    No student selected, please select a student from the 'student' tab
                </div>
                <div id="visualisation" class="hide">
                    <div id="student-name"></div>
                    <div class="results-overview">
                        <div class="row">
                            <div class="col-md-4">
                                <div id="attempts"></div>
                            </div>
                            <div class="col-md-4">
                                <div id="average-time-taken"></div>
                            </div>
                            <div class="col-md-4">
                                <div id="percentage-correct"></div>
                            </div>
                        </div>
                    </div>
                    <?php for($i = 0; $i < 10; $i++) { #for all 10 questions answered in quiz, show each result?>
                     <div class="quiz-information">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="question-container"> 
                                    <div class="question-title"></div>
                                    <div class="question-choices">
                                        <div class="quiz-choice"></div>
                                        <div class="quiz-choice"></div>
                                        <div class="quiz-choice"></div>
                                        <div class="quiz-choice"></div>
                                    </div>
                                    <div class="question-type"></div>
                                    <div class="question-correct"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="data-container"> 
                                    <div class="picked"></div>
                                    <div class="picked"></div>
                                    <div class="picked"></div>
                                    <div class="data-time-taken"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div id="pie-chart-container" class="quiz-information">
                        <div class="row">
                            <div class="col-lg-6">
                                <div id="pie-chart-correct"> 
                                    <canvas id="piechart-good"></canvas>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div id="pie-chart-incorrect"> 
                                    <canvas id="piechart-bad"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="bar-chart-container" class="quiz-information">
                        <div id="bar-chart"> 
                            <canvas id="barchart"></canvas>
                        </div>
                    </div>
                    <!--smaller screens can't view charts well, so they get shown this message instead-->
                    <div id="chart-message" class="hide">
                        Please move to a larger device to see more data on this student.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require './inc/footer.php'; ?>