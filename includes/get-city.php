<?php
//Connecting to database
$dataBase= mysqli_connect('localhost', 'root', '','trady');

$errors=array();

if(isset($_GET['district_id'])){

    $district_id = mysqli_real_escape_string($dataBase, $_GET['district_id']);

    $cityQuery = "SELECT * FROM cities WHERE district_id = '$district_id'";
    $cityResult = mysqli_query($dataBase, $cityQuery);

    $city_list = "";

    while($cityRow = mysqli_fetch_assoc($cityResult)){

        $city_list = "<option value=\"{$cityRow['city_id']}\">{$cityRow['city_name']}</option>";
        echo $city_list;
    }

}else{

    array_push($errors, "*City is required");
}

?>