<?php 
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
    <div class="login-container">
        <div class="register-content form-input-container">
            <form action="inc/registration.inc.php" method="post">
                <div class="login-title">
                    Create a new student account
                </div>
                <?php
                    if(isset($_GET['errors'])){ #if errors, inform user message
                        echo '<div class="h5" style="color:red;"> Something Went Wrong! </div>';
                    } else if(isset($_GET['success'])){ #if success, inform user
                        echo '<div style="color:green;">Registration Successful!</div>';
                    }
                ?>
                <input type="text" name="firstname" <?php 
                       $field = 'placeholder="First Name"'; #fill field with a placeholder as default
                       $style = 'class= "default"'; #system assumes by default no problems
                       if(isset($_GET['errors'])){  #if teachers attempted to change this field before and an error occured 
                           if ( !in_array($_GET['firstname'], array('empty','toolong','invalidchar')) ) {
                               $field = 'value='.$_GET['firstname']; #if this field didn't have the error, auto fill it with previous input
                           } else {
                               $style = 'class= "error"'; #otherwise turn the field red so user know this field had a mistake
                           }
                       }
                       echo $field.' '.$style;
                       ?> maxlength="255">
                <?php 
                    if(isset($_GET['errors'])){ #if error did occur, determine what the error was and give the correct error message and solutions
                        if($_GET['firstname'] == 'empty'){
                            echo '<div class="h5" style="color:red; text-align: left;">This field is required.</div>';
                        } else if($_GET['firstname'] == 'toolong'){
                            echo '<div class="h5" style="color:red; text-align: left;">This field cannot exceed 255 characters.</div>';
                        } else if($_GET['firstname'] == 'invalidchar'){
                            echo '<div style="color:red; text-align: left;">
                                    <p class="h5"> Please Match the requested format. </p>
                                    <p> This field only accepts letters. </p>
                                  </div>';
                        }
                    }
                ?>
                <input type="text" name="lastname" <?php 
                       $field = 'placeholder="Last Name"';
                       $style = 'class= "default"';
                       if(isset($_GET['errors'])){
                           if ( !in_array($_GET['lastname'], array('empty','toolong','invalidchar')) ) {
                               $field = 'value='.$_GET['lastname'];
                           } else {
                               $style = 'class= "error"';
                           }
                       }
                       echo $field.' '.$style;
                       ?> maxlength="255">
                <?php 
                    if(isset($_GET['errors'])){
                        if($_GET['lastname'] == 'empty'){
                            echo '<div class="h5" style="color:red; text-align: left;">This field is required.</div>';
                        } else if($_GET['lastname'] == 'toolong'){
                            echo '<div class="h5" style="color:red; text-align: left;">This field cannot exceed 255 characters.</div>';
                        } else if($_GET['lastname'] == 'invalidchar'){
                            echo '<div style="color:red; text-align: left;">
                                    <p class="h5"> Please Match the requested format. </p>
                                    <p> This field only accepts letters. </p>
                                  </div>';
                        }
                    }
                ?>
                <input type="text" name="username" <?php 
                       $field = 'placeholder="Username"';
                       $style = 'class= "default"';
                       if(isset($_GET['errors'])){
                           if ( !in_array($_GET['username'], array('empty','toolong','invalidchar','taken')) ) {
                               $field = 'value='.$_GET['username'];
                           } else {
                               $style = 'class= "error"';
                           }
                       }
                       echo $field.' '.$style;
                       ?> maxlength="255">
                <?php 
                    if(isset($_GET['errors'])){
                        if($_GET['username'] == 'empty'){
                            echo '<div class="h5" style="color:red; text-align: left;">This field is required.</div>';
                        } else if($_GET['username'] == 'toolong'){
                            echo '<div class="h5" style="color:red; text-align: left;">This field cannot exceed 255 characters.</div>';
                        } else if($_GET['username'] == 'invalidchar'){
                            echo '<div style="color:red; text-align: left;">
                                    <p class="h5"> Please Match the requested format. </p>
                                    <p> This field only accepts letters, numbers and underscores. </p>
                                  </div>';
                        } else if($_GET['username'] == 'taken'){
                            echo '<div style="color:red; text-align: left;">
                                    <p class="h5"> Username Taken </p>
                                    <p> Please try something else. </p>
                                  </div>';
                        }
                    }
                ?>
                <input type="password" name="password" placeholder="Password" <?php 
                       $style = 'class = "default"';
                       if(isset($_GET['errors'])){
                           if ( in_array($_GET['password'], array('empty','toolong','mismatch','invalidchar', '')) ) {
                               $style = 'class= "error"';
                           }
                       }
                       echo $style;
                       ?> maxlength="50">
                <?php 
                    if(isset($_GET['errors'])){
                        if( in_array($_GET['password'], array('empty','')) ){
                            echo '<div class="h5" style="color:red; text-align: left;">This field is required.</div>';
                        } else if($_GET['password'] == 'toolong'){
                            echo '<div class="h5" style="color:red; text-align: left;">This field cannot exceed 50 characters.</div>';
                        } else if($_GET['password'] == 'invalidchar'){
                            echo '<div style="color:red; text-align: left;">
                                    <p class="h5"> Please Match the requested format. </p>
                                    <p> This field accepts letters, numbers, underscores and the following special characters: <br /> @ % + \' ! # $ ^ ? : . ( ) { } [ ] ~ </p>
                                    <p> Please include at least 1 letter and 1 number. </p>
                                  </div>';
                        } else if($_GET['password'] == 'mismatch'){
                            echo '<div class="h5" style="color:red; text-align: left;"> Passwords didn\'t match, please try again </div>';
                        }
                    }
                ?>
                <input type="password" name="repeat-password" placeholder="Re-type Password" <?php 
                       $style = 'class = "default"';
                       if(isset($_GET['errors'])){
                           if ( in_array($_GET['password'], array('empty','toolong','mismatch','invalidchar', '')) ) {
                               $style = 'class= "error"';
                           }
                       }
                       echo $style;
                       ?> maxlength="50">
                <?php 
                    if(isset($_GET['errors'])){
                        if($_GET['password'] == 'mismatch'){
                            echo '<div class="h5" style="color:red; text-align: left;"> Passwords didn\'t match, please try again </div>';
                        } else {
                            echo '<div class="h5" style="color:red; text-align: left;">This field is required.</div>';
                        }
                    }
                ?>
                <button type="submit" name="signup-submit">Add</button>
            </form>
        </div>
    </div>
</div>

<?php require './inc/footer.php'; ?>