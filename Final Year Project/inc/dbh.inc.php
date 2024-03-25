<?php

$server = 'localhost'; 
$username = 'root';
$password = '';
$database = 'educationalappsystem';

$connection = mysqli_connect($server, $username, $password, $database);

if (!$connection) {
    die("Unfortunatly something went wrong. ".mysqli_connect_error(). " Please try again in a little while...");
}