;(function($) {


  // Global variables
  var $newReportAction = $('#new-report');

  // event handlers 
  $newReportAction.click(createNewReport)


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

    $('#private-tasks').prepend( $('#report-template').html() ); 
 }

})(jQuery);