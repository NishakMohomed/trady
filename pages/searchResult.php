
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/searchResult.css">
    <title>Hire now</title>
</head>
<body>
    <!---------------------------------Navigation bar-------------------------------------------------------->

    <?php include('../includes/navbar_1.php'); ?>

    <!-------------------------------------------Search Results----------------------------------------------->
           
    <div class="container">

        
    <?php 

        //Connecting to database
        $dataBase = mysqli_connect('localhost', 'root', '','trady');
        
        $searchTerm = $_GET["search"];

        $searchQuery = "SELECT * FROM advertisements WHERE category LIKE '%".$searchTerm."%' AND status = 'active'";

        //$searchQuery = "SELECT * FROM advertisements WHERE MATCH (title,category) AGAINST ('$searchTerm') AND status = 'active'";
    
        $searchResult = mysqli_query($dataBase, $searchQuery);

        $rowCount = mysqli_num_rows($searchResult);

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
        }
        else{

            echo '<div class="search_header">

                    <h2>Search results for "<em>'.$searchTerm.'</em>"</h2>
            
                                <div class="search_result_input">
                                    
                                        <select name="district" id="filter">
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

            while($row = mysqli_fetch_assoc($searchResult)){

                $adOwnerId = $row['customer_id'];
        
                $adOwnerQuery = "SELECT * FROM customer WHERE customer_id = $adOwnerId";
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
                
                //Display the search result
                echo '<div class="result '.$adDistrict.'">
                            <hr>
                            &nbsp;
                            <div class="content">
                                <div class="image">
                                   <a href="../pages/adView.php?adId='.$adId.'"> <img src="../uploads/'.$adImage.'"> </a>
                                </div>
                                <div class="links">
                                    <a href="../pages/adView.php?adId='.$adId.'" class="result_link" ><h3>' .$adTitle. '</h3></a>
                                    <p>'.$adCategory.'</p>
                                    <p>' .$adownerFirstName.' '.$adownerLastName.'</p>
                                    <p>'.$adCity.', '.$adDistrict.'.</p>
                                </div>
                            </div>
                      </div>';
            }

        }
    ?>
        
    </div>

    <script>
        /*$(document).ready(function(){
            $("#filter").on('change', function(){
                var value = $(this).val();
                //alert(value);
                $(".result").hide();
                $("#" + value).fadeIn(700);
            });
        });*/

        $(document).ready(function(){
            $("#filter").on('change', function(){

                $(".result").hide();

                var value = $(this).val();

                if(value == "All"){
                    $(".result").show();
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