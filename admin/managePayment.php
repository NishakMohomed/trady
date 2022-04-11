<?php

session_start();

if(!$_SESSION['adminLogin']){
    header("location: adminLogin.php");
}


//Database connection
$dataBase = mysqli_connect('localhost', 'root', '','trady');


//Delete payment record
if(isset($_POST['deleteRecord'])){
    $payment_id = mysqli_real_escape_string($dataBase, $_POST['deleteId']);

    $query = "DELETE FROM payment WHERE payment_id = '$payment_id'";
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
    <link rel="stylesheet" href="../css/managePayment.css">
</head>
<body>
    <div class="container">
        <table class="content-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Email</th>
                    <th>Customer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php

            //Database connection
            $dataBase = mysqli_connect('localhost', 'root', '','trady');

            $Query="SELECT * FROM payment ORDER BY payment_id ASC";

            $result=mysqli_query($dataBase, $Query);

            //Advertisement 

            while( $row = mysqli_fetch_array($result)){

                $paymentId = $row['payment_id'];
                $amount = $row['amount'];
                $date = $row['date'];
                $email = $row['email'];

                $paymentById = $row['customer_id'];

                $customerQuery = "SELECT first_name, last_name FROM customer WHERE customer_id = '$paymentById'";

                $customerQueryresult=mysqli_query($dataBase, $customerQuery);

                if($customerName = mysqli_fetch_array($customerQueryresult)){

                    $paymentBy = $customerName['first_name']." ".$customerName['last_name'];

                    echo '<tr id="'.$paymentId.'"><form>
                    <td data-target="title">'.$paymentId.'</td>
                    <td data-target="category">$ '.$amount.'</td>
                    <td data-target="city">'.$date.'</td>
                    <td data-target="district">'.$email.'</td>
                    <td data-target="adPostedBy">'.$paymentBy.'</td>
                    <td> <button onclick="deleteAccount()" data-role="delete" data-id="'.$paymentId.'" ><i class="bx bxs-trash-alt"></i></button></td>
                    </form>
                    </tr>';
                }
            }

            ?>
            </tbody>
        </table>
    </div>

<!-------------------------------------------------------------------------------------------------------------------------------------------->
    
     <div class="deleteConfirmation">
        <div class="modal-content">
            <div class="close2">+</div>
            <div class="update_section">
                <div class="update_form_content">
                    <h2>Delete</h2>
                    <form action="managePayment.php" method="POST">
                        <div class="update_input">
                            <span>Are you sure want to delete this payment record?</span> <br>
                        </div>

                        <div class="update_input">
                            <input type="hidden" id="deleteId" name="deleteId">
                        </div>
    
                        <div class="update_input">
                            <input type="submit" name="deleteRecord" value="Yes">
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