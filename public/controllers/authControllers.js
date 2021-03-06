(function() {

	var LoginController = function($scope, $window, $location, $rootScope, $auth) {

	    $scope.emailLogin = function() {
	      $auth.login({ email: $scope.email, password: $scope.password })
	        .then(function(response) {
	          $window.localStorage.currentUser = JSON.stringify(response.data.user);
	          $rootScope.currentUser = JSON.parse($window.localStorage.currentUser);
	          $window.ga('send', 'event', 'auth', 'login');
	          $location.path('tasks');
	        })
	        .catch(function(response) {
	        	$scope.error = response.data.error;
	        });
	    };

  	};
  
	var RegisterController = function($scope, $window, $location, $rootScope, $auth) {

	    $scope.register = function() {
	    	console.log('hello!');
	      $auth.signup({ name: $scope.name, email: $scope.email, password: $scope.password, password_confirmation : $scope.password_confirmation })
	        .then(function(response) {
	          $window.localStorage.currentUser = JSON.stringify(response.data.user);
	          $auth.setToken(response.data.token)
	          $rootScope.currentUser = JSON.parse($window.localStorage.currentUser);
	          $window.ga('send', 'event', 'auth', 'register');
	          $location.path('tasks');
	        })
	        .catch(function(response) {
	        	$scope.errors = response.data.errors;
	        });
	    };

	}
  
	app.controller("LoginController", LoginController);
	app.controller("RegisterController", RegisterController);
  
} ());	