
var reportedTable = {
 
  $el: $('#reported-tasks'),

  init: function() {
    var self = this;

    this.$el.on('click', '.expand-task', this.expandReport);

    this.$el.on('change', '.subreport input', this.updateSubreport);    
  },

  expandReport: function() {
    var $expandButton = $(this);
    var $tr = $expandButton.closest('tr');
    var $subreports = $tr.nextUntil('.task', '.subreport');

    var expanded = $tr.hasClass('expanded');

    if ( expanded ) {
      $expandButton.removeClass('glyphicon-chevron-down');
      $expandButton.addClass('glyphicon-chevron-right');

      $subreports.addClass('hide');
      $tr.removeClass('expanded');

      return;
    }

    $expandButton.removeClass('glyphicon-chevron-right');
    $expandButton.addClass('glyphicon-chevron-down');

    $subreports.removeClass('hide')
    $tr.addClass('expanded');
  },

  updateSubreport: function() {
    var $input = $(this);
    var $tr = $input.closest('tr');
    var subreportId = $tr.data('id');
    var time = $input.val();

    if ( !Number(time) ) return;

    setUpdateState( $tr );

    $.post('task/update-subreport-time', { id: subreportId, time: time }, function(data, textStatus) {
      if (textStatus !== 'success') return;

      // update total time for subreport?

      removeUpdateState( $tr );
    });
  }

};

reportedTable.init();