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

    $taskTr.find('td.totaltime').text( totaltime );
  }

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
