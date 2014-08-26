exports.config = {
  helper: function( event ) {
    var name = $(this).find('input.name').first().val();
    return $( "<div class='helper'>Flyttar " + name + "</div>" );
  },
  cursor: 'pointer',
  cursorAt: {
    left: 0,
    top: 15
  }
};
