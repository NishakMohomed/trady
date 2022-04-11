<?php 

session_start();
//Log user in

//Database connection
$dataBase= mysqli_connect('localhost', 'root', '','trady');

//Initialize variables for login
$emailLogin= "";
$passwordLogin= "";
$errors = array();

if(isset($_POST['signin'])){

    $emailLogin= mysqli_real_escape_string($dataBase, $_POST['emailLogin']);
    $passwordLogin= mysqli_real_escape_string($dataBase, $_POST['passwordLogin']);

    if(empty($emailLogin)){array_push($errors, "*Email is required");}
    if(empty($passwordLogin)){array_push($errors, "*Password is required");}


    if(count($errors) == 0){
        $encryptPasswordLogin= md5($passwordLogin);

        $loginCheckQuery= "SELECT * FROM customer WHERE email='$emailLogin' AND password= '$encryptPasswordLogin'";
        $loginCheckResults= mysqli_query($dataBase, $loginCheckQuery);


        if(mysqli_num_rows($loginCheckResults)){
            $_SESSION['email'] = $emailLogin;
            $_SESSION['login'] = true;
            header('location: dashboard.php');
        }
        else{
            array_push($errors, "*Wrong email or password. please try again");
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
                <h2>#Login to get started.</h2>
            </div>
        </div>
        <div class="login_content">
            <div class="login_form">
                <h2>Sign in</h2>
                <form action="login.php" method="POST">
                <?php include('../includes/errors.php') ?>
                    <div class="login_input">
                        <span>Email</span>
                        <input type="email" name="emailLogin" required>
                    </div>

                    <div class="login_input">
                        <span>Password</span>
                        <input type="password" name="passwordLogin" required>
                    </div>

                    <div class="login_input">
                        <input type="submit" name="signin" value="Sign in">
                    </div>

                    <div class="login_input">
                        <p>Don't have an account? <a href="./register.php">Sign up</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

<!--------------------------------------------Footer Section---------------------------------------------->
    
    <?php include('../includes/footer.php'); ?>

</body>
</html>