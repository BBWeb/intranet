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
      var asanaId = $(this).closest('tr').data('id');

      // send the clicked asanaID to the listener
      self.onConnect( asanaId );
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