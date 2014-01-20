;(function() {
   $('#tasks-tbody').on('click', 'button.add-task', addTaskToDb);

   $('#added-tasks-tbody').on('click', 'button.report-button', reportTime);

   function reportTime() {
      var $trParent = $(this).closest('tr')
        , timeWorked = $trParent.find('.time-worked').eq(0).val()
        , id = $trParent.data('id')
        ;

      $.post('testar', { id: id, timeWorked: timeWorked }, function(data, textStatus, jqXhr) {
         console.log('Post sent', arguments);
      });

      // console.log('Report', $(this));
   }

   $('#project-data-btn').click(getProjectData);

   function getProjectData(e) {
      var selectedProject = $('#project-select').val();

      // get request to server fetching data
      $.get('asana/' + selectedProject, function(response, textStatus) {
         var $tasksTbody = $('#tasks-tbody').html('');
         var taskTemplate = _.template( $('#task-template').html() );

         console.log('Arguments', arguments);
         if ( textStatus !== 'success' ) return;

         var tasks = response.data || [];

         tasks.forEach(function(task) {
            var taskObject = getTaskObject( task );
            $tasksTbody.append( taskTemplate( taskObject ) );
         });
      });

      e.preventDefault();
   }

   function getTaskObject(task) {
      return {
         id: task.id,
         project: task.taskState.projects.name,
         task: task.name,
         assigned: 'Niklas'
      };
   }

   function addTaskToDb(e) {
      var $trParent = $(this).closest('tr')
        , id = $trParent.data('id')
        , project = $trParent.data('project')
        , name = $trParent.data('name')
        ;

      console.log('Id', id);
      $.post('task', { id: id, project: project, name: name}, function(data, textStatus, jqXhr) {
         console.log('Post sent', arguments);

         if ( textStatus !== 'success' ) return;

         $trParent.hide();
         console.log('Sent to server', arguments);
      });
      // get task data
      // send post req to server with data
      // wait for answer, if positive hide
   }
})();
