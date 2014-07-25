@extends('admin.staff.base')

@section('header')
<h1>Löneinformation</h1>
@stop

@section('form')
<div class="row">
  <ul class="list-inline">
    <li><a href="#">Historik</a></li>
    <li><a href="#">Planerade lönebyten</a></li>
    <li><a href="#">Ny lön</a></li>
  </ul>
</div>
<div class="row">

  <div class="form-group">
    <label for="">Avdrag inkomstskatt (%)</label>
      <input type="text" value="{{ $staff->currentIncomeTax }}" class="form-control" disabled>
  </div>

  <div class="form-group">
    <label for="">Timlön (kr)</label>
    <input type="text" value="{{ $staff->currentHourlySalary }}" class="form-control" disabled>
  </div>

  <div class="form-group">
    <label for="">Arbetsgivaravgift (%)</label>
    <input type="text" value="{{ $staff->currentEmployerFee }}" class="form-control" disabled>
  </div>

  <div class="form-group">
    <label for="#">Gällande från</label>
    <input type="text" value="{{ $staff->currentStartDate }}" class="form-control" disabled>
  </div>

</div>

@stop
