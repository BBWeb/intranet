;(function() {

  var $allSubreportsModal = $('#all-subreports-modal');
  var subreportTemplate = _.template( $('#subreport-template').html() );

  // show modal when clicking on the totaltime "link"
  $('body').on('click', 'span.total-time', function() {
    var $trParent = $(this).closest('tr');
    var taskId = $trParent.data('id');

    // get all subreports for that task
    $.get('/task/index/' + taskId, function(data, textStatus) {
      if ( textStatus !== 'success' ) return;

      var subreports = JSON.parse(data);

      $allSubreportsModal.find('tbody').html( subreportTemplate({ subreports: subreports }) );
      $allSubreportsModal.modal();
    });

  });

})();
