;(function() {

   var $addedTasksTBody = $('#added-tasks-tbody');

   $('#tasks-tbody').on('click', 'button.add-task', addTaskToDb);

   $addedTasksTBody.on('click', 'button.report-button', showReportModal);
   $addedTasksTBody.on('click', 'button.remove-button' , showRemoveTaskModal);
   $addedTasksTBody.on('blur', 'input.time-worked', updateWorkedTime);

   $('#report-tasks-modal').on('blur', 'input', updateSubreportTime);

  $('.confirm-remove-button').click(removeTask);

  $('#project-data-btn').click(getProjectData);

  $('#report-tasks-modal').on('click', 'button.remove-button', removeSubreport);

  $('#finish-task-btn').click(finishTask);

  $('body').on('click', '.timer', function() {
    $(this).stopwatch();

    var $timerBadge = $(this)
      , $timeWorkedInput = $timerBadge.closest('tr').find('input.time-worked')
      , elapsedTimeInMs = $timerBadge.stopwatch('getTime')
      ;

    if ( elapsedTimeInMs > 0) {
      $timerBadge.stopwatch('stop');
      // convert to minutes, elapsedTime is number of ms
      var elapsedTimeInS = elapsedTimeInMs / 1000
        , minutesWorked = Math.round( elapsedTimeInS / 60 )
        ;

      // update input field
      var timeAlreadyWorked = parseInt( $timeWorkedInput.val(), 10 );
      $timeWorkedInput.val( timeAlreadyWorked + minutesWorked );

      // report to server etc
      updateWorkedTime.call(this);
      $timeWorkedInput.prop( 'disabled', false );

      $timerBadge.stopwatch('reset');
    } else {
      $timerBadge.stopwatch('start');
      $timeWorkedInput.prop( 'disabled', true );
    }
  });

   var $trParent;
   function showRemoveTaskModal() {
      $trParent = $(this).closest('tr');

      $('#remove-added-task-modal').modal();
   }

   function showReportModal() {
      $trParent = $(this).closest('tr');
      var taskId = $trParent.data('id');
      var $reportTasksModal = $('#report-tasks-modal');
      var subreportTemplate = _.template( $('#subreport-template').html() );

      // get tasks for a certain task id
      $.get('/task/index/' + taskId, function(data, textStatus) {
        // if not success return
        if ( textStatus !== 'success' ) return;

        // go through underscore template and add
        var subreports = JSON.parse( data );
        $reportTasksModal.find('tbody').html( subreportTemplate({ subreports: subreports }) );

        $('#report-tasks-modal').modal();
      });
   }

   function reportTask() {
    var $trParent = $(this).closest('tr')
       , id = $trParent.data('id')
       ;

       $.post('task/report', { id: id }, function(data,textStatus) {
          if( textStatus !== 'success' ) return;

          $trParent.hide();
       });
   }

   function removeTask() {
      var id = $trParent.data('id');

        $.post('task/remove', { id: id }, function(data, textStatus, jqXhr) {
          if( textStatus !== 'success' )return;

          $trParent.hide();
          $('#remove-added-task-modal').modal('hide');
       });
   }

  function updateWorkedTime() {
    var $trParent = $(this).closest('tr')
      , $timeWorkedInput = $trParent.find('input.time-worked')
      , id = $trParent.data('id')
      , timeWorked = $timeWorkedInput.val()
      ;

      $timeWorkedInput.after('<span class="spinner"></span>');
      // TODO mock put request
      $.post('task/update-time', { id: id, timeWorked: timeWorked }, function(data, textStatus, jqXhr) {
         if (textStatus !== 'success') return;

         $timeWorkedInput.siblings('.spinner').remove();
      });
   }


   function getProjectData(e) {
      var selectedProject = $('#project-select').val();

      // get request to server fetching data
      $.get('asana/' + selectedProject, function(response, textStatus) {
        console.log('Arguments', arguments);
        var $tasksTbody = $('#tasks-tbody').html('')
          , taskTemplate = _.template( $('#task-template').html() )
          ;

        if ( textStatus !== 'success' ) return;

        var tasks = response.data || {};

        for (var taskKey in tasks) {
          var task = tasks[ taskKey ];
          var taskObject = getTaskObject( task );
          $tasksTbody.append( taskTemplate( taskObject ) );
         }
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
      $.post('task/create', taskData, function(data, textStatus, jqXhr) {
        if ( textStatus !== 'success' ) return;

        data = JSON.parse(data);
        // the id we got from the server
        taskData.id = data.id;

        // hide the tr we just added
        $trParent.hide();
        $addedTasksTBody.append( taskTemplate( taskData ) );
      });
   }

   function getTaskDataFromTr($tr) {
      return {
         asana_id: $tr.data('id'),
         project_name: $tr.data('project-name'),
         project_id: $tr.data('project-id'),
         name: $tr.data('name')
      };
   }

  function removeSubreport() {
    var $trParent = $(this).closest('tr');
    var id = $trParent.data('id');

    $.post('/task/remove-subreport', { id: id }, function(data, textStatus) {
      if ( textStatus !== 'success' ) return;

      $trParent.hide();

      var n = noty({
        text: 'Du tog bort en delrapport',
        layout: 'topCenter',
        type: 'information',
        template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
        buttons: [
          {
            addClass: 'btn btn-primary', text: 'Ångra', onClick: function($noty) {
              $.post('/task/undo-subreport-remove', { id: id }, function(data, textStatus) {
                if ( textStatus !== 'success' ) return;

                $trParent.show();
                $noty.close();
              // send post req to that server, undoing the action
              // show the row again

              });
            }
          },
        ]
      });
    });

  }

  function finishTask() {
    var taskId = $trParent.data('id');

    var n = noty({
      text: 'Är du säker på att du vill "avsluta task?"',
      layout: 'topCenter',
      buttons: [
        {
          addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {
            $.post('/task/report', { id: taskId }, function(data, textStatus, jqXhr) {
              if ( textStatus !== 'sucess' )

              // if success, hide modal and tr
              $trParent.hide();
              $('#report-tasks-modal').modal('hide');
            });
            $noty.close();
          }
        },
        {
          addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
            $noty.close();
          }
        }
      ]
    });
  }

  function updateSubreportTime() {
    var $this = $(this);
    var $trParent = $this.closest('tr');
    var id = $trParent.data('id');
    var timeWorked = $this.val();

    if ( !Number(timeWorked) ) return;

    $this.after('<span class="spinner"></span>');
      // TODO mock put request
      $.post('task/update-subreport-time', { id: id, timeWorked: timeWorked }, function(data, textStatus, jqXhr) {
         if (textStatus !== 'success') return;

         $this.siblings('.spinner').remove();
      });
  }

})();
