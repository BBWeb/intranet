@extends('layouts.authenticated')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-md-6">
        {{ Form::open(array('url' => '/staff'))}}
           <div class="form-group">
             <label for="email">Email address</label>
             {{ Form::email('email', null, array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter email')) }}
             {{ $errors->first('email', '<span class="text-danger">:message</span>') }}
           </div>
           <div class="form-group">
             <label for="name">Name</label>
             {{ Form::text('name', null, array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name')) }}
             {{ $errors->first('name', '<span class="text-danger">:message</span>') }}
           </div>
           <div class="form-group">
             <label for="password">Password</label>
             {{ Form::password('password', array('class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password')) }}
             {{ $errors->first('password', '<span class="text-danger">:message</span>') }}
           </div>
           <div class="checkbox">
             <label>
               <input type="checkbox" name="admin" value="admin"> Admin
             </label>
           </div>
          {{ Form::submit('Lägg till', array('class' => 'btn btn-success')) }}
        {{ Form::close() }}
      </div>
   </div>
@stop
