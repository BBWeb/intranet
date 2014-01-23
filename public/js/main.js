;(function() {
   $('#tasks-tbody').on('click', 'button.add-task', addTaskToDb);

   $('#added-tasks-tbody').on('click', 'button.report-button', reportTask);

   $('#added-tasks-tbody').on('blur', 'input.time-worked', updateWorkedTime);

   $('#added-tasks-tbody').on("click",".remove-button", removeTask);

   function reportTask() {
    var $trParent = $(this).closest('tr')
       , id = $trParent.data('id')
       ;

       $.post("task-report", { id: id }, function(data,textStatus) {

        if(textStatus!=="success")return;
          $trParent.hide();
       });
   }

   function removeTask(){
      var $trParent = $(this).closest('tr')
       , id = $trParent.data('id')
       ;

        $.post('task-remove', { id: id }, function(data, textStatus, jqXhr) {

         if( textStatus !== "success" )return;

         $trParent.hide();
       });
   }

   function updateWorkedTime() {
      var $trParent = $(this).closest('tr')
       , id = $trParent.data('id')
      , timeWorked = $trParent.find('.time-worked').eq(0).val()
       ;

      // TODO mock put request
      $.post('task-update-time', { id: id, timeWorked: timeWorked }, function(data, textStatus, jqXhr) {
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
      $.post('task', taskData, function(data, textStatus, jqXhr) {
         if ( textStatus !== 'success' ) return;

         data = JSON.parse(data);
         // the id we got from the server
         taskData.id = data.id;

         // hide the tr we just added
         $trParent.hide();
         $('#added-tasks-tbody').append( taskTemplate( taskData ) );
      });
   }

   function getTaskDataFromTr($tr)
   {
      return {
         asana_id: $tr.data('id'),
         project: $tr.data('project'),
         name: $tr.data('name')
      };
   }
})();
