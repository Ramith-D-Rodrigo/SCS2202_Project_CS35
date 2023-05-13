const profileBtn = document.getElementById("profileBtn");   //get profile button
const profileLinks = document.querySelectorAll(".profile-links");  //get links

if(profileBtn !== null && profileLinks !== null){   //if the user is logged in
    profileBtn.addEventListener("click", ()=>{
        profileLinks.forEach(link => {
            link.classList.toggle("profile-links-display");  //toggle the links
        });
    });
}

