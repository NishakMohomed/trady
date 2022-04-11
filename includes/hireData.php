<?php

session_start();

if(!$_SESSION['login']){
    header("location: ../pages/login.php");
}

//Connecting to database
$dataBase = mysqli_connect('localhost', 'root', '','trady');

$errors = array();

//Hire Ads
if(isset($_POST['send'])){

    //Finding Customer Id
    $customerEmail = $_SESSION['email'];
    $customerIdQuery = "SELECT customer_id FROM customer WHERE email = '$customerEmail'";
    $customerResult = mysqli_query($dataBase, $customerIdQuery);
    $resultRow = mysqli_fetch_assoc($customerResult);

    //Details
    $name = mysqli_real_escape_string($dataBase, $_POST['firstName']);
    $tel_no = mysqli_real_escape_string($dataBase, $_POST['telno']);
    $address = mysqli_real_escape_string($dataBase, $_POST['address']);
    $date = mysqli_real_escape_string($dataBase, $_POST['date']);
    $details = mysqli_real_escape_string($dataBase, $_POST['details']);
    $customer_id = $resultRow['customer_id'];
    $advertisementId = mysqli_real_escape_string($dataBase, $_POST['adId']);

    //Form validation
    if(empty($name)){array_push($errors, "*Your name is required");}
    if(empty($tel_no)){array_push($errors, "*Phone number is required");}
    if(empty($address)){array_push($errors, "*Your address is required");}
    if(empty($date)){array_push($errors, "*Date is required");}
    if(empty($details)){array_push($errors, "*Work detail is required");}

    //Finding ad publisher's email
    $adOwnerQuery = "SELECT * FROM advertisements WHERE ad_id = '$advertisementId'";
    $adOwnerResult = mysqli_query($dataBase, $adOwnerQuery);

    if($adOwnerRow = mysqli_fetch_array($adOwnerResult)){
        $adOwnerId = $adOwnerRow['customer_id'];

        //Customer Table
        $adOwnerEmailQuery = "SELECT * FROM customer WHERE customer_id = '$adOwnerId'";
        $adOwnerEmailResult = mysqli_query($dataBase, $adOwnerEmailQuery);

        if($adOwnerEmailRow = mysqli_fetch_array($adOwnerEmailResult)){

            $to = $adOwnerEmailRow['email'];
            $subject = "Dear Customer, You're hired";
            $message = "<b>  <u>Client Details</u></b><br>
                        &nbsp;
                        <b>Name    : </b>{$name} <br>
                        &nbsp;
                        <b>Phone   : </b>{$tel_no} <br>
                        &nbsp;
                        <b>Address : </b>{$address} <br>
                        &nbsp;
                        <b>Date    : </b>{$date} <br>
                        &nbsp;
                        <b>Details : </b>" . nl2br(strip_tags($details));

            $header = "From:mailme.trady@gmail.com\r\nContent-Type: text/html;";

            //If no errors
        if(count($errors) == 0){
            $query = "INSERT INTO hire_ads(name,tel_no,address,details,date,customer_id,ad_id) VALUES('$name','$tel_no','$address','$details','$date','$customer_id','$advertisementId')";
            mysqli_query($dataBase, $query);
            mail($to, $subject, $message, $header);
            echo '<script>alert("Details sent successfully");</script>';
            header('location: ../pages/adView.php?adId='.$advertisementId.'');
        }
        }

    }

}

?>