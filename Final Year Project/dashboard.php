<?php 
    require './inc/header.php'; 
    require './inc/navbar-teacher.php';
    include './inc/banner.php';

    if (!isset($_SESSION['usertype'])){ #if the user isn't logged in
        header('Location: login.php'); #take them to loggin page
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
    <div class="content">
        <div class="dashboard-container">
            <?php
                if(isset($_GET['error'])){#if error occured, user is notified
                    echo '<div class="h5" style="color:red; text-align:center; ">Something Went Wrong!</div>';
                }
            ?>
            <div class="row">
                <a href="teacher-profile.php" class="col-xl-4 thumbnail dashboard-button" style="background-color: #53A1EE;">
                    <p class="dashboard-content"><i class="fas fa-user"></i><?php if (isset($_SESSION['firstname'])){echo ' '.$_SESSION['firstname']."'s";} #personalise by refrencing user's name?> Profile</p>
                </a>
                <a href="student-profile.php" class="col-xl-4 thumbnail dashboard-button" style="background-color: #EC6E62;">
                    <p class="dashboard-content"><i class="fas fa-user-friends"></i> Student's Profile</p>
                </a>
                <a href="add-student.php" class="col-xl-4 thumbnail dashboard-button" style="background-color: #CBD3DF;">
                    <p class="dashboard-content"><i class="fas fa-user-plus"></i> Add Student</p>
                </a>
            </div>
            <div class="row">
                <a href="give-assignment.php" class="col-xl-4 thumbnail dashboard-button" style="background-color: #47B0B4;">
                    <p class="dashboard-content"><i class="fas fa-list"></i> Assessments</p>
                </a>
                <a href="view-results.php" class="col-xl-4 thumbnail dashboard-button" style="background-color: #FFC65B;">
                    <p class="dashboard-content"><i class="fas fa-tasks"></i> View Results</p>
                </a>
                <a href="view-class-results.php" class="col-xl-4 thumbnail dashboard-button" style="background-color: #8A81C4;">
                    <p class="dashboard-content"><i class="fas fa-users"></i> Classroom Summary</p>
                </a>
            </div>
        </div>
    </div>
</div>

<?php require './inc/footer.php'; ?>
