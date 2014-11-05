@extends('layouts.authenticated')

@section('content')

<div class="container">
  <div class="row">
      {{ Form::open(array('route' => 'reported-time.filter', 'class' => 'form-inline')) }}
      <div class="col-md-3">
        <div class="form-group">
          <label for="">Projekt</label>
          {{ Form::select('project', array('all' => 'Alla') + $projects, Session::get('project'), array('class' => 'form-control')) }}
        </div>
      </div>

      <div class="col-md-2">
        <div class="input-group date">
          <span class="input-group-addon">Från</span>
          {{ Form::text('from', Session::get('from'), array('id' => 'from-date', 'class' => 'form-control')) }}
        </div>
      </div>


      <div class="col-md-2">
        <div class="input-group date">
          <span class="input-group-addon">Till</span>
          {{ Form::text('to', Session::get('to'), array('id' => 'to-date', 'class' => 'form-control')) }}
        </div>
      </div>

        {{ Form::submit('Filtrera', array('class' => 'btn btn-primary')) }}
      {{ Form::close() }}
    </div>
  </div>

  <div class="row" style="margin-top: 15px">
    <div class="col-md-6">
     <!-- unpayed time in hours and minutes  -->
      <ul class="list-unstyled">
        <li>Obetald tid {{ $totalUnpayed->hours }} timmar {{ $totalUnpayed->minutes }} minuter</li>
        <li>Betald tid {{ $totalPayed->hours }} timmar {{ $totalPayed->minutes }} minuter</li>
      </ul>
     <!-- payed time in hours and minutes -->
    </div>
  </div>

  <div class="row" style="margin-top: 15px">
    <div class="col-md-12">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Projekt</th>
            <th>Uppgift</th>
            <th>Obetald tid</th>
            <th>Tid (hh:mm)</th>
            <th>Datum (rapporterat)</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tasks as $task)
          <tr data-id="{{ $task->id }}">
            <td>{{ $task->projectName() }}</td>
            <td>{{ $task->taskName() }}</td>
            <td>{{ $task->formattedUnpayedTime() }}</td>
            <td><span class="total-time" href="">{{ $task->formattedTotalTime() }}</span></td>
            <td>
              @if ($task->completionDate() == '0000-00-00')
              Icke avslutad
              @else
              {{$task->completionDate() }}
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
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
   <script src="/js/reported-time.js"></script>
@stop
