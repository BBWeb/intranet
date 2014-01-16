;(function() {
   $('#tasks-tbody').on('click', 'button.add-task', addTaskToDb);

   $('#project-data-btn').click(getProjectData);

   function getProjectData(e) {
      var selectedProject = $('#project-select').val();
      
      // get request to server fetching data
      $.get('asana/' + selectedProject, function(response) {
         var $tasksTbody = $('#tasks-tbody').html('');
         var taskTemplate = _.template( $('#task-template').html() );
         var tasks = response.data;

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

      $.post('task', { id: id, project: project, name: name}, function(data) {
         console.log('Sent to server', arguments);
      });
      // get task data
      // send post req to server with data
      // wait for answer, if positive hide
   }
})();
