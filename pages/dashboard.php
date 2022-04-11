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


 //Delete account

//Initialize variables for login
 $password = "";
 $errors = array();

 if(isset($_POST['deleteAccount'])){

    $password = mysqli_real_escape_string($dataBase, $_POST['password']);

    if(empty($password)){array_push($errors, "*Password is required");}

    if(count($errors) == 0){

        $encryptPassword = md5($password);

        $passwordCheckQuery= "SELECT * FROM customer WHERE email='$email' AND password= '$encryptPassword'";
        $passwordCheckResults= mysqli_query($dataBase, $passwordCheckQuery);

        if(mysqli_num_rows($passwordCheckResults)){

            $_SESSION['email'] = "";
            $_SESSION['login'] = false;
            $deleteQuery = "DELETE FROM customer WHERE email = '$email'";
            mysqli_query($dataBase, $deleteQuery);
            echo '<script>alert("Account successfully deleted");</script>';

            header('location: login.php');
        }
        else{
            array_push($errors, "*Wrong password. please try again");
        }
    }
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
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Dashboard</title>
</head>
<body>
    <header class="header">
        <div class="header_container">
            
            <a href="../pages/index.php" class="header_logo">Trady</a>

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
                <a href="../pages/index.php" class="nav_link nav_logo">
                    <i class='bx bxl-tumblr nav_icon'></i>
                    <span class="nav_logo-name">Trady</span>
                </a>

                <div class="nav_list">
                    <div class="nav_items">
                        <h3 class="nav_subtitle">Dashboard</h3>

                        <a href="#" class="nav_link active" id="userOverview">
                            <i class='bx bx-chart nav_icon'></i>
                            <span class="nav_name">Overview</span>
                        </a>

                        <div class="nav_dropdown">
                            <a href="#" class="nav_link">
                                <i class='bx bx-news nav_icon'></i>
                                <span class="nav_name">Advertisement</span>
                                <i class='bx bx-chevron-down nav_icon nav_dropdown-icon'></i>
                            </a>

                            <div class="nav_dropdown-collapse">
                                <div class="nav_dropdown-content">
                                    <a href="#" class="nav_dropdown-item" id="postedAds">Posted ads</a>
                                    <a href="#" class="nav_dropdown-item" id="hiredAds">Hired ads</a>
                                </div>
                            </div>
                        </div>

                        <!--<a href="#" class="nav_link" id="messages">
                            <i class='bx bx-bell nav_icon'></i>
                            <span class="nav_name">Alerts</span>
                        </a>-->
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
                                    <a href="#" class="nav_dropdown-item" id="changeDetails">Change Details</a>
                                    <a href="#" class="nav_dropdown-item" id="changeEmail">Change Mail</a>
                                    <a href="#" class="nav_dropdown-item" id="changePassword">Change Password</a>
                                    <a href="#" class="nav_dropdown-item" id="deleteAcc">Close account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="../includes/logout.php" class="nav_link nav_logout">
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
    </div>
    </section>
</main>

<!-------------------------------------------------------------------------------------------------->



<div class="deleteAccount">
        <div class="modal-content">
            <div class="close2">+</div>
            <div class="update_section">
                <div class="update_form_content">
                    <h2>Close Account</h2>
                    <form action="dashboard.php" method="POST">
                        <?php include('../includes/errors.php') ?>
                        <div class="update_input">
                            <span>Are you sure want to close this account?</span> <br>
                            <ul>
                                <li>This cannot be un done</li>
                                <li>This will delete all your advertisement posted on the site</li>
                                <li>This will delete all your data</li>
                                <li>Please confirm your password</li>
                            </ul>
                        </div>

                        <div class="update_input">
                            <input type="password" name="password">
                        </div>
    
                        <div class="update_input">
                            <input type="submit" name="deleteAccount" value="Delete">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>

        document.getElementById('deleteAcc').addEventListener('click', function(){
            document.querySelector('.deleteAccount').style.display = 'flex';
        });

        document.querySelector('.close2').addEventListener('click', function(){
            document.querySelector('.deleteAccount').style.display = 'none';
        });
    </script>


<!-------------------------------------------------------------------------------------------------->

<!-------------------------------Function for displaying details in dashboard----------------------->

    <script src="../js/dashboardToggle.js"></script>
    <script src="../js/dashboardLinks.js"></script>
</body>
</html>