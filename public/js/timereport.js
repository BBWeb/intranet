;(function($) {

  var draggable = require('./timereport/draggable');
  var reportedTable = require('./timereport/reportedTable')();
  var privateTable = require('./timereport/privateTable')(reportedTable);

  // get the important data and return an object
  function extractTaskData(task) {
    return {
      id: task.id,
      task: task.name,
      project_name: task.taskState.projects.name,
      project_id: task.taskState.projects.id
    };
  }

})(jQuery);