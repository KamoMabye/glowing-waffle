//When the user scrolls down the page, the button will appear
window.onscroll = function(){
    scrollFunction();
};

function scrollFunction(){

    var scrollButton = document.getElementById("scroll_button");

    if(document.documentElement.scrollTop > 500){
        scrollButton.style.display = "block";
    }
    else{
        scrollButton.style.display = "none";
    }
}

//This will allow the user to go back to the top of the page
function scrollBackUp(){
    document.documentElement.scrollTop = 0;
}

//This allows me to animate the pictures and text in my website as the user scrolls down the page
const observer = new IntersectionObserver((entries) =>{

    entries.forEach(entry => {
        console.log(entry);

        if(entry.isIntersecting){
            entry.target.classList.add("show");
        }
    });

})

//This targets all the pictures and text I want to animate
var hardwareImgs = document.querySelectorAll("#hardware");
var softwareImgs = document.querySelectorAll("#software");
var servicesImgs = document.querySelectorAll("#services");
var servicesImgs1 = document.querySelectorAll("#services_1");
var mainHeadings = document.querySelectorAll("h1");
var partnersImgs = document.querySelectorAll("#partners");
var clientsImgs = document.querySelectorAll("#clients");
var slogan = document.querySelectorAll("#mainpage");
var map = document.querySelectorAll("#contact_map");
hardwareImgs.forEach((el) => observer.observe(el));
mainHeadings.forEach((el) => observer.observe(el));
softwareImgs.forEach((el) => observer.observe(el));
servicesImgs.forEach((el) => observer.observe(el));
servicesImgs1.forEach((el) => observer.observe(el));
partnersImgs.forEach((el) => observer.observe(el));
clientsImgs.forEach((el) => observer.observe(el));
map.forEach((el) => observer.observe(el));
slogan.forEach((el) => observer.observe(el));


//Will alert the user when a text box has been left out
function validateForm(){

    let firstname = document.forms["form"]["first"].value;
    let lastname = document.forms["form"]["last"].value;
    let email = document.forms["form"]["email"].value;
    let phone = document.forms["form"]["phoneNum"].value;
    let text = document.forms["form"]["body"].value;

    if(firstname == ""){
      alert("Please enter your first name!");
      return false;
    }

    if(lastname == ""){
      alert("Please enter your last name!");
      return false;
    }

    if(email == ""){
      alert("Please enter your email address!");
      return false;
    }

    if(phone == ""){
      alert("Please enter your phone number!");
      return false;
    }

    if(text == ""){
      alert("Please enter your feedback!");
      return false;
    }

}

//These functions will clear out text boxes when the user clicks on them
function clearFirstName(){
  document.getElementById("firstName").value = "";
}

function clearLastName(){
  document.getElementById("lastName").value = "";
}

function clearEmail(){
  document.getElementById("emails").value = "";
}

function clearPhone(){
  document.getElementById("phone").value = "";
}

function clearText(){
  document.getElementById("textarea").value = "";
}