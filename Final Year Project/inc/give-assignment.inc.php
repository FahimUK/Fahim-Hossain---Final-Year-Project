<?php
session_start();

if (isset($_POST['assign-submit'])) { #if the user tried directly accessing this file then send them to the index page
    require 'dbh.inc.php';
    
    $userID = $_POST['username']; #Store username variable
    $assignmentID = $_POST['assignment']; #Store assignment variable
    $studentID = $_POST['studentId']; #Store studentId variable
    $urlAdditions = $_POST['url']; #Store url variable
    $urlError = 'Location: ../give-assignment.php?error'.$urlAdditions; #error message
    $urlSuccess = 'Location: ../give-assignment.php?success'.$urlAdditions; #success message
    
    //USER INPUT VALIDATION
    if(empty($userID) || empty($assignmentID) || empty($studentID)){ #if any of the variables are empty, send error message
        header($urlError);
        exit();
    }
    
    //USER ID VALIDATION
    $query = "SELECT * FROM students WHERE username=? && id=?"; #find the student requested
    $statement = mysqli_stmt_init($connection);
    if(mysqli_stmt_prepare($statement, $query)){
        mysqli_stmt_bind_param($statement, 'si', $userID, $studentID);
        mysqli_stmt_execute($statement);
        $results = mysqli_stmt_get_result($statement);
        if(!$row = mysqli_fetch_assoc($results)){ #if student not found send error message
            header($urlError);
            exit();
        }
    } else {
        header($urlError); #if error occured during retrival send error message
        exit();
    }

    //EXISTING ACTIVITY VALIDATION (Ignore if none since that means no assignments given)
    if($assignmentID != 'none') {
        $query = "SELECT * FROM activities WHERE id = ?"; #find the activity requested
        if(mysqli_stmt_prepare($statement, $query)) {
            mysqli_stmt_bind_param($statement, 'i', $assignmentID);
            mysqli_stmt_execute($statement);
            $results = mysqli_stmt_get_result($statement);
            if(!($row = mysqli_fetch_assoc($results))){ #if activity not found send error message
                header($urlError);
                exit();
            }
        } else {
            header($urlError);#if error occured during retrival send error message
            exit();
        }
    }

    //GETTING ASSIGNMENT INFO
    $query = "SELECT * FROM activity_assignment WHERE studentid = ?"; #find id the student has existing assignment
    if(mysqli_stmt_prepare($statement, $query)){
        mysqli_stmt_bind_param($statement, 'i', $studentID);
        mysqli_stmt_execute($statement);
        $results = mysqli_stmt_get_result($statement);
        if (($row = mysqli_fetch_assoc($results))) { #if the student does
            //DELETING EXISTING STORED RESULTS    
            $query = "DELETE FROM results_storage WHERE assignmentid = ?"; #get all the results for this assignment and delete the
            if(mysqli_stmt_prepare($statement, $query)) {
                mysqli_stmt_bind_param($statement, 'i', $row['id']);
                mysqli_stmt_execute($statement);
                //DELETING ASSIGNMENT ITSELF (second because it is a foreign id to results_storage) 
                $query = "DELETE FROM activity_assignment WHERE id = ?";
                echo ''.$row['id'].' and '.$row['time'];
                if(mysqli_stmt_prepare($statement, $query)) {
                    mysqli_stmt_bind_param($statement, 'i', $row['id']);
                    mysqli_stmt_execute($statement);
                } else {
                    header($urlError);#if error occured during retrival send error message
                    exit();
                }
            } else {
                header($urlError);#if error occured during retrival send error message
                exit();
            }
        }
    } else {
        header($urlError);#if error occured during retrival send error message
        exit();
    }
    //ASSIGNING NEW ASSIGNMENT TO STUDENT
    if($assignmentID != 'none'){ #if assignment is to be made
        $query = "INSERT INTO activity_assignment (teacherid, studentid, activityid) VALUES (?,?,?)"; #create the assignment
        if(mysqli_stmt_prepare($statement, $query)) {
            mysqli_stmt_bind_param($statement, 'iii', $_SESSION['id'], $studentID, $assignmentID);
            mysqli_stmt_execute($statement);
        } else {
            header($urlError);#if error occured during retrival send error message
            exit();
        }
    }
    
    header($urlSuccess); #send user back with success message
    exit();
    
}
else {
    header('Location: ../index.php');
    exit();
}