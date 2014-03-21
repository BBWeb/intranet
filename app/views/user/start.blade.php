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
                  <th>Tid (minuter)</th>
                  <th></th>
               </tr>
            </thead>
            <tbody id="added-tasks-tbody">
            @foreach($tasks as $task)
               <tr data-id="{{ $task->id }}">
                  <td>{{ $task->theproject->name }}</td>
                  <td>{{ $task->task }}</td>
                  <td><input type="number" value="{{ $task->time_worked }}" min="0" class="time-worked" style="width: 60px" /></td>
                  <td>
                     <button class="btn btn-primary report-button">Rapportera</button>
                     <button class="btn btn-danger remove-button">Ta bort</button>
                  </td>
               </tr>
            @endforeach
            </tbody>
         </table>
      </div>
   </div>

   <div class="row">
      <div class="col-md-5">
         <form class="form-inline">
            <div class="form-group">
               <label for="project-select" class="">Hämta data för</label>
               <select id="project-select" class="form-control">
                  <option value="all">Alla</option>
               </select>
            </div>
            <button type="submit" id="project-data-btn" class="btn btn-primary">Hämta</button>
         </form>
      </div>
   </div>

   <div class="row">
      <div class="col-md-8">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>Projekt</th>
                  <th>Uppgift</th>
                  <th></th>
               </tr>
            </thead>
            <tbody id="tasks-tbody">
            </tbody>
         </table>
      </div>
   </div>
</div> <!-- /container -->

<!-- Modal -->
<div class="modal fade" id="remove-added-task-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Bekräfta borttagning</h4>
      </div>
      <div class="modal-body">
       <p>Är du säker?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
        <button type="button" class="btn btn-danger confirm-remove-button">Bekräfta</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/template" id="task-template">
   <tr data-id="<%- id %>" data-project-name="<%- project_name %>" data-project-id="<%- project_id %>" data-name="<%- task %>">
      <td class="task-project"><%- project_name %></td>
      <td class="task-name"><%- task %></td>
      <td><button class="btn btn-success add-task">Lägg till</button></td>
   </tr>
</script>

<script type="text/template" id="added-task-template">
   <tr data-id="<%- id %>">
      <td class="task-project"><%- project_name %></td>
      <td class="task-name"><%- name %></td>
      <td><input type="number" value="0" class="time-worked" style="width: 60px" /></td>
      <td>
         <button class="btn btn-primary report-button">Rapportera</button>
         <button class="btn btn-danger remove-button">Ta bort</button>
      </td>
   </tr>
</script>
@stop

@section('footer-scripts')
   <script src="js/main.js"></script>
@stop
