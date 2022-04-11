
//Function to toggle menu

var navbar_links = document.getElementById("navbar_links");
        
navbar_links.style.maxHeight = "0px";
        
function menutoggle(){
    if(navbar_links.style.maxHeight == "0px")
        {
             navbar_links.style.maxHeight = "230px"
        }
        else
        {
             navbar_links.style.maxHeight = "0px"
        }
}

//Function to toggle postads page menu

function menutoggle2(){
    if(navbar_links.style.maxHeight == "0px")
    {
        navbar_links.style.maxHeight = "230px"
        document.getElementById("spacer").style.height = "190px";
        document.getElementById("spacer").style.transition = "0.5s";
    }
    else
    {
        navbar_links.style.maxHeight = "0px"
        document.getElementById("spacer").style.height = "0px";
        document.getElementById("spacer").style.transition = "0.5s";
    }
}