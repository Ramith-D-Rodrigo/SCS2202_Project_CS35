const notificationList = document.querySelector(".dropdown");

const getNotifications = async (notificationList) => {
    await fetch("../../controller/general/get_notifications_controller.php")
        .then(res =>{
            if(!res.ok){
                throw Error("not logged in");
            }
            return res.json();
        })
        .then(data => {
            let unreadCount = 0;

            notificationList.innerHTML = "";

            if(data.length == 0){   //no notifications
                const notificationItem = document.createElement("li");
                notificationItem.classList.add("dropdown-item");
                notificationItem.innerHTML = "No Notifications";
                notificationList.appendChild(notificationItem);
                return;
            }


            for(let i = 0; i < data.length; i++){   //travel through notifications
                const notificationItem = document.createElement("li");

                const notificationDiv = document.createElement("div");

                const subject = document.createElement("h6");
                subject.classList.add("notification-subject");
                subject.innerHTML = data[i].subject;

                const content = document.createElement("p");
                content.classList.add("notification-content");
                content.innerHTML = data[i].description;

                notificationItem.classList.add("dropdown-item");

                //mark as read container
                const markAsReadContainer = document.createElement("div");
                markAsReadContainer.classList.add("mark-as-read-container");

                const markAsRead = document.createElement("i");
                markAsRead.className ="fa-solid fa-circle-check";
                markAsRead.classList.add("mark-as-read");
                markAsRead.id = data[i].notificationID;

                markAsRead.addEventListener("click", markNotificationAsRead);

                //if notification is read, add class to notification div
                if(data[i].status == 'Read'){
                    notificationDiv.classList.add("notification-read");
                }
                else{
                    unreadCount++;
                }

                notificationDiv.appendChild(subject);
                notificationDiv.appendChild(content);
                markAsReadContainer.appendChild(markAsRead);
                notificationDiv.appendChild(markAsReadContainer);

                notificationItem.appendChild(notificationDiv);
                notificationList.appendChild(notificationItem);

                //notification count icon

                const notificationCount = document.querySelector("#notificationCount");
                if(unreadCount > 0){
                    //set the badge to the show unread notifications
                    notificationCount.classList.add("have-notifications");
                }
                else{
                    //remove the badge
                    notificationCount.classList.remove("have-notifications");
                }
            }
        })
        .catch(err => {
            console.log(err);
        });
}

const markNotificationAsRead = async (e) => {
    const notificationID = e.target.id;

    await fetch("../../controller/general/mark_notification_controller.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            notificationID: notificationID
        })
    })
    .then(res => {
        if(!res.ok){
            throw Error("Error Marking Notification as Read");
        }
        return res.json();
    })
    .then(data => {
        console.log(data);
        getNotifications(notificationList);
    })
    .catch(err => {
        console.log(err);
    });
}

getNotifications(notificationList);