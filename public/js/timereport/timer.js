function setLocalStorageFor(id, time) {
  localStorage.setItem('time.' + id, millis);
}

function clearLocalStorageFor(id) {
  localStorage.removeItem('time.' + id);
}

module.exports = function(config) {


  function handleTimer() {
    var $trParent = $(this).closest('tr')
    , id = $trParent.data('id')
    ;

    var $timerBadge = $(this);
    var stopwatch = $timerBadge.stopwatch();

    var $timeWorkedInput = $timerBadge.closest('tr').find( config.el )
    , elapsedTimeInMs = $timerBadge.stopwatch('getTime')
    , timerIsRunning = elapsedTimeInMs > 0
    ;

    if ( !timerIsRunning ) {
      $timerBadge.stopwatch('start');
      $timeWorkedInput.prop( 'disabled', true );

      stopwatch.on('tick.stopwatch', function(e, millis) {
        setLocalStorageFor(id, millis);
      });

      return;
    }

    // timer was running when we clicked "time"
    $timerBadge.stopwatch('stop');
    // convert to minutes, elapsedTime is number of ms
    var minutesWorked = convertMillisToMinutes( elapsedTimeInMs );

    // update input field
    var timeAlreadyWorked = parseInt( $timeWorkedInput.val(), 10 );
    $timeWorkedInput.val( timeAlreadyWorked + minutesWorked );

    // report to server etc
    config.onStop.call(this);

    $timerBadge.stopwatch('reset');
  }

  return {
    handleTimer: handleTimer
  };
};


function convertMillisToMinutes(ms) {
  var elapsedTimeInS = ms / 1000;
  var minutesWorked = Math.round( elapsedTimeInS / 60 );
  return minutesWorked;
}

