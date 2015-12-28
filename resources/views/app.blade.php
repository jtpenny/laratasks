<!DOCTYPE html>
<html lang="en" ng-app="laratasks">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laratasks @yield('title')</title>

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.js"></script>
<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.14.1.js"></script>
<script src="/js/app.js"></script>
<?php /*
<script type="text/javascript" src="/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="/css/bootstrap-multiselect.css" type="text/css"/>
*/ ?>
</head>
<body>

	<nav class="navbar navbar-default" role="navigation" ng-controller="NavbarController">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" ng-init="navCollapsed = true" ng-click="navCollapsed = !navCollapsed">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">Laratasks</a>
			</div>

			<div class="collapse navbar-collapse" ng-class="!navCollapsed && 'in'">
				<ul class="nav navbar-nav">
					<?php /*<li><a href="{{ url('/') }}">Home</a></li> */ ?>
					
					@if(Auth::check())
						
						<li><a href="<% url('/administration') %>">Administration</a></li>
					@endif
					
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="<% url('/auth/login') %>">Login</a></li>
						
					@else
						<li class="dropdown" dropdown>
							<a href="#" class="dropdown-toggle" dropdown-toggle data-toggle="dropdown" role="button" aria-expanded="false"><% Auth::user()->name %> <span class="caret"></span></a>
							<ul class="dropdown-menu" dropdown-menu role="menu">
								<li><a href="<% url('/auth/logout') %>">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
	</nav>

	@yield('content')
<div class="footer navbar-fixed-bottom" style="text-align: center;background: white;">Copyright &copy; 2015 Jonathan Penny</div>
	<!-- Scripts -->

</body>
</html>