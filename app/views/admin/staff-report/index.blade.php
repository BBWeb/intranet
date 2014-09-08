@extends('admin.staff-report.base')

@section('content')
  @parent

  <div class="row" style="margin-top: 10px; margin-bottom: 10px">
    <div class="col-md-12">
      <span>Total tid: {{ $totaltime }} minuter</span>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <table class="table" id="user-tasks">
        <thead>
          <tr>
            <th>Projekt</th>
            <th>Uppgift</th>
            <th>Obetald tid (minuter)</th>
            <th>Datum avklarad</th>
            <th><input type="checkbox" id="payall-checkbox">Markera för lön</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($tasks as $task)
          <tr data-id="{{ $task->id }}">
            <td>{{ $task->projectName() }}</td>
            <td>{{ $task->taskName() }}</td>
            <td>{{ $task->totalUnpayedTimeBetween($from, $to) }}</td>
            <td>
              @if ($task->completionDate() == '0000-00-00')
                Icke avklarad
              @else
                {{ $task->completionDate() }}
              @endif
            </td>
            <td><input type="checkbox" class="pay-checkbox"></td>
            <td><button class="btn btn-primary toggle-subreports">Göm/Visa delrapporter</button></td>
          </tr>
          <tr class="subreports hide">
            <td colspan="6">
              <table class="table">
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th>Tid</th>
                    <th>Datum</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                @foreach($task->unpayedSubreportsBetween($from, $to) as $subreport)
                  <tr data-id="{{ $subreport->id }}">
                    <td></td>
                    <td></td>
                    <td style="width: 17%;">{{ $subreport->time }}</td>
                    <td style="width: 14%;">{{ $subreport->reported_date }}</td>
                    <td style="width: 30%"><input type="checkbox" class="subreport-checkbox"></input></td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col-md-2">
      <button class="btn btn-primary" id="pay-btn">Utbetalning</button>
    </div>
  </div>

<div class="modal fade" id="step-payment-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th>Datum rapporterat</th>
              <th>Tid</th>
              <th>Markera för lön</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop

