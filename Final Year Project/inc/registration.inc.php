<?php

session_start();

if (isset($_POST['signup-submit'])) { #if the user tried directly accessing this file then send them to the index page
    
    require 'dbh.inc.php';
    
    $userFirstname = $_POST['firstname']; #Store firstname variable
    $userLastname = $_POST['lastname']; #Store lastname variable
    $userID = $_POST['username']; #Store username variable
    $userPass = $_POST['password']; #Store password variable
    $userRepeatPass = $_POST['repeat-password']; #Store repeat-password variable
    
    $errorMessage = '?errors=found'; #error message for non password fields
    $errorMessagePass = '&password='; #error message for password fields
    $userFieldsValues = array($userFirstname, $userLastname, $userID); #variables in an array to make iteration easier
    $userFieldsName = array('firstname','lastname','username'); #variables in an array to make iteration easier
    $userFieldsChanges = False; #if validation failed, this will be turned true
    $userFieldsPassChanges = False; #if validation failed, this will be turned true
    
    if($_SESSION['usertype'] == 1){ #if a admin is creating the account
        $usertype = 2; #User is a teacher account
        $databaseTable = 'teachers'; #and will be inserted into the teachers database
    } else if($_SESSION['usertype'] == 2) { #if a teacher is creating the account
        $usertype = 3; #User is a student account
        $teacherid = $_SESSION['id']; #under this teacher
        $databaseTable = 'students'; #and will be inserted into the student database
    }
    
    //EMPTY FIELD CHECK
    for ($i = 0; $i < sizeof($userFieldsValues); $i++) { #check all fields to see if any are empty
        if(empty($userFieldsValues[$i])){
            $userFieldsValues[$i] = 'empty'; #if so, change that field value to empty so that the user can be informed
            $userFieldsChanges = True;
        } 
    }
    if(empty($userPass)){
        $errorMessagePass .= 'empty';
        $userFieldsPassChanges = True;
    } 
    
    //STRING LENGTH CHECK
    for ($i = 0; $i < sizeof($userFieldsValues); $i++) { #check all fields to see if any strings exceed their allowed length
        if(strlen($userFieldsValues[$i]) > 255){
            $userFieldsValues[$i] = 'toolong'; #if so, change that field value to toolong so that the user can be informed
            $userFieldsChanges = True;
        }
    }
    if(strlen($userPass) > 50){
        $errorMessagePass .= '&toolong';
        $userFieldsPassChanges = True;
    }
    
    //STRING CHARACTER CHECK
    for ($i = 0; $i < sizeof($userFieldsValues) - 1; $i++) { #check all fields to see if any strings invalid characters
        if(!preg_match("/^[^\W_0-9]*$/", $userFieldsValues[$i])){ #name fields can only contain letters
            $userFieldsValues[$i] = 'invalidchar'; #if so, change that field value to invalidchar so that the user can be informed
            $userFieldsChanges = True;
        }
    } 
    if(!preg_match("/^[\w]*$/", $userFieldsValues[2])){ #username field can contain letters, numbers and underscores
        $userFieldsValues[2] = 'invalidchar';
        $userFieldsChanges = True;
    }
    if(!preg_match("/^(?=.*\d)(?=.*[^\W_0-9])[\w@%+'!#$^?:.(){}[\]~]*$/", $userPass) && !$userFieldsPassChanges){  #password fields must have a letter, a number and can contain these specified special characters
        $errorMessagePass .= 'invalidchar';
        $userFieldsPassChanges = True;
    }
    
    //REPEAT PASSWORD CHECK
    if(($userPass != $userRepeatPass) && (!$userFieldsPassChanges)){ #check to see if the two passwords match
        $errorMessagePass .= 'mismatch';
        $userFieldsPassChanges = True;
    }
    
    //EXISTING USER CHECK
    $query = "SELECT * FROM ". $databaseTable ." WHERE username=?"; 
    $statement = mysqli_stmt_init($connection);
    if(mysqli_stmt_prepare($statement, $query)){ #preparing query to avoid SQL injections
        mysqli_stmt_bind_param($statement, 's', $userID); #binding the user's input to the query
        mysqli_stmt_execute($statement); #Executing the query
        $results = mysqli_stmt_get_result($statement); #storing the results in a variable
        if($row = mysqli_fetch_assoc($results)){ #if result found, the user exists
            $userFieldsValues[2] = 'taken'; #change that field value to taken so that the user can be informed
            $userFieldsChanges = True;
        }
    } else {
        $userFieldsChanges = True; #if any problem occured and the statement couldn't be executed, send an error message
    }
    
    //Validation Check
    if($userFieldsChanges || $userFieldsPassChanges){ #if any of these are true, meaning validations failed, send the user back to their registration page with the variables, if validation passed then that field will be autofilled
        $errorMessage .= $errorMessagePass;
        for ($i = 0; $i < sizeof($userFieldsValues); $i++) { 
            $errorMessage .= '&'.$userFieldsName[$i].'='.$userFieldsValues[$i];
        }
        if($_SESSION['usertype'] == 1){
            header('Location: ../registration.php'.$errorMessage);
            exit();
        } else {
            header('Location: ../add-student.php'.$errorMessage);
            exit();
        }
    }
    
    //VALIDATION PASSED, INSERT DETAILS INTO DATABASE
    $query = "INSERT INTO ". $databaseTable ." (firstname, lastname, username, password, usertype";
    if($databaseTable == 'teachers'){
      $query.= ') VALUES (?,?,?,?,?)';
    } else {
      $query.= ', teacherid) VALUES (?,?,?,?,?,?)';
    }
    
    if(mysqli_stmt_prepare($statement, $query)){
        $hash = password_hash($userPass, PASSWORD_DEFAULT); #hash the password as we can't store plain text for security purposes
        if($databaseTable == 'teachers'){ #Student accounts have one more field to store, the teacher id 
          mysqli_stmt_bind_param($statement, 'ssssi', $userFirstname, $userLastname, $userID, $hash, $usertype); 
        } else {
          mysqli_stmt_bind_param($statement, 'ssssii', $userFirstname, $userLastname, $userID, $hash, $usertype, $teacherid);
        }
        mysqli_stmt_execute($statement);
    } else { #if an error occured, then send an error message back
        $errorMessage .= $errorMessagePass;
        for ($i = 0; $i < sizeof($userFieldsValues); $i++) { 
            $errorMessage .= '&'.$userFieldsName[$i].'='.$userFieldsValues[$i];
        }
        if($_SESSION['usertype'] == 1){
            header('Location: ../registration.php'.$errorMessage);
            exit();
        } else {
            header('Location: ../add-student.php'.$errorMessage);
            exit();
        }
    }
    
    mysqli_stmt_close($statement);
    mysqli_close($connection);
    
    #once successfully registers, send the user back to their registration page with the success messages
    if($_SESSION['usertype'] == 1){
        header('Location: ../registration.php?success');
        exit();
    } else {
        header('Location: ../add-student.php?success');
        exit();
    }

}
else {
    header('Location: ../index.php');
    exit();
}