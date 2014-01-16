@extends('user.base')

@section('content')

<div class="container">

   <div class="row">
      <div class="col-md-8">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>Projekt</th>
                  <th>Uppgift</th>
                  <th>Tid (minuter)</th>
                  <th></th>
               </tr>
            </thead>
            <tbody>
            @foreach(Auth::user()->tasks as $task)
               <tr>
                  <td>{{ $task->project }}</td>
                  <td>{{ $task->task }}</td>
                  <td>{{ $task->time_worked }}</td>
                  <td><button class="btn btn-primary">Rapportera</button></td>
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
                  @foreach ($projects as $project)
                  <option value="{{ $project->id }}">{{ $project->name }}</option>
                  @endforeach
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
                  <th>Tilldelad</th>
                  <th></th>
               </tr> 
            </thead>
            <tbody id="tasks-tbody">
            </tbody>
         </table>
      </div>
   </div>
</div> <!-- /container -->

<script type="text/template" id="task-template">
   <tr data-id="<%= id %>" data-project="<%= project %>" data-name="<%= task %>">
      <td class="task-project"><%= project %></td>
      <td class="task-name"><%= task %></td>
      <td class="task-assigned"><%= assigned %></td>
      <td><button class="btn btn-success add-task">Lägg till</button></td>
   </tr>
</script>
@stop

@section('footer-scripts')
   <script src="js/main.js"></script>
@stop
