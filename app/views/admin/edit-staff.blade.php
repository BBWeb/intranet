@extends('layouts.authenticated')

@section('content')
<div class="container">

   <div class="row">
      <div class="col-md-6">
      {{ Form::open(array('method' => 'put', 'url' => array('/staff', $staff->id) )) }}
           <div class="form-group">
             <label for="email">E-mail</label>
             <input type="email" class="form-control" id="email" placeholder="Enter email" value="{{ $staff->email }}" disabled>
           </div>
           <div class="form-group">
             <label for="exampleInputPassword1">Password</label>
             <input type="password" class="form-control" name="password" id="password" placeholder="Password">
           </div>
           <div class="checkbox">
             <label>
               <input type="checkbox" name="admin" value="admin"> Admin
             </label>
           </div>
           <button type="submit" class="btn btn-default">Ändra</button>
      {{ Form::close() }}

      </div>
   </div>


@stop