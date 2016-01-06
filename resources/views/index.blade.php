<!DOCTYPE html>
<html lang="en" ng-app="laratasks">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laratasks</title>

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>


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
				<a class="navbar-brand" href="#/">Laratasks</a>
			</div>

			<div class="collapse navbar-collapse" ng-class="!navCollapsed && 'in'">
				<ul class="nav navbar-nav">
					
					
				</ul>

				<ul class="nav navbar-nav navbar-right">
						<li ng-if="!isAuthenticated()"><a href="#/login">Login</a></li>
						
						<li class="dropdown" dropdown ng-if="isAuthenticated() && currentUser.name">
							<a href="#" class="dropdown-toggle" dropdown-toggle data-toggle="dropdown" role="button" aria-expanded="false">{{currentUser.name}} <span class="caret"></span></a>
							<ul class="dropdown-menu" dropdown-menu role="menu">
								<li><a ng-click="logout()">Logout</a></li>
							</ul>
						</li>
					
				</ul>
			</div>
	</nav>

<div class="container" ng-view></div>
<div class="footer navbar-fixed-bottom" style="text-align: center;background: white;">Copyright &copy; 2016 Jonathan Penny | See the code at <a href="https://github.com/jtpenny/laratasks" target="_blank">github.com/jtpenny/laratasks</a></div>

	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-animate.js"></script>
	<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.14.1.js"></script>
	<script src="//code.angularjs.org/1.4.7/angular-route.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular-messages.js"></script>
	<script src="//cdn.jsdelivr.net/satellizer/0.13.3/satellizer.min.js"></script>
	<script src="/js/app.js"></script>
	<script src="/controllers/authControllers.js"></script>
	<script src="/controllers/taskControllers.js"></script>
	<script src="/js/ga.js"></script>

</body>
</html>