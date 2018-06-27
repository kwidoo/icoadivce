function getTimeRemaining(endtime) {
    var t = Date.parse(endtime) - Date.parse(new Date());
    return {
        'total': t,
    };

}


function initializeClock(endtime) {
    function updateClock() {
        var t = getTimeRemaining(endtime);
        jQuery('#countDays').html(Math.floor(t.total / (1000 * 60 * 60 * 24)));
        jQuery('#countHours').html(Math.floor((t.total / (1000 * 60 * 60)) % 24));
        jQuery('#countMin').html(Math.floor((t.total / 1000 / 60) % 60));
        jQuery('#countSec').html(Math.floor((t.total / 1000) % 60));
        if (t.total <= 0) {
            clearInterval(timeinterval);
        }
    }
   // updateClock();
    var timeinterval = setInterval(updateClock, 1000);
}

var deadline = new Date($('#timestamp').text()*1000);

initializeClock(deadline);


