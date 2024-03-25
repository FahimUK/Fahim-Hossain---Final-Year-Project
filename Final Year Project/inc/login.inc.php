<?php

if (isset($_POST['login-submit'])) { #if the user tried directly accessing this file then send them to the index page or login page
    require 'dbh.inc.php';
    
    $userID = $_POST['username']; #Store username variable
    $userPass = $_POST['password']; #Store password variable
    $usertype = intval($_POST['usertype']); #Store usertype variable as an int value
    
    if($usertype == 1){ #determine what database to look for the account in
        $databaseTable = 'admins';
    } else if($usertype == 2) {
        $databaseTable = 'teachers';
    } else if($usertype == 3) {
        $databaseTable = 'students';
    }
    
    $errorMessage = '?errors=found'; #error message for non password fields
    $errorMessagePass = '&password='; #error message for password fields
    $userFieldsChanges = False; #if validation failed, this will be turned true
    
    //EMPTY FIELD CHECK
    if(empty($userID)){ #check all fields to see if any are empty
        $userID = 'empty'; #if so, change that field value to empty so that the user can be informed
        $userFieldsChanges = True;
    } 
    if(empty($userPass)){
        $errorMessagePass .= 'empty';
        $userFieldsChanges = True;
    }
    
    //EXISTING USER CHECK
    if(!$userFieldsChanges){
        $query = "SELECT * FROM ". $databaseTable ." WHERE username=?";
        $statement = mysqli_stmt_init($connection);
        if(mysqli_stmt_prepare($statement, $query)){ #preparing query to avoid SQL injections
            mysqli_stmt_bind_param($statement, 's', $userID); #binding the user's input to the query
            mysqli_stmt_execute($statement); #Executing the query
            $results = mysqli_stmt_get_result($statement); #storing the results in a variable
            if(($row = mysqli_fetch_assoc($results))){ #if result found, the user exists
                //PASSWORD CHECK
                if(!(password_verify($userPass, $row['password']))){ #compare the hash of the password the user inputted with that stored in the database
                    $errorMessagePass .= 'incorrect'; #if the hashes dont match then the password is wrong
                    $userFieldsChanges = True;
                } 
            } else {
                $userID = 'invaliduser'; #if no result found, the user doesnt exists
                $userFieldsChanges = True;
            }
        } else {
            $userFieldsChanges = True; #if any problem occured and the statement couldn't be executed, send an error message
        }
    }
    
    //Validation Check
    if($userFieldsChanges){ #if any of the validations failed
        $errorMessage .= $errorMessagePass.'&username='.$userID.'&usertype='.$usertype; #send the information back to the login page
        header('Location: ../login.php'.$errorMessage);
        exit();
    } else{ #if all validations passed and the user was found
        session_start(); #start a session to log the user in and store the account details into session variables
        if($usertype != 1){ #admin accounts dont have name details
            $_SESSION['firstname'] = $row['firstname'];
            $_SESSION['lastname'] = $row['lastname'];
        }
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['usertype'] = $row['usertype'];
        
        mysqli_stmt_close($statement);
        mysqli_close($connection);
        
        if($_SESSION['usertype'] == 1){ #Send the user to their respective starting page
            header('Location: ../registration.php');
            exit(); 
        } else if($_SESSION['usertype'] == 2){
            header('Location: ../dashboard.php');
            exit(); 
        } else if($_SESSION['usertype'] == 3){
            header('Location: ../index.php');
            exit(); 
        }
    }
}
else {
    if (isset($_SESSION['usertype'])){
        header('Location: ../index.php');
        exit();
    } else {
        header('Location: ../login.php');
        exit();
    }
}
