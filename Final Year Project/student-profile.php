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

    //GETTING STUDENTS' INFO
    if(!empty($_GET['orderby'])){ #if the ordrby variable isn't empty in the url
        $order = $_GET['orderby']; #order is this variables value
    } else {
        $order = 'firstname'; #otherwise by default it is firstname
    }
    if(!empty($_GET['sort'])){ #if the sort variable isn't empty in the url
        $sort = $_GET['sort']; #sort is this variables value
    } else {
        $sort = 'asc'; #otherwise by default it is asc
    }
    if(!empty($_GET['limit'])){ #if the limit variable isn't empty in the url
        $maxNumRows = $_GET['limit']; #limit is this variables value
    } else {
        $maxNumRows = 5; #otherwise by default it is 5
    }
    if(!empty($_GET['page'])){ #if the page variable isn't empty in the url
        $currentPage = $_GET['page']; #page is this variables value
    } else {
        $currentPage = 1; #otherwise by default it is 1
    }
    $startingRow = ($currentPage - 1) * $maxNumRows; #determine which record to begin from, determined by what page the user is currently on
    $query = "SELECT * FROM students WHERE teacherid=? ORDER BY ".$order.' '.$sort; #query that gets all the student records in the correct order
    $statement = mysqli_stmt_init($connection);
    if(mysqli_stmt_prepare($statement, $query)) {
        mysqli_stmt_bind_param($statement, 'i', $_SESSION['id']);
        mysqli_stmt_execute($statement);
        $results = mysqli_stmt_get_result($statement);
        if(!($row = mysqli_fetch_assoc($results))){ #if no results found, then send user back to dashboard with error message
            header('Location: dashboard.php?error');
            exit();
        }
        #if results, find the number of records to determine the number of pages for pagination
        $numResults = mysqli_num_rows($results);
        $numPages = ceil($numResults / $maxNumRows);
    } else {
        header('Location: dashboard.php?error'); #if an error occured, send user back to dashboard with error message
        exit();
    }
?>

