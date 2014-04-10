$('#get-payed-usertasks').click(function(e) {
  e.preventDefault();

  var selectedUser = $('#user').val()

  $(location).attr('href', '/staff-report/payed/' + selectedUser);
});