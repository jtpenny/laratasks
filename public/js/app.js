var app = angular.module("laratasks", ['ui.bootstrap','ngRoute','satellizer']);

(function() {

	app.config(function($routeProvider, $authProvider) {
    	$routeProvider
    	  .when('/', {
    	    templateUrl: 'views/home.html',
    	    controller: 'HomeController'
    	  })
    	  .when('/login', {
    	    templateUrl: 'views/login.html',
    	    controller:'LoginController'
    	  })
    	  .when('/register', {
    	    templateUrl: 'views/register.html',
	        controller: 'RegisterController'
	      })
	      .when('/tasks', {
	      	templateUrl: 'views/tasks.html',
	      	controller: 'TasksController'
	      })
	      .when('/photo/:id', {
	        templateUrl: 'views/detail.html',
	        controller: 'DetailCtrl'
	      })
	      .otherwise('/');
	      
	       $authProvider.loginUrl = '/api/authenticate';
	       $authProvider.signupUrl = '/api/register';
	  });
	  
	  app.run(function($rootScope, $window, $auth) {
	    if ($auth.isAuthenticated()) {
	      $rootScope.currentUser = JSON.parse($window.localStorage.currentUser);
    	}
  	  });

    
    var NavbarController = function($scope, $window, $rootScope, $auth, $location ) {
    	
    	$scope.isAuthenticated = function() {
	      return $auth.isAuthenticated();
	    };
	
	    $scope.logout = function() {
	      $auth.logout();
	      delete $window.localStorage.currentUser;
	      $location.path('#/');
	    };
    	
    	var navbarResponsive = function() {
    		if ($window.innerWidth <= 768) {
        		$scope.navCollapsed = true;
    		} else {
    			$scope.navCollapsed = false;
    		}
    	}
    	
    	var w = angular.element($window);
    	 	
		w.bind('resize', function () {
		//	console.log(w);
			navbarResponsive();
		});
    	
    	navbarResponsive();
    }
    
    var HomeController = function($scope,$window, $rootScope, $auth) {
    	
    	$scope.isAuthenticated = function() {
	      return $auth.isAuthenticated();
	    };    	
    	
    }

    app.controller("NavbarController", NavbarController);
    app.controller("HomeController", HomeController);
  }

  ());
  

