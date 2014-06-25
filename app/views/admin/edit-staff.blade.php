@extends('layouts.authenticated')

@section('content')
<div class="container">
   @if($errors)
      @foreach($errors as $error)
         <p>{{ $error }}</p>
      @endforeach
   @endif
   <div class="row">
      <div class="col-md-6">
      {{ Form::open(array('method' => 'put', 'url' => array('/staff', $staff->id) )) }}
           <div class="form-group">
             <label for="name">Namn</label>
             {{ Form::text('name', $staff->name, array('class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name')) }}
             {{ $errors->first('name', '<span class="text-danger">:message</span>') }}
           </div>
           <div class="form-group">
             <label for="email">E-mail</label>
             {{ Form::email('email', $staff->email, array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'Enter email', 'disabled' => true)) }}
             {{ $errors->first('email', '<span class="text-danger">:message</span>') }}
           </div>
           <div class="form-group">
             <label for="exampleInputPassword1">Password</label>
             {{ Form::password('password', array('class' => 'form-control', 'id' => 'password',  'placeholder' => 'Password')) }}
             {{ $errors->first('password', '<span class="text-danger">:message</span>') }}
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
