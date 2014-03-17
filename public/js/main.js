;(function() {

   var $addedTasksTBody = $('#added-tasks-tbody');

   $('#tasks-tbody').on('click', 'button.add-task', addTaskToDb);

   $addedTasksTBody.on('click', 'button.report-button', reportTask);
   $addedTasksTBody.on('click', 'button.remove-button' , showRemoveTaskModal);
   $addedTasksTBody.on('blur', 'input.time-worked', updateWorkedTime);

   $('.confirm-remove-button').click(removeTask);

   $('#project-data-btn').click(getProjectData);

   var $trParent;
   function showRemoveTaskModal() {
      $trParent = $(this).closest('tr');

      $('#remove-added-task-modal').modal();
   }

   function reportTask() {
    var $trParent = $(this).closest('tr')
       , id = $trParent.data('id')
       ;

       $.post('task-report', { id: id }, function(data,textStatus) {

          if( textStatus !== 'success' ) return;

          $trParent.hide();
       });
   }

   function removeTask() {
      var id = $trParent.data('id');

        $.post('task-remove', { id: id }, function(data, textStatus, jqXhr) {

         if( textStatus !== 'success' )return;

         $trParent.hide();
         $('#remove-added-task-modal').modal('hide');
       });
   }

   function updateWorkedTime() {
      var $timeWorkedInput = $(this)
        , $trParent = $timeWorkedInput.closest('tr')
        , id = $trParent.data('id')
        , timeWorked = $timeWorkedInput.val()
        ;

      $timeWorkedInput.after('<span class="spinner"></span>');
      // TODO mock put request
      $.post('task-update-time', { id: id, timeWorked: timeWorked }, function(data, textStatus, jqXhr) {
         if (textStatus !== 'success') return;

         $timeWorkedInput.siblings('.spinner').remove();
      });
   }


   function getProjectData(e) {
      var selectedProject = $('#project-select').val();

      // get request to server fetching data
      $.get('asana/' + selectedProject, function(response, textStatus) {
         var $tasksTbody = $('#tasks-tbody').html('')
           , taskTemplate = _.template( $('#task-template').html() )
           ;

         if ( textStatus !== 'success' ) return;

         var tasks = response.data || [];

          console.log('Tasks', tasks);

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
         task: task.name,
         project_name: task.taskState.projects.name,
         project_id: task.taskState.projects.id
      };
   }

   function addTaskToDb(e) {
      // get task data
      var $trParent = $(this).closest('tr')
        , taskData = getTaskDataFromTr( $trParent )
        , taskTemplate = _.template( $('#added-task-template').html() )
        ;

      // send post req to server with data
      $.post('task', taskData, function(data, textStatus, jqXhr) {
         if ( textStatus !== 'success' ) return;

         data = JSON.parse(data);
         // the id we got from the server
         taskData.id = data.id;

         // hide the tr we just added
         $trParent.hide();
         $addedTasksTBody.append( taskTemplate( taskData ) );
      });
   }

   function getTaskDataFromTr($tr)
   {
      return {
         asana_id: $tr.data('id'),
         project_name: $tr.data('project-name'),
         project_id: $tr.data('project-id'),
         name: $tr.data('name')
      };
   }
})();
