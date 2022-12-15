const profileBtn = document.getElementById("profileBtn");   //get profile button
const profileLinks = document.getElementById("profile-links");  //get links div

if(profileBtn !== null && profileLinks !== null){   //if the user is logged in
    profileBtn.addEventListener("click", ()=>{
        console.log("hello");
        if(profileLinks.style.display === 'none'){  //disply or hide on event
            profileLinks.style.display = 'block';
        }
        else{
            profileLinks.style.display = 'none';
        }
    });
}

