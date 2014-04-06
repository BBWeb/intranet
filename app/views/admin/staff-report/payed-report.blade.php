@extends('admin.staff-report.payed')

@section('content')
  @parent

  <div class="row">
    <div class="col-md-12">
      <table class="table" id="project-tasks">
        <thead>
          <tr>
            <th>Projekt</th>
            <th>Uppgift</th>
            <th>Rapporterad tid (minuter)</th>
            <th>Datum rapporterat</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tasks as $task)
          <tr data-id="{{ $task->id }}">
            <td>{{ $task->theproject->name }}</td>
            <td>{{ $task->task }}</td>
            <td>{{ $task->totaltime() }}</td>
            <td>
              @if ($task->reported_date == '0000-00-00')
                Icke avslutad
              @else
                {{$task->reported_date }}
              @endif
            </td>
            <td><input type="checkbox"></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="row">
    <div class="col-md-2">
      <button class="btn btn-primary">Utbetalning</button>
    </div>
  </div>

@stop

