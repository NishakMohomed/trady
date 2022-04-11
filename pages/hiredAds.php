<?php

session_start();

if(!$_SESSION['login']){
    header("location: login.php");
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
    <link rel="stylesheet" href="../css/hiredAds.css">
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
                </tr>
            </thead>
            <tbody>

            <?php

            $customerEmail = $_SESSION['email'];

            //Database connection
            $dataBase = mysqli_connect('localhost', 'root', '','trady');

            //Finding customer id
            $customerIdQuery = "SELECT * FROM customer WHERE email = '$customerEmail'";
            $customerIdResult = mysqli_query($dataBase, $customerIdQuery);

            if($customerIdRow = mysqli_fetch_array($customerIdResult)){

                $customerId = $customerIdRow['customer_id'];

                //Search Hire_ads database
                $adHireQeuery="SELECT * FROM hire_ads WHERE customer_id = '$customerId' ORDER BY hire_id ASC";
                $adHireresult=mysqli_query($dataBase, $adHireQeuery);

                if($adHireRow = mysqli_fetch_array($adHireresult)){
                    
                    $advertisementId = $adHireRow['ad_id'];

                    //Advertisement find query
                    $adFindQuery = "SELECT * FROM advertisements WHERE ad_id = '$advertisementId' ORDER BY ad_id ASC";
                    $adFindresult = mysqli_query($dataBase, $adFindQuery);

                    //Advertisement 
                    while($row = mysqli_fetch_array($adFindresult)){

                        $title = $row['title'];
                        $category = $row['category'];
                        $city = $row['city'];
                        $district = $row['district'];
                        $description = $row['description'];
                        $phone = $row['tel_no'];


                        echo '<tr><form>
                        <td data-target="title">'.$title.'</td>
                        <td data-target="category">'.$category.'</td>
                        <td data-target="city">'.$city.'</td>
                        <td data-target="district">'.$district.'</td>
                        <td data-target="description">'.$description.'</td>
                        <td data-target="phone">'.$phone.'</td>
                        </form>
                        </tr>';
                    }

                }
            }

            ?>
            </tbody>
        </table>
    </div>

</body>
</html>