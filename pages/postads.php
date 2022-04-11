<?php

session_start();

if(!$_SESSION['login']){
    header("location: login.php");
}

//Initializing image variable
$adimgName = "";
$adimgSize = "";
$adimgTempName = "";
$adimgExtention = "";
$adimgNewName= "";
$adimgUploadPath = "";
$adimgError = "";

//Initializing variables
$adTitle = "";
$adCategory = "";
$adCity = "";
$adDistrict = "";
$adDescription = "";
$adTelno = "";
$customerId = "";
$customerEmail = "";
$errors=array();

//Connecting to database
$dataBase= mysqli_connect('localhost', 'root', '','trady');

//Post advertisements
if(isset($_POST['postad'])){

    //Image
    $adimgName = $_FILES['adimg']['name'];
    $adimgSize = $_FILES['adimg']['size'];
    $adimgTempName = $_FILES['adimg']['tmp_name'];
    $adimgExtention = pathinfo($adimgName, PATHINFO_EXTENSION);
    $adimgExtentionLc = strtolower($adimgExtention);
    $allowedExtention = array("jpg", "jpeg", "png");
    $adimgError = $_FILES['adimg']['error'];

    //Image error
    if(!$adimgError === 0){array_push($errors, "*Please reupload the image");}
    if($adimgSize > 125000000){array_push($errors, "*Sorry your image size is too large");}
    if(!in_array($adimgExtentionLc, $allowedExtention)){array_push($errors, "*You can't upload file of this type");}

    //Finding district
    $districtId = mysqli_real_escape_string($dataBase, $_POST['district']);
    $districtQuery = "SELECT * FROM districts WHERE district_id = '$districtId'";
    $districtResult = mysqli_query($dataBase, $districtQuery);
    $districtRow = mysqli_fetch_assoc($districtResult);

    //Finding city
    $cityId = mysqli_real_escape_string($dataBase, $_POST['city']);
    $cityQuery = "SELECT * FROM cities WHERE city_id = '$cityId'";
    $cityResult = mysqli_query($dataBase, $cityQuery);
    $cityRow = mysqli_fetch_assoc($cityResult);

    $adTitle = mysqli_real_escape_string($dataBase, $_POST['title']);
    $adCategory = mysqli_real_escape_string($dataBase, $_POST['category']);
    $adCity = $cityRow['city_name'];
    $adDistrict = $districtRow['district_name'];
    $adDescription = mysqli_real_escape_string($dataBase, $_POST['description']);
    $adTelno = mysqli_real_escape_string($dataBase, $_POST['phoneno']);
    

    //Form validation
    if(empty($adTitle)){array_push($errors, "*Title is required");}
    if(strlen($adTitle) > 62){array_push($errors, "*Maximum character limit for a title is 10");}
    if(empty($adCategory)){array_push($errors, "*Category is required");}
    if(empty($adCity)){array_push($errors, "*City is required");}
    if(empty($adDistrict)){array_push($errors, "*District is required");}
    if(empty($adDescription)){array_push($errors, "*Description is required");}
    if(strlen($adDescription) > 415){array_push($errors, "*Maximum character limit for a description is 415");}
    if(empty($adTelno)){array_push($errors, "*Phone number is required");}
    if(strlen($adTelno) != 10){array_push($errors, "*Phone number is invalid");}

    //Post advertisements if no errors
    if(count($errors) == 0){

        //Image
        $adimgNewName = uniqid("IMG-", true).'.'.$adimgExtentionLc;
        $adimgUploadPath = '../uploads/'.$adimgNewName;
        move_uploaded_file($adimgTempName, $adimgUploadPath);

        //finding the customer id
        $customerEmail = $_SESSION['email'];
        $idQuery = "SELECT customer_id FROM customer WHERE email = '$customerEmail'";

        //Passing id finding query
        $idQueryResult = mysqli_query($dataBase, $idQuery);

        $rowId = mysqli_fetch_assoc($idQueryResult);
        $customerId = $rowId['customer_id'];


        //Session variables
        $_SESSION['adTitle'] = $adTitle;
        $_SESSION['adCategory'] = $adCategory;
        $_SESSION['adCity'] = $adCity;
        $_SESSION['adDistrict'] = $adDistrict;
        $_SESSION['adDescription'] = $adDescription;
        $_SESSION['adTelno'] = $adTelno;
        $_SESSION['adimgNewName'] = $adimgNewName;
        $_SESSION['customerId'] = $customerId;


        $_SESSION['adData-available'] = true;
        header('location: checkout.php');
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
    <link rel="stylesheet" href="../css/postads.css">
    <title>Post Advertisement</title>
</head>
<body>

<!---------------------------------Navigation bar-------------------------------------------------------->

   <?php include('../includes/navbar_1.php'); ?>

<!------------------------------------------------------------------------------------------------------->
   <!-- <div id="spacer">
        &nbsp;
    </div>-->
<!------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------->
    <section>

        <div class="postad_section">
            <div class="postad_form_content">
                <h2>Post Advertisement</h2>
                <form action="postads.php" method="POST" enctype="multipart/form-data">
                <?php include('../includes/errors.php') ?>
                    <div class="postad_input">
                        <span>Job Title</span> <br>
                        <input type="text" name="title" required>
                    </div>

                    <div class="postad_input">
                        <span>Category</span> <br>
                            <select name="category" id="" required>
                                <option value="">Select</option>
                                <option value="Electrician">Electrician</option>
                                <option value="Plumber">Plumber</option>
                                <option value="Painter">Painter</option>
                                <option value="Carpenter">Carpenter</option>
                                <option value="Welder">Welder</option>
                                <option value="Mason">Mason</option>
                                <option value="Landscaper">Landscaper</option>
                                <option value="Kitchenfitter">Kitchen fitter</option>
                                <option value="Elevatormechanic">Elevator mechanic</option>
                                <option value="Acmechanic">AC Mechanic</option>
                                <option value="Roofer">Roofer</option>
                                <option value="Saddler">Saddler</option>
                            </select>
                    </div>

                    <div class="postad_input">
                        <span>District</span> <br>
                        <select name="district" id="district" required>
                                            <option value="">Select</option>
                                            <option value="1">Ampara</option>
                                            <option value="2">Anuradhapura</option>
                                            <option value="3">Badulla</option>
                                            <option value="4">Batticaloa</option>
                                            <option value="5">Colombo</option>
                                            <option value="6">Galle</option>
                                            <option value="7">Gampaha</option>
                                            <option value="8">Hambantota</option>
                                            <option value="9">Jaffna</option>
                                            <option value="10">Kalutara</option>
                                            <option value="11">Kandy</option>
                                            <option value="12">Kegalle</option>
                                            <option value="13">Kilinochchi</option>
                                            <option value="14">Kurunegala</option>
                                            <option value="15">Mannar</option>
                                            <option value="16">Matale</option>
                                            <option value="17">Matara</option>
                                            <option value="18">Monaragala</option>
                                            <option value="19">Mullaitivu</option>
                                            <option value="20">Nuwara Eliya</option>
                                            <option value="21">Polonnaruwa</option>
                                            <option value="22">Puttalam</option>
                                            <option value="23">Ratnapura</option>
                                            <option value="24">Trincomalee</option>
                                            <option value="25">Vavuniya</option>
                                        </select>
                    </div>

                    <div class="postad_input">
                        <span>City</span> <br>
                        <select name="city" id="city" required>
                        <option value="">Select</option>
                        </select>
                    </div>

                    <div class="postad_input">
                        <span>Image</span> <br>
                        <input type="file" name="adimg" required>
                    </div>

                    <div class="postad_input">
                        <span>Description</span> <br>
                        <textarea name="description" id="description" cols="10" rows="8" required></textarea>
                    </div>

                    <div class="postad_input">
                        <span>Phone Number</span> <br>
                        <input type="tel" name="phoneno" required>
                    </div>

                    <div class="postad_input">
                        <input type="submit" name="postad" value="Proceed">
                    </div>
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <script>
            $(document).ready(function(){
                $("#district").on("change", function(){
                    var districtId = $("#district").val();
                    var getURL = "../includes/get-city.php?district_id=" + districtId;
                    $.get(getURL, function(data, status){
                        $("#city").html(data);
                    });
                });
            });
        </script>
        
    </section>

<!-------------------------------------------Footer Section---------------------------------------------->
    
    <?php include('../includes/footer.php'); ?>
    
</body>
</html>