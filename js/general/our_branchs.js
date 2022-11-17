let queryResults = null;
const result = document.getElementById("example");

fetch("../../controller/general/our_branches_controller.php")
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
        queryResults = JSON.stringify(data);
        result.innerText = data;
    });



