@extends('layouts.authenticated')

@section('content')
<div class="container">
  <h1>Arkivera projekt</h1>
  {{ Form::open(['method' => 'post', 'url' => 'archive'])}}
  <div class="row">
    <div class="col-md-6">
      <table class="table">
        <thead>
          <tr>
            <th>Namn</th>
            <th>Arkivera</th>
          </tr>
        </thead>
        <tbody>
          @foreach($projects as $project)
          <tr>
            <td>{{ $project->name }}</td>
            <td><input type="checkbox" name="projects[{{ $project->id }}].archive" @if ($project->archive)checked @endif></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <input type="submit" class="btn btn-primary" value="Spara ändringar">
      </div>

    </div>
    {{ Form::close() }}
</div>
@stop
