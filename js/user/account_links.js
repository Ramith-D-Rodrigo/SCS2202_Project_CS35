const profileBtn = document.getElementById("profileBtn");
const profileLinks = document.getElementById("profile-links");

profileBtn.addEventListener("click", ()=>{
    console.log("hello");
    if(profileLinks.style.display === 'none'){
        profileLinks.style.display = 'block';
    }
    else{
        profileLinks.style.display = 'none';
    }
});