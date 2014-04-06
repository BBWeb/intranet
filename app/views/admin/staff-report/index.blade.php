@extends('admin.staff-report.base')

@section('content')
  @parent

  <div class="row">
    <div class="col-md-12">
      <table class="table" id="project-tasks">
        <thead>
          <tr>
            <th>Projekt</th>
            <th>Uppgift</th>
            <th>Obetald tid (minuter)</th>
            <th>Datum avklarad</th>
            <th>Markera för lön</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tasks as $task)
          <tr data-id="{{ $task->id }}">
            <td>{{ $task->theproject->name }}</td>
            <td>{{ $task->task }}</td>
            <td>{{ $task->totalUnpayedTime() }}</td>
            <td>
              @if ($task->reported_date == '0000-00-00')
                Icke avklarad
              @else
                {{$task->reported_date }}
              @endif
            </td>
            <td><input type="checkbox" class="payed-checkbox"></td>
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

@stop

