;(function() {
   $('#tasks-tbody').on('click', 'button.add-task', addTaskToDb);

   $('#added-tasks-tbody').on('click', 'button.report-button', reportTime);

   function reportTime() {
      var $trParent = $(this).closest('tr')
        , timeWorked = $trParent.find('.time-worked').eq(0).val()
        , id = $trParent.data('id')
        ;

      // TODO mock put request
      $.post('task-update', { id: id, timeWorked: timeWorked }, function(data, textStatus, jqXhr) {
         console.log('Post sent', arguments);
      });
   }

   $('#project-data-btn').click(getProjectData);

   function getProjectData(e) {
      var selectedProject = $('#project-select').val();

      // get request to server fetching data
      $.get('asana/' + selectedProject, function(response, textStatus) {
         var $tasksTbody = $('#tasks-tbody').html('')
           , taskTemplate = _.template( $('#task-template').html() )
           ;

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
         task: task.name
      };
   }

   function addTaskToDb(e) {
      // get task data
      var $trParent = $(this).closest('tr')
        , taskData = getTaskDataFromTr( $trParent )
        , taskTemplate = _.template( $('#added-task-template').html() )
        ;

      // send post req to server with data
      $.post('task', { id: taskData.id, project: taskData.project, name: taskData.name}, function(data, textStatus, jqXhr) {
         if ( textStatus !== 'success' ) return;

         // wait for answer, if positive hide
         $trParent.hide();
         $('#added-tasks-tbody').append( taskTemplate( taskData ) );
      });
   }

   function getTaskDataFromTr($tr)
   {
      return {
         id: $tr.data('id'),
         project: $tr.data('project'),
         name: $tr.data('name')
      };
   }
})();
