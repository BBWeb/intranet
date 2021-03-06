@extends('layouts.base')

@section('base-content')

<div class="container">

      <form class="form-signin" role="form" method="post" action="login">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" name="email" class="form-control" placeholder="Email address" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <label class="checkbox">
          <input type="checkbox" name="remember-me" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->
@stop
