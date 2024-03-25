<?php $current_page = basename($_SERVER['SCRIPT_NAME']);?> 

<div class="navigation-container nav-bg">
    <nav class="navbar navbar-expand-xl navbar-light">
        <button class="navbar-toggler" data-toggle="collapse" data-target="#my-nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"> BRAND </a>
        <div class="collapse navbar-collapse" id="my-nav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php if($current_page == 'dashboard.php'){ echo 'activated';}?>">
                    <a class="nav-item nav-link home-tab" href="dashboard.php">
                        <span class="home-icon"></span> Dashboard
                    </a>
                </li>

                <li class="nav-item <?php if($current_page == 'store.php'){ echo 'activated';}?>">
                    <a class="nav-item nav-link store-tab" href="#">
                        <span class="store-icon"></span> Store
                    </a>
                </li>

                <li class="nav-item <?php if($current_page == 'contact.php'){ echo 'activated';}?>">
                    <a class="nav-item nav-link contact-tab" href="#">
                        <span class="contact-icon"></span> Contact
                    </a>
                </li>

                <li class="nav-item <?php if($current_page == 'about.php'){ echo 'activated';}?>">
                    <a class="nav-item nav-link about-tab" href="#">
                        <span class="about-icon"></span> About
                    </a>
                </li>

                <li class="nav-item <?php if($current_page == 'help.php'){ echo 'activated';}?>">
                    <a class="nav-item nav-link help-tab" href="#">
                        <span class="help-icon"></span> Help
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
