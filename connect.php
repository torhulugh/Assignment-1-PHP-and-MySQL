<?php
    $connect = mysqli_connect("localhost", "root", "password", "recipeDatabase");

    if(!$connect){
        die("Connection failed" . mysqli_connect_error());
    }