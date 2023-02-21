const changeToLocalTime = (time) => {
    //split the time
    const timeArr = time.split(":");
    const hours = parseInt(timeArr[0]);
    const minutes = parseInt(timeArr[1]);
    const seconds = parseInt(timeArr[2]);

    const date = new Date();
    date.setHours(hours);
    date.setMinutes(minutes);
    date.setSeconds(seconds);

    const localTime = date.toLocaleTimeString();
    return localTime;
}

export {changeToLocalTime};