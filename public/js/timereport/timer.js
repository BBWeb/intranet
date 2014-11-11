
module.exports = function(config) {

  // local storage functions
  function setLocalStorageFor(id, time) {
    var storagePrefix = config.name;
    localStorage.setItem(storagePrefix + '.' + id, millis);
  }

  function clearLocalStorageFor(id) {
    var storagePrefix = config.name;
    localStorage.removeItem(storagePrefix + '.' + id);
  }

  function getLocalStorageFor(id) {
    var storagePrefix = config.name;

    var timeStr = localStorage.getItem(storagePrefix + '.' + id);
    return Number( timeStr );

  }

  var $table = $(config.tableId);

  function initTimers() {
    var $taskRows = $table.find(config.rowClass) ;

    $taskRows.each(function() {
      var $tr = $(this);
      var taskId = $tr.data('id');

      var timeForRow = getLocalStorageFor( taskId );

      if ( timeForRow === 0 ) return true;

      var $timerBadge = $tr.find('.timer');
      $timerBadge.stopwatch({ initialTime: timeForRow });
    });
  }


  function handleTimer() {
    var $trParent = $(this).closest('tr')
    , id = $trParent.data('id')
    ;

    var $timerBadge = $(this);
    var stopwatch = $timerBadge.stopwatch();

    var $timeWorkedInput = $timerBadge.closest('tr').find( config.inputEl )
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
    handleTimer: handleTimer,
    initTimers: initTimers,
    clearTaskTimer: clearLocalStorageFor
  };
};


function convertMillisToMinutes(ms) {
  var elapsedTimeInS = ms / 1000;
  var minutesWorked = Math.round( elapsedTimeInS / 60 );
  return minutesWorked;
}

