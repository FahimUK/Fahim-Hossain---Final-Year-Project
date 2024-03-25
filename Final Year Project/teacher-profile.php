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

    //GETTING USER'S INFO
    $query = "SELECT * FROM teachers WHERE username=?"; #get teachers account details
    $statement = mysqli_stmt_init($connection);
    if(mysqli_stmt_prepare($statement, $query)) {
        mysqli_stmt_bind_param($statement, 's', $_SESSION['username']);
        mysqli_stmt_execute($statement);
        $results = mysqli_stmt_get_result($statement);
        if(!($row = mysqli_fetch_assoc($results))){ #if no results found, send user back to dashboard with error message
            header('Location: dashboard.php?error');
            exit();
        } 
    } else { #if error occured, send user back to dashboard with error message
        header('Location: dashboard.php?error');
        exit();
    }
?>

<div class="main-container">
    <div class="login-container">
        <div class="register-content form-input-container">
            <form action="inc/edit-profile.inc.php" method="post">
                <div class="login-title">
                    Edit your account details
                </div>
                <?php
                    if(isset($_GET['errors']) || isset($_GET['error'])){ #if errors, inform user message
                        echo '<div class="h5" style="color:red;"> Something Went Wrong! </div>';
                    } else if(isset($_GET['success'])){ #if success, inform user
                        echo '<div style="color:green;">Edits Successful!</div>';
                    }
                ?>
                <input type="text" name="firstname" <?php 
                       $field = 'value='.$row['firstname']; #fill field with user account name
                       $style = 'class= "default"'; #system assumes by default no problems
                       if(isset($_GET['errors'])){ #in teacher attempted to change this field before and an error occured turn the field red
                           $style = 'class= "error"';
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
                       $field = 'value='.$row['lastname'];
                       $style = 'class= "default"';
                       if(isset($_GET['errors'])){
                           $style = 'class= "error"';
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
                <input type="text" name="new-username" <?php 
                       $field = 'value='.$row['username'];
                       $style = 'class= "default"';
                       if(isset($_GET['errors'])){
                           $style = 'class= "error"';
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
                <input type="password" name="current-password" placeholder="Current Password" <?php 
                       $style = 'class = "default"';
                       if(isset($_GET['errors'])){
                           $style = 'class= "error"';
                       }
                       echo $style;
                       ?> maxlength="50">
                <?php 
                    if(isset($_GET['errors'])){
                        if( $_GET['password'] == 'empty') {
                            echo '<div class="h5" style="color:red; text-align: left;">This field is required.</div>';
                        } else if(in_array($_GET['password'], array('incorrect',''))){
                            echo '<div class="h5" style="color:red; text-align: left;">Incorrect Password.</div>';
                        }
                    }
                ?>
                <input type="password" name="new-password" placeholder="New Password" <?php 
                       $style = 'class = "default"';
                       if(isset($_GET['errors']) && $_GET['newpassword'] != ''){
                           $style = 'class= "error"';
                       }
                       echo $style;
                       ?> maxlength="50">
                <?php 
                    if(isset($_GET['errors'])){
                        if( $_GET['newpassword'] == 'toolong') {
                            echo '<div class="h5" style="color:red; text-align: left;">This field cannot exceed 255 characters.</div>';
                        } else if($_GET['newpassword'] == 'invalidchar'){
                            echo '<div style="color:red; text-align: left;">
                                    <p class="h5"> Please Match the requested format. </p>
                                    <p> This field accepts letters, numbers, underscores and the following special characters: <br /> @ % + \' ! # $ ^ ? : . ( ) { } [ ] ~ </p>
                                    <p> Please include at least 1 letter and 1 number. </p>
                                  </div>';
                        }
                    }
                ?>
                <input type="hidden" name="usertype" value=<?php echo $row['usertype'] ?>>
                <input type="hidden" name="old-username" value=<?php echo $row['username'] ?>>
                <input type="hidden" name="id" value=<?php echo $row['id'] ?>>
                <button type="submit" name="edit-submit">Edit</button>
            </form>
        </div>
    </div>
</div>

<?php require './inc/footer.php'; ?>