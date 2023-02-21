const coachingSessionsContainer = document.querySelector('#coachingSessionsContainer');

fetch("../../controller/user/coaching_sessions_controller.php")
    .then(res => res.json())
    .then(data => {
        console.log(data);
    });

