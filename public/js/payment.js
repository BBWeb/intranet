;(function($) {

	// inputs
	var $hourlySalaryInput = $('#hourly-salary');
	var $incomeTaxInput = $('#income-tax'); 
	var $employerFeeInput = $('#employer-fee');
	var $startDateInput = $('#start-date');

	// when the modal is completely hidden
	$('#plan-salary-modal').on('hidden.bs.modal', clearSalaryChangeInputs);
	$('#plan-salary-btn').on('click', newSalaryChange);

	$('body').on('click', '.remove-salary-change', function() {
    var staffId  = $(this).data('staff-id');
    var salaryChangeId = $(this).data('id');

    $.ajax({
      type: 'DELETE',
      url: '/staff/' + staffId + '/edit/payment/' + salaryChangeId,
      success: function(data, textstatus) {
        if ( !data.deleted ) return;

        location.reload();
      }
    })


		// if we verify that we want to remove it
		// 	get id and send to server, on yes - refresh
	});

	function clearSalaryChangeInputs() {
		$startDateInput.val('');
		$hourlySalaryInput.val('');

		$startDateInput.val( $startDateInput.data('default') );
		$incomeTaxInput.val( $incomeTaxInput.data('default') );

    clearSalaryChangeErrors();
  }

  function showSalaryChangeErrors(errors) {
    for (var errorKey in errors) {
      var formattedErrorKey = errorKey.replace('_', '-');
      var error = errors[ errorKey ]; 

      $('#' + formattedErrorKey + '-error').removeClass('hidden').text( error );
    }
  }

  function clearSalaryChangeErrors() {
    var possibleErrors = ['hourly-salary-error', 'income-tax-error', 'start-date-error', 'employer-fee-error'];

    possibleErrors.forEach(function(error) {
      $('#' + error).addClass('hidden').text('');      
    });

  }

  function newSalaryChange() {
    var staffId =  $(this).data('staff-id');
    var salaryChangeData = getSalaryChangeData();

    // in case we faied once before
    clearSalaryChangeErrors();

    $.post('/staff/' + staffId + '/edit/payment', salaryChangeData, function(data) {
     console.log('Every day we meckng', data);
     if ( data.success ) {
      location.reload();
    }

    var errors = JSON.parse( data.errors );
    showSalaryChangeErrors( errors );
  });
  }

  function getSalaryChangeData() {
    return {
     hourly_salary: $hourlySalaryInput.val(),
     income_tax: $incomeTaxInput.val(),
     employer_fee: $employerFeeInput.val(),
     start_date: $startDateInput.val()
   };
 }

})(jQuery);
