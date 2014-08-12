@extends('layouts.authenticated')

@section('content')

<div class="container">

  <div class="row">

    <div class="col-md-5">
      <h1>Privata</h1>

      <table class="table">
        <thead>
          <tr>
            <th class="name">Namn</th>
            <th class="report">Tid</th>
            <th class="actions">
              <span id="new-report" class="new-report glyphicon glyphicon-plus pull-right"></span>
            </th>
          </tr>
        </thead>
        <tbody id="private-tasks">
          <tr>
            <td><input type="text" class="form-control name" value="Meck"></td>
            <td>
              <input type="number" class="form-control" value="10">
            </td>
            <td class="valign">
              <a href="#">
                <span class="connect glyphicon glyphicon-random"></span>
              </a>
              <span class="remove-report glyphicon glyphicon-minus pull-right"></span>
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" class="form-control name" value="Opp"></td>
              <td>
                <input type="number" class="form-control" value="15">
              </td>
              <td class="valign">
                <a href="#">
                  <span class="connect glyphicon glyphicon-random"></span>
                </a>
                <span class="remove-report glyphicon glyphicon-minus pull-right"></span>
              </td>
            </tr>
          </tbody>
        </table>
      </div> 

      <div class="col-md-5 col-md-offset-1">
        <h1>Rapporterade</h1>

      </div>

    </div>

 <!--   <div class="row">
      <div class="col-md-5">
      {{ Form::open([ 'url' => '/', 'method' => 'GET', 'class' => 'form-inline' ]) }}
            <div class="form-group">
               <label for="project-select" class="">Visa projekt</label>
               {{ Form::select('project', array( 'all' => 'All' ) +$projects, Session::get('project'), array('id' => 'project-select', 'class' => 'form-control')) }}
            </div>
            {{ Form::submit('Filtrera', array('class' => 'btn btn-primary'))}}
      {{ Form::close() }}
      </div>
    </div> -->
   <!--
   <div class="row" style="margin-top: 10px">
     <div class="col-md-12">
         <table class="table table-bordered">
            <thead>
               <tr>
                  <th>Projekt</th>
                  <th>Uppgift</th>
                  <th>Tid (minuter)</th>
                  <th>Timer</th>
                  <th>Total tid (minuter)</th>
                  <th></th>
               </tr>
            </thead>
            <tbody id="added-tasks-tbody">
            @foreach($tasks as $task)
               <tr data-id="{{ $task->id }}">
                  <td>{{ $task->theproject->name }}</td>
                  <td>{{ $task->task }}</td>
                  <td><input type="number" value="{{ $task->unpayedTimeToday() }}" min="0" class="time-worked" style="width: 60px" /></td>
                  <td><div class="badge timer">00:00:00</div></td>
                  <td>{{ $task->totaltime() }}</td>
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
</div>
-->
<!-- /container -->

<!-- Modal -->
<div class="modal fade" id="asana-tasks-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Koppla ihop med uppgift</h4> 
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <input id="asana-task-filter" type="text" placeholder="Filter..." class="form-control"> 
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
          <table class="table">
            <thead>
              <tr>
                <th>Projekt</th>
                <th>Namn</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="asana-tasks">
            </tbody>
          </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


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

<!-- Modal -->
<div class="modal fade" id="report-tasks-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Rapportera</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Datum rapporterat</th>
                <th>Tid (minuter)</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Avbryt</button>
        <button type="button" id="finish-task-btn" class="btn btn-primary">Avsluta task</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/template" id="report-template">
  <tr class="newly-added">
    <td><input type="text" class="form-control name" placeholder="Programmerat..."></td>
    <td>
      <input type="number" class="form-control" value="0">
    </td>
    <td class="valign">
      <a href="#">
        <span class="connect glyphicon glyphicon-random"></span>
      </a>
      <span class="remove-report glyphicon glyphicon-minus pull-right"></span>
    </td>
  </tr>  
</script>

<script type="text/template" id="task-template">
 <tr data-id="<%- id %>" data-project-name="<%- project_name %>" data-project-id="<%- project_id %>" data-name="<%- task %>">
  <td class="task-project"><%- project_name %></td>
  <td class="task-name"><%- task %></td>
  <td><button class="btn btn-primary connect-task">Koppla</button></td>
</tr>
</script>

<script type="text/template" id="added-task-template">
 <tr data-id="<%- id %>">
  <td class="task-project"><%- project_name %></td>
  <td class="task-name"><%- name %></td>
  <td><input type="number" value="0" class="time-worked" style="width: 60px" /></td>
  <td><div class="badge timer">00:00:00</div></td>
  <td>0</td>
  <td>
   <button class="btn btn-primary report-button">Rapportera</button>
   <button class="btn btn-danger remove-button">Ta bort</button>
 </td>
</tr>
</script>

<script type="text/template" id="subreport-template">
  <% _.each(subreports, function(subreport) { %>
    <tr data-id="<%- subreport.id %>">
      <td><%- subreport.reported_date %></td>
      <td>
        <input type="number" value="<%- subreport.time %>" style="width: 70px" <% if (subreport.payed == 1) { %> disabled <% } %> />
      </td>
      <td>
        <% if (subreport.payed == 1) { %>
          Redan betald
          <% } else { %>
            <button class="btn btn-danger remove-button">Ta bort</button>
            <% } %>
          </td>
        </tr>
        <% }); %>
</script>


@stop

@section('footer-scripts')
<!-- // <script src="js/main.js"></script> -->
<script src="js/timereport.js"></script>
<script src="js/libs/jquery.noty.packaged.min.js"></script>
@stop
