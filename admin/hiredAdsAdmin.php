<?php

session_start();

if(!$_SESSION['adminLogin']){
    header("location: adminLogin.php");
}


//Database connection
$dataBase = mysqli_connect('localhost', 'root', '','trady');


//Delete customer account
if(isset($_POST['deleteAd'])){
    $hire_id = mysqli_real_escape_string($dataBase, $_POST['deleteId']);

    $query = "DELETE FROM hire_ads WHERE hire_id = '$hire_id'";
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
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Work Details</th>
                    <th>Date</th>
                    <th>Customer ID</th>
                    <th>Advertisement ID</th>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>

            <?php

            //Database connection
            $dataBase = mysqli_connect('localhost', 'root', '','trady');

            $Query="SELECT * FROM hire_ads ORDER BY hire_id ASC";

            $result=mysqli_query($dataBase, $Query);

            //Advertisement 
            while( $row = mysqli_fetch_array($result)){

                $hireId = $row['hire_id'];
                $name = $row['name'];
                $phone = $row['tel_no'];
                $address = $row['address'];
                $details = $row['details'];
                $date = $row['date'];
                $customer_id = $row['customer_id'];
                $ad_id = $row['ad_id'];

                echo '<tr id="'.$hireId.'"><form>
                <td data-target="title">'.$name.'</td>
                <td data-target="category">'.$phone.'</td>
                <td data-target="city">'.$address.'</td>
                <td data-target="district">'.$details.'</td>
                <td data-target="description">'.$date.'</td>
                <td data-target="phone">'.$customer_id.'</td>
                <td data-target="adPostedBy">'.$ad_id.'</td>
                <td> <button onclick="deleteAccount()" data-role="delete" data-id="'.$hireId.'" ><i class="bx bxs-trash-alt"></i></button></td>
                </form>
                </tr>';
            }

            ?>
            </tbody>
        </table>
    </div>

     <!-------------------------------------------------------------------------------------------------->
     <div class="deleteConfirmation">
        <div class="modal-content">
            <div class="close2">+</div>
            <div class="update_section">
                <div class="update_form_content">
                    <h2>Delete</h2>
                    <form action="hiredAdsAdmin.php" method="POST">
                        <div class="update_input">
                            <span>Are you sure want to delete this data?</span> <br>
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



      <!-------------------------------------------------------------------------------------------------->

    <script>

        function deleteAccount(){
            document.querySelector('.deleteConfirmation').style.display = 'flex';
        }


        //Append value to input fields
        $(document).ready(function(){

                //Delete 
                $(document).on('click','button[data-role=delete]',function(){
                    var id = $(this).data('id');

                    $('#deleteId').val(id);

                });

            });


        document.querySelector('.close2').addEventListener('click', function(){
            document.querySelector('.deleteConfirmation').style.display = 'none';
        });
    </script>
</body>
</html>