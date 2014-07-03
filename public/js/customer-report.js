$('.input-group.date').datepicker({
  format: 'dd-mm-yyyy'
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