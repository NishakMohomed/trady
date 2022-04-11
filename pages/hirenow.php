<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/hirenow.css">
    <title>Hire now</title>
</head>
<body>
    <!---------------------------------Navigation bar-------------------------------------------------------->

    <?php include('../includes/navbar_1.php'); ?>

    <!-------------------------------------------Hire Now----------------------------------------------->
            <div class="search_section">
                <div class="search_content">
                    <div class="search_field">
                        <div class="search_box">
                            
                            <form action="searchResult.php" method="get">
                                <input type="search" name="search" class="input" placeholder="Search tradesman">
                                <div class="search_btn">

                                <button type="submit">
                                    <i class='bx bx-search'></i>
                                </button>
                                    
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            

    <!--------------------------------------------Footer Section-------------------------------------------->

        <?php include('../includes/footer.php'); ?>

    </body>
</html>