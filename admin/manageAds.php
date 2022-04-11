<?php

session_start();

if(!$_SESSION['adminLogin']){
    header("location: adminLogin.php");
}


//Database connection
$dataBase = mysqli_connect('localhost', 'root', '','trady');

//Initialize variables
$adId = "";
$title = "";
$category = "";
$city = "";
$district = "";
$description = "";
$phone = "";
$status = "";
$errors=array();

//Change the details of the customer
if(isset($_POST['save'])){

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

    //Data
    $adId = mysqli_real_escape_string($dataBase, $_POST['id']);
    $title = mysqli_real_escape_string($dataBase, $_POST['title']);
    $category = mysqli_real_escape_string($dataBase, $_POST['category']);
    $city = $cityRow['city_name'];
    $district = $districtRow['district_name'];
    $description = mysqli_real_escape_string($dataBase, $_POST['description']);
    $phone = mysqli_real_escape_string($dataBase, $_POST['telno']);
    $status = mysqli_real_escape_string($dataBase, $_POST['status']);

    //Form validation
    if(empty($title)){array_push($errors, "*Title is required");}
    if(empty($category)){array_push($errors, "*Category is required");}
    if(empty($city)){array_push($errors, "*City is required");}
    if(empty($district)){array_push($errors, "*District is required");}
    if(empty($description)){array_push($errors, "*Description is required");}
    if(empty($phone)){array_push($errors, "*Phone number is required");}
    if(empty($status)){array_push($errors, "*Status is required");}

     //Update advertisements if no errors
     if(count($errors) == 0){

        $query = "UPDATE advertisements SET `title` = '$title' , `category` = '$category' , `city` = '$city' , `district` = '$district' , `description` = '$description' , `tel_no` = '$phone' , `status` = '$status' WHERE `ad_id` = '$adId'";

        mysqli_query($dataBase, $query);
        echo '<script>alert("Successfully updated");</script>';

    }else{

        echo '<script>alert("Error! please check the details again");</script>';
    }

}