<div class="main-container">
    <div class="content">
        <div class="student-records-container">
            <?php
                if(isset($_GET['errors']) || isset($_GET['error'])){ #if errors, inform user
                    echo '<div class="h5" style="color:red;">Something Went Wrong!</div>';
                } else if(isset($_GET['success'])){ #if success, inform user
                    echo '<div style="color:green;">Edits Successful!</div>';
                }
            ?>
            <div class="student-records-content">
                <?php 
                    if(mysqli_data_seek($results,$startingRow)){ #if the student records can start in the stored starting row (if not send user back to dashboard with error message)
                        for($i = 0; $i < $maxNumRows; $i++){ #loop throught from the starting position to the number of rows to show
                            if(!$row = mysqli_fetch_assoc($results)){ #if loop not over and results finish, break out the loop
                                break;
                            }
                ?>
                <!--form that shows each student's record-->
                <form action="inc/edit-profile.inc.php" method="post">
                    <input type="text" name="firstname" <?php echo "value='".$row["firstname"]."'" ?> maxlength="255">
                    <input type="text" name="lastname" <?php echo "value='".$row["lastname"]."'" ?> maxlength="255">
                    <input type="text" name="new-username" <?php echo "value='".$row["username"]."'" ?> maxlength="255">
                    <input type="password" name="new-password" placeholder="New Password" maxlength="50">
                    <input type="hidden" name="usertype" value=<?php echo $row['usertype'] ?>>
                    <input type="hidden" name="old-username" value=<?php echo $row['username'] ?>>
                    <input type="hidden" name="id" value=<?php echo $row['id'] ?>>
                    <?php #determine the url so when student account details are changed, the system goes back to the users chosen order
                        if(!(empty($_GET['page']) && empty($_GET['orderby']) && empty($_GET['sort']) && empty($_GET['limit']))) {
                            $value = '';
                            if(!empty($_GET['page'])){
                               $value .= '&page='.$_GET['page'];
                            }
                            if(!empty($_GET['orderby'])){
                                $value .= '&orderby='.$_GET['orderby'];
                            }
                            if(!empty($_GET['sort'])){
                                $value .= '&sort='.$_GET['sort'];
                            }
                            if(!empty($_GET['limit'])){
                                $value .= '&limit='.$_GET['limit'];
                            }
                            echo '<input type="hidden" name="url" value='.$value.'>'; #send it as a hidden field
                        }
                    ?>
                    <button type="submit" name="edit-submit">Edit</button>
                </form>
                <?php 
                        } 
                    } else {
                        header('Location: dashboard.php?error');
                        exit();
                    }
                ?>
            </div>
            <div class="student-records-nav">
                <div class="pagination">
                <?php
                    for($i = 1; $i < $numPages + 1; $i++){ #starting from one, to the number of pages required
                        $pagination = '<a href="student-profile.php?page='.$i; #build the pagination, making sure each link has the chosen order details as well
                        if(isset($_GET['orderby'])){
                            $pagination .= '&orderby='.$_GET['orderby'];
                        }
                        if(isset($_GET['sort'])){
                            $pagination .= '&sort='.$_GET['sort'];
                        }
                        if(isset($_GET['limit'])){
                            $pagination .= '&limit='.$_GET['limit'];
                        }
                        if(isset($_GET['page'])){
                            if($_GET['page'] == $i){
                                $pagination .= '" class = "current-page"'; #make the page number the user is on the current page
                            }
                        } else if($i == 1){ #defualt when user starts they're on page 1
                            $pagination .= '" class = "current-page"';
                        }
                        $pagination .= '">'.$i.'</a>';
                        echo $pagination;
                    }
                ?>
                </div>
                <form action="student-profile.php" method="get">
                    <fieldset>
                        <label for="orderby">Order by</label>
                        <select name="orderby" onchange="this.form.submit()">
                            <option value="firstname"<?php #label the selected option as what the user is currently seeing
                                if(isset($_GET['orderby'])){
                                    if ( $_GET['orderby'] == 'firstname' ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>First Name</option>
                            <option value="lastname"<?php
                                if(isset($_GET['orderby'])){
                                    if ( $_GET['orderby'] == 'lastname' ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>Last Name</option>
                            <option value="username"<?php
                                if(isset($_GET['orderby'])){
                                    if ( $_GET['orderby'] == 'username' ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>Username</option>
                        </select>
                    </fieldset>
                    <fieldset>
                        <label for="sort">Sort by</label>
                        <select name="sort" onchange="this.form.submit()">
                            <option value="asc"<?php #label the selected option as what the user is currently seeing
                                if(isset($_GET['sort'])){
                                    if ( $_GET['sort'] == 'asc' ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>ASC</option>
                            <option value="desc"<?php
                                if(isset($_GET['sort'])){
                                    if ( $_GET['sort'] == 'desc' ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>DESC</option>
                        </select>
                    </fieldset>
                    <fieldset>
                        <label for="limit">Number of rows</label>
                        <select name="limit" onchange="this.form.submit()">
                            <option value="5"<?php #label the selected option as what the user is currently seeing
                                if(isset($_GET['limit'])){
                                    if ( $_GET['limit'] == 5 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>5</option>
                            <option value="10"<?php
                                if(isset($_GET['limit'])){
                                    if ( $_GET['limit'] == 10 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>10</option>
                            <option value="15"<?php
                                if(isset($_GET['limit'])){
                                    if ( $_GET['limit'] == 15 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>15</option>
                            <option value="20"<?php
                                if(isset($_GET['limit'])){
                                    if ( $_GET['limit'] == 20 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>20</option>
                            <option value="25"<?php
                                if(isset($_GET['limit'])){
                                    if ( $_GET['limit'] == 25 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>25</option>
                            <option value="30"<?php
                                if(isset($_GET['limit'])){
                                    if ( $_GET['limit'] == 30 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>30</option>
                            <option value="35"<?php
                                if(isset($_GET['limit'])){
                                    if ( $_GET['limit'] == 35 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>35</option>
                            <option value="40"<?php
                                if(isset($_GET['limit'])){
                                    if ( $_GET['limit'] == 40 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>40</option>
                            <option value="45"<?php
                                if(isset($_GET['limit'])){
                                    if ( $_GET['limit'] == 45 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>45</option>
                            <option value="50"<?php
                                if(isset($_GET['limit'])){
                                    if ( $_GET['limit'] == 50 ) {
                                        echo 'selected';
                                    }
                                }
                            ?>>50</option>
                        </select>
                    </fieldset>
                    <noscript>
                        <!--normally once the user changes the field, the page is auto updated but is javascript isn't on then the user can use this button-->
                        <button type="submit" name="order-btn">Edit Filters</button>
                    </noscript>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require './inc/footer.php'; ?>