function saveReservation() {
    var formData = JSON.parse(localStorage.getItem("formData"));  /*get the reservation details using localStorage
                                                converts the json string into an object */
    console.log(formData);
    fetch("../../controller/receptionist/save_reservation_controller.php", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then((res) => res.json())
    .then((data) => {
        var paymentReceipt = document.getElementById("paymentReceipt");
        var originalContents = document.body.innerHTML;   

        document.body.innerHTML = paymentReceipt.innerHTML;   //print only the payment receipt's content
        window.print();

        document.body.innerHTML = originalContents;  //convert the body to show the original content
        if(data){
            window.location.href = '../../public/receptionist/receptionist_dashboard.php';
        }else{
            errMsg = document.getElementById("err-msg");
            errMsg.innerHTML = "Error in saving the reservation";
        }
    });
    

}