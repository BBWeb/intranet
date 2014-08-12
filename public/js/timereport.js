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
    // show noty
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

})(jQuery);