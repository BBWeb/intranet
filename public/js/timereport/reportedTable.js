
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
  },

  expandReport: function($tr) {
    var $expandButton = $tr.find('.expand-task').first();
    var $subreports = $tr.nextUntil('.task', '.subreport');

    var expanded = $tr.hasClass('expanded');

    if ( expanded ) {
      $expandButton.removeClass('glyphicon-chevron-down');
      $expandButton.addClass('glyphicon-chevron-right');

      $subreports.addClass('hide');
      $tr.removeClass('expanded');

      return;
    }

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
      sumTotalTaskTime( $task );

      removeUpdateState( $tr );
    });
  },

  updateOrAppendTask: function(taskId, template) {
    // get the tbody   
    var $tbody = $('#reported-tasks tbody').first();
    var $existingTasks = $tbody.children('tr.task');

    var foundExisting = false;

    $existingTasks.each(function() {
      var $task = $(this);

      if ( $task.data('id') == taskId) {
        var $subreports = getFollowingSubreports($task);
        $subreports.remove();

        var $template = $(template);

        // maybe extract into a nice function
        $template.first().droppable( droppableOptions );
        $template.filter('.subreport').draggable( draggableOptions );

        $task.after( $template );

        if ( $task.hasClass('expanded') ) reportedTable.expandReport( $template.first() );
        $task.remove();

        // remove all the subreports aswell
        foundExisting = true;
        return;
      }
    });

    // we dont need to append a new task
    if ( foundExisting ) return;

    $tbody.prepend( template );
  }

};

function getFollowingSubreports($taskTr) {
  var $subreports = $([]);

  var $nextSibling = $taskTr.next();

  while ($nextSibling && $nextSibling.hasClass('subreport')) {
    $subreports = $subreports.add( $nextSibling );
    $nextSibling = $nextSibling.next();
  }

  return $subreports;
}

function sumTotalTaskTime($taskTr) {
  var totaltime = 0;

  var $subreports = getFollowingSubreports($taskTr);

  $subreports.each(function() {
    var $subreport = $(this);
    totaltime += Number( $subreport.find('input.time').val() );
  }); 

  $taskTr.find('td.totaltime').text( totaltime );
}

reportedTable.init();

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

          $dragged.remove();              
        }
      });
        // do a put to some "update subreport path" 
        // send the task and the subreport id 
        // remove the dragged one
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

$('.subreport').draggable( draggableOptions );

$('tr.task').droppable( droppableOptions );