//Delete customer account
if(isset($_POST['deleteAd'])){
    $ad_id = mysqli_real_escape_string($dataBase, $_POST['deleteId']);

    $query = "DELETE FROM advertisements WHERE ad_id = '$ad_id'";
    mysqli_query($dataBase, $query);

    echo '<script>alert("Successfully deleted");</script>';
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
    <link rel="stylesheet" href="../css/manageAds.css">
</head>
<body>
    <div class="container">
        <table class="content-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>City</th>
                    <th>District</th>
                    <th>Description</th>
                    <th>Phone number</th>
                    <th>Posted by</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php

            //Database connection
            $dataBase = mysqli_connect('localhost', 'root', '','trady');

            $Query="SELECT * FROM advertisements ORDER BY ad_id ASC";

            $result=mysqli_query($dataBase, $Query);

            //Advertisement 

            while( $row = mysqli_fetch_array($result)){

                $adId = $row['ad_id'];
                $title = $row['title'];
                $category = $row['category'];
                $city = $row['city'];
                $district = $row['district'];
                $description = $row['description'];
                $phone = $row['tel_no'];
                $image = $row['ad_img'];
                $status = $row['status'];
                $adpostedId = $row['customer_id'];

                $customerQuery = "SELECT first_name, last_name FROM customer WHERE customer_id = '$adpostedId'";

                $customerQueryresult=mysqli_query($dataBase, $customerQuery);

                $customerName = mysqli_fetch_array($customerQueryresult);

                $adPostedBy = $customerName['first_name'];

                echo '<tr id="'.$adId.'"><form>
                <td data-target="title">'.$title.'</td>
                <td data-target="category">'.$category.'</td>
                <td data-target="city">'.$city.'</td>
                <td data-target="district">'.$district.'</td>
                <td data-target="description">'.$description.'</td>
                <td data-target="phone">'.$phone.'</td>
                <td data-target="adPostedBy">'.$adPostedBy.'</td>
                <td data-target="status">'.$status.'</td>
                <td><button data-role="update" data-id="'.$adId.'" onclick="edit()"><i class="bx bxs-pencil" ></i></button> <button onclick="deleteAccount()" data-role="delete" data-id="'.$adId.'" ><i class="bx bxs-trash-alt"></i></button></td>
                </form>
                </tr>';
            }

            ?>
            </tbody>
        </table>
    </div>

    <!-------------------------------------------------------------------------------------------------->

    <div class="bg-modal">
        <div class="modal-content">
            <div class="close">+</div>
            <div class="update_section">
                <div class="update_form_content">
                    <h2>Change details</h2>
                    <form method="POST" action="manageAds.php">
                        <div class="update_input">
                            <span>Title</span> <br>
                            <input type="text" id="adTitle" name="title">
                        </div>
    
                        <div class="update_input">
                            <span>Category</span> <br>
                            <select name="category" id="adCategory">
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

                        <div class="update_input">
                            <span>District</span> <br>
                            <select name="district" id="district">
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

                        <div class="update_input">
                            <span>City</span> <br>
                            <select name="city" id="city">
                            <option value="">Select</option>
                            </select>
                        </div>

                        <div class="update_input">
                            <span>Description</span> <br>
                            <textarea name="description" id="adDescription" cols="10" rows="2"></textarea>
                        </div>

                        <div class="update_input">
                            <span>Phone Number</span> <br>
                            <input type="text" id="telno" name="telno">
                        </div>

                        <div class="update_input">
                            <span>Status</span> <br>
                            <select name="status" id="status">
                                <option value="">Select</option>
                                <option value="active">Active</option>
                                <option value="off">Off</option>
                            </select>
                        </div>

                        <input type="hidden" id="adId" name="id">
    
                        <div class="update_input">
                            <input type="submit" id="save" name="save" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

     <!-------------------------------------------------------------------------------------------------->
     <div class="deleteConfirmation">
        <div class="modal-content">
            <div class="close2">+</div>
            <div class="update_section">
                <div class="update_form_content">
                    <h2>Delete</h2>
                    <form action="manageAds.php" method="POST">
                        <div class="update_input">
                            <span>Are you sure want to delete this advertisement?</span> <br>
                        </div>

                        <div class="update_input">
                            <input type="hidden" id="deleteId" name="deleteId">
                        </div>
    
                        <div class="update_input">
                            <input type="submit" name="deleteAd" value="Yes">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-------------------------------------------------------------------------------------------------------------------------------------------->

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


<!---------------------------------------------------------------------------------------------------------------------------------------------->

    <script>

        function edit(){
            document.querySelector('.bg-modal').style.display = 'flex';
        }

        function deleteAccount(){
            document.querySelector('.deleteConfirmation').style.display = 'flex';
        }


        //Append value to input fields
        $(document).ready(function(){
                $(document).on('click','button[data-role=update]',function(){
                    var id = $(this).data('id');
                    var title = $('#'+id).children('td[data-target=title]').text();
                    var category = $('#'+id).children('td[data-target=category]').text();
                    //var city = $('#'+id).children('td[data-target=city]').text();
                    //var district = $('#'+id).children('td[data-target=district]').text();
                    var description = $('#'+id).children('td[data-target=description]').text();
                    var phone = $('#'+id).children('td[data-target=phone]').text();
                    var adPostedBy = $('#'+id).children('td[data-target=adPostedBy]').text();
                    var status = $('#'+id).children('td[data-target=status]').text();


                    $('#adId').val(id);
                    $('#adTitle').val(title);
                    $('#adCategory').val(category);
                    //$('#adcity').val(city);
                    //$('#adDistrict').val(district);
                    $('#adDescription').val(description);
                    $('#telno').val(phone); 
                    $('#adPostedBy').val(adPostedBy);
                    $('#status').val(status);
                });

                //Delete 
                $(document).on('click','button[data-role=delete]',function(){
                    var id = $(this).data('id');

                    $('#deleteId').val(id);

                });



               /* $('#save').click(function(){
                    var id = $('#customerId').val();
                    var firstName = $('#firstName').val();
                    var lastName = $('#lastName').val();
                    var dob = $('#dob').val();
                    var gender = $('#gender').val();
                    var customerEmail = $('#customerEmail').val();

                    $.ajax({
                        url: 'adminServer.php',
                        method: 'post',
                        data: {firstName : firstName , lastName : lastName , dob : dob , gender : gender , customerEmail : customerEmail , id : id},
                        success : function(response){
                            $('#'+id).children('td[data-target=firstName]').text(firstName);
                            $('#'+id).children('td[data-target=lastName]').text(lastName);
                            $('#'+id).children('td[data-target=dob]').text(dob);
                            $('#'+id).children('td[data-target=gender]').text(gender);
                            $('#'+id).children('td[data-target=customerEmail]').text(customerEmail);
                        }
                    });
                });*/
            });


        document.querySelector('.close').addEventListener('click', function(){
            document.querySelector('.bg-modal').style.display = 'none';
        });

        document.querySelector('.close2').addEventListener('click', function(){
            document.querySelector('.deleteConfirmation').style.display = 'none';
        });
    </script>
</body>
</html>