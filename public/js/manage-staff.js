;(function() {

   var 
   var $trParent;

   $('#staff-members').on('click', '.remove-button', function() {
      $trParent = $(this).closest('tr');

      $('#remove-staff-modal').modal();
   });

   $('.sucess-button').click(function() {

      $('#remove-staff-modal').modal('hide');

      var id = $trParent.data('id')

      $.ajax({
         url: '/staff/' + id,
         type: 'DELETE',

         success: function(data, textStatus) {
            if( textStatus !== 'success' ) return;

            $trParent.hide();
         }
      });
   });

})();
