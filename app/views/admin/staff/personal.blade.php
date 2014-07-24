@extends('admin.staff.base')

@section('header')
<h1>Personuppgifter</h1>
@stop

@section('form')
{{ Form::open([ 'route' => ['staff.updatepersonal', $staff->id], 'method' => 'PUT' ] ) }}

<div class="form-group">
  <label for="ssn">Personnummer</label>
  {{ Form::text('ssn', $staff->ssn, ['class' => 'form-control', 'placeholder' => '121212-12'])}}
</div>

<div class="form-group">
  <label for="address">Adress</label>
  {{ Form::text('address', $staff->address, ['class' => 'form-control', 'placeholder' => 'Hagforsgatan 72'])}}
</div>

<div class="form-group">
  <label for="postal_code">Postnummer</label>
  {{ Form::text('postal_code', $staff->postalCode, ['class' => 'form-control', 'placeholder' => '416 74'])}}
</div>

<div class="form-group">
  <label for="city">Ort</label>
  {{ Form::text('city', $staff->city, ['class' => 'form-control', 'placeholder' => 'Göteborg'])}}
</div>

<div class="form-group">
  <label for="tel">Telefon</label>
  {{ Form::text('tel', $staff->tel, ['class' => 'form-control', 'placeholder' => '031 - 33 44 55'])}}
</div>

{{ Form::submit('Spara personuppgifter', ['class' => 'btn btn-default'])}}

{{ Form::close() }}
@stop
