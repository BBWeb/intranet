function setUpdateState($tr) {
  $tr.addClass('updating');
  $tr.find('input').attr('disabled', true);
}

function removeUpdateState($tr) {
  $tr.removeClass('updating');
  $tr.find('input').attr('disabled', false);
}
