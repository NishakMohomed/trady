$('#overview').click(function(){
    $("#content_section").load("overview.php");
});

$('#manageCustomer').click(function(){
    $("#content_section").load("manageCustomer.php");
});

$('#manageAds').click(function(){
    $("#content_section").load("manageAds.php");
});

$('#managePayments').click(function(){
    $("#content_section").load("managePayment.php");
});

$('#managePrice').click(function(){
    $("#content_section").load("managePrice.php");
});

$('#addAdmin').click(function(){
    $("#content_section").load("addAdmin.php");
});

$('#adminAccounts').click(function(){
    $("#content_section").load("manageAdmin.php");
});

$('#changeDetails').click(function(){
    $("#content_section").load("changeAdminDetails.php");
});

$('#changePassword').click(function(){
    $("#content_section").load("changeAdminPassword.php");
});

$('#hiredAds').click(function(){
    $("#content_section").load("hiredAdsAdmin.php");
});