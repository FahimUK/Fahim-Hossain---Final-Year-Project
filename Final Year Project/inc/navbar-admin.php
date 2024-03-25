<?php $current_page = basename($_SERVER['SCRIPT_NAME']);?> 

<div class="navigation-container nav-bg">
    <nav class="navbar navbar-expand-xl navbar-light">
        <button class="navbar-toggler" data-toggle="collapse" data-target="#my-nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"> BRAND </a>
        <div class="collapse navbar-collapse" id="my-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php if($current_page == 'registration.php'){ echo 'activated';}?>">
                    <a class="nav-item nav-link home-tab" href="registration.php" >
                        <span class="home-icon"></span> Registration
                    </a>
                </li>

                <li class="nav-item <?php if($current_page == 'login.php'){ echo 'activated';}?>">
                    <a class="nav-item nav-link signin-tab" 
                       <?php
                            if (isset($_SESSION['usertype'])){
                                echo 'href="inc/logout.inc.php"';
                            } else {
                                echo 'href="login.php"';
                            }
                       ?> >
                        <span class="signin-icon"></span> 
                        <?php
                            if (isset($_SESSION['usertype'])){
                                echo 'Sign Out';
                            } else {
                                echo 'Sign In';
                            }
                       ?>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
