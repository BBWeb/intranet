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
