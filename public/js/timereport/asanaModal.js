// set up event handlers

// els and such, which one should it use

var asanaModal = {

  $el: $('#asana-tasks-modal'),
  $tasks: $('#asana-tasks'),
  $filter: $('#asana-task-filter'),

  // event handler
  onConnect: function() {},

  init: function() {
    var self = this;

    this.$filter.on('input', function() {
      var filterString = $(this).val();
      self.filter( filterString );
    });

    this.$tasks.on('click', '.connect-task', function() {
      var $tr = $(this).closest('tr');
      var asanaData = extractAsanaDataFrom( $tr );
      // send data to the listener
      self.onConnect( asanaData );
    });
  },

  populate: function(tasks) {
    var self = this;
    var template = _.template( $('#task-template').html() );

    tasks.forEach(function(task) {
      self.$tasks.append( template( task ) );
    });

    return this;
  },

  filter: function(filterString) {
    var regex = new RegExp(filterString, 'i');

    var $trs = this.$tasks.find('tr');
    $trs.hide();

    $trs.filter(function () {
      return regex.test($(this).text());
    }).show();
  },

  show: function() {
   // show the modal 
   this.$el.modal();

   return this;
  },

  close: function() {
    this.$el.modal('hide'); 

    return this;
  }

};

asanaModal.init();

function extractAsanaDataFrom($tr) {
  return {
     asana_id: $tr.data('id'),
     project_name: $tr.data('project-name'),
     project_id: $tr.data('project-id'),
     name: $tr.data('name')
  };
}
