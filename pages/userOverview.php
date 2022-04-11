<?php

session_start();

if(!$_SESSION['login']){
    header("location: login.php");
}

$dataBase = mysqli_connect('localhost', 'root', '','trady');
$email = $_SESSION['email'];

//User
 $lastNameQuery="SELECT * FROM customer WHERE email = '$email'";
 $result=mysqli_query($dataBase, $lastNameQuery);
 $row = mysqli_fetch_array($result);
 $customerId = $row['customer_id'];
 $lastname = $row['last_name'];

//Advertisement
 $adDetailsQuery = "SELECT * FROM advertisements WHERE customer_id = '$customerId'";
 $adDetailsResult = mysqli_query($dataBase, $adDetailsQuery);
 $adDetailsCount = mysqli_num_rows($adDetailsResult);


 //Total Hired ads
 $hiredAdQuery = "SELECT * FROM hire_ads WHERE customer_id = '$customerId'";
 $hireAdResult = mysqli_query($dataBase, $hiredAdQuery);
 $totalHireAd = mysqli_num_rows($hireAdResult);
 
?>


<style>
    <?php include('../css/userOverview.css'); ?>
</style>

<div class="widgets">
    <div class="container">
        <div class="container-body">
            <div class="main-body">
                <div class="tittle">
                    <span class="greeting">Hello,<?php echo $lastname ?>   &#128075</span>
                    <h2>Overview</h2>
                </div>

                <div class="cards">

                    <div class="row row-2">
                        
                        <div class="col">
                            <div class="total-ads">
                                <h3 class="cardtittle">Total posted ads</h3>
                                <span class="p-i"><?php echo $adDetailsCount ?></span>
                                <span class="status">
                                    <i class='bx bx-line-chart'></i>
                                </span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="total-hiredads">
                                <h3 class="cardtittle">Total hired ads</h3> 
                                <span class="u-i"><?php echo $totalHireAd ?></span>
                                <span class="status">
                                    <i class='bx bx-line-chart'></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>