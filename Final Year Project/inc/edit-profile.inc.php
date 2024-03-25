<?php
if (isset($_POST['edit-submit'])) { #if the user tried directly accessing this file then send them to the index page
    
    require 'dbh.inc.php';
    
    $userFirstname = $_POST['firstname']; #Store firstname variable
    $userLastname = $_POST['lastname']; #Store lastname variable
    $newuserID = $_POST['new-username']; #Store new-username variable
    $olduserID = $_POST['old-username']; #Store old-username variable
    $newUserPass = $_POST['new-password']; #Store new-password variable
    $usertype = $_POST['usertype']; #Store usertype variable
    $id = $_POST['id']; #Store id variable
    
    $errorMessage = '?errors=found'; #error message for non password fields
    $errorMessagePass = '&password='; #error message for password fields
    $errorMessageNewPass = '&newpassword='; #error message for new password fields
    $userFieldsValues = array($userFirstname, $userLastname, $newuserID); #variables in an array to make iteration easier
    $userFieldsName = array('firstname','lastname','username'); #variables in an array to make iteration easier
    $userFieldsChanges = False; #if validation failed, this will be turned true
    $userFieldsPassChanges = False; #if validation failed, this will be turned true
    $userFieldsNewPassChanges = False; #if validation failed, this will be turned true
    $urlAdditions = $_POST['url']; #stores url for when user is taken back to the profile page, their order is kept
        
    if($usertype == 2){ #if a teacher account is being edited
        $databaseTable = 'teachers'; #use the teacher database
        $currentUserPass = $_POST['current-password']; #store the password (student accounts don't need passwords)
    } else if($usertype == 3) { #if a student account is being edited
        $databaseTable = 'students'; #use the student database
    } else if(empty($olduserID) || empty($id) || empty($usertype)){ #if any of the important fields are empty, send user back with an error message 
        header('Location: ../dashboard.php?error');
        exit();
    }
    
    //USER ID VALIDATION
    $query = "SELECT * FROM ". $databaseTable ." WHERE username=? && id=?"; #check to make sure the username and given id exists (incase user changes this through the form)
    $statement = mysqli_stmt_init($connection);
    if(mysqli_stmt_prepare($statement, $query)){
        mysqli_stmt_bind_param($statement, 'si', $olduserID, $id);
        mysqli_stmt_execute($statement);
        $results = mysqli_stmt_get_result($statement);
        if(!$row = mysqli_fetch_assoc($results)){ #if no user found, meaning they don't match
            header('Location: ../dashboard.php?error'); #send user back with an error message
            exit();
        }
    } else {
        header('Location: ../dashboard.php?error'); #if any problem occured and the statement couldn't be executed, send an error message
        exit();
    }
    
    if(empty($newUserPass)){ #if new password field is empty
        $changePassword = False; #user doesnt wanna change their password
    } else {
        $changePassword = True; #if not, then they do
    }
    
    //EMPTY FIELD CHECK
    for ($i = 0; $i < sizeof($userFieldsValues); $i++) { #check all fields to see if any are empty 
        if(empty($userFieldsValues[$i])){
            $userFieldsValues[$i] = 'empty'; #if so, change that field value to empty so that the user can be informed
            $userFieldsChanges = True;
        } 
    }
    if(empty($currentUserPass) && $usertype != 3){
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
    if(strlen($newUserPass) > 50){
        $errorMessageNewPass .= 'toolong';
        $userFieldsNewPassChanges = True;
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
    if(!preg_match("/^(?=.*\d)(?=.*[^\W_0-9])[\w@%+'!#$^?:.(){}[\]~]*$/", $newUserPass) && !$userFieldsNewPassChanges && $changePassword){ #password fields must have a letter, a number and can contain these specified special characters
        $errorMessageNewPass .= 'invalidchar';
        $userFieldsNewPassChanges = True;
    }
    
    //EXISTING USER NAME
    if($newuserID != $olduserID){
        $query = "SELECT * FROM ". $databaseTable ." WHERE username=?";
        if(mysqli_stmt_prepare($statement, $query)){
            mysqli_stmt_bind_param($statement, 's', $newuserID);
            mysqli_stmt_execute($statement);
            $results = mysqli_stmt_get_result($statement);
            if($row = mysqli_fetch_assoc($results)){  #if result found, the user already exists
                $userFieldsValues[2] = 'taken'; #change that field value to taken so that the user can be informed
                $userFieldsChanges = True;
            }
        } else {
            header('Location: ../dashboard.php?error'); #if any problem occured and the statement couldn't be executed, send an error message
            exit();
        }
    }
    
    //PASSWORD CHECK
    if(!$userFieldsPassChanges && $usertype != 3){ #as long as the password field wasn't changed (since if the system changed it for error messages then it wouldn't make sense to validate) and the account isn't a student account
        $query = "SELECT * FROM ". $databaseTable ." WHERE username=?";
        if(mysqli_stmt_prepare($statement, $query)){
            mysqli_stmt_bind_param($statement, 's', $olduserID);
            mysqli_stmt_execute($statement);
            $results = mysqli_stmt_get_result($statement);
            if($row = mysqli_fetch_assoc($results)){
                if(!(password_verify($currentUserPass, $row['password']))){ #compare the hash of the password the user inputted with that stored in the database
                    $errorMessagePass .= 'incorrect'; #if the hashes dont match then the password is wrong
                    $userFieldsChanges = True;
                }
            } else {
                header('Location: ../teacher-profile.php?error'); #if any problem occured, send an error message
                exit();
            }
        } else {
            header('Location: ../teacher-profile.php?error'); #if any problem occured and the statement couldn't be executed, send an error message
            exit();
        }
    }
    
    //Validation Check
    if($userFieldsChanges || $userFieldsPassChanges || $userFieldsNewPassChanges) { #if any of the validations failed
        if($usertype != 3){ #password fields for non student accounts
            $errorMessage .= $errorMessagePass.$errorMessageNewPass;
            for ($i = 0; $i < sizeof($userFieldsValues); $i++) { 
                $errorMessage .= '&'.$userFieldsName[$i].'='.$userFieldsValues[$i];
            }
        }
        if($usertype == 2){ #teacher account gets taken to teacher profile
            header('Location: ../teacher-profile.php'.$errorMessage);
            exit(); 
        } else if($usertype == 3) { #student account gets taken to student profile
            header('Location: ../student-profile.php'.$errorMessage.$urlAdditions);
            exit(); 
        }
    }
    
    //VALIDATION PASSED, UPDATE DETAILS IN DATABASE
    $query = "UPDATE ". $databaseTable ." SET firstname=?, lastname=?, username=?";
    if($changePassword){
        $query .= ', password=?';
    }
    $query .= ' WHERE id=?';
    if(mysqli_stmt_prepare($statement, $query)){
        if($changePassword){
            $hash = password_hash($newUserPass, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($statement, 'sssss', $userFirstname, $userLastname, $newuserID, $hash, $id);
        } else {
            mysqli_stmt_bind_param($statement, 'ssss', $userFirstname, $userLastname, $newuserID, $id);
        }
        mysqli_stmt_execute($statement); 
    } else {
        header('Location: ../dashboard.php?error');
        exit();
    }
    
    mysqli_stmt_close($statement);
    mysqli_close($connection);
    
    if($usertype == 2){ #teacher account need to update sessions since values changed
        session_start();
        $_SESSION['firstname'] = $userFirstname;
        $_SESSION['lastname'] = $userLastname;
        $_SESSION['username'] = $newuserID;
        header('Location: ../teacher-profile.php?success'); #teacher account gets taken to teacher profile
        exit();
    } else if($usertype == 3){
        header('Location: ../student-profile.php?success'.$urlAdditions); #student account gets taken to student profile
        exit();
    }
}
else {
    header('Location: ../index.php');
    exit();
}