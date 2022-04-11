<?php


session_start();

if(!$_SESSION['adminLogin']){
    header("location: adminLogin.php");
}

//Database connection
$dataBase = mysqli_connect('localhost', 'root', '','trady');

//Initializing variables
$firstName="";
$lastName="";
$gender="";
$dob="";
$userName="";
$password="";
$errors=array();

//Change the details of the customer
if(isset($_POST['add'])){

    $firstName= mysqli_real_escape_string($dataBase, $_POST['firstName']);
    $lastName= mysqli_real_escape_string($dataBase, $_POST['lastName']);
    $gender= mysqli_real_escape_string($dataBase, $_POST['gender']);
    $dob= mysqli_real_escape_string($dataBase, $_POST['dob']);
    $userName= mysqli_real_escape_string($dataBase, $_POST['username']);
    $password= mysqli_real_escape_string($dataBase, $_POST['password']);

     //Form validation
     if(empty($firstName)){array_push($errors, "*First name is required");}
     if(empty($lastName)){array_push($errors, "*Last name is required");}
     if(empty($gender)){array_push($errors, "*Gender is required");}
     if(empty($dob)){array_push($errors, "*Date of birth is required");}
     if(empty($userName)){array_push($errors, "*Email is required");}
     if(empty($password)){array_push($errors, "*Password is required");}

     //Password validation
     if (strlen($password) <= '8'){array_push($errors, "*Your Password Must Contain At Least 8 Characters!");}
     elseif(!preg_match("#[0-9]+#",$password)){array_push($errors, "*Your Password Must Contain At Least 1 Number!");}

     //Username validation
     if(strlen($userName) <= '6'){array_push($errors, "*Your Username Must Contain At Least 6 Characters!");}
     elseif(!preg_match("#[0-9]+#",$userName)){array_push($errors, "*Your Username Must Contain At Least 1 Number!");}

    //Check the database for any existing user with same username
    $usernameCheckQuery= "SELECT * FROM admin WHERE username = '$userName'";

    $usernameCheckResults= mysqli_query($dataBase, $usernameCheckQuery);

    //Matching username in database
    $matchingUsername= mysqli_fetch_assoc($usernameCheckResults);

    if($matchingUsername){
        if($matchingUsername['username'] === $userName){
            array_push($errors, "*Username already exists");
        }
    }

    //Add admin if no error
    if(count($errors) == 0){

        //Encrypt the password
        $encryptedpassword = md5($password);

        $query = "INSERT INTO admin(`first_name`, `last_name`, `gender`, `dob`, `username` , `password`) VALUES ('$firstName','$lastName','$gender','$dob','$userName','$encryptedpassword')"; 
        
        //Passing query
        mysqli_query($dataBase, $query);

        echo '<script>alert("Successfully added");</script>';
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/addAdmin.css">
</head>
<body>
<section>

<div class="register_section">
    <div class="register_form_content">
        <h2>Add admin</h2>
        <form action="addAdmin.php" method="POST">
        <?php include('../includes/errors.php') ?>
            <div class="register_input">
                <span>First name</span> <br>
                <input type="text" id="firstName" name="firstName" required>
            </div>

            <div class="register_input">
                <span>Last name</span> <br>
                <input type="text" id="lastName" name="lastName" required>
            </div>

            <div class="register_input">
                <span>Gender</span> <br>
                <select name="gender" id="gender" required>
                    <option value="">Select</option>
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                </select>
            </div>

            <div class="register_input">
                    <span>Date of birth</span> <br>
                    <input type="date" id="dob" name="dob" required>
            </div>

            <div class="register_input">
                    <span>User Name</span> <br>
                    <input type="text" id="adminUsername" name="username" required>
            </div>

            <div class="register_input">
                    <span>Password</span> <br>
                    <input type="password" id="password" name="password" required>
            </div>

            <div class="register_input">
                    <input type="submit" id="add" name="add" value="Add">
            </div>
        </form>
    </div>
</div>

</section>
    
</body>
</html>