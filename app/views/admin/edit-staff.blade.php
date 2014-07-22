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
      <h1>Kontouppgifter</h1>
     </div>
   </div>
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

      <div class="col-md-3">
        <ul class="nav nav-pills nav-stacked">
          <li class="active"><a href="#">Kontouppgifter</a></li>
          <li><a href="#">Personuppgifter</a></li>
          <li><a href="#">Företagsinfo</a></li>
        </ul>
      </div>

    </div>

        <div class="row">
      <div class="col-md-6">
      <h1>Personuppgifter</h1>
        {{ Form::open() }}

        <div class="form-group">
          <label for="ssn">Personnummer</label>
          {{ Form::text('Personnummer', null, ['class' => 'form-control', 'placeholder' => '121212-12'])}}
        </div>

        <div class="form-group">
          <label for="address">Adress</label>
          {{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Hagforsgatan 72'])}}
        </div>

        <div class="form-group">
          <label for="postal_code">Postnummer</label>
          {{ Form::text('postal_code', null, ['class' => 'form-control', 'placeholder' => '416 74'])}}
        </div>

        <div class="form-group">
          <label for="city">Ort</label>
          {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'Göteborg'])}}
        </div>

        <div class="form-group">
          <label for="tel">Telefon</label>
          {{ Form::text('tel', null, ['class' => 'form-control', 'placeholder' => '031 - 33 44 55'])}}
        </div>

        {{ Form::submit('Spara personuppgifter', ['class' => 'btn btn-default'])}}

        {{ Form::close() }}
      </div>

    </div>

    <div class="row">
      <div class="col-md-6">
      <h1>Betalningsinformation</h1>
        
        {{ Form::close() }}
      </div>
    </div>

@stop
