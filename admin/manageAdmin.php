<?php
session_start();

if(!$_SESSION['adminLogin']){
    header("location: adminLogin.php");
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
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>User Name</th>
                </tr>
            </thead>
            <tbody>

            <?php

            //Database connection
            $dataBase = mysqli_connect('localhost', 'root', '','trady');

            $Query="SELECT * FROM admin ORDER BY admin_id ASC";

            $result=mysqli_query($dataBase, $Query);

            //Customer 

            while( $row = mysqli_fetch_array($result)){

                $adminId = $row['admin_id'];
                $firstName = $row['first_name'];
                $lastName = $row['last_name'];
                $gender = $row['gender'];
                $dob = $row['dob'];
                $userName = $row['username'];

                echo '<tr><form>
                <td>'.$firstName.'</td>
                <td>'.$lastName.'</td>
                <td>'.$gender.'</td>
                <td>'.$dob.'</td>
                <td>'.$userName.'</td>
                </form>
                </tr>';
            }

            ?>
            </tbody>
        </table>
    </div>
</body>
</html>