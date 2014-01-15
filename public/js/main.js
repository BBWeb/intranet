;(function() {

   $projectSelect = $('#project-select');

   $('#project-data-btn').click(getProjectData);

   function getProjectData(e) {
      var selectedProject = $projectSelect.val();
      
      // get request to server fetching data
      e.preventDefault();
   }
})();
