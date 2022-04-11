<?php

session_start();

if(!$_SESSION['adminLogin']){
    header("location: adminLogin.php");
}

//Database connection
$dataBase = mysqli_connect('localhost', 'root', '','trady');

//Change the details of the customer
if(isset($_POST['save'])){

    $firstName= mysqli_real_escape_string($dataBase, $_POST['firstName']);
    $lastName= mysqli_real_escape_string($dataBase, $_POST['lastName']);
    $dob= mysqli_real_escape_string($dataBase, $_POST['dob']);
    $gender= mysqli_real_escape_string($dataBase, $_POST['gender']);
    $email= mysqli_real_escape_string($dataBase, $_POST['email']);
    $customerId= mysqli_real_escape_string($dataBase, $_POST['id']);

    $query = "UPDATE customer SET `first_name` = '$firstName' , `last_name` = '$lastName' , `dob` = '$dob' , `gender` = '$gender' , `email` = '$email' WHERE `customer_id` = '$customerId'";

    mysqli_query($dataBase, $query);
    echo '<script>alert("Successfully updated");</script>';

}


//Delete customer account
if(isset($_POST['deleteAccount'])){
    $customer_id = mysqli_real_escape_string($dataBase, $_POST['deleteId']);

    $query = "DELETE FROM customer WHERE customer_id = '$customer_id'";
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
    <link rel="stylesheet" href="../css/manageCustomer.css">
</head>
<body>
    <div class="container">
        <table class="content-table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>DOB</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php

            //Database connection
            $dataBase = mysqli_connect('localhost', 'root', '','trady');

            $Query="SELECT * FROM customer ORDER BY customer_id ASC";

            $result=mysqli_query($dataBase, $Query);

            //Customer 

            while( $row = mysqli_fetch_array($result)){

                $customerId = $row['customer_id'];
                $firstName = $row['first_name'];
                $lastName = $row['last_name'];
                $dob = $row['dob'];
                $gender = $row['gender'];
                $customerEmail = $row['email'];

                echo '<tr id="'.$customerId.'"><form>
                <td data-target="firstName">'.$firstName.'</td>
                <td data-target="lastName">'.$lastName.'</td>
                <td data-target="dob">'.$dob.'</td>
                <td data-target="gender">'.$gender.'</td>
                <td data-target="customerEmail">'.$customerEmail.'</td>
                <td><button data-role="update" data-id="'.$customerId.'" onclick="edit()"><i class="bx bxs-pencil" ></i></button> <button onclick="deleteAccount()" data-role="delete" data-id="'.$customerId.'" ><i class="bx bxs-trash-alt"></i></button></td>
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
                    <form method="POST" action="manageCustomer.php">
                        <div class="update_input">
                            <span>First name</span> <br>
                            <input type="text" id="firstName" name="firstName">
                        </div>
    
                        <div class="update_input">
                            <span>Last name</span> <br>
                            <input type="text" id="lastName" name="lastName">
                        </div>

                        <div class="update_input">
                            <span>Date of birth</span> <br>
                            <input type="date" id="dob" name="dob">
                        </div>

                        <div class="update_input">
                            <span>Gender</span> <br>
                            <select name="gender" id="gender">
                                <option value="">Select</option>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </div>

                        <div class="update_input">
                            <span>Email</span> <br>
                            <input type="email" id="customerEmail" name="email">
                        </div>

                        <input type="hidden" id="customerId" name="id">
    
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
                    <form action="manageCustomer.php" method="POST">
                        <div class="update_input">
                            <span>Are you sure want to delete this account?</span> <br>
                        </div>

                        <div class="update_input">
                            <input type="hidden" id="deleteId" name="deleteId">
                        </div>
    
                        <div class="update_input">
                            <input type="submit" name="deleteAccount" value="Yes">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



      <!-------------------------------------------------------------------------------------------------->

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
                    var firstName = $('#'+id).children('td[data-target=firstName]').text();
                    var lastName = $('#'+id).children('td[data-target=lastName]').text();
                    var dob = $('#'+id).children('td[data-target=dob]').text();
                    var gender = $('#'+id).children('td[data-target=gender]').text();
                    var customerEmail = $('#'+id).children('td[data-target=customerEmail]').text();

                    $('#firstName').val(firstName);
                    $('#lastName').val(lastName);
                    $('#dob').val(dob);
                    $('#gender').val(gender);
                    $('#customerEmail').val(customerEmail);
                    $('#customerId').val(id);
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