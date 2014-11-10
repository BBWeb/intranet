@extends('layouts.authenticated')

@section('content')

<div class="container">

  <div class="row">

    <div class="col-md-6">
      <h1>Privata</h1>

      <table id="private-tasks" class="table">
        <thead>
          <tr>
            <th class="name">Namn</th>
            <th class="report">Tid</th>
            <th class="actions">
              <span id="new-report" class="new-report glyphicon glyphicon-plus pull-right"></span>
            </th>
          </tr>
        </thead>
        <tbody id="private-tasks-tbody">
          {{ View::renderEach('templates.private_task', $privateTasks, 'privateTask') }}
        </tbody>
        </table>
      </div>

      <div class="col-md-6">
        <h1>Rapporterade</h1>

        <table id="reported-tasks" class="table">
          <thead>
            <tr>
              <th class="project">Projekt</th>
              <th class="name">Namn</th>
              <th>Total tid</th>
              <th class="actions"></th>
            </tr>
          </thead>
          <tbody>
            {{ View::renderEach('templates.reported_task', $tasks, 'task') }}
          </tbody>
        </table>

      </div>

    </div>

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
          <div class="col-md-6">
          <a href="#" class="pull-right" style="line-height: 34px">
            <span class="glyphicon glyphicon-refresh asana-sync"></span>
          </a>
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
            {{ View::renderEach('templates.asana_task', $asanaTasks, 'asanaTask') }}
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
      <input type="number" class="form-control report" value="0">
    </td>
    <td class="valign">
    </td>
  </tr>
</script>

<script type="text/template" id="subreport-template">
  <tr class="second-level subreport newly-added">
    <td colspan="2"><input type="text" class="form-control name" placeholder="Programmerat..."></td>
    <td>
      <input type="number" class="form-control report" value="0">
    </td>
    <td class="valign">
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

@stop

@section('footer-scripts')
<!-- // <script src="js/main.js"></script> -->
<script src="js/timereport/utils.js"></script>
<script src="js/timereport/asanaModal.js"></script>
<script src="dist/timereport-bundle.js"></script>
@stop
