@extends('layouts.authenticated')

@section('content')
<div class="container">

   <div class="row">
      <div class="col-md-6">
         <form role="form" method="POST" action="/staff">
           <div class="form-group">
             <label for="email">Email address</label>
             <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
           </div>
           <div class="form-group">
             <label for="name">Name</label>
             <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
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
           <button type="submit" class="btn btn-success">Lägg till</button>
         </form>

      </div>
   </div>


@stop
