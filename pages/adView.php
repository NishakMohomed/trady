<?php

session_start();

if(!$_SESSION['login']){
    header("location: login.php");
}

    //Connecting to database
    $dataBase = mysqli_connect('localhost', 'root', '','trady');

    $adId = $_GET['adId'];

    $adQuery = "SELECT * FROM advertisements WHERE ad_id = '$adId'";

    $adQueryResult = mysqli_query($dataBase, $adQuery);

    $row = mysqli_fetch_assoc($adQueryResult);

    $adOwnerId = $row['customer_id'];

    //Query advertisement owner details
    $adOwnerQuery = "SELECT * FROM customer WHERE customer_id = $adOwnerId";
    $adOwnerResult = mysqli_query($dataBase, $adOwnerQuery);
    $adOwnerRow = mysqli_fetch_assoc($adOwnerResult);

    //Advertisement details
    $advertisementId = $row['ad_id'];
    $adTitle = $row['title'];
    $adCategory = $row['category'];
    $adDescription = $row['description'];
    $adCity = $row['city'];
    $adDistrict = $row['district'];
    $adImage = $row['ad_img'];
    $adownerFirstName = $adOwnerRow['first_name'];
    $adownerLastName = $adOwnerRow['last_name'];

    //Rating details
    $ratingQuery = "SELECT * FROM ratings WHERE ad_id = '$advertisementId'";
    $ratingQueryResult = mysqli_query($dataBase, $ratingQuery);
    $totalRaters = mysqli_num_rows($ratingQueryResult);
    $totalStarCount = 0;
    $ratingAverage = 0.0;

    if($totalRaters > 0){

        while($ratingRow = mysqli_fetch_array($ratingQueryResult)){

            $rating = intval($ratingRow['rating']);
            $totalStarCount += $rating;
        }
    
        $ratingAverage = floatval($totalStarCount / $totalRaters);

    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/adView.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <title>Hire Now</title>
</head>
<body>

    <div class="adview_section">
        <div class="container">
            <div class="imgBx">
                <?php echo "<img src='../uploads/".$adImage."'>" ?>
            </div>

            <div class="details">
                <div class="content">
                        <h2><?php echo $adTitle?> <br> <span style = "color:#000"><?php echo "$adownerFirstName $adownerLastName"; ?>
                        (<i class='bx bxs-star' style = "color:#fd4"></i> <?php echo "$totalStarCount"?>) <?php echo number_format((float)$ratingAverage, 2, '.', ''); ?> %</span> <br>
                        <span><?php echo "$adCategory in $adCity , $adDistrict"; ?></span>
                    </h2>

                    <p>
                        <?php echo $adDescription?>
                    </p>

                    <button id="button">Send Details</button>
                    <button id="rate">Give Ratings</button>
                </div>
            </div>
        </div>
    </div>
<!-------------------------------------------------------------------------------------------------------->

    <div class="bg-modal">
        <div class="modal-content">
            <div class="close">+</div>
            <div class="update_section">
                <div class="update_form_content">
                    <h2>Please fill the details</h2>
                    <form action="../includes/hireData.php" method="POST">
                        <div class="update_input">
                            <span>Name</span> <br>
                            <input type="text" name="firstName" required>
                            <input type="hidden" name="adId" value="<?php echo $advertisementId ?>" required>
                        </div>
    
                        <div class="update_input">
                            <span>Phone number</span> <br>
                            <input type="text" name="telno" required>
                        </div>

                        <div class="update_input">
                            <span>Address</span> <br>
                            <input type="text" name="address" required>
                        </div>

                        <div class="update_input">
                            <span>Date</span> <br>
                            <input type="date" name="date" required>
                        </div>

                        <div class="update_input">
                            <span>Work details</span> <br>
                            <textarea name="details" id="description" cols="10" rows="2" required></textarea>
                        </div>
    
                        <div class="update_input">
                            <input type="submit" name="send" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('button').addEventListener('click', function(){
            document.querySelector('.bg-modal').style.display = 'flex';
        });

        document.querySelector('.close').addEventListener('click', function(){
            document.querySelector('.bg-modal').style.display = 'none';
        });
        
    </script>

<!-------------------------------------------------------------------------------------------------------->
<div class="container_widget">
    <div class="close2">+</div>
        <div class="rate_widget">
            <div class="post">
                <div class="text">Thanks for rating</div>
                <div class="edit">Edit</div>
            </div>
            <div class="star-widget">
                <form action="../includes/ratingData.php" method="post">
                    <input type="radio" name="rate" value="5" id="rate-5">
                    <label for="rate-5" class="bx bxs-star"></label>
                    <input type="radio" name="rate" value="4" id="rate-4">
                    <label for="rate-4" class="bx bxs-star"></label>
                    <input type="radio" name="rate" value="3" id="rate-3">
                    <label for="rate-3" class="bx bxs-star"></label>
                    <input type="radio" name="rate" value="2" id="rate-2">
                    <label for="rate-2" class="bx bxs-star"></label>
                    <input type="radio" name="rate" value="1" id="rate-1">
                    <label for="rate-1" class="bx bxs-star"></label>
            
                    <div class="bottom">
                        <header></header>
                        <!--<div class="textarea">
                            <textarea name="" id="" cols="30" placeholder="Describe your experience.."></textarea>
                        </div>-->
                        <input type="hidden" name="adId" value="<?php echo $advertisementId ?>" required>
                        <div class="btn">
                            <button type="submit" name="rateBtn">Post</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const btn = document.querySelector("button");
        const post = document.querySelector(".post");
        const widget = document.querySelector(".star-widget");
        const editBtn = document.querySelector(".edit");

        btn.onclick = ()=>{
            widget.style.display = "block";
            post.style.display = "none";
            editBtn.onclick = ()=>{
                widget.style.display = "block";
                post.style.display = "none";
            }
            return false;
        }

        document.getElementById('rate').addEventListener('click', function(){
            document.querySelector('.container_widget').style.display = 'flex';
        });

        document.querySelector('.close2').addEventListener('click', function(){
            document.querySelector('.container_widget').style.display = 'none';
        });
    </script>



<!--------------------------------------------Footer Section---------------------------------------------->
    
    <?php include('../includes/footer.php'); ?>

</body>
</html>