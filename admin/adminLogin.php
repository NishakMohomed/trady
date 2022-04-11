<?php 

session_start();
//Log user in

//Database connection
$dataBase= mysqli_connect('localhost', 'root', '','trady');

//Initialize variables for login
$username= "";
$password= "";
$errors = array();

if(isset($_POST['signin'])){

    $username= mysqli_real_escape_string($dataBase, $_POST['username']);
    $password= mysqli_real_escape_string($dataBase, $_POST['password']);

    if(empty($username)){array_push($errors, "*User name is required");}
    if(empty($password)){array_push($errors, "*Password is required");}


    if(count($errors) == 0){
        $encryptpassword= md5($password);

        $loginCheckQuery= "SELECT * FROM admin WHERE username = '$username' AND password= '$encryptpassword'";
        $loginCheckResults= mysqli_query($dataBase, $loginCheckQuery);


        if(mysqli_num_rows($loginCheckResults)){
            $_SESSION['adminUsername'] = $username;
            $_SESSION['adminLogin'] = true;
            header('location: adminDashboard.php');
        }
        else{
            array_push($errors, "*Wrong username or password. please try again");
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
    <link rel="stylesheet" href="../css/login.css">
    <title>Sign in</title>
</head>
<body>
    <section>
        <div class="login_image">
            <img src="../images/loginpic.jpg">
            <div class="loginText">
                <h2>#Admin dashboard.</h2>
            </div>
        </div>
        <div class="login_content">
            <div class="login_form">
                <h2>Sign in</h2>
                <form action="adminLogin.php" method="POST">
                <?php include('../includes/errors.php') ?>
                    <div class="login_input">
                        <span>User Name</span>
                        <input type="text" name="username" required>
                    </div>

                    <div class="login_input">
                        <span>Password</span>
                        <input type="password" name="password" required>
                    </div>

                    <div class="login_input">
                        <input type="submit" name="signin" value="Sign in">
                    </div>
                </form>
            </div>
        </div>
    </section>

<!--------------------------------------------Footer Section---------------------------------------------->
    
    <?php include('../admin/adminFooter.php'); ?>

</body>
</html>