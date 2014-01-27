@extends('layouts.base')

@section('base-content')
    <div class="container">

      <!-- Static navbar -->
      <div class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">B&B Web - Intranet</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/">Projekt</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Personal <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/staff">Hantera</a></li>
                <li><a href="/staff/create">Lägg till</a></li>
              </ul>
            </li>

          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Acccount <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/account">Account</a></li>
                <li class="divider"></li>
                <li><a href="/logout">Log out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="container">
		  @yield('content')
      </div>

    </div> <!-- /container -->

@stop
