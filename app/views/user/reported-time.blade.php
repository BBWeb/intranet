@extends('layouts.authenticated')

@section('content')

<div class="container">
	<div class="col-md-12">
     	<table class="table table-bordered">
        	<thead>
               <tr>
                  <th>Projekt</th>
                  <th>Uppgift</th>
                  <th>Tid (minuter)</th>
                  <th>Datum (rapporterat)</th>
               </tr>
           </thead>
           <tbody>
            @foreach($tasks as $task)
               <tr data-id="{{ $task->id }}">
                  <td>{{ $task->theproject->name }}</td>
                  <td>{{ $task->task }}</td>
                  <td>{{ $task->time_worked }}</td>
                  <td>{{ $task->reported_date }}</td>
    	       </tr>
            @endforeach
            </tbody>
            </table>
      </div>
</div>
@stop