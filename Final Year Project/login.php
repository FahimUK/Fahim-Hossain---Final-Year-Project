<?php 

    require './inc/header.php'; 
    require './inc/navbar-default.php';

?>

<div class="login-container">
    <div class="login-content">
        <div class="form-img-container">
            <img class="avatar" src="./img/avatar.png">
        </div>
        <div class="form-input-container">
            <form action="inc/login.inc.php" method="post">
                <div class="login-title">
                    Log In to Your Account
                </div>
                <?php
                    if(isset($_GET['errors'])){ #if error occured, then display an error message
                        echo '<div class="h5" style="color:red;">Something Went Wrong!</div>';
                    }
                ?>
                <input type="text" name="username" <?php 
                       $field = 'placeholder="Username"';
                       $style = 'class= "default"';
                       if(isset($_GET['errors'])){
                           if ( !in_array($_GET['username'], array('empty','invaliduser')) ) {#if not an error message
                               $field = 'value='.$_GET['username']; #auto fill the field with previous inputed value
                           } else {
                               $style = 'class= "error"';
                           }
                       }
                       echo $field.' '.$style; #if error, turn field border to red, else keep the field as its default
                       ?> maxlength="255">
                <?php 
                    if(isset($_GET['errors'])){
                        if( $_GET['username'] == 'empty' ) {
                            echo '<div class="h5" style="color:red; text-align: left;">This field is required.</div>';
                        } else if( $_GET['username'] == 'invaliduser' ) {
                            echo '<div class="h5" style="color:red; text-align: left;">This User Doesn\'t Exist.</div>';
                        }
                    } #if error, inform user of the type of error
                ?>
                <input type="password" name="password" placeholder="Password" <?php 
                       $style = 'class = "default"';
                       if(isset($_GET['errors'])){
                           if ( in_array($_GET['password'], array('empty','incorrect','')) ) {
                               $style = 'class= "error"';
                           }
                       }
                       echo $style;
                       ?> maxlength="50">
                <?php 
                    if(isset($_GET['errors'])){
                        if( $_GET['password'] == 'empty' ){
                            echo '<div class="h5" style="color:red; text-align: left;">This field is required.</div>';
                        } else if( $_GET['password'] == 'incorrect' ){
                            echo '<div class="h5" style="color:red; text-align: left;">Incorrect Password.</div>';
                        }
                    }
                ?>
                <label>Account Type</label>
                <select name="usertype">
                    <option value="1" <?php
                                if(isset($_GET['errors'])){
                                    if ( $_GET['usertype'] == 1 ) {
                                        echo 'selected'; #if error, have this selection be what user previously selected
                                    }
                                }
                            ?>>Admin</option>
                    <option value="2" <?php
                                if(isset($_GET['errors'])){
                                    if ( $_GET['usertype'] == 2 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>Teacher</option>
                    <option value="3" <?php
                                if(isset($_GET['errors'])){
                                    if ( $_GET['usertype'] == 3 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>Student</option>
                </select>
                <button type="submit" name="login-submit">Login</button>
            </form>
        </div>
    </div>
</div>

<?php require './inc/footer.php'; ?>
