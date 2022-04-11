<?php
session_start();

if(!$_SESSION['login']){
    header("location: login.php");
}

if(!$_SESSION['adData-available']){
    header("location: postads.php");
}

//Connecting to database
$dataBase= mysqli_connect('localhost', 'root', '','trady');

//Price details
$priceQuery = "SELECT * FROM price WHERE price_id = '1'";
$priceResult = mysqli_query($dataBase, $priceQuery);
$priceRow = mysqli_fetch_array($priceResult);
$price = $priceRow['price'];

//Post advertisements
if($_SESSION['adData-available']){

    //Payment Details
    $amount = $price;
    $date = date("Y-m-d");
    $email = $_SESSION['email'];
    $customer_id = $_SESSION['customerId'];

    $paymentQuery = "INSERT INTO `payment`(`amount`, `date`, `email`, `customer_id`) VALUES ('$amount','$date','$email','$customer_id')";

    //Passing payment query
    mysqli_query($dataBase, $paymentQuery);

    //Advertisement details
    $adTitle = $_SESSION['adTitle'];
    $adCategory = $_SESSION['adCategory'];
    $adCity = $_SESSION['adCity'];
    $adDistrict = $_SESSION['adDistrict'];
    $adDescription = $_SESSION['adDescription'];
    $adTelno = $_SESSION['adTelno'];
    $adimgNewName = $_SESSION['adimgNewName'];
    $customerId = $_SESSION['customerId'];

    $postadQuery = "INSERT INTO advertisements(title,category,city,district,description,tel_no,ad_img,status,customer_id) 
                        VALUES ('$adTitle','$adCategory','$adCity','$adDistrict','$adDescription','$adTelno','$adimgNewName','active','$customerId')";

    //Passing postad query
    mysqli_query($dataBase, $postadQuery);

    //Unsetting sessions
    unset($_SESSION['adTitle']);
    unset($_SESSION['adCategory']);
    unset($_SESSION['adCity']);
    unset($_SESSION['adDistrict']);
    unset($_SESSION['adDescription']);
    unset($_SESSION['adTelno']);
    unset($_SESSION['adimgNewName']);
    unset($_SESSION['customerId']);
    $_SESSION['adData-available'] = false;

    echo "<script>
            alert('Successfully posted');
        </script>";

    header('location: ../pages/index.php');
}else{

    echo "<script>
            alert('Error please fill the advertisement details');
        </script>";
    header('location: ../pages/postads.php');
}

?>