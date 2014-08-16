;(function($) {

  // Global variables
  var $newReportAction = $('#new-report');
  var $privateTasks = $('#private-tasks-tbody');

  // Event handlers 
  $newReportAction.click(createNewReport)

  $privateTasks.on('click', '.connect', connectToAsanaTaskModal);
  $privateTasks.on('click', '.remove-report', removePrivateReport)

  // we want to save a new private task when name is changed
  $privateTasks.on('change', '.newly-added input.name', createPrivateTask);
  // update an existing task if we change input
  $privateTasks.on('change', '.private-task input', updatePrivateTask);

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
    })
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
        asana_task_id: asanaData.asana_id,
        project_id: asanaData.project_id, 
        project_name: asanaData.project_name,
        name: asanaData.name
      }, function(data) {
        var taskId = data.task_id;
        var template = data.template;
        // find rendered task with id, or append
        reportedTable.updateOrAppendTask(taskId, template);

        // close modal and remove "private task"
        asanaModal.close();
        $tr.remove();
      });

      // when we get a response we want to hide/delete the private task

      // add to the right side, 

    };

    asanaModal.show();
    $.get('asana/all', function(response, textStatus) {
      var asanaTasks = response.data || [];

      var transformed = _.map(asanaTasks, function(task, key) {
        return extractTaskData(task); 
      });

      asanaModal.populate( transformed );
    });
  }

  // get the important data and return an object
  function extractTaskData(task) {
    return {
      id: task.id,
      task: task.name,
      project_name: task.taskState.projects.name,
      project_id: task.taskState.projects.id
    };
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
      removeUpdateState( $tr );

      $tr
        .data('id', data.id)
        .removeClass('newly-added')
        .addClass('private-task');
    });
  }

})(jQuery);