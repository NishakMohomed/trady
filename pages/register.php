<?php 

session_start();

//Initializing variables
$firstName="";
$lastName="";
$dob="";
$gender="";
$emailRegister="";
$passwordRegister="";
$errors=array();
$passwordErrors=array();

//Variable for validating email
$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^"; 

//Connecting to database
$dataBase= mysqli_connect('localhost', 'root', '','trady');


//Register new customers
if(isset($_POST['signup'])){
    $firstName= mysqli_real_escape_string($dataBase, $_POST['firstName']);
    $lastName= mysqli_real_escape_string($dataBase, $_POST['lastName']);
    $dob= mysqli_real_escape_string($dataBase, $_POST['dob']);
    $gender= mysqli_real_escape_string($dataBase, $_POST['gender']);
    $emailRegister= mysqli_real_escape_string($dataBase, $_POST['emailRegister']);
    $passwordRegister= mysqli_real_escape_string($dataBase, $_POST['passwordRegister']);

    //Form validation
    if(empty($firstName)){array_push($errors, "*First name is required");}
    if(empty($lastName)){array_push($errors, "*Last name is required");}
    if(empty($dob)){array_push($errors, "*Date of birth is required");}
    if(empty($gender)){array_push($errors, "*Gender is required");}
    if(empty($emailRegister)){array_push($errors, "*Email is required");}
    if (!filter_var($emailRegister, FILTER_VALIDATE_EMAIL)){array_push($errors, "*Invalid format and please re-enter valid email");}
    if(empty($passwordRegister)){array_push($errors, "*Password is required");}


    if (strlen($passwordRegister) <= '8'){array_push($errors, "*Your Password Must Contain At Least 8 Characters!");}
    elseif(!preg_match("#[0-9]+#",$passwordRegister)){array_push($errors, "*Your Password Must Contain At Least 1 Number!");}
    //elseif(!preg_match("#[A-Z]+#",$passwordRegister)){array_push($errors, "*Your Password Must Contain At Least 1 Capital Letter!");}
    //elseif(!preg_match("#[a-z]+#",$passwordRegister)){array_push($errors, "*Your Password Must Contain At Least 1 Lowercase Letter!");}

    //Check the database for any existing user with same email id
    $emailCheckQuery= "SELECT * FROM customer WHERE email = '$emailRegister'";

    $emailCheckResults= mysqli_query($dataBase, $emailCheckQuery);

    //Mathing email id's in database
    $matchingEmail= mysqli_fetch_assoc($emailCheckResults);

    if($matchingEmail){
        if($matchingEmail['email'] === $emailRegister){
            array_push($errors, "*Email already exists");
        }
    }


    //Register the customer if no any error
    if(count($errors) == 0){

        //Encrypt the password
        $encryptedpasswordRegister = md5($passwordRegister);

        $registerQuery= "INSERT INTO customer (first_name,last_name,dob,gender,email,password)
                        VALUES('$firstName','$lastName','$dob','$gender','$emailRegister','$encryptedpasswordRegister')";
        
        //Passing query
        mysqli_query($dataBase, $registerQuery);

        $_SESSION['email'] = $emailRegister;
        $_SESSION['login'] = true;
        header('location: ./index.php');
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
    <link rel="stylesheet" href="../css/register.css">
    <title>Sign up</title>
</head> 
<body>
    <section>

        <div class="register_section">
            <div class="register_form_content">
                <h2>Sign up</h2>
                <form action="" method="POST">
                <?php include('../includes/errors.php') ?>
                    <div class="register_input">
                        <span>First Name</span> <br>
                        <input type="text" name="firstName" required>
                    </div>

                    <div class="register_input">
                        <span>Last Name</span> <br>
                        <input type="text" name="lastName" required>
                    </div>

                    <div class="register_input">
                        <span>Date of birth</span> <br>
                        <input type="date" name="dob" required>
                    </div>

                    <div class="register_input">
                        <span>Gender</span> <br>
                            <select name="gender" id="" required>
                                <option value="">Select</option>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                    </div>

                    <div class="register_input">
                        <span>Email</span> <br>
                        <input type="email" name="emailRegister" required>
                    </div>

                    <div class="register_input">
                        <span>Password</span> <br>
                        <input type="password" name="passwordRegister" required>
                    </div>

                    <div class="register_input">
                        <input type="submit" name="signup" value="Sign up">
                    </div>

                    <div class="register_input">
                        <p>Already have an account? <a href="./login.php">Sign in</a></p>
                    </div>
                </form>
            </div>
        </div>
        
    </section>

<!--------------------------------------------Footer Section--------------------------------------------->
    
    <?php include('../includes/footer.php'); ?>

</body>
</html>