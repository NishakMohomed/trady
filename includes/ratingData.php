<?php

session_start();

if(!$_SESSION['login']){
    header("location: ../pages/login.php");
}

//Connecting to database
$dataBase = mysqli_connect('localhost', 'root', '','trady');

if(isset($_POST['rateBtn'])){

    //Finding customer id
    $customerEmail = $_SESSION['email'];
    $customerIdQuery = "SELECT customer_id FROM customer WHERE email = '$customerEmail'";
    $customerResult = mysqli_query($dataBase, $customerIdQuery);
    $resultRow = mysqli_fetch_assoc($customerResult);

    //Star Count
    $starCount = "";

    $rating = "";
    $date = "";
    $ad_id = "";
    $customer_id = "";
    $errors = array();


    if(isset($_POST['rate'])){
        $starCount = $_POST['rate'];
    }else{
        array_push($errors, "Please select a star");
        echo '<script>alert("Please select a star");</script>';

    }

    $rating = $starCount;
    $date = date("Y-m-d");
    $ad_id = mysqli_real_escape_string($dataBase, $_POST['adId']);
    $customer_id = $resultRow['customer_id'];

    //Check if already rated
    $checkQuery = "SELECT * FROM ratings WHERE ad_id = '$ad_id' AND customer_id = '$customer_id'";
    $checkResult = mysqli_query($dataBase, $checkQuery);
    $checkRowCount = mysqli_num_rows($checkResult);

    if($checkRowCount > 0){
        array_push($errors, "You already rated"); 
        echo '<script>alert("You already rated");</script>';

    }

    if(count($errors) == 0){

        $query = "INSERT INTO ratings(rating,date,ad_id,customer_id) VALUES('$rating','$date','$ad_id','$customer_id')";
        mysqli_query($dataBase, $query);
        echo '<script>alert("Rated successfully");</script>';
        header('location: ../pages/adView.php?adId='.$ad_id.'');
    }


}

?>