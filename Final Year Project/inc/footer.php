<div class="my-footer-container">
    <footer class="footer-content">
        <div class="row">
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-xs-6 footer-links">
                        <div class="footer-heading">
                            About
                        </div>
                        <ul>
                            <li>
                                <a href="#">
                                    Our Misson
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Meet the Team
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Partners
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    News
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Teachers & Parents
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-6 footer-links">
                        <div class="footer-heading">
                            Support
                        </div>
                        <ul>
                            <li>
                                <a href="#">
                                    Help center
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Contact Us
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    FAQ
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="row social-links">
                    <ul>
                        <li>
                            <a href="https://www.facebook.com/" target="_blank">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/" target="_blank">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/" target="_blank">
                                <i class="	fab fa-youtube"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="row app-links">
                    <div class="col-sm-6">
                        <a href="https://www.apple.com/uk/ios/app-store/" target="_blank">
                            <img src="./img/app-store-badge.png" />
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="https://play.google.com/store?hl=en" target="_blank">
                            <img src="./img/google-play-badge.png" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<!--jquery, bootstrap and charts.js-->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

<?php #add script to the page they are used within
    $current_page = basename($_SERVER['SCRIPT_NAME']);
    if($current_page == 'activity-page.php'){ echo '<script src="./js/activity-script.js"></script>';}
    if($current_page == 'view-results.php'){ echo '<script src="./js/view-results-script.js"></script>';}
    if($current_page == 'view-class-results.php'){ echo '<script src="./js/view-class-results-script.js"></script>';}
?>

</body>

</html>