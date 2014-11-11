(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({"./js/timereport.js":[function(require,module,exports){
;(function($) {

  var draggable = require('./timereport/draggable');
  var reportedTable = require('./timereport/reportedTable')();
  var privateTable = require('./timereport/privateTable')(reportedTable);

  // get the important data and return an object
  function extractTaskData(task) {
    return {
      id: task.id,
      task: task.name,
      project_name: task.taskState.projects.name,
      project_id: task.taskState.projects.id
    };
  }

})(jQuery);
},{"./timereport/draggable":"/Users/nandreasson/Code/bbweb/intranet/public/js/timereport/draggable.js","./timereport/privateTable":"/Users/nandreasson/Code/bbweb/intranet/public/js/timereport/privateTable.js","./timereport/reportedTable":"/Users/nandreasson/Code/bbweb/intranet/public/js/timereport/reportedTable.js"}],"/Users/nandreasson/Code/bbweb/intranet/public/js/timereport/draggable.js":[function(require,module,exports){
exports.config = {
  helper: function( event ) {
    var name = $(this).find('input.name').first().val();
    return $( "<div class='helper'>Flyttar " + name + "</div>" );
  },
  cursor: 'pointer',
  cursorAt: {
    left: 0,
    top: 15
  }
};

},{}],"/Users/nandreasson/Code/bbweb/intranet/public/js/timereport/privateTable.js":[function(require,module,exports){
module.exports = function(reportedTable) {

  var draggable = require('./draggable');
  var timer = require('./timer')({
    name: 'privateTable',
    tableId: '#private-tasks',
    rowClass: '.private-task',
    inputEl: 'input.report',
    onStop: updatePrivateTask
  });

  timer.initTimers();

  var $privateTasks = $('#private-tasks-tbody');

  $privateTasks.on('click', '.connect', connectToAsanaTaskModal);
  $privateTasks.on('click', '.remove-report', removePrivateReport);

  // we want to save a new private task when name is changed
  $privateTasks.on('change', '.newly-added input.name', createPrivateTask);
  // update an existing task if we change input
  $privateTasks.on('change', '.private-task input', updatePrivateTask);

  $('.private-task').draggable( draggable.config );

  // Global variables
  var $newReportAction = $('#new-report');

  // Event handlers
  $newReportAction.click(createNewReport);

  $privateTasks.on('click', '.timer', handleTimer);

  function handleTimer() {
    // start timer etc
    timer.handleTimer.call(this);
  }

  function createNewReport() {
    // checkout all the newly added reports, if they have an empty value focus that one
    var $newlyAddedNames = $('.newly-added input.name');

    var foundUnusedReport = false;

    $newlyAddedNames.each(function() {
      var $newReport = $(this);

      if ( !$newReport.val() ) {
        foundUnusedReport = true;
        $newReport.focus();
        // break the each
        return;
      }
    });

    // we dont want to add a new report row if there is an unused
    if ( foundUnusedReport ) return;

    $privateTasks.prepend( $('#report-template').html() );
  }

  function removePrivateReport() {
    var $deleteButton = $(this);
    var $tr = $deleteButton.closest('tr');
    var taskId = $tr.data('id');

    // send a delete req to server
    $.ajax({
      method: 'DELETE',
      url: '/private-task/' + taskId,
      success: function(data) {
        if ( data.deleted ) $tr.remove();
      }
    });
  }

  function updatePrivateTask() {
    var $inputChanged = $(this);
    var $tr = $inputChanged.closest('tr');
    var taskId = $tr.data('id');

      // get the inputs values
      var name = $tr.find('input.name').first().val();
      var timeWorked = $tr.find('input.report').first().val();

      setUpdateState( $tr );

      $.ajax({
        method: 'PUT',
        url: '/private-task/' + taskId,
        data: {
          name: name,
          time_worked: timeWorked
        },
        success: function() {
          timer.clearTaskTimer(taskId);

          removeUpdateState( $tr );
        }
      });
    }

    function createPrivateTask() {
      var $inputChanged = $(this);
      var $tr = $inputChanged.closest('tr');

      // get the inputs values
      var name = $tr.find('input.name').first().val();
      var timeWorked = $tr.find('input.report').first().val();

      setUpdateState( $tr );

      $.post('/private-task', {
        name: name,
        time_worked: timeWorked
      }, function(data) {
        $tr.remove();

        var $template = $(data.template);
        $privateTasks.prepend( $template );

        $template.draggable( draggable.config );
      });
    }

    function connectToAsanaTaskModal() {
      var $connectButton = $(this);
      var $tr = $(this).closest('tr');
      var privateTaskId = $tr.data('id');

      asanaModal.onConnect = function(asanaData) {
        // send private task id and asana task id to server
        console.log('Asana data', asanaData);

        $.post('/task/connect-asana', {
          private_task_id: privateTaskId,
          asana_task_id: asanaData.asana_id
        }, function(data) {
          var taskId = data.task_id;
          var template = data.template;
          // find rendered task with id, or append
          reportedTable.updateOrAppendTask(taskId, template);

          // close modal and remove "private task"
          asanaModal.close();
          $tr.remove();
        });

      };

      asanaModal.show();
    }

};

},{"./draggable":"/Users/nandreasson/Code/bbweb/intranet/public/js/timereport/draggable.js","./timer":"/Users/nandreasson/Code/bbweb/intranet/public/js/timereport/timer.js"}],"/Users/nandreasson/Code/bbweb/intranet/public/js/timereport/reportedTable.js":[function(require,module,exports){
var draggable = require('./draggable');

module.exports = function() {

var reportedTable = {

  $el: $('#reported-tasks'),

  init: function() {
    var self = this;

    this.$el.on('click', '.expand-task', function() {
      var $expandButton = $(this);
      var $tr = $expandButton.closest('tr');
      self.expandReport($tr);
    });

    this.$el.on('change', '.subreport input', this.updateSubreport);
    this.$el.on('click', '.timer', function() {
      timer.handleTimer.call(this);
    });

    this.$el.on('click', '.add-subreport', this.addSubreport);
    this.$el.on('change', '.newly-added input.name', this.createSubreport);

    this.$el.on('click', '.subreport span.remove-report', function() {
      var $subreportTr = $(this).closest('tr.subreport');
      self.removeSubreport( $subreportTr );
    });
  },

  addSubreport: function() {
    var $addButton = $(this);
    var $tr = $addButton.closest('tr.task');

    var $report = $( $('#subreport-template').html() );
    $tr.after( $report );
  },

  createSubreport: function() {
    var $changedInput = $(this);
    var $tr = $changedInput.closest('tr');
    var taskId = $tr.prev('tr.task').data('id');

    // get the inputs values
    var name = $tr.find('input.name').first().val();
    var timeWorked = $tr.find('input.report').first().val();

    setUpdateState( $tr );

    $.post('/task/create-subreport', {
      name: name,
      time_worked: timeWorked,
      task_id: taskId
    }, function(data) {
      var template = data.template;
      // find rendered task with id, or append
      reportedTable.updateOrAppendTask(taskId, template);
    });
  },

  removeSubreport: function($subreportTr) {
    var subreportId = $subreportTr.data('id');

    $.ajax({
      url: '/task/remove-subreport',
      method: 'POST',
      data: {
        id: subreportId
      },
      success: function() {
        removeSubreportUpdateTask( $subreportTr );
      }
    });
  },

  expandReport: function($tr) {
    var $expandButton = $tr.find('.expand-task').first();
    var $addButton = $tr.find('.add-subreport').first();
    var $subreports = $tr.nextUntil('.task', '.subreport');

    var expanded = $tr.hasClass('expanded');

    if ( expanded ) {
      $expandButton.removeClass('glyphicon-chevron-down');
      $expandButton.addClass('glyphicon-chevron-right');

      $subreports.addClass('hide');
      $tr.removeClass('expanded');

      $addButton.addClass('hide');

      return;
    }

    $addButton.removeClass('hide');

    $expandButton.removeClass('glyphicon-chevron-right');
    $expandButton.addClass('glyphicon-chevron-down');

    $subreports.removeClass('hide')
    $tr.addClass('expanded');
  },

  updateSubreport: function() {
    var $input = $(this);
    var $tr = $input.closest('tr');
    var subreportId = $tr.data('id');

    var name = $tr.find('input.name').first().val();
    var time = Number( $tr.find('input.time').first().val() );

    if ( isNaN( time ) ) return;

    setUpdateState( $tr );

    $.post('task/update-subreport', { id: subreportId, name: name, time: time }, function(data, textStatus) {
      if (textStatus !== 'success') return;

      // the task which the subreport belongs to
      var $task = $tr.prevAll('tr.task').first();
      reportedTable.sumTotalTaskTime( $task );

      removeUpdateState( $tr );
    });
  },

  updateOrAppendTask: function(taskId, template) {
    // get the tbody
    var $tbody = $('#reported-tasks tbody').first();
    var $existingTasks = $tbody.children('tr.task');

    var $existingTask = this.findTaskTr(taskId);

    if ( $existingTask ) {
      var $subreports = getFollowingSubreports( $existingTask );
      $subreports.remove();

      var $template = $(template);

      // maybe extract into a nice function
      $template.first().droppable( droppableOptions );
      $template.filter('.subreport:not(.payed)').draggable( draggable.config );

      $existingTask.after( $template );

      if ( $existingTask.hasClass('expanded') ) reportedTable.expandReport( $template.first() );
      $existingTask.remove();

      return;
    }
    // prepend a new task if not found
    $tbody.prepend( template );
  },

  findTaskTr: function(taskId) {
    var $tbody = $('#reported-tasks tbody').first();
    var $taskTrs = $tbody.children('tr.task');

    var $foundTaskTr = null;

    $taskTrs.each(function() {
      var $taskTr = $(this);

      if ( $taskTr.data('id') == taskId ) {
        $foundTaskTr = $taskTr;
        return;
      }
    });

    return $foundTaskTr;
  },

  sumTotalTaskTime: function($taskTr) {
    var totaltime = 0;

    var $subreports = getFollowingSubreports($taskTr);

    $subreports.each(function() {
      var $subreport = $(this);
      totaltime += Number( $subreport.find('input.time').val() );
    });

    // change format to hh:mm
    var formattedTime = formatTotalTime( totaltime );

    $taskTr.find('td.totaltime').text( formattedTime );
  }

};

// return time in format hh:mm
var formatTotalTime = function(totaltime) {
  var hours = Math.floor(totaltime / 60);
  var minutes = totaltime % 60;

  return (hours < 9 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes;
};

var timer = require('./timer')({
  el: 'input.time',
  onStop: reportedTable.updateSubreport
});


function getFollowingSubreports($taskTr) {
  var $subreports = $([]);

  var $nextSibling = $taskTr.next();

  while ($nextSibling && $nextSibling.hasClass('subreport')) {
    $subreports = $subreports.add( $nextSibling );
    $nextSibling = $nextSibling.next();
  }

  return $subreports;
}

function getParentTaskTr($subreportTr) {
  var $prevSibling = $subreportTr.prev();

  while ($prevSibling && $prevSibling.hasClass('subreport')) {
    $prevSibling = $prevSibling.prev();
  }

  // when the loop breaks we should have found a tr with a class "task"
  return $prevSibling;
}

reportedTable.init();

function removeSubreportUpdateTask($subreportTr) {
  var $parentTask = getParentTaskTr( $subreportTr );
  $subreportTr.remove();
  reportedTable.sumTotalTaskTime( $parentTask );
}

var droppableOptions = {
  hoverClass: "drop-hover",
  drop: function(e, ui) {
    var $dragged = $(ui.draggable);
    var draggedId = $dragged.data('id');
    var reportedTaskId = $(this).data('id');

    var moveSubreport = function() {
      $.ajax({
        url: '/task/move-subreport/' + draggedId,
        method: 'PUT',
        data: {
          reported_task_id: reportedTaskId
        },
        success: function(data) {
          var template = data.template;
          // calculate report time for the old one, append the new template osv
          reportedTable.updateOrAppendTask(reportedTaskId, template);

          removeSubreportUpdateTask( $dragged );
        }
      });
    };

    var movePrivateTask = function() {
      $.post('/task/add-private-to-task', {
        private_task_id: draggedId,
        reported_task_id: reportedTaskId
      }, function(data) {
        var template = data.template;

        // find rendered task with id, or append
        reportedTable.updateOrAppendTask(reportedTaskId, template);

        // close modal and remove "private task"

        // get the parent task.tr, then update that summm thime and so on mon
        $dragged.remove();
      });
    };

    var draggedIsSubreport = $dragged.hasClass('subreport');

    if ( draggedIsSubreport ) {
      moveSubreport();
    } else {
      movePrivateTask();
    }

  } // end of drop

};

$('.subreport:not(.payed)').draggable( draggable.config );

$('tr.task').droppable( droppableOptions );

return reportedTable;
};

},{"./draggable":"/Users/nandreasson/Code/bbweb/intranet/public/js/timereport/draggable.js","./timer":"/Users/nandreasson/Code/bbweb/intranet/public/js/timereport/timer.js"}],"/Users/nandreasson/Code/bbweb/intranet/public/js/timereport/timer.js":[function(require,module,exports){

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


},{}]},{},["./js/timereport.js"]);
