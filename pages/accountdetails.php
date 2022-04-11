<?php

session_start();

$dataBase = mysqli_connect('localhost', 'root', '','trady');
$email = $_SESSION['email'];

 $lastNameQuery="SELECT * FROM customer WHERE email = '$email'";
 
 $result=mysqli_query($dataBase, $lastNameQuery);

 $row = mysqli_fetch_array($result)

?>

<style>
    <?php include('../css/accountdetails.css'); ?>
</style>

<div class="user_details_section">
    <div class="user_details_content">
    <h1>Account details</h1>
        <div class="personal_details">
            <span>First Name : </span>
            <?php echo $row['first_name'] ?>
        </div>

        <div class="personal_details">
            <span>Last Name : </span>
            <?php echo $row['last_name'] ?>
        </div>

        <div class="personal_details">
            <span>Date of birth : </span>
            <?php echo $row['dob'] ?>
        </div>

        <div class="personal_details">
            <span>Gender : </span>
            <?php if($row['gender'] == 'm'){
                echo "Male";
            }
            else{
                echo "Female";
            } ?>
        </div>
        
        <div class="personal_details">
            <span>Email : </span>
            <?php echo $row['email'] ?>
        </div>

    </div>

    <div class="card-body">
        <div class="float-left">
            <h3>
                <span class="posted_ads">0</span> <br>
                <span class="count">Ads posted</span>
            </h3>
        </div>
    </div>

    <div class="card-body">
        <div class="float-left">
            <h3>
                <span class="posted_ads">0</span> <br>
                <span class="count">Ads hired</span>
            </h3>
        </div>
    </div>
</div>
