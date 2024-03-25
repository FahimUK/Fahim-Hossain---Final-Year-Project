<?php
session_start();

if (isset($_POST['submit'])) { #if the user tried directly accessing this file then send them to the index page
    require 'dbh.inc.php';
    
    $userID = $_POST['username']; #Store username variable
    $type = $_POST['typeOfData']; #Store typeOfData variable
    $errorMessage = "Unfortunatly something might have gone wrong, unable to show your results.<br>Please try again in a little while...";  #error message to be shown to the user
    $storedResults = []; #array to store results
    
    //USER INPUT VALIDATION
    if(empty($userID) && $type != 'class'){ #if an individual result is requested and the user id is empty, tell the user something went wrong
        echo $errorMessage;
        exit();
    }
    
    //TYPE OF DATA VALIDATION
    if(!in_array($type, array('individual','class'))){ #if the user edit the type of data varaible to be something other than individual or class, don't do anything and just send an error message
        echo $errorMessage;
        exit();
    }
    
    if($type == 'individual') { #if an individual result is requested
        //USER VALIDATION
        $query = "SELECT * FROM students WHERE username=?"; #get the students account details
        $statement = mysqli_stmt_init($connection);
        if(mysqli_stmt_prepare($statement, $query)){
            mysqli_stmt_bind_param($statement, 's', $userID);
            mysqli_stmt_execute($statement);
            $studentResults = mysqli_stmt_get_result($statement);
            if(!($studentRow = mysqli_fetch_assoc($studentResults))){ #if user isn't found, send error message letting the user know
                echo 'Unfortunatly something might have gone wrong, the user appears to not exist.';
                exit();
            } else {
                mysqli_data_seek($studentResults,0); #if user is found, reset pointer
            }
        } else {
            echo $errorMessage; #if an error occured during reterival, send error message
            exit();
        }

        //USER ASSIGNMENT VALIDATION
        $query = "SELECT * FROM activity_assignment WHERE studentid = ?"; #get the student's assignment details
        if(mysqli_stmt_prepare($statement, $query)){
            mysqli_stmt_bind_param($statement, 'i', $studentRow['id']);
            mysqli_stmt_execute($statement);
            $assignmentResults = mysqli_stmt_get_result($statement);
            if(!($assignmentRow = mysqli_fetch_assoc($assignmentResults))){ #if assignment isn't found, send error message letting the user know
                echo 'Unfortunatly something might have gone wrong, the user appears to not have been tasked any assignments.';
                exit();
            } else {
                if($assignmentRow['attempts'] == 0){ #if assignment isn't attempted yet, send error message letting the user know
                    echo 'The user has yet to attempt the assignment.<br>Please try again in a little while...';
                    exit();
                }
                mysqli_data_seek($assignmentResults,0); #if assignment is found, reset pointer
            }
        } else {
            echo $errorMessage; #if an error occured during reterival, send error message
            exit();
        }

        //RESULTS EXISTING CHECK
        $query = "SELECT * FROM results_storage WHERE assignmentid = ?"; #get the student's assignment results
        if(mysqli_stmt_prepare($statement, $query)){
            mysqli_stmt_bind_param($statement, 'i', $assignmentRow['id']);
            mysqli_stmt_execute($statement);
            $results = mysqli_stmt_get_result($statement);
            if(!($row = mysqli_fetch_assoc($results))){ #if results isn't found, send error message letting the user know
                echo 'Unfortunatly something went wrong and we couldn\'t store the user\'s results<br>Please advise user to try the test again.';
                exit();
            } else {
                mysqli_data_seek($results,0); #if results is found, reset pointer
                while($row = mysqli_fetch_assoc($results)){ #loop through all the results and push them to the results array
                    array_push($storedResults, $row);
                }
                array_push($storedResults, $assignmentRow['attempts']); #at end, push attempts and time in seconds
                array_push($storedResults, $assignmentRow['time']);
            }
        } else {
            echo $errorMessage; #if an error occured during reterival, send error message
            exit();
        }
    } else { #if a class result is requested
        //CLASS ASSIGNMENT VALIDATION
        $query = "SELECT * FROM activity_assignment WHERE teacherid=?"; #get all the assignments, the teacher gave
        $statement = mysqli_stmt_init($connection);
        if(mysqli_stmt_prepare($statement, $query)){
            mysqli_stmt_bind_param($statement, 'i', $_SESSION['id']);
            mysqli_stmt_execute($statement);
            $assignmentResults = mysqli_stmt_get_result($statement);
            if(!($assignmentRow = mysqli_fetch_assoc($assignmentResults))){ #if assignments isn't found, send error message letting the user know
                echo 'There appears to be no active assignments to display.';
                exit();
            }
        } else {
            echo $errorMessage; #if an error occured during reterival, send error message
            exit();
        }

        //CLASS RESULTS EXISTING CHECK
        mysqli_data_seek($assignmentResults,0); #reset pointer
        $classAttempts = 0; #initially start at 0
        $classTime = 0; #initially start at 0
        $count = 0; #initially start at 0
        while($assignmentRow = mysqli_fetch_assoc($assignmentResults)){ #loop through all the assignments
            $query = "SELECT * FROM results_storage WHERE assignmentid = ?"; #get the result of each assignment
            if(mysqli_stmt_prepare($statement, $query)){
                mysqli_stmt_bind_param($statement, 'i', $assignmentRow['id']);
                mysqli_stmt_execute($statement);
                $results = mysqli_stmt_get_result($statement);
                $count++;
                $classAttempts += intval($assignmentRow['attempts']); #add this student's attempts to the tally
                $classTime += intval($assignmentRow['time']); #add this student's time to the tally
                if(!($row = mysqli_fetch_assoc($results))) { #if no results found, send error message letting the user know
                    echo 'There appears to be no results on record to display.<br>No student has yet to attempt the assigned task.';
                    exit();
                } else {
                    mysqli_data_seek($results,0); #if results found, reset pointer
                }
                while($row = mysqli_fetch_assoc($results)){ #loop through all the results and push them to the results array
                    array_push($storedResults, $row);
                }
            } else {
                echo $errorMessage; #if an error occured during reterival, send error message
                exit();
            }
        }
        array_push($storedResults, $count); #at end, push count, attempts and time in seconds
        array_push($storedResults, $classAttempts);
        array_push($storedResults, $classTime);
    }
    
    echo json_encode($storedResults); #send the data back in a json format
}
else {
    header('Location: ../index.php');
    exit();
}