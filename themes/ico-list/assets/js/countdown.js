function getTimeRemaining(endtime) {
    var t = Date.parse(endtime) - Date.parse(new Date());
    var seconds = Math.floor((t / 1000) % 60);
    var minutes = Math.floor((t / 1000 / 60) % 60);
    var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
    var days = Math.floor(t / (1000 * 60 * 60 * 24));
    return {
        'total': t,
        'days': days,
        'hours': hours,
        'minutes': minutes,
        'seconds': seconds
    };
}

function initializeClock(endtime) {
    var daysSpan = document.querySelector('#countDays');
    var hoursSpan = document.querySelector('#countDays');
    var minutesSpan = document.querySelector('#countMin');
    var secondsSpan = document.querySelector('#countSec');

    function updateClock() {
        var t = getTimeRemaining(endtime);

        daysSpan.innerHTML = t.days;
        hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
        minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
        secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

        if (t.total <= 0) {
            clearInterval(timeinterval);
        }
    }

    updateClock();
    var timeinterval = setInterval(updateClock, 1000);
}
var dayData = $('#countDays').text();
var hourData = $('#countHours').text();
var minutesData = $('#countMin').text();
var secondsData = $('#countSec').text();

var deadline = new Date(Date.parse(new Date()) + dayData * hourData * minutesData * secondsData * 1000);
initializeClock( deadline);