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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/adminDashboard.css">
    <title>Admin</title>
</head>
<body>
    <header class="header">
        <div class="header_container">
            
            <a href="../admin/adminDashboard.php" class="header_logo">Trady</a>

            <div class="header_name">

            </div>

            <div class="header_toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
        </div>
    </header>

    <div class="nav" id="navbar">
        <nav class="nav_container">
            <div>
                <a href="../admin/adminDashboard.php" class="nav_link nav_logo">
                    <i class='bx bxl-tumblr nav_icon'></i>
                    <span class="nav_logo-name">Trady</span>
                </a>

                <div class="nav_list">
                    <div class="nav_items">
                        <h3 class="nav_subtitle">Dashboard</h3>

                        <a href="#" class="nav_link active" id="overview">
                            <i class='bx bx-chart nav_icon'></i>
                            <span class="nav_name">Overview</span>
                        </a>

                        <div class="nav_dropdown">
                            <a href="#" class="nav_link">
                                <i class='bx bx-edit nav_icon'></i>
                                <span class="nav_name">Manage</span>
                                <i class='bx bx-chevron-down nav_icon nav_dropdown-icon'></i>
                            </a>

                            <div class="nav_dropdown-collapse">
                                <div class="nav_dropdown-content">
                                    <a href="#" class="nav_dropdown-item" id="manageCustomer">customer</a>
                                    <a href="#" class="nav_dropdown-item" id="manageAds">advertisement</a>
                                    <a href="#" class="nav_dropdown-item" id="managePayments">payments</a>
                                    <a href="#" class="nav_dropdown-item" id="managePrice">price</a>
                                </div>
                            </div>
                        </div>

                        <a href="#" class="nav_link" id="hiredAds">
                            <i class='bx bx-collection nav_icon'></i>
                            <span class="nav_name">Hired ads</span>
                        </a>
                    </div>

                    <div class="nav_items">
                        <h3 class="nav_subtitle">Account</h3>

                        <div class="nav_dropdown">
                            <a href="#" class="nav_link">
                                <i class='bx bx-cog nav_icon'></i>
                                <span class="nav_name">Settings</span>
                                <i class='bx bx-chevron-down nav_icon nav_dropdown-icon'></i>
                            </a>

                            <div class="nav_dropdown-collapse">
                                <div class="nav_dropdown-content">
                                    <a href="#" class="nav_dropdown-item" id="adminAccounts">Admin Accounts</a>
                                    <a href="#" class="nav_dropdown-item" id="changeDetails">Change Details</a>
                                    <a href="#" class="nav_dropdown-item" id="changePassword">Change Password</a>
                                    <a href="#" class="nav_dropdown-item" id="addAdmin">Add admin</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="../admin/adminLogout.php" class="nav_link nav_logout">
                <i class='bx bx-log-out nav_icon'></i>
                <span class="nav_name">Log Out</span>
            </a>

        </nav>
    </div>

<!-------------------------------Contents------------------------------------------------------>

<main>
    <section>
    <div class="content_section" id="content_section">
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
    
       
    </div>
    </section>
</main>

<!-------------------------------Function for displaying details in dashboard------------->

    <script src="../js/dashboardToggle.js"></script>
    <script src="../js/adminLinks.js"></script>
</body>
</html>