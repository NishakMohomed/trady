<?php

session_start();

$dataBase = mysqli_connect('localhost', 'root', '','trady');
$username = $_SESSION['adminUsername'];

$Query="SELECT * FROM admin WHERE username = '$username'";
 
$result=mysqli_query($dataBase, $Query);

$row = mysqli_fetch_array($result);

 //Initializing variables
$oldPassword="";
$newPassword1="";
$newPassword2="";
$errors=array();

if(isset($_POST['update'])){
    $oldPassword= mysqli_real_escape_string($dataBase, $_POST['passwordUpdateOld']);
    $newPassword1= mysqli_real_escape_string($dataBase, $_POST['passwordUpdateNew']);
    $newPassword2= mysqli_real_escape_string($dataBase, $_POST['passwordUpdateReEnter']);

    $encryptedOldPassword = md5($oldPassword);

    if(empty($oldPassword)){array_push($errors, "*Old password is required!");}
    elseif(empty($newPassword1)){array_push($errors, "*New password is required!");}
    elseif(empty($newPassword2)){array_push($errors, "*Please confirm new password!");}
    elseif ($encryptedOldPassword != $row['password']){array_push($errors, "*Your old password is wrong!");}
    elseif ($newPassword1 != $newPassword2){array_push($errors, "*The new password doesn't match!");}
    elseif (strlen($newPassword1) <= '8'){array_push($errors, "*Your new Password Must Contain At Least 8 Characters!");}
    elseif(!preg_match("#[0-9]+#",$newPassword1)){array_push($errors, "*Your new Password Must Contain At Least 1 Number!");}

    if(count($errors) == 0){

                $encryptedNewPassword = md5($newPassword1);

                $updateQuery = "UPDATE admin SET password = '$encryptedNewPassword' WHERE username = '$username'";
          
                //Passing query
                mysqli_query($dataBase, $updateQuery);

                $_SESSION['adminUsername'] = "";
                $_SESSION['adminLogin'] = false;
                session_destroy();
                echo '<script>alert("Password successfully changed");</script>';
                header('location: ../admin/adminLogin.php');
            }
    }

?>


<style>
    <?php include('../css/changePassword.css'); ?>
</style>

<section>

        <div class="update_section">
            <div class="update_form_content">
                <h2>Change password</h2>
                <form action="changeAdminPassword.php" method="POST">
                <?php include('../includes/errors.php') ?>
                    <div class="update_input">
                        <span>Old Password</span> <br>
                        <input type="password" name="passwordUpdateOld">
                    </div>

                    <div class="update_input">
                        <span>New Password</span> <br>
                        <input type="password" name="passwordUpdateNew">
                    </div>

                    <div class="update_input">
                        <span>Re Enter New Password</span> <br>
                        <input type="password" name="passwordUpdateReEnter">
                    </div>

                    <div class="update_input">
                        <input type="submit" name="update" value="Change">
                    </div>
                </form>
            </div>
        </div>
        
    </section>