<?php

session_start();

$dataBase = mysqli_connect('localhost', 'root', '','trady');

 $Query="SELECT * FROM price";
 
 $result=mysqli_query($dataBase, $Query);

 $row = mysqli_fetch_array($result);

 //Initializing variables
$price ="";
$discount ="";


if(isset($_POST['update'])){
    $price = mysqli_real_escape_string($dataBase, $_POST['priceUpdate']);
    $discount = mysqli_real_escape_string($dataBase, $_POST['discountUpdate']);

    if(!empty($price)){
        $updateQuery = "UPDATE `price` SET `price`='$price' WHERE `price_id` = '1'";
          
        //Passing query
        mysqli_query($dataBase, $updateQuery);
    }

    if(!empty($discount)){
        $updateQuery = "UPDATE `price` SET `discount`='$discount' WHERE `price_id` = '1'";
          
        //Passing query
        mysqli_query($dataBase, $updateQuery);
    }

    header('location: ./adminDashboard.php');

}

?>


<style>
    <?php include('../css/changeDetails.css'); ?>
</style>

<section>

        <div class="update_section">
            <div class="update_form_content">
                <h2>Manage Price</h2>
                <form action="managePrice.php" method="POST">
                    <div class="update_input">
                        <span>Price</span> <br>
                        <input type="text" name="priceUpdate" placeholder="<?php echo $row['price'] ?>">
                    </div>

                    <div class="update_input">
                        <span>Discount</span> <br>
                        <input type="text" name="discountUpdate" placeholder="<?php echo $row['discount'] ?>">
                    </div>

                    <div class="update_input">
                        <input type="submit" name="update" value="Update">
                    </div>
                </form>
            </div>
        </div>
        
    </section>