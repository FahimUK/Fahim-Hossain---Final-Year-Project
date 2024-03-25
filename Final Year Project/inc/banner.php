<div class="banner-container">

    <div class="banner">

        <h1 class="pb-3 display-4"> 
            <?php
                $message = 'WELCOME';
                if (isset($_SESSION['firstname'])){
                    $message .= ', '.$_SESSION['firstname'];
                }
                echo $message; #if logged in, welcome the user by name
            ?>
        </h1>
        <?php
            $current_page = basename($_SERVER['SCRIPT_NAME']);
            if($current_page == 'activity-page.php') { #if activity page, display activity name
                echo '<h2 class="pb-3 display-5"> <strong> Lets see how well you do on, '.$row['name'].' </strong> </h2>';
            } else if($current_page == 'index.php') {  #if index page, display following
                echo '<h2 class="pb-3 display-5"> <strong> What would you like to learn today? </strong> </h2>';
            } else { #all other pages, display following
                echo '<h2 class="pb-3 display-5"> <strong> What would you like to do today? </strong> </h2>';
            }
        ?>
    </div>

</div>
