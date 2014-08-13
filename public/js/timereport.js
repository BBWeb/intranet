;(function($) {


  // Global variables
  var $newReportAction = $('#new-report');
  var $privateTasks = $('#private-tasks');
  var $asanaTasksModal = $('#asana-tasks-modal');

  // parent for tasks in asana modal
  var $asanaTasks = $('#asana-tasks');
  var $asanaTaskFilter = $('#asana-task-filter');

  // Event handlers 
  $newReportAction.click(createNewReport)

  $privateTasks.on('click', '.connect', connectToAsanaTaskModal);
  $privateTasks.on('click', '.remove-report', removePrivateReport)
  $asanaTaskFilter.on('input', filterAsanaTasks);

  // we want to save a new private task when name is changed
  $privateTasks.on('change', '.newly-added input.name', createPrivateTask);

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
    // get tasks from asana
    $.get('asana/all', function(response, textStatus) {
      var asanaTaskTemplate = _.template( $('#task-template').html() );

      var asanaTasks = response.data || {};

      // remove data that might exists 
      $asanaTasks.html('');

      // add all of the tasks to the modal
      for (var taskKey in asanaTasks) {
        var task = asanaTasks[ taskKey ];
        var taskObject = extractTaskData( task );
        $asanaTasks.append( asanaTaskTemplate( taskObject ) );
      }
    });

    // show modal
    $asanaTasksModal.modal();
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

  function filterAsanaTasks() {
    var filterString = $(this).val();

    var regex = new RegExp(filterString, 'i');

    var $trs = $asanaTasks.find('tr');
    $trs.hide();

    $trs.filter(function () {
      return regex.test($(this).text());
    }).show();
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



  function setUpdateState($tr) {
    $tr.addClass('updating');
    $tr.find('input').attr('disabled', true);
  }

  function removeUpdateState($tr) {
    $tr.removeClass('updating');
    $tr.find('input').attr('disabled', false);
  }

})(jQuery);