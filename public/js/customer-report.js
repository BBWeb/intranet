$('.input-group.date').datepicker({
  format: 'dd-mm-yyyy'
});


// get form values on click?
$('#search-project-tasks').click(function(e) {
  e.preventDefault();

  var selectedProject = $('#project').val()
    , fromDate = $('#from-date').val()
    , toDate = $('#to-date').val()
    ;

  var url = [ '/customer-report', selectedProject, fromDate, toDate ].join('/');

  $(location).attr('href', url);
});

$('#project-tasks').on('change', 'input.adjusted-time', function() {
  var $adjustedTimeInput = $(this)
    , $trParent = $adjustedTimeInput.closest('tr')
    , id = $trParent.data('id')
    , adjustedTime = $adjustedTimeInput.val()
    ;

  $adjustedTimeInput.after('<span class="spinner"></span>');
  // TODO mock put request
  $.post('/task/update-adjusted-time', { id: id, 'adjusted-time': adjustedTime }, function(data, textStatus, jqXhr) {
     if (textStatus !== 'success') return;

     $adjustedTimeInput.siblings('.spinner').remove();
  });
   });