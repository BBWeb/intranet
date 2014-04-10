@extends('layouts.authenticated')

@section('content')

<div class="container">
	<div class="col-md-12">
     	<table class="table table-bordered">
        	<thead>
               <tr>
                  <th>Projekt</th>
                  <th>Uppgift</th>
                  <th>Obetald tid</th>
                  <th>Tid (minuter)</th>
                  <th>Datum (rapporterat)</th>
               </tr>
           </thead>
           <tbody>
            @foreach($tasks as $task)
               <tr data-id="{{ $task->id }}">
                  <td>{{ $task->theproject->name }}</td>
                  <td>{{ $task->task }}</td>
                  <td>{{ $task->totalUnpayedTime() }}</td>
                  <td><span class="total-time" href="">{{ $task->totaltime() }}</span></td>
                  <td>
                    @if ($task->reported_date == '0000-00-00')
                      Icke avslutad
                    @else
                      {{$task->reported_date }}
                    @endif
                  </td>
    	       </tr>
            @endforeach
            </tbody>
            </table>
      </div>
</div>


<!-- Modal -->
<div class="modal fade" id="all-subreports-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Delrapporter</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Datum rapporterat</th>
                <th>Tid (minuter)</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary">Ok</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/template" id="subreport-template">
  <% _.each(subreports, function(subreport) { %>
    <tr data-id="<%- subreport.id %>">
      <td><%- subreport.reported_date %></td>
      <td><%- subreport.time %></td>
    </tr>
  <% }); %>
</script>
@stop

@section('footer-scripts')
   <script src="js/reported-time.js"></script>
@stop
