
let branchPhotos = [];
let branchPhotosIndex = 0;

let courtPhotos = [];
let courtPhotosIndex = 0;


fetch("../../controller/general/about_us_controller.php")
.then(response => response.json())
.then(data => {
    //console.log(data);

    branchPhotos = data.branchPhotos;
    courtPhotos = data.courtPhotos;

    //add branch photos
    const branchPhotosContainer = document.querySelector("#branch-img-container");
    branchPhotosContainer.innerHTML = "";

    const branchImg = document.createElement("img");
    branchImg.src = branchPhotos[branchPhotosIndex];
    branchImg.alt = "Branch Photo";
    branchPhotosContainer.appendChild(branchImg);

    //add court photos
    const courtPhotosContainer = document.querySelector("#court-img-container");
    courtPhotosContainer.innerHTML = "";

    const courtImg = document.createElement("img");
    courtImg.src = courtPhotos[courtPhotosIndex];
    courtImg.alt = "Court Photo";
    courtPhotosContainer.appendChild(courtImg);

    //time interval for branch photos
    setInterval(() => {
        branchPhotosIndex++;
        if(branchPhotosIndex >= branchPhotos.length) branchPhotosIndex = 0;
        branchImg.src = branchPhotos[branchPhotosIndex];
    }, 2000);

    //time interval for court photos
    setInterval(() => {
        courtPhotosIndex++;
        if(courtPhotosIndex >= courtPhotos.length) courtPhotosIndex = 0;
        courtImg.src = courtPhotos[courtPhotosIndex];
    }, 2000);

});