<?php
session_start();

if (isset($_POST['submit'])) { #if the user tried directly accessing this file then send them to the index page
    require 'dbh.inc.php';
    
    $data = $_POST['data']; #Store data variable
    $overallTime = $_POST['time']; #Store time variable
    $activityID = $_POST['activityid']; #Store activityid variable
    $overallAttempts; #Store overall attempts
    $errorMessage = "Unfortunatly something went wrong, unable to submit your results.\nPlease try again in a little while..."; #error message
    $successMessage = "Results Stored!"; #success message
    
    //EMPTY VALIDATION
    if( empty($data) || empty($overallTime) || empty($activityID)){ #if any of the important fields are empty, send user back with an error message
        echo $errorMessage;
        exit();
    }
    
    //FORMAT VALIDATION
    for($i = 0; $i < sizeof($data); $i++) { #loop through the data to ensure no tampering was made
        for($j = 0; $j < sizeof($data[$i]['choicesList']); $j++) { #make sure the choices only have letters, numbers and these specific special characters
            if( !preg_match("/^[a-zA-Z0-9'!?,* ]*$/", $data[$i]['choicesList'][$j]) ){
                echo $errorMessage; #if fail, send user back with error message
                exit();
            }
        }
        for($j = 0; $j < sizeof($data[$i]['choicesPicked']); $j++) { #make sure the choices picked only have letters, numbers and these specific special characters
            if( !preg_match("/^[a-zA-Z0-9'!?,* ]*$/", $data[$i]['choicesPicked'][$j]) ){
                echo $errorMessage; #if fail, send user back with error message
                exit();
            }
        }
        if( !preg_match("/^[a-zA-Z_,?'. ]*$/", $data[$i]['questionTitle']) || !preg_match("/^[a-zA-Z0-9! ]*$/", $data[$i]['correctChoice']) ) { #make sure the question titles only have letters and these specific special characters
            echo $errorMessage; #if fail, send user back with error message
            exit();
        }
        if( !in_array($data[$i]['questionType'], array('Spelling','Understanding','Punctuation','Grammar')) ){ #make sure the question types are one of these strings
            echo $errorMessage; #if fail, send user back with error message
            exit();
        }
        if( !is_numeric($data[$i]['attempts']) || !is_numeric($data[$i]['timeTaken']) || !is_numeric($data[$i]['correct']) || !is_numeric($overallTime) || !is_numeric($activityID) ){ #make sure these values are only numbers
            echo $errorMessage; #if fail, send user back with error message
            exit();
        }
    }
    
    //GETTING ASSIGNMENT INFO
    $query = "SELECT * FROM activity_assignment WHERE studentid = ?"; #find the students assignment
    $statement = mysqli_stmt_init($connection);
    if(mysqli_stmt_prepare($statement, $query)) {
        mysqli_stmt_bind_param($statement, 'i', $_SESSION['id']);
        mysqli_stmt_execute($statement);
        $assignmentResults = mysqli_stmt_get_result($statement);
        while ( ($assignmentRow = mysqli_fetch_assoc($assignmentResults)) ){ #if no assignment, this all gets skipped
            if( $assignmentRow['activityid'] == $activityID ) { #however, if this is an assignment then...
                $overallAttempts = $assignmentRow['attempts'] + 1; #incriment attempts by 1
                $query = "DELETE FROM results_storage WHERE assignmentid = ?"; #delete any exisiting results
                if(mysqli_stmt_prepare($statement, $query)) {
                    mysqli_stmt_bind_param($statement, 'i', $assignmentRow['id']);
                    mysqli_stmt_execute($statement);
                    $query = "UPDATE activity_assignment SET attempts=?, time=? WHERE id=?"; #update with the new attempt count and time
                    if(mysqli_stmt_prepare($statement, $query)) {
                        mysqli_stmt_bind_param($statement, 'iii', $overallAttempts, $overallTime, $assignmentRow['id']);
                        mysqli_stmt_execute($statement);
                        $query = "INSERT INTO results_storage (assignmentid, question, correct, attempts, time, type, choices, picked, title, answer) VALUES (?,?,?,?,?,?,?,?,?,?)"; #update with the new results
                        for($i = 0; $i < sizeof($data); $i++){ #loop through the data to insert everything
                            $choicePicked = implode(', ',$data[$i]['choicesPicked']);
                            $choiceList = implode(', ',$data[$i]['choicesList']);
                            if(mysqli_stmt_prepare($statement, $query)) {
                                mysqli_stmt_bind_param($statement, 'iiiiisssss', $assignmentRow['id'], $i, $data[$i]['correct'], $data[$i]['attempts'], $data[$i]['timeTaken'], $data[$i]['questionType'], $choiceList, $choicePicked, $data[$i]['questionTitle'], $data[$i]['correctChoice']);
                                mysqli_stmt_execute($statement);
                            } else {
                                echo $errorMessage; #if an error occured, send error message
                                exit();
                            }
                        }
                    } else {
                        echo $errorMessage; #if an error occured, send error message
                        exit();
                    }
                } else {
                    echo $errorMessage; #if an error occured, send error message
                    exit();
                }
            }
        }
    } else {
        echo $errorMessage; #if an error occured, send error message
        exit();
    }
    
    mysqli_stmt_close($statement);
    mysqli_close($connection);
    echo $successMessage; #echo sucess message if data was stored
}
else {
    header('Location: ../index.php');
    exit();
}
