<?php

session_start();

$dataBase = mysqli_connect('localhost', 'root', '','trady');
$email = $_SESSION['email'];

 $Query="SELECT * FROM customer WHERE email = '$email'";
 
 $result=mysqli_query($dataBase, $Query);

 $row = mysqli_fetch_array($result);

 //Initializing variables
$emailUpdate="";
$errors=array();

if(isset($_POST['update'])){
    $emailUpdate= mysqli_real_escape_string($dataBase, $_POST['emailUpdate']);

    if(empty($emailUpdate)){array_push($errors, "*Email is required");}
    if (!filter_var($emailUpdate, FILTER_VALIDATE_EMAIL)){array_push($errors, "*Invalid format and please re-enter valid email");}

    if(count($errors) == 0){
        $updateQuery = "UPDATE customer SET email = '$emailUpdate' WHERE email = '$email'";
          
        //Passing query
        mysqli_query($dataBase, $updateQuery);

        $_SESSION['email'] = "";
        $_SESSION['login'] = false;
        session_destroy();
        header('location: ../pages/login.php');
    }

}

?>


<style>
    <?php include('../css/changeEmail.css'); ?>
</style>

<section>

        <div class="update_section">
            <div class="update_form_content">
                <h2>Update email</h2>
                <form action="changeEmail.php" method="POST">
                <?php include('../includes/errors.php') ?>
                    <div class="update_input">
                        <span>Email</span> <br>
                        <input type="email" name="emailUpdate" placeholder="<?php echo $row['email'] ?>">
                    </div>

                    <div class="update_input">
                        <input type="submit" name="update" value="Update">
                    </div>
                </form>
            </div>
        </div>
        
    </section>