<?php
session_start();

if(!$_SESSION['login']){
    header("location: login.php");
}

if(!$_SESSION['adData-available']){
    header("location: postads.php");
}

//Connecting to database
$dataBase= mysqli_connect('localhost', 'root', '','trady');

//Price Details
$priceQuery = "SELECT * FROM price WHERE price_id = '1'";
$priceResult = mysqli_query($dataBase, $priceQuery);
$priceRow = mysqli_fetch_assoc($priceResult);
$price = $priceRow['price'];
$discount = $priceRow['discount'];
$totalPrice = $price - $discount;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/checkout.css">
    <title>Payment</title>
</head>
<body>
    <section>
        <div class="payment_image">
            <img src="../images/payment.jpg">
            <div class="paymentText">
                <h2>#Make your payment.</h2>
            </div>
        </div>
        <div class="payment_content">
            <div class="payment_form">
                <h2>Payment</h2>
                <form action="checkout.php" method="POST">
                    <div class="payment_bill">
                        <h3>Summary</h3>
      
                        <ul>
                            <li>
                                <span>Advertisement</span>
                                <span>$<?php echo $price ?></span>
                            </li>
                            <li>
                                <span>Discount</span>
                                <span>$<?php echo $discount ?></span>
                            </li>
                            <li>
                                <span>Total</span>
                                <span>$<?php echo $totalPrice ?></span>
                            </li>
                        </ul>
                        <hr>
                  </div>

                    <div class="payment_input">
                        <!--<input type="submit" name="pay" value="Post Ad">-->
                        <div id="paypal-payment-button"></div>
                    </div>

                </form>
            </div>
        </div>
    </section>

<!--------------------------------------------Footer Section---------------------------------------------->
    
    <?php include('../includes/footer.php'); ?>

<!--------------------------------------------Paypal Script---------------------------------------------->

<script src="https://www.paypal.com/sdk/js?client-id=AWf2wt-Ir8cLbnvohKqZfT16Jz8fVc8-K3t-x4AaLI7l78_fhOi6qKpbhPXGHuAdA2o8HGHHQ1GbfO1x&disable-funding=credit,card"></script>
<script>
    paypal.Buttons({
        style:{
            color: 'blue'
        },
        createOrder:function(data,actions){
            return actions.order.create({
                purchase_units:[{
                    amount:{
                        value:'<?php echo $totalPrice ?>'
                    }
                }]
            });
        },
        onApprove:function(data,actions){
            return actions.order.capture().then(function(details){
                //alert('Transaction completed by ' + details.payer.name.given_name);
                //console.log(details);
                window.location = "../includes/adData.php";
            });
        },
        onCancel:function(data){
            alert('Transaction cancelled');
            window.location = "./postads.php";
        }
    }).render('#paypal-payment-button');
</script>

</body>
</html>