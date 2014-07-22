@extends('admin.staff.base')

@section('header')
<h1>Företagsuppgifter</h1>
@stop

@section('form')
{{ Form::open() }}
        <div class="form-group">
          <label for="employment_nr">Anställningsnummer</label>
          {{ Form::text('employment_nr', null, ['class' => 'form-control', 'placeholder' => '33'])}}
        </div>

        <div class="form-group">
          <label for="bank">Bank</label>
          {{ Form::text('bank', null, ['class' => 'form-control', 'placeholder' => 'Swedbank'])}}
        </div>

        <div class="form-group">
          <label for="clearing">Clearingnummer</label>
          {{ Form::text('clearing', null, ['class' => 'form-control', 'placeholder' => '131'])}}
        </div>

        <div class="form-group">
          <label for="bank_nr">Banknummer</label>
          {{ Form::text('bank_nr', null, ['class' => 'form-control', 'placeholder' => '131 133 - 131'])}}
        </div>
          {{ Form::submit('Spara betalningsinfo', ['class' => 'btn btn-default'])}}
{{ Form::close() }}
@stop