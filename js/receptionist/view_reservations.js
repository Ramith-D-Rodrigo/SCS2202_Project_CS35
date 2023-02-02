fetch("../../controller/receptionist/view_reservations_controller.php")
    .then((res) => res.json())
    .then((data) => {
        console.log(data);
    });