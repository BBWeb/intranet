@extends('layouts.authenticated')

@section('content')
<div class="container">

   <div class="row">
      <div class="col-md-12">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>Projekt</th>
                  <th>Uppgift</th>
                  <th>Person</th>
                  <th>Tid (min)</th>
               </tr>
            </thead>
            <tbody id="staff-members">
            @foreach($tasks as $task)
              <tr>
                <td>{{ $task->project }}</td>
                <td>{{ $task->task }}</td>
                <td>{{ $task->user->email }}</td>
                <td>{{ $task->time_worked }}</td>
              </tr>
            @endforeach
            </tbody>
         </table>
      </div>
   </div>

   <!-- Modal -->
<div class="modal fade" id="remove-staff-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Bekräfta borttagning av personal</h4>
      </div>
      <div class="modal-body">
       <p>Är du säker på detta?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
        <button type="button" class="btn btn-danger sucess-button">Bekräfta</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@stop

@section('footer-scripts')
   <script src="js/manage-staff.js"></script>
@stop
