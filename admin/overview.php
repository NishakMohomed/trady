<?php
session_start();

if(!$_SESSION['adminLogin']){
    header("location: adminLogin.php");
}

$dataBase = mysqli_connect('localhost', 'root', '','trady');
$username = $_SESSION['adminUsername'];

//Admin
$lastNameQuery="SELECT * FROM admin WHERE username = '$username'";
$lastNameResult=mysqli_query($dataBase, $lastNameQuery);
$row = mysqli_fetch_array($lastNameResult);
$lastName = $row['last_name'];

//Users
$userQuery = "SELECT * FROM customer";
$userResult = mysqli_query($dataBase, $userQuery);
$totalUsers = mysqli_num_rows($userResult);

//Advertisements
$adQuery = "SELECT * FROM advertisements";
$adResult = mysqli_query($dataBase, $adQuery);
$totalAds = mysqli_num_rows($adResult);

//Hired ads
$hiredadQuery = "SELECT * FROM hire_ads";
$hiredadResult = mysqli_query($dataBase, $hiredadQuery);
$totalHiredads = mysqli_num_rows($hiredadResult);

//Total Revenue
$revenueQuery = "SELECT * FROM payment";
$revenueResult = mysqli_query($dataBase, $revenueQuery);
$totalRevenue = 0.00;
while($revenueRow = mysqli_fetch_assoc($revenueResult)){

    $totalRevenue += $revenueRow['amount'];
}

?>


<style>
    <?php include('../css/overview.css'); ?>
</style>

<div class="widgets">
    <div class="container">
        <div class="container-body">
            <div class="main-body">
                <div class="tittle">
                    <span class="greeting">Hello,<?php echo $lastName ?>   &#128075</span>
                    <h2>Overview</h2>
                </div>

                <div class="cards">
                    <div class="row row-1">
                        <div class="col">
                            <div class="total-revenue">
                                <h3 class="cardtittle">Total revenue</h3>
                                <h2 class="balance">$ <?php echo $totalRevenue ?></h2>
                            </div>
                        </div>
                    </div>

                    <div class="row row-2">
                        <div class="col">
                            <div class="total-users">
                                <h3 class="cardtittle">Total users</h3> 
                                <span class="t-i"><?php echo $totalUsers ?></span>
                                <span class="status">+</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="total-ads">
                                <h3 class="cardtittle">Total posted ads</h3>
                                <span class="p-i"><?php echo $totalAds ?></span>
                                <span class="status">
                                    <i class='bx bx-line-chart'></i>
                                </span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="total-hiredads">
                                <h3 class="cardtittle">Total hired ads</h3>
                                <span class="u-i"><?php echo $totalHiredads ?></span>
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