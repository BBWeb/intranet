$('.input-group.date').datepicker({
  format: 'dd-mm-yyyy'
}).datepicker('setDate', new Date());

$('#search-user-tasks').click(function(e) {
  e.preventDefault();

  var selectedUser = $('#user').val();

  $(location).attr('href', '/staff-report/' + selectedUser);
});

$('#pay-btn').click(function(e) {
  var tasksToPayFor = [];
  // get all the rows where the checkbox is checked
  $('.payed-checkbox:checked').each(function() {
    // extract the task-id for these
    var taskId = $(this).closest('tr').data('id');
    tasksToPayFor.push(taskId);
  });

  // send the list with tasks to server
  $.post('/task/pay', { tasks: tasksToPayFor }, function(data, textStatus, jqXhr) {
    // TODO should display error?
    if ( textStatus !== 'sucess' ) return;

    console.log('Args', arguments);

    // maybe refresh current page

  });
});
