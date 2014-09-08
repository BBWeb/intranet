;(function() {

  /*
    1. EVENT HANDLERS
    2. GLOBAL DATA
    3. CHANGES MODAL
    4. SERVER INTERACTORS
   */

  // EVENT HANDLERS
  $('#project-tasks').on('click', 'button.change-button', fetchDataAndShowModal);
  $('#update-task-button').click(getFormDataAndUpdateTask);
  $('body').on('click', 'button.finish-task-btn', finishTask);

  // GLOBAL DATA
  var taskId; // the task for which to show modal for

  // Changes modal
  var $changesModal = $('#changes-modal');
  var $customerTitle = $('#customer-title');
  var $dateGroup = $('#date-group');

  var $taskDateTemplate = $('#task-date-template');

  // MODAL FUNCTIONS

  function fetchDataAndShowModal() {
    // get id for task clicked on
    var $trParent = $(this).closest('tr');
    taskId = $trParent.data('id');

    fetchTaskData(taskId, showModal);
  }

  function showModal(taskData) {
    // get template and add to modal
    var title = taskData.title;
    $customerTitle.val( title );

    setDateGroup( taskData );

    // show modal
    $changesModal.modal()
  }

  function setDateGroup(taskData) {

    console.log('Task data', taskData);
    var dateTemplate = _.template( $taskDateTemplate.html() );

    // compile template and append ..
    $dateGroup.html( dateTemplate( taskData ) );
  }


  function getFormDataAndUpdateTask() {
    var formData = getFormData();

    updateTask(taskId, formData, function() {
      // hideModal();
      location.reload(true);
    });
  }

  function getFormData() {
    var title = $customerTitle.val();
    var date = $('#customer-date').val();

    return { title: title, date: date };
  }

  function hideModal() {
    $changesModal.modal('hide');
  }

  function finishTask(e) {
    e.preventDefault();

    var taskId = $(this).data('id');

    // report the task
    reportTask(taskId, function() {
      // then, get new data about it and update modal input
      fetchTaskData(taskId, setDateGroup);
    });
  }

  // SERVER INTERACTORS

  function fetchTaskData(id, cb) {
    // we want data regarding the name, and data
    $.get('/task/modified-task-data/' + id, cb);
  }

  function updateTask(id, data, cb) {
    console.log('Update task', arguments);
    // construct post url or put
    $.ajax('/task/modify-task/' + id, {
      type: 'PUT',
      data: data,
      success: cb
    });
  }

  function reportTask(taskId, cb) {
    $.post('/task/report', { id: taskId }, cb);
  }

})();