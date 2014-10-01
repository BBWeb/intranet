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
            <th>Betald tid (minuter)</th>
            <th>Datum rapporterat</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tasks as $task)
          <tr data-id="{{ $task->id }}">
            <td>{{ $task->projectName }}</td>
            <td>{{ $task->taskName }}</td>
            <td>{{ $task->totalPayedTime() }}</td>
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

@stop

