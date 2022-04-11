<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/allAds.css">
    <title>All Ads</title>
</head>
<body>

<!---------------------------------Navigation bar-------------------------------------------------------->

    <?php include('../includes/navbar_1.php'); ?>

<!---------------------------------All ads--------------------------------------------------------------->

    <section class="section all-ads" id="all-ads">


    <?php

    //Connecting to database
    $dataBase = mysqli_connect('localhost', 'root', '','trady');

    $query = "SELECT * FROM advertisements";

    $result = mysqli_query($dataBase, $query);

    $rowCount = mysqli_num_rows($result);

    if($rowCount == 0){

        echo '<div class="no_result"> 
                        <div class="wrapper" >
                                <h2>Oops! Results not found.</h2>
                                <div>
                                    <img src="../images/404.svg" alt="404">
                                </div>
                                <h4>We can\'t find the results you\'re looking for.</h4>
                        </div>
                  </div>';
    }else{

        echo '<div class="ads_header">

                    <div class="ads_result_input">
                            <select name="category" id="categoryFilter">
                                <option value="All">Category</option>
                                <option value="All">All</option>
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

                    <div class="ads_result_input">
                        
                            <select name="district" id="districtFilter">
                                <option value="All">District</option>
                                <option value="All">All</option>
                                <option value="Ampara">Ampara</option>
                                <option value="Anuradhapura">Anuradhapura</option>
                                <option value="Badulla">Badulla</option>
                                <option value="Batticaloa">Batticaloa</option>
                                <option value="Colombo">Colombo</option>
                                <option value="Galle">Galle</option>
                                <option value="Gampaha">Gampaha</option>
                                <option value="Hambantota">Hambantota</option>
                                <option value="Jaffna">Jaffna</option>
                                <option value="Kalutara">Kalutara</option>
                                <option value="Kandy">Kandy</option>
                                <option value="Kegalle">Kegalle</option>
                                <option value="Kilinochchi">Kilinochchi</option>
                                <option value="Kurunegala">Kurunegala</option>
                                <option value="Mannar">Mannar</option>
                                <option value="Matale">Matale</option>
                                <option value="Matara">Matara</option>
                                <option value="Monaragala">Monaragala</option>
                                <option value="Mullaitivu">Mullaitivu</option>
                                <option value="Nuwara">Nuwara Eliya</option>
                                <option value="Polonnaruwa">Polonnaruwa</option>
                                <option value="Puttalam">Puttalam</option>
                                <option value="Ratnapura">Ratnapura</option>
                                <option value="Trincomalee">Trincomalee</option>
                                <option value="Vavuniya">Vavuniya</option>
                            </select>
                    </div>
            </div>';

        echo '<div class="ads-center ad-content">';


        while($row = mysqli_fetch_assoc($result)){

            $adOwnerId = $row['customer_id'];
        
            //Advertisement owner
            $adOwnerQuery = "SELECT * FROM customer WHERE customer_id = '$adOwnerId'";
            $adOwnerResult = mysqli_query($dataBase, $adOwnerQuery);
            $adOwnerRow = mysqli_fetch_assoc($adOwnerResult);
                
            $adId = $row['ad_id'];
            $adTitle = $row['title'];
            $adCategory = $row['category'];
            $adCity = $row['city'];
            $adDistrict = $row['district'];
            $adImage = $row['ad_img'];
            $adownerFirstName = $adOwnerRow['first_name'];
            $adownerLastName = $adOwnerRow['last_name'];

            //Advertisement rating
            $ratingCount = 0;
            $adRatingQuery = "SELECT * FROM ratings WHERE ad_id = '$adId'";
            $adRatingResult = mysqli_query($dataBase, $adRatingQuery);
            $ratingRowCount = mysqli_num_rows($adRatingResult);


            if($ratingRowCount > 0){

                while( $adRatingRow = mysqli_fetch_assoc($adRatingResult)){

                    $ratingCount += (int)$adRatingRow['rating'];
                }
                
            }
            else{

                $ratingCount = 0;
            }

            //Display the result
            echo '<a href="../pages/adView.php?adId='.$adId.'" class="ad-link '.$adDistrict.' '.$adCategory.'"><div class="ads">
                        <div class="ads-image">
                            <img src="../uploads/'.$adImage.'" alt="">
                        </div>

                        <div class="ads-footer">
                            <h3>'.$adCategory.'</h3>
                            <h4>'.$adownerFirstName.' '.$adownerLastName.'</h4>
                            <h4>'.$adCity.', '.$adDistrict.'</h4>

                            <div class="rating">
                                <span><i class="bx bxs-star"></i> '.$ratingCount.'</span>
                            </div>
                        </div>
                </div></a>';
        }

        echo '</div>';

    }

    ?>
</section>

<script>
        //District filter
        $(document).ready(function(){
            $("#districtFilter").on('change', function(){

                $(".ad-link").hide();

                var value = $(this).val();

                if(value == "All"){
                    $(".ad-link").show();
                }else{
                    $("." + $(this).val()).fadeIn(200);
                }
            }).change();
        });


        //Category filetr
        $(document).ready(function(){
            $("#categoryFilter").on('change', function(){

                $(".ad-link").hide();

                var value = $(this).val();

                if(value == "All"){
                    $(".ad-link").show();
                }else{
                    $("." + $(this).val()).fadeIn(200);
                }
            }).change();
        });
    </script>

<!--------------------------------------------Footer Section-------------------------------------------->

    <?php include('../includes/footer.php'); ?>

</body>
</html>