$('#userOverview').click(function(){
    $("#content_section").load("userOverview.php");
});

$('#user_icon').click(function(){
    $("#content_section").load("accountdetails.php");
});

$('#changeDetails').click(function(){
    $("#content_section").load("changeDetails.php");
});

$('#changeEmail').click(function(){
    $("#content_section").load("changeEmail.php");
});

$('#changePassword').click(function(){
    $("#content_section").load("changePassword.php");
});

$('#postedAds').click(function(){
    $("#content_section").load("postedAds.php");
});

$('#hiredAds').click(function(){
    $("#content_section").load("hiredAds.php");
});

$('#messages').click(function(){
    $("#content_section").load("notification.php");
});