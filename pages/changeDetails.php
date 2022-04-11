<?php

session_start();

$dataBase = mysqli_connect('localhost', 'root', '','trady');
$email = $_SESSION['email'];

 $Query="SELECT * FROM customer WHERE email = '$email'";
 
 $result=mysqli_query($dataBase, $Query);

 $row = mysqli_fetch_array($result);

 //Initializing variables
$firstName="";
$lastName="";
$dateOfBirth="";
$gender="";

if(isset($_POST['update'])){
    $firstName= mysqli_real_escape_string($dataBase, $_POST['firstNameUpdate']);
    $lastName= mysqli_real_escape_string($dataBase, $_POST['lastNameUpdate']);
    $dateOfBirth= mysqli_real_escape_string($dataBase, $_POST['dobUpdate']);
    $gender= mysqli_real_escape_string($dataBase, $_POST['genderUpdate']);

    if(!empty($firstName)){
        $updateQuery = "UPDATE customer SET first_name = '$firstName' WHERE email = '$email'";
          
        //Passing query
        mysqli_query($dataBase, $updateQuery);
    }

    if(!empty($lastName)){
        $updateQuery = "UPDATE customer SET last_name = '$lastName' WHERE email = '$email'";
          
        //Passing query
        mysqli_query($dataBase, $updateQuery);
    }

    if(!empty($dateOfBirth)){
        $updateQuery = "UPDATE customer SET dob = '$dateOfBirth' WHERE email = '$email'";
          
        //Passing query
        mysqli_query($dataBase, $updateQuery);
    }

    if(!empty($gender)){
        $updateQuery = "UPDATE customer SET gender = '$gender' WHERE email = '$email'";
          
        //Passing query
        mysqli_query($dataBase, $updateQuery);
    }

    header('location: ./dashboard.php');

}

?>


<style>
    <?php include('../css/changeDetails.css'); ?>
</style>

<section>

        <div class="update_section">
            <div class="update_form_content">
                <h2>Account details</h2>
                <form action="changeDetails.php" method="POST">
                    <div class="update_input">
                        <span>First Name</span> <br>
                        <input type="text" name="firstNameUpdate" placeholder="<?php echo $row['first_name'] ?>">
                    </div>

                    <div class="update_input">
                        <span>Last Name</span> <br>
                        <input type="text" name="lastNameUpdate" placeholder="<?php echo $row['last_name'] ?>">
                    </div>

                    <div class="update_input">
                        <span>Date of birth</span> <br>
                        <input type="text" name="dobUpdate" placeholder="<?php echo $row['dob'] ?>" onfocus="(this.type='date')">
                    </div>

                    <div class="update_input">
                        <span>Gender</span> <br>
                            <select name="genderUpdate" id="">
                                <option value="">Select</option>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                    </div>

                    <div class="update_input">
                        <input type="submit" name="update" value="Update">
                    </div>
                </form>
            </div>
        </div>
        
    </section>