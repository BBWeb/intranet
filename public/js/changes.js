;(function() {

	$('#project-tasks').on('click', 'button.change-button', showChangeModal);

	function showChangeModal() {
		$('#changes-modal').modal()
	}

})();