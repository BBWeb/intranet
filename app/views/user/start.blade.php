@extends('user.base')

@section('content')

<div class="container">

   <div class="row">
      <div class="col-md-3">
         <form class="form-inline">
            <div class="form-group">
               <label for="project-select">Hämta data för</label>
               <select id="project-select" class="form-control">
                  <option value="all">Alla</option>
                  @foreach ($projects as $project)
                  <option value="{{ $project->id }}">{{ $project->name }}</option>
                  @endforeach
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
                  <th>Tilldelad</th>
               </tr> 
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>
   </div>
</div> <!-- /container -->
@stop

@section('footer-scripts')
   <script src="js/main.js"></script>
@stop
