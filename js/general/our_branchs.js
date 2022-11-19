let queryResults = null;
const result = document.getElementById("branches");

fetch("../../controller/general/our_branches_controller.php")
    .then((res) => res.json())
    .then((data) => {
        for(i = 0; i < data.length; i++){
            console.log(JSON.parse(data[i]));
        }
    });



