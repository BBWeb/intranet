$('.input-group.date').datepicker({
  format: 'dd-mm-yyyy'
}).datepicker('setDate', new Date());

$('#search-user-tasks').click(function(e) {
  e.preventDefault();

  var selectedUser = $('#user').val()
    , fromDate = $('#from-date').val()
    , toDate = $('#to-date').val()
    ;

  var url = [ '/staff-report', selectedUser, fromDate, toDate ].join('/');

  $(location).attr('href', url);
});

$('#pay-btn').click(function(e) {
  var toPay = {};

  // go through all checked subreports, add them to toPay obh
  // ex toPay[1] = { subreports: [123, 33, 56] }
  $('.subreport-checkbox:checked').each(function() {
    var $trParent = $(this).closest('tr');
    var $trSubreports = $trParent.closest('tr.subreports');
    var taskId = $trSubreports.prev().data('id');
    var subreportId = $trParent.data('id');

    var task = toPay[taskId] || (toPay[taskId] = {});
    var subreports = task.subreports || (task.subreports = []);
    subreports.push(subreportId);
  });

  // send the list with tasks to server
  $.post('/task/pay', { tasks: toPay }, function(data, textStatus, jqXhr) {
    // TODO should display error?
    if ( textStatus !== 'success' ) return;

    var n = noty({
      text: 'Betalning genomförd! Var vänlig ladda om sidan',
      type: 'success',
      layout: 'topCenter'
    });
  });
});

$('#user-tasks').on('click', '.toggle-subreports', function() {
  var $trParent = $(this).closest('tr');
  var $subreportsTr = $trParent.next();

  $subreportsTr.toggleClass('hide');
  // var $subreportsTr = $trParent.next();

  // $subreportsTr.collapse('toggle');
  // $('#step-payment-modal').modal();
});

$('#user-tasks').on('click', '.pay-checkbox', function() {
  var $trParent = $(this).closest('tr');
  var $subreportsTr = $trParent.next();

  $('#payall-checkbox').prop('checked', false);
  // select if check, deselect if box is unchecked
  $subreportsTr.find('input[type="checkbox"]').prop('checked', this.checked);
});

$('tr.subreports').on('click', 'input[type="checkbox"]', function() {
  var $trParent = $(this).closest('tr.subreports');
  var $parentTaskCheckbox = $trParent.prev().find('.pay-checkbox');

  $parentTaskCheckbox.prop('checked', false);
});

$('#payall-checkbox').click(function(e) {
  $('#user-tasks').find('input[type="checkbox"]').prop('checked', this.checked);
});