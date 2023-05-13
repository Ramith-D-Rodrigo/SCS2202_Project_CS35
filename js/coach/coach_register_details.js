const sportSelect = document.querySelector("#sport");

fetch("../../controller/coach/register_entry_controller.php")
.then(res => res.json())
.then(data=>{
    for(let i = 0; i < data.length; i++){
        const option = document.createElement("option");
        console.log(data);
        option.value = data[i].sportID;
        option.text = data[i].sportName;

        sportSelect.appendChild(option);
    }
